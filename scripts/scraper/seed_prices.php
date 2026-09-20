<?php
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/CompetitorPrice.php';

echo "Đang khởi tạo/cập nhật dữ liệu giá thị trường đối thủ...\n";

$productModel = new Product();
$competitorModel = new CompetitorPrice();

$products = $productModel->all();

if (empty($products)) {
    echo "Không tìm thấy sản phẩm nào trong cơ sở dữ liệu.\n";
    exit;
}

$pdo = Database::getInstance();

foreach ($products as $product) {
    $pId = $product['id'];
    $pName = $product['name'];
    $pPrice = (float)$product['price'];

    // Xóa dữ liệu giá cũ của sản phẩm
    $stmtDelete = $pdo->prepare("DELETE FROM competitor_prices WHERE product_id = :product_id");
    $stmtDelete->execute(['product_id' => $pId]);

    // Tạo các mức giá đối thủ tham khảo (Thế Giới Di Động, FPT Shop, CellphoneS)
    $mockCompetitors = [
        ['website' => 'Thế Giới Di Động', 'name' => $pName, 'price' => round($pPrice * 1.03, -4), 'url' => 'https://www.thegioididong.com'],
        ['website' => 'FPT Shop', 'name' => $pName, 'price' => round($pPrice * 1.01, -4), 'url' => 'https://fptshop.com.vn'],
        ['website' => 'CellphoneS', 'name' => $pName, 'price' => round($pPrice * 0.98, -4), 'url' => 'https://cellphones.com.vn']
    ];


    $stmtInsert = $pdo->prepare("INSERT INTO competitor_prices (product_id, website_name, competitor_product_name, price, competitor_url, updated_at) VALUES (:product_id, :website_name, :competitor_product_name, :price, :competitor_url, NOW())");

    foreach ($mockCompetitors as $item) {
        $stmtInsert->execute([
            'product_id' => $pId,
            'website_name' => $item['website'],
            'competitor_product_name' => $item['name'],
            'price' => $item['price'],
            'competitor_url' => $item['url']
        ]);
    }
    echo "Đã cập nhật giá đối thủ cho: {$pName} (Giá shop: " . number_format($pPrice) . " VNĐ)\n";
}

echo "Hoàn tất cập nhật dữ liệu giá thị trường!\n";
