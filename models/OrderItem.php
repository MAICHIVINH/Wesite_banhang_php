<?php
require_once  './core/Models.php';
class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'quantity' => 'INT',
        'unit_price' => 'DECIMAL(12,2)',
        'product_id' => 'INT',
        'order_id' => 'INT',
        'isDeleted' => 'TINYINT(1) DEFAULT 0'
    ];

    protected $foreignKeys = [
        'product_id' => 'products(id)',
        'order_id' => 'orders(id)'
    ];

    public function countProductsSoldThisWeek()
    {
        $sql = "SELECT SUM(oi.quantity) AS total_sold
        FROM {$this->table} oi JOIN orders o ON oi.order_id = o.id 
        WHERE o.isDeleted = 0 
                AND o.status_id = 6 
                AND YEARWEEK(o.create_at, 1) = YEARWEEK(CURDATE(), 1)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function getOrderItemByOrderId($orderId)
    {
        $sql = "
        SELECT 
            *
        FROM {$this->table} oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = :order_id
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function hasPendingOrCompletedOrdersByProduct($productId): bool
    {
        $sql = "
        SELECT 1
        FROM {$this->table} oi
        JOIN orders o ON oi.order_id = o.id
        WHERE oi.product_id = :pid
          AND o.isDeleted = 0
          AND o.status_id IN (2, 4)
        LIMIT 1
    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['pid' => $productId]);
        return (bool) $stmt->fetchColumn();
    }

    public function getOrderIdsByProductId($productId): array
    {
        $sql = "
        SELECT DISTINCT od.order_id
        FROM {$this->table} od
        WHERE od.product_id = :product_id
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['product_id' => $productId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function canDeleteCategory($category_id)
    {
        $sql = "
        SELECT COUNT(*) as cnt
        FROM {$this->table} od
        INNER JOIN products p ON od.product_id = p.id
        INNER JOIN orders o ON od.order_id = o.id
        WHERE p.category_id = :category_id
          AND o.status_id NOT IN (1, 5, 6)
          AND o.isDeleted = 0
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['category_id' => $category_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['cnt'] == 0;
    }

    public function canDeleteSupplier($supplier_id)
    {
        $sql = "
        SELECT COUNT(*) as cnt
        FROM {$this->table} od
        INNER JOIN products p ON od.product_id = p.id
        INNER JOIN orders o ON od.order_id = o.id
        WHERE p.supplier_id = :supplier_id
          AND o.status_id NOT IN (2, 3, 4)
          AND o.isDeleted = 0
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['supplier_id' => $supplier_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['cnt'] == 0;
    }
}
