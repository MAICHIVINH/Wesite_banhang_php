<?php
require_once  './core/Models.php';

class Review extends Model
{
    protected $table = 'reviews';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'rating' => 'INT',
        'comment' => 'TEXT',
        'user_id' => 'INT',
        'product_id' => 'INT',
        'isDeleted' => 'TINYINT(1)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'

    ];

    protected $foreignKeys = [
        'user_id' => 'users(id)',
        'product_id' => 'products(id)'
    ];

    public function getAllOfProduct($id)
    {
        $sql = "SELECT * 
            FROM {$this->table} r 
            JOIN users u ON r.user_id = u.id
            WHERE r.product_id = :product_id
            ORDER BY r.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['product_id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
