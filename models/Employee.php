<?php

require_once  './core/Models.php';


class Employee extends Model
{
    protected $table = 'employees';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(255)',
        'phone' => 'VARCHAR(20)',
        'email' => 'VARCHAR(255) UNIQUE NOT NULL',
        'position' => 'VARCHAR(255)',
        'address' => 'VARCHAR(255)',
        'password_hash' => 'VARCHAR(255)',
        'branch_id' => 'INT NOT NULL',
        'isDeleted' => 'TINYINT(1)',
        'is_first_login' => 'TINYINT(1) DEFAULT 1',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    ];

    protected $foreignKeys = [
        'branch_id' => 'branches(id)'
    ];

    public function getFilterEmployees($keyword = null, $limit = 8, $offset = 0, $isDeleted = 0)
    {
        $sql = "SELECT * FROM employees WHERE 1=1 ";

        $params = ['isDeleted' => $isDeleted];
        $sql .= " AND isDeleted = :isDeleted";

        if (!empty($keyword)) {
            $sql .= " AND (name LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword)";
            $params['keyword'] = '%' . $keyword . '%';
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

    public function countFilteredEmployees($keyword = null, $isDeleted = 0)
    {
        $sql = "SELECT COUNT(*) as total FROM employees WHERE 1=1 ";
        $params = ['isDeleted' => $isDeleted];
        $sql .= " AND isDeleted = :isDeleted";

        if (!empty($keyword)) {
            $sql .= " AND (name LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword)";
            $params['keyword'] = '%' . $keyword . '%';
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
