<?php
require_once  './core/Models.php';

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(255) NOT NULL',
        'contact_person' => 'VARCHAR(255)',
        'image_url' => 'VARCHAR(255)',
        'Phone' => 'VARCHAR(20)',
        'Email' => ' VARCHAR(255)',
        'Address' => 'TEXT',
        'isDeleted' => 'TINYINT(1)',
    ];

    public function getFilteredSuppliers($limit = 8, $offset = 0, $keyword = '', $isDeleted = 0)
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1 ";
        $params = ['isDeleted' => $isDeleted];
        $sql .= " AND isDeleted = :isDeleted";

        if (!empty($keyword)) {
            $sql .= " AND name LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);

        // Bind keyword nếu có
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val, PDO::PARAM_STR);
        }

        // Bind limit và offset
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function countSupplier($keyword = '', $isDeleted = 0)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE isDeleted = 0";
        $params = ['isDeleted' => $isDeleted];
        $sql .= " AND isDeleted = :isDeleted";
        if (!empty($keyword)) {
            $sql .= " AND name LIKE :keyword";
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
}
