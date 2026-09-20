<?php

require_once  './core/Models.php';

class RoleMenu extends Model
{
    protected $table = 'role_menu';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'menu_id' => 'INT NOT NULL',
        'role_id' => 'INT NOT NULL',
        'isDeleted' => 'TINYINT(1)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    protected $foreignKeys = [
        'menu_id' => 'menus(id)',
        'role_id' => 'roles(id)'
    ];

    public function getMenuIdsByRole($roleId)
    {
        $sql = "SELECT menu_id FROM role_menu WHERE role_id = :role_id AND isDeleted = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['role_id' => $roleId]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'menu_id');
    }

    public function updateByRoleId($roleId, $data)
    {
        $setParts = [];
        $params = [];

        foreach ($data as $key => $value) {
            $setParts[] = "`$key` = :$key";
            $params[$key] = $value;
        }

        $params['role_id'] = $roleId;
        $setString = implode(", ", $setParts);

        $sql = "UPDATE {$this->table} SET $setString WHERE role_id = :role_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function where(array $conditions)
    {
        $sql = "SELECT * FROM {$this->table} WHERE ";
        $params = [];
        $wheres = [];

        foreach ($conditions as $key => $value) {
            $wheres[] = "`$key` = :$key";
            $params[$key] = $value;
        }

        $sql .= implode(" AND ", $wheres);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first(array $conditions)
    {
        $result = $this->where($conditions);
        return $result[0] ?? null;
    }

    public function forceUpdate($id)
    {
        $sql = "UPDATE role_menu SET isDeleted = 0 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
