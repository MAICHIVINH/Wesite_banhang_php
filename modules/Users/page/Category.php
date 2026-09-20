<?php
$products = [
    [
        'name' => 'Laptop Acer Nitro 5',
        'category' => 'laptop',
        'image' => 'https://product.hstatic.net/200000722513/product/legion_5_15irx10_ct1_02_5319efe70fe84554a98431db99c284f4_1024x1024.png',
        'price' => 21990000,
        'description' => 'Laptop gaming mạnh mẽ, card rời GTX 1650'
    ],
    [
        'name' => 'Laptop ASUS ROG',
        'category' => 'gaming',
        'image' => 'https://via.placeholder.com/400x250?text=Laptop',
        'price' => 30990000,
        'description' => 'Thiết kế ngầu, hiệu năng cao cho game thủ'
    ],
    [
        'name' => 'PC GVN RGB',
        'category' => 'pc',
        'image' => 'https://via.placeholder.com/400x250?text=Laptop',
        'price' => 17990000,
        'description' => 'PC build sẵn, LED RGB cực đẹp'
    ],
    [
        'name' => 'Laptop Dell Inspiron',
        'category' => 'laptop',
        'image' => 'https://product.hstatic.net/200000722513/product/legion_5_15irx10_ct1_02_5319efe70fe84554a98431db99c284f4_1024x1024.png',
        'price' => 16990000,
        'description' => 'Laptop học tập, văn phòng bền bỉ'
    ],
    [
        'name' => 'PC i7 12th',
        'category' => 'laptop',
        'image' => 'https://via.placeholder.com/400x250?text=Laptop',
        'price' => 28990000,
        'description' => 'PC chơi game và làm việc đa năng'
    ],
    [
        'name' => 'Laptop HP Pavilion',
        'category' => 'laptop',
        'image' => 'https://product.hstatic.net/200000722513/product/legion_5_15irx10_ct1_02_5319efe70fe84554a98431db99c284f4_1024x1024.png',
        'price' => 19990000,
        'description' => 'Laptop mỏng nhẹ, pin trâu cho công việc'
    ],
    [
        'name' => 'Laptop Lenovo IdeaPad',
        'category' => 'laptop',
        'image' => 'https://product.hstatic.net/200000722513/product/legion_5_15irx10_ct1_02_5319efe70fe84554a98431db99c284f4_1024x1024.png',
        'price' => 15990000,
        'description' => 'Laptop giá rẻ, hiệu năng ổn định'
    ],
    [
        'name' => 'Laptop MSI GF63',
        'category' => 'laptop',
        'image' => 'https://via.placeholder.com/400x250?text=Laptop',
        'price' => 24990000,
        'description' => 'Laptop gaming mỏng nhẹ, card rời GTX 1650'
    ],
    [
        'name' => 'PC Gaming Ryzen 5',
        'category' => 'laptop',
        'image' => 'https://via.placeholder.com/400x250?text=Laptop',
        'price' => 21990000,
        'description' => 'PC gaming với hiệu năng vượt trội'
    ],
];

$selectedCategory = $_GET['category'] ?? null;
$filteredProducts = array_filter($products, fn($p) => $p['category'] === $selectedCategory);
?>

<div class="container mt-4">
    <h4 class="mb-3">Sản phẩm thuộc danh mục:
        <span class="text-danger"><?= htmlspecialchars(ucfirst($selectedCategory)) ?></span>
    </h4>

    <div class="row g-3">
        <?php if (!empty($filteredProducts)): ?>
            <?php foreach ($filteredProducts as $product): ?>
                <div class="col-md-3">
                    <div class="ecom-product-card shadow-sm">
                        <img src="<?= htmlspecialchars($product['image']) ?>" class="ecom-product-img" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 180px; object-fit: contain;">
                        <h6 class="ecom-product-title"><?= htmlspecialchars($product['name']) ?></h6>
                        <p class="text-muted small mb-2" style="font-size: 12px; height: 32px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?= htmlspecialchars($product['description']) ?></p>
                        <div class="ecom-price-box">
                            <div class="price-current"><?= number_format($product['price'], 0, ',', '.') ?>₫</div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Không có sản phẩm nào trong danh mục này.</p>
        <?php endif; ?>
    </div>
</div>