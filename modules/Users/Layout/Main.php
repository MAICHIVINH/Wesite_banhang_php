<?php
$id_category = null;
$id_supplier = null;
$priceRanges = [];
$arrayBrand = [];
$arrayPrice = [];
$keyword = null;
$priceQuery = '';

if (isset($_GET['category']) && $_GET['category'] !== '') {
    $id_category = $_GET['category'];
}

if (isset($_GET['supplier']) && $_GET['supplier'] !== '') {
    $id_supplier = $_GET['supplier'];
}

if (isset($_GET['brand']) && $_GET['brand'] !== '') {
    $arrayBrand = (array) $_GET['brand'];
}
if (isset($_GET['price']) && $_GET['price'] !== '') {
    $arrayPrice = (array) $_GET['price'];
}

if (isset($_GET['price']) && $_GET['price'] !== '') {
    $priceRanges = $_GET['price'];
}

if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
}

if (!empty($arrayPrice)) {
    foreach ($arrayPrice as $p) {
        $priceQuery .= '&price[]=' . urlencode($p);
    }
}
?>

<div class="container mt-3">
    <div class="row g-3 align-items-start">
        <!-- Left Filter Sidebar -->
        <div class="col-12 col-lg-3">
            <div class="sticky-lg-top" style="top: 80px; z-index: 1020;">
                <?php include 'Sidebar.php'; ?>
            </div>
        </div>

        <!-- Right Product Area -->
        <div class="col-12 col-lg-9">
            <?php
            if (isset($_GET['page'])) {
                require $_GET['page'];
            } else {
                require './modules/Users/page/Product.php';
            }
            ?>
        </div>
    </div>
</div>