<?php
require_once __DIR__ . '/../core/Models.php';

class CompetitorPrice extends Model
{
    protected $table = 'competitor_prices';

    public function getPricesByProductId($productId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE product_id = :product_id ORDER BY price ASC");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPricesByProductName($productName)
    {
        $stmt = $this->pdo->prepare("SELECT cp.* FROM {$this->table} cp 
                                     LEFT JOIN products p ON cp.product_id = p.id 
                                     WHERE p.name LIKE :name OR cp.competitor_product_name LIKE :name 
                                     ORDER BY cp.price ASC");
        $stmt->execute(['name' => '%' . $productName . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
