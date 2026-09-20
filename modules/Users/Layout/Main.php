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

<div class="mt-3">
    <div class="d-flex" style="min-height: 100vh;">
        <div style="width: 310px;">
            <div style="position: sticky; top: 70px; z-index: 1029;">
                <?php include 'Sidebar.php'; ?>
            </div>
        </div>

        <div class="flex-grow-1 ms-3">
            <div class="row g-3">
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
</div>