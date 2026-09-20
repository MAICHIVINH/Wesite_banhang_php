<?php
require_once  './core/Models.php';

class User extends Model
{

    protected $table = "users";

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'FullName' => 'VARCHAR(255) NOT NULL',
        'Email' => 'VARCHAR(255) UNIQUE',
        'Phone' => 'VARCHAR(20)',
        'Address' => 'TEXT',
        'PasswordHash' => 'VARCHAR(255)',
        'CreatedAt' => 'DATETIME',
        'UpdateAt' => 'DATETIME',
        'deleted_by_id' => 'INT',
        'deleted_by_type ' => 'VARCHAR(50)',
        'deleted_at' => 'DATETIME',
        'reason' => 'TEXT',
        'isDeleted' => 'TINYINT(1)',
    ];

    public function getFilteredUsers($limit = 8, $offset = 0, $keyword = '', $isDeleted = 0)
    {
        $sql = "SELECT * FROM {$this->table} Where 1=1 ";

        $params = ['isDeleted' => $isDeleted];
        $sql .= " AND isDeleted = :isDeleted";
        if (!empty($keyword)) {
            $sql .= " AND FullName LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val, PDO::PARAM_STR);
        }

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUser($keyword = '', $isDeleted = 0)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1 ";
        $params = ['isDeleted' => $isDeleted];
        $sql .= " AND isDeleted = :isDeleted";
        if (!empty($keyword)) {
            $sql .= " AND FullName LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val, PDO::PARAM_STR);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($result['total'] ?? 0);
    }

    public function countUserAll()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE isDeleted = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($result['total'] ?? 0);
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // thống kế tổng số lượng khách hàng tham gia theo tháng
    public function countUsersByMonthInYear($year = null)
    {
        $year = $year ?? date('Y');
        $sql = "SELECT MONTH(CreatedAt) as month, COUNT(*) as total FROM {$this->table} 
                        WHERE isDeleted = 0 AND YEAR(CreatedAt) = :year 
                        GROUP BY MONTH(CreatedAt)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['year' => $year]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $monthlyCounts = array_fill(1, 12, 0);
        foreach ($results as $row) {
            $monthlyCounts[(int)$row['month']] = (int)$row['total'];
        }

        return $monthlyCounts;
    }
}
