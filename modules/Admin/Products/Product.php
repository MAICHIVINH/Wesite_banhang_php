<?php

// $listProduct = $product->getAll();
$id_category = null;
$id_supplier = null;
$keyword = $_GET['search'] ?? '';


$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalProducts = $product->countProductsToDb($id_category, $id_supplier, $keyword);
$totalPages = ceil($totalProducts / $limit);

$listProduct = $product->getFilterProductsToDb($id_category, $id_supplier, $keyword, $limit, $offset);


?>
<?php require_once 'modules/Admin/Products/DeleteProduct.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <?php
        if (hasPermission('modules/Admin/Products/Product.php')) {
        ?>
            <a href="Admin.php?page=modules/Admin/Products/AddProduct.php" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i> Thêm sản phẩm
            </a>
        <?php
        }
        ?>

        <form class="search-form ms-auto" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Products/Product.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Nhập tên sản phẩm cần tìm ...">
        </form>
    </div>

    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 80px">Mã</th>
                        <th style="width: 100px">Hình ảnh</th>
                        <th style="width: 260px">Tên sản phẩm</th>
                        <th style="width: 100px">Giá</th>
                        <th style="width: 100px">Giảm giá</th>
                        <th style="width: 160px">Loại sản phẩm</th>
                        <th style="width: 160px">Nhà cung cấp</th>
                        <th style="width: 160px">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($listProduct as $item) {
                    ?>
                        <tr id="product-row-<?= $item['id'] ?>">
                            <td style="color:black"><?php echo $item["id"] ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="Ảnh sản phẩm" style="width: 100px; height: 80px;">
                            </td>
                            <td><?php echo htmlspecialchars($item['name']) ?></td>
                            <td><?php echo number_format($item['price'], 0) ?></td>
                            <td><?= (int)$item['discount'] ?>%</td>
                            <td>
                                <?php
                                $categoryItem = $category->getById($item["category_id"]);
                                echo $categoryItem['name'];
                                ?>
                            </td>
                            <td>
                                <?php
                                $supplierItem = $supplier->getById($item["supplier_id"]);
                                echo $supplierItem['name'];
                                ?>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <?php if (hasPermission('modules/Admin/Products/UpdateProduct.php')): ?>
                                            <li>
                                                <a href="Admin.php?page=modules/Admin/Products/UpdateProduct.php&id=<?= $item['id'] ?>" class="dropdown-item">
                                                    <i class="fas fa-edit me-2 text-primary"></i> Chỉnh sửa
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (hasPermission('modules/Admin/Products/DeleteProduct.php')): ?>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger delete-btn"
                                                    data-bs-toggle="modal" data-bs-target="#deleteProductModal"
                                                    data-id="<?= $item['id'] ?>" data-name="<?= htmlspecialchars($item['name']) ?>">
                                                    <i class="fas fa-trash-alt me-2"></i> Xóa sản phẩm
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="Admin.php?page=modules/Admin/Products/Product.php&category=<?= $id_category ?>&supplier=<?= $id_supplier ?>&search=<?= $keyword ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>

<!-- Spinner -->
<div id="loadingOverlay" style="display:none; position:fixed; z-index:9999; background:rgba(0,0,0,0.5); top:0; left:0; width:100%; height:100%; justify-content:center; align-items:center;">
    <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<script>
    const addBtn = document.querySelector('a[href*="AddProduct.php"]');
    const loadingOverlay = document.getElementById('loadingOverlay');

    document.querySelectorAll('#deleteProductForm').forEach(form => {
        form.addEventListener('submit', function() {
            loadingOverlay.style.display = 'flex';
        });
    });


    if (addBtn) {
        addBtn.addEventListener('click', function(e) {
            e.preventDefault();
            loadingOverlay.style.display = 'flex';
            setTimeout(() => {
                window.location.href = addBtn.href;
            }, 300);
        });
    }

    const editButtons = document.querySelectorAll('a[href*="UpdateProduct.php"]');
    editButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            loadingOverlay.style.display = 'flex';
            setTimeout(() => {
                window.location.href = btn.href;
            }, 300);
        });
    });

    const pageLinks = document.querySelectorAll('a.page-link');
    pageLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            loadingOverlay.style.display = 'flex';
            setTimeout(() => {
                window.location.href = link.href;
            }, 300);
        });
    });
</script>