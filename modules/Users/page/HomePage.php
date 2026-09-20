<?php
// Sản phẩm nổi bật
$featuredProducts = $product->getLatestProducts();

// Sản phẩm giảm giá
$saleProducts = $product->getLatestSaleProducts();

$getCategory = $category->getAll();

// Banner động từ cơ sở dữ liệu
$sliderBanners = isset($bannerController) ? $bannerController->getByPosition('slider_main') : [];
$sideBanners = isset($bannerController) ? $bannerController->getByPosition('side_banner') : [];
?>

<style>
    .ecom-product-title a {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* Giới hạn 2 dòng */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 2.8em;
        /* Giữ chiều cao cố định để không bị lệch layout */
        line-height: 1.4em;
        /* Khoảng cách giữa các dòng */
        font-size: 14px;
        color: inherit;
        text-decoration: none;
    }
</style>


<!-- Hero Section 3-Column CellphoneS Layout -->
<div class="container mt-3">
    <div class="row g-3 align-items-stretch">
        <!-- Column 1: Vertical Category Menu (Desktop) -->
        <div class="col-lg-3 d-none d-lg-block">
            <div class="hero-category-menu">
                <?php
                $menuCount = 0;
                foreach ($getCategory as $catItem) {
                    if ($catItem['status'] === 1) continue;
                    if ($menuCount >= 9) break;
                    ?>
                    <a href="index.php?subpage=modules/Users/Layout/Main.php&category=<?= $catItem['id'] ?>" class="hero-category-item">
                        <div class="d-flex align-items-center gap-2">
                            <?php if (!empty($catItem['icon'])): ?>
                                <img src="<?= htmlspecialchars($catItem['icon']) ?>" alt="<?= htmlspecialchars($catItem['name']) ?>" style="width: 22px; height: 22px; object-fit: contain;">
                            <?php else: ?>
                                <i class="bi bi-laptop text-danger fs-6"></i>
                            <?php endif; ?>
                            <span><?= htmlspecialchars($catItem['name']) ?></span>
                        </div>
                        <i class="bi bi-chevron-right small text-muted"></i>
                    </a>
                    <?php
                    $menuCount++;
                }
                ?>
            </div>
        </div>

        <!-- Column 2: Center Main Carousel -->
        <div class="col-lg-6 col-md-8">
            <div id="heroMainCarousel" class="carousel slide hero-main-carousel" data-bs-ride="carousel" data-bs-interval="4000">
                <?php if (!empty($sliderBanners)): ?>
                    <div class="carousel-indicators">
                        <?php foreach ($sliderBanners as $index => $b): ?>
                            <button type="button" data-bs-target="#heroMainCarousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>"></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="carousel-inner">
                        <?php foreach ($sliderBanners as $index => $b): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <?php if (!empty($b['link'])): ?>
                                    <a href="<?= htmlspecialchars($b['link']) ?>">
                                        <img src="<?= htmlspecialchars($b['image']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($b['title'] ?? 'Banner') ?>">
                                    </a>
                                <?php else: ?>
                                    <img src="<?= htmlspecialchars($b['image']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($b['title'] ?? 'Banner') ?>">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#heroMainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#heroMainCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#heroMainCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://file.hstatic.net/200000722513/file/thang_06_banner_build_pc_top_promotion_banner_2.png" class="d-block w-100" alt="Banner Build PC">
                        </div>
                        <div class="carousel-item">
                            <img src="https://file.hstatic.net/200000722513/file/laptop_gaming_top_promotion_banner.png" class="d-block w-100" alt="Banner Laptop Gaming">
                        </div>
                        <div class="carousel-item">
                            <img src="https://file.hstatic.net/200000722513/file/thang_06_banner_man_hinh_top_promotion_banner.png" class="d-block w-100" alt="Banner Màn Hình">
                        </div>
                    </div>
                <?php endif; ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroMainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Trước</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroMainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Sau</span>
                </button>
            </div>
        </div>

        <!-- Column 3: Right Stacked Promo Banners -->
        <div class="col-lg-3 col-md-4 d-none d-md-block">
            <div class="hero-right-banners">
                <?php if (!empty($sideBanners)): ?>
                    <?php 
                    $sideCount = 0;
                    foreach ($sideBanners as $b):
                        if ($sideCount >= 2) break;
                    ?>
                        <div class="hero-right-banner-item">
                            <?php if (!empty($b['link'])): ?>
                                <a href="<?= htmlspecialchars($b['link']) ?>">
                                    <img src="<?= htmlspecialchars($b['image']) ?>" alt="<?= htmlspecialchars($b['title'] ?? 'Side Banner') ?>">
                                </a>
                            <?php else: ?>
                                <img src="<?= htmlspecialchars($b['image']) ?>" alt="<?= htmlspecialchars($b['title'] ?? 'Side Banner') ?>">
                            <?php endif; ?>
                        </div>
                    <?php 
                        $sideCount++;
                    endforeach; 
                    ?>
                <?php else: ?>
                    <div class="hero-right-banner-item">
                        <img src="https://file.hstatic.net/200000722513/file/bot_promotion_banner_small_2_2ad55c2345c64fbfb87dab4957b33914.png" alt="Promo PC Poseidon">
                    </div>
                    <div class="hero-right-banner-item">
                        <img src="https://file.hstatic.net/200000722513/file/thang_06_banner_ghe_top_promotion_banner_1.png" alt="Promo Ghế Gaming">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Trust Badges Bar -->
<div class="container">
    <div class="trust-badges-bar">
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="trust-badge-item">
                    <div class="trust-badge-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 13.5px;">100% Chính Hãng</div>
                        <div class="text-muted" style="font-size: 11.5px;">Bảo hành tận tâm 12 tháng</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="trust-badge-item">
                    <div class="trust-badge-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 13.5px;">Giao Nhanh 2H</div>
                        <div class="text-muted" style="font-size: 11.5px;">Miễn phí vận chuyển toàn quốc</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="trust-badge-item">
                    <div class="trust-badge-icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 13.5px;">1 Đổi 1 Trong 30 Ngày</div>
                        <div class="text-muted" style="font-size: 11.5px;">Nếu phát sinh lỗi nhà sản xuất</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="trust-badge-item">
                    <div class="trust-badge-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 13.5px;">Tổng Đài 24/7</div>
                        <div class="text-muted" style="font-size: 11.5px;">Tư vấn giải đáp hotline 1800.6789</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flash Sale Container -->
<?php if (!empty($saleProducts)): ?>
<div class="container">
    <div class="flash-sale-box">
        <div class="flash-sale-header">
            <div class="flash-sale-title">
                <i class="bi bi-lightning-charge-fill text-warning fs-3"></i> HOT SALE GIÁ SỐC
            </div>
            <div class="countdown-box d-none d-sm-flex">
                <span>KẾT THÚC TRONG:</span>
                <span class="countdown-item">08</span> :
                <span class="countdown-item">45</span> :
                <span class="countdown-item">12</span>
            </div>
        </div>
        <div class="row g-3">
            <?php 
            $saleCount = 0;
            foreach ($saleProducts as $item) {
                if ($saleCount >= 6) break;
                $originalPrice = (float)$item['price'];
                $discount = (float)$item['discount'];
                $finalPrice = $originalPrice * (1 - $discount / 100);
                $displayDiscount = (int)round($discount);
                ?>
                <div class="col-lg-2 col-md-3 col-6">
                    <div class="ecom-product-card bg-white shadow-sm rounded-3 p-2 text-dark">
                        <?php if ($displayDiscount > 0): ?>
                            <span class="ecom-product-badge sale">-<?= $displayDiscount ?>%</span>
                        <?php endif; ?>
                        <a href="index.php?subpage=modules/Users/page/Detail.php&id=<?= $item['id'] ?>" class="text-center d-block">
                            <img src="<?= htmlspecialchars($item['image_url']) ?>" class="ecom-product-img" alt="<?= htmlspecialchars($item['name']) ?>" style="height: 140px;">
                        </a>
                        <h6 class="ecom-product-title mt-2 mb-1" style="font-size: 13px;">
                            <a href="index.php?subpage=modules/Users/page/Detail.php&id=<?= $item['id'] ?>" class="text-dark">
                                <?= htmlspecialchars($item['name']) ?>
                            </a>
                        </h6>
                        <div class="ecom-price-box">
                            <div class="price-current text-danger fw-bold" style="font-size: 15px;">
                                <?= number_format($finalPrice, 0, ',', '.') ?>₫
                            </div>
                            <?php if ($displayDiscount > 0): ?>
                                <div class="price-old text-muted text-decoration-line-through small" style="font-size: 11.5px;">
                                    <?= number_format($originalPrice, 0, ',', '.') ?>₫
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="sale-progress-bar">
                            <div class="sale-progress-fill" style="width: 75%;"></div>
                            <div class="sale-progress-text">🔥 ĐÃ BÁN 15/20</div>
                        </div>
                    </div>
                </div>
                <?php
                $saleCount++;
            }
            ?>
        </div>
    </div>
</div>
<?php endif; ?>



<!-- Sản phẩm nổi bật -->
<div class="container ecom-section ecom-carousel">
    <h3 class="ecom-title">Sản phẩm mới nhất</h3>
    <div id="featuredCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">
            <?php foreach (array_chunk($featuredProducts, 6) as $i => $group) { ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <div class="row g-3 product-list">
                        <?php foreach ($group as $item) {
                            $originalPrice = (float) $item['price'];
                            $discount = (float) $item['discount'];
                            $finalPrice = $originalPrice * (1 - $discount / 100);
                            $displayDiscount = (int) round($discount);
                            ?>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                <div class="ecom-product-card shadow-sm">
                                    <?php if ($displayDiscount > 0): ?>
                                        <span class="ecom-product-badge sale">-<?= $displayDiscount ?>%</span>
                                    <?php else: ?>
                                        <span class="ecom-product-badge new">Mới</span>
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
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<div class="container ecom-section">
    <div class="row g-3">

        <!-- Carousel Banner 1 -->
        <div class="col-md-6">
            <div id="bannerCarousel1" class="carousel slide ecom-small-banner-carousel" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://file.hstatic.net/200000722513/file/bot_promotion_banner_small_2_2ad55c2345c64fbfb87dab4957b33914.png"
                            class="img-fluid w-100" alt="Banner 1" style="height: 200px; object-fit: contain;">
                    </div>
                    <div class="carousel-item">
                        <img src="https://file.hstatic.net/200000722513/file/banner_790x250_tai_nghe_6f6dcb17d3a54fcc88b3de96762d2d41.jpg"
                            class="img-fluid w-100" alt="Banner 2" style="height: 200px; object-fit: contain;">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel1"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel1"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>

        <!-- Carousel Banner 2 -->
        <div class="col-md-6">
            <div id="bannerCarousel2" class="carousel slide ecom-small-banner-carousel" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://file.hstatic.net/200000722513/file/thang_06_banner_build_pc_top_promotion_banner_2.png"
                            class="img-fluid w-100" alt="Banner 3" style="height: 200px; object-fit: contain;">
                    </div>
                    <div class="carousel-item">
                        <img src="https://file.hstatic.net/200000722513/file/thang_06_banner_ghe_top_promotion_banner_1.png"
                            class="img-fluid w-100" alt="Banner 4" style="height: 200px; object-fit: contain;">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel2"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel2"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Sản phẩm giảm giá -->
<div class="container ecom-section ecom-carousel">
    <h3 class="ecom-title">Sản phẩm giảm giá</h3>
    <div id="saleCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">
            <?php foreach (array_chunk($saleProducts, 6) as $i => $group) { ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <div class="row g-3">
                        <?php foreach ($group as $item) {
                            $originalPrice = (float) $item['price'];
                            $discount = (float) $item['discount'];
                            $finalPrice = $originalPrice * (1 - $discount / 100);
                            $displayDiscount = (int) round($discount);
                            ?>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                <div class="ecom-product-card shadow-sm">
                                    <span class="ecom-product-badge sale">-<?= $displayDiscount ?>%</span>
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
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#saleCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#saleCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>