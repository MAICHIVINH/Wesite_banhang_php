<?php

$id_product = $_GET['id'] ?? '';

if ($id_product == '') {
    echo "<h1>Yêu cầu mã</h1>";
    exit;
}

$productById = $product->getById($id_product);
$productByCategoryId = $product->getFilterProducts($productById['category_id'], null, null);

$imageByProductId = $imageController->getImageById($id_product);

$inventoryProduct = $inventoryController->getProductInventory($id_product, null) ?? 0;


$reviews = $reviewController->getAllReviewUser($id_product);

?>
<style>
    .card-title-container a {
        font-weight: bold;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: auto;
        line-height: 1.2em;
        max-height: calc(1.2em * 2);
    }
</style>

<div class="container py-5">
    <!-- Sản phẩm -->
    <div class="row align-items-start" style="margin: 0 30px;">
        <div class="col-lg-6 col-md-6 col-12 product-image-col">
            <img src="<?= $productById['image_url'] ?>" class="img-fluid border rounded mb-3" id="mainImage"
                alt="Ảnh sản phẩm" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal">

            <div class="d-flex gap-2 flex-wrap">
                <?php foreach ($imageByProductId as $item) { ?>
                    <img src="<?= $item['image_url'] ?>" class="thumb-img border" onclick="swapImage(this);">
                <?php } ?>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12">
            <h2><?= $productById['name'] ?></h2>
            <?= strip_tags($productById['content']) ?>
            <?php
            $originalPrice = $productById['price'];
            $discount = $productById['discount'];
            $finalPrice = $originalPrice * (1 - $discount / 100);
            ?>

            <div class="mt-2">
                <?php if ($discount > 0) { ?>
                    <div class="d-flex align-items-baseline gap-2">
                        <h3 class="text-danger fw-bold mb-0" style="color: #d70018 !important; font-size: 26px;">
                            <?= number_format($finalPrice, 0, ',', '.') ?>₫
                        </h3>
                        <span class="text-muted text-decoration-line-through fs-5">
                            <?= number_format($originalPrice, 0, ',', '.') ?>₫
                        </span>
                        <span class="badge bg-danger text-white px-2 py-1" style="font-size: 12px;">-<?= (int)round($discount) ?>%</span>
                    </div>
                <?php } else { ?>
                    <h3 class="text-danger fw-bold mb-0" style="color: #d70018 !important; font-size: 26px;">
                        <?= number_format($originalPrice, 0, ',', '.') ?>₫
                    </h3>
                <?php } ?>
            </div>

            <?php
            // Dynamic Promotion Offers per Category
            $catDetail = isset($productById['category_id']) ? $category->getById($productById['category_id']) : null;
            $catName = mb_strtolower($catDetail['name'] ?? '', 'UTF-8');

            $promotions = [
                "Tặng Voucher 200.000đ khi thanh toán qua PayOS QR",
                "Miễn phí vận chuyển giao nhanh tận nhà trong 2H"
            ];

            if (str_contains($catName, 'laptop') || str_contains($catName, 'màn hình')) {
                $promotions[] = "Giảm thêm 10% khi mua kèm Bàn phím / Chuột Gaming / Balo Laptop";
                $promotions[] = "Giảm 50% gói bảo hành mở rộng 12 tháng chính hãng";
            } elseif (str_contains($catName, 'tai nghe') || str_contains($catName, 'loa') || str_contains($catName, 'âm thanh')) {
                $promotions[] = "Giảm thêm 10% khi mua kèm Hộp bảo vệ / Củ sạc phụ kiện âm thanh";
                $promotions[] = "Bảo hành 1 đổi 1 trong 30 ngày đầu nếu có lỗi nhà sản xuất";
            } elseif (str_contains($catName, 'điện thoại') || str_contains($catName, 'đồng hồ') || str_contains($catName, 'smartphone')) {
                $promotions[] = "Giảm thêm 15% khi mua kèm Ốp lưng / Sạc dự phòng / Dán cường lực";
                $promotions[] = "Thu cũ đổi mới trợ giá lên đến 1.000.000đ";
            } else {
                $promotions[] = "Giảm thêm 5% khi mua kèm các sản phẩm phụ kiện cùng đơn hàng";
                $promotions[] = "Cam kết hàng chính hãng 100% - Đổi trả trong 30 ngày";
            }
            ?>

            <!-- Hot Promotions Box -->
            <div class="hot-promo-box">
                <div class="hot-promo-title">
                    <i class="bi bi-gift-fill"></i> KHUYẾN MÃI HẤP DẪN
                </div>
                <ul class="promo-item-list">
                    <?php foreach ($promotions as $promo): ?>
                        <li><i class="bi bi-check-circle-fill text-success"></i> <?= htmlspecialchars($promo) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <form class="product-form mt-3" method="post" action="index.php?subpage=modules/Users/page/Cart.php">
                <input type="hidden" name="id" value="<?= $productById['id'] ?>">
                <input type="hidden" name="name" value="<?= htmlspecialchars($productById['name']) ?>">
                <input type="hidden" name="price" value="<?= $finalPrice ?>">
                <input type="hidden" name="image" value="<?= htmlspecialchars($productById['image_url']) ?>">

                <?php if (!empty($inventoryProduct)) { ?>
                    <div class="d-flex flex-column gap-2 w-100">
                        <button type="submit" name="addCart" class="btn btn-buy-now">
                            <i class="bi bi-bag-check-fill me-2"></i> MUA NGAY (Giao tận nơi hoặc nhận tại cửa hàng)
                        </button>
                        <button type="submit" name="addCart" class="btn btn-add-cart-outline">
                            <i class="bi bi-cart-plus me-2"></i> THÊM VÀO GIỎ HÀNG
                        </button>
                    </div>
                <?php } else { ?>
                    <button class="btn btn-secondary w-100 py-3 fw-bold disabled">HẾT HÀNG TẠI TẤT CẢ CỬA HÀNG</button>
                <?php } ?>

                <div class="store-box mt-3 w-100">
                    <h6><i class="bi bi-geo-alt-fill me-1 text-danger"></i> Sản phẩm có tại các cửa hàng:</h6>
                    <?php if (!empty($inventoryProduct)) { ?>
                        <ul class="list-unstyled mb-0 small">
                            <?php foreach ($inventoryProduct as $inv) { ?>
                                <li class="py-1 border-bottom">
                                    <span class="fw-bold text-dark"><?= htmlspecialchars($inv['name']) ?></span> - 
                                    <span class="text-muted"><?= htmlspecialchars($inv['address']) ?></span> - 
                                    <span class="text-danger fw-semibold">(Còn <?= $inv['stock_quantity'] ?> SP)</span>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p class="text-muted mb-0 text-center small">Sản phẩm hiện không có sẵn tại các chi nhánh.</p>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mt-5" id="productTab" role="tablist">
        <li class="nav-item" role="presentation" style="font-weight: bold; font-size: 1.2rem;">
            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-pane"
                type="button" role="tab">
                Mô tả sản phẩm
            </button>
        </li>
        <li class="nav-item" role="presentation" style="font-weight: bold; font-size: 1.2rem;">
            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-pane" type="button"
                role="tab">
                Đánh giá
            </button>
        </li>
    </ul>

    <div class="tab-content border p-3" id="productTabContent">
        <!-- Tab mô tả -->
        <div class="tab-pane fade show active" id="description-pane" role="tabpanel" aria-labelledby="description-tab">
            <div id="descriptionContent" class="product-description-content">
                <?= $productById['description'] ?>
            </div>
            <div class="show-more-wrapper">
                <span id="toggleDescription" class="show-more-btn" style="display: none; cursor:pointer;">Xem
                    thêm</span>
            </div>
        </div>

        <div class="tab-pane fade" id="reviews-pane" role="tabpanel" aria-labelledby="reviews-tab">
            <?php if (!empty($reviews)) { ?>
                <?php foreach ($reviews as $review) { ?>
                    <div class="review-item">
                        <!-- Avatar -->
                        <div class="review-avatar">
                            <?= strtoupper(substr($review['FullName'], 0, 1)) ?>
                        </div>

                        <!-- Nội dung -->
                        <div class="review-content">
                            <div class="review-header">
                                <span class="review-username"><?= htmlspecialchars($review['FullName']) ?></span>
                                <span class="review-date"><?= date('d/m/Y', strtotime($review['created_at'])) ?></span>
                            </div>
                            <div class="review-stars">
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <i class="bi <?= $i <= $review['rating'] ? 'bi-star-fill' : 'bi-star' ?>"></i>
                                <?php } ?>
                            </div>
                            <p class="review-text"><?= nl2br($review['comment']) ?></p>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-muted text-center my-4">Chưa có đánh giá nào cho sản phẩm này.</p>
            <?php } ?>
        </div>
    </div>


    <!-- Sp tương tự -->
    <div class="mt-5">
        <h4 class="fw-bold text-center mb-4 fs-4 text-primary">Sản phẩm tương tự</h4>
        <div class="row row-cols-1 row-cols-md-5 g-4">
            <?php
            $count = 0;
            foreach ($productByCategoryId as $item) {
                $originalPrice = (float) $item['price'];
                $discount = (float) $item['discount'];
                $finalPrice = $originalPrice * (1 - $discount / 100);
                $displayDiscount = (int) round($discount);
                if ($count == 4)
                    break;
                ?>
                <div class="col">
                    <div class="ecom-product-card shadow-sm">
                        <?php if ($displayDiscount > 0): ?>
                            <span class="ecom-product-badge sale">-<?= $displayDiscount ?>%</span>
                        <?php endif; ?>
                        <a href="index.php?subpage=modules/Users/page/Detail.php&id=<?= $item['id'] ?>">
                            <img src="<?= htmlspecialchars($item['image_url']) ?>" class="ecom-product-img"
                                alt="<?= htmlspecialchars($item['name']) ?>">
                        </a>
                        <h6 class="ecom-product-title">
                            <a href="index.php?subpage=modules/Users/page/Detail.php&id=<?= $item['id'] ?>">
                                <?= htmlspecialchars($item['name']) ?>
                            </a>
                        </h6>
                        <div class="ecom-price-box">
                            <div class="price-current text-danger fw-bold"
                                style="color: #d70018 !important; font-size: 15px; font-weight: 700;">
                                <?= number_format($finalPrice, 0, ',', '.') ?>₫
                            </div>
                            <?php if ($displayDiscount > 0): ?>
                                <div class="mt-1">
                                    <span class="price-old text-secondary text-decoration-line-through small"
                                        style="color: #888888 !important; text-decoration: line-through !important; font-size: 12.5px;">
                                        <?= number_format($originalPrice, 0, ',', '.') ?>₫
                                    </span>
                                </div>
                            <?php else: ?>
                                <div class="mt-1 opacity-0 small" style="font-size: 12.5px;">&nbsp;</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
                $count++;
            }
            ?>
        </div>
    </div>
</div>

<!-- modal hình  -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 position-relative w-100">
            <!-- <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button> -->
            <div class="modal-body text-center position-relative p-0" style="height: auto; margin: 10px;">
                <button class="btn btn-light position-absolute top-50 start-0 translate-middle-y" style="z-index:2;"
                    onclick="prevImage()">
                    &#10094;
                </button>
                <img src="" id="modalImage" class="img-fluid rounded">
                <button class="btn btn-light position-absolute top-50 end-0 translate-middle-y" style="z-index:2;"
                    onclick="nextImage()">
                    &#10095;
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    const description = document.getElementById('descriptionContent');
    const toggleBtn = document.getElementById('toggleDescription');

    function checkDescriptionHeight() {
        if (description.scrollHeight > description.clientHeight + 5) {
            toggleBtn.style.display = 'inline-block';
        } else {
            toggleBtn.style.display = 'none';
        }
    }

    toggleBtn.addEventListener('click', function () {
        description.classList.toggle('expanded');
        toggleBtn.textContent = description.classList.contains('expanded') ? 'Thu gọn' : 'Xem thêm';
    });

    // Khi load trang
    window.addEventListener('load', () => {
        setTimeout(checkDescriptionHeight, 200);
    });

    // Khi chuyển sang tab mô tả
    document.getElementById('description-tab').addEventListener('shown.bs.tab', () => {
        checkDescriptionHeight();
    });
</script>