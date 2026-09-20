<?php

require_once  './core/Models.php';

class Image extends Model
{
    protected $table = 'images';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'image_url' => 'VARCHAR(255) NOT NULL',
        'product_id' => 'INT NOT NULL',
        'isDeleted' => 'TINYINT(1) DEFAULT 0',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    protected $foreignKeys = [
        'product_id' => 'products(id)'
    ];

    public function getImagesByProductId($productId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE product_id = :product_id AND isDeleted = 0");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImagesByProductIdIsDeleted($productId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function deleteByProductId($productId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE product_id = :product_id");
        return $stmt->execute(['product_id' => $productId]);
    }
}
