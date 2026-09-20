<?php

require_once  './core/Models.php';

class Role extends Model
{
    protected $table = 'roles';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'role_name' => 'VARCHAR(255)',
        'isDeleted' => 'TINYINT(1)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    public function getFilterRoles($keyword = null, $limit = 8, $offset = 0, $isDeleted = 0)
    {
        $sql = "SELECT * FROM roles WHERE 1=1 ";

        $params = ['isDeleted' => $isDeleted];
        $sql .= " AND isDeleted = :isDeleted";

        if (!empty($keyword)) {
            $sql .= " AND role_name LIKE :keyword";
            $params['keyword'] = "%" . $keyword . "%";
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countFilteredRoles($keyword, $isDeleted = 0)
    {
        $sql = "SELECT COUNT(*) as total FROM roles WHERE 1=1";
        $params = ['isDeleted' => $isDeleted];
        $sql .= " AND isDeleted = :isDeleted";
        if (!empty($keyword)) {
            $sql .= " AND role_name LIKE :keyword";
            $params['keyword'] = "%" . $keyword . "%";
        }

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getAllRolesWithMenus()
    {
        $sql = "SELECT 
                r.id as role_id, 
                r.role_name, 
                m.id as menu_id, 
                m.menu_name, 
                m.menu_url
            FROM roles r
            LEFT JOIN role_menu rm ON r.id = rm.role_id AND rm.isDeleted = 0
            LEFT JOIN menus m ON rm.menu_id = m.id AND m.isDeleted = 0
            WHERE r.isDeleted = 0
            ORDER BY r.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $roleWithMenus = [];
        foreach ($result as $item) {
            $roleId = $item['role_id'];

            if (!isset($roleWithMenus[$roleId])) {
                $roleWithMenus[$roleId] = [
                    'role_id' => $roleId,
                    'role_name' => $item['role_name'],
                    'menus' => []
                ];
            }

            if (!empty($item['menu_id'])) {
                $roleWithMenus[$roleId]['menus'][] = [
                    'menu_id' => $item['menu_id'],
                    'menu_name' => $item['menu_name'],
                    'menu_url' => $item['menu_url']
                ];
            }
        }
        return array_values($roleWithMenus);
    }

    public function existsByNameRole($name): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$this->table} WHERE role_name = :name AND isDeleted = 0");
        $stmt->execute(['name' => $name]);
        return $stmt->fetchColumn() > 0;
    }

    public function existsByNameExceptIdRole($id, $name): bool
    {
        $name = trim(mb_strtolower($name));

        $sql = "SELECT COUNT(*) FROM {$this->table} 
            WHERE LOWER(TRIM(role_name)) = :name AND id != :id AND isDeleted = 0";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
