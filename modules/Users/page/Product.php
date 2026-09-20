<?php


$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalProducts = $product->countProducts($id_category, $id_supplier, $keyword, $priceRanges);
$totalPages = ceil($totalProducts / $limit);

$products = $product->getFilterProducts($id_category, $id_supplier, $keyword, $limit, $offset, $priceRanges);

// var_dump($products);
?>

<div class="container mt-3 product-list">
    <div class="row g-3">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $item) {
                $originalPrice = (float)$item['price'];
                $discount = (float)$item['discount'];
                $finalPrice = $originalPrice * (1 - $discount / 100);
                $displayDiscount = (int)round($discount);
            ?>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="product-card ecom-product-card shadow-sm">
                        <?php if ($displayDiscount > 0): ?>
                            <span class="ecom-product-badge sale">-<?= $displayDiscount ?>%</span>
                        <?php endif; ?>
                        <a href="index.php?subpage=modules/Users/page/Detail.php&id=<?= $item['id'] ?>">
                            <img src="<?= htmlspecialchars($item['image_url']) ?>" class="product-img" alt="<?= htmlspecialchars($item['name']) ?>" style="height: 180px; object-fit: contain;">
                        </a>
                        <div class="product-body">
                            <h5 class="product-title"><a href="index.php?subpage=modules/Users/page/Detail.php&id=<?= htmlspecialchars($item['id']) ?>"><?= htmlspecialchars($item['name']) ?></a></h5>
                            <div class="ecom-price-box">
                                <div class="price-current text-danger fw-bold" style="color: #d70018 !important; font-size: 15px; font-weight: 700;">
                                    <?= number_format($finalPrice, 0, ',', '.') ?>₫
                                </div>
                                <?php if ($displayDiscount > 0): ?>
                                    <div class="mt-1">
                                        <span class="price-old text-secondary text-decoration-line-through small" style="color: #888888 !important; text-decoration: line-through !important; font-size: 12.5px;">
                                            <?= number_format($originalPrice, 0, ',', '.') ?>₫
                                        </span>
                                    </div>
                                <?php else: ?>
                                    <div class="mt-1 opacity-0 small" style="font-size: 12.5px;">&nbsp;</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 bg-white mx-auto" style="max-width: 540px;">
                    <div class="text-danger mb-3" style="font-size: 56px;">
                        <i class="bi bi-funnel-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Không tìm thấy sản phẩm phù hợp!</h5>
                    <p class="text-muted small mb-4">Rất tiếc, hiện tại không có sản phẩm nào trong tầm giá hoặc tiêu chí lọc bạn đã chọn. Vui lòng thử chọn mức giá khác.</p>
                    <div>
                        <a href="index.php?subpage=modules/Users/Layout/Main.php" class="btn btn-danger rounded-pill px-4 py-2 fw-semibold shadow-sm">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Xóa bộ lọc &amp; Xem tất cả
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($products) && $totalPages > 1): ?>
<nav class="mt-4">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="index.php?subpage=modules/Users/Layout/Main.php&category=<?= $id_category ?>&supplier=<?= $id_supplier ?>&search=<?= $keyword ?><?= $priceQuery ?>&number=<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>
<?php endif; ?>