<?php

$keyword = $_GET['search'] ?? '';



$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;



$totalCategories = $category->countCategoriesToDb($keyword);
$totalPages = ceil($totalCategories / $limit);
$listCategories = $category->getFilterCategoriesToDb($limit, $offset, $keyword);



?>
<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <?php
        if (hasPermission('modules/Admin/Categories/AddCategory.php')) {

        ?>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="bi bi-plus-circle me-2"></i> Thêm loại
            </button>
        <?php
        }
        ?>
        <form class="search-form ms-auto" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Categories/Category.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm loại sản phẩm...">
        </form>
    </div>


    <!-- Nhúng các modal -->
    <?php require_once 'modules/Admin/Categories/AddCategory.php'; ?>
    <?php require_once 'modules/Admin/Categories/UpdateCategory.php'; ?>
    <?php require_once 'modules/Admin/Categories/DeleteCategory.php'; ?>

    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 120px">ID</th>
                        <th style="width: 250px">Tên</th>
                        <th style="width: 160px">Biểu tượng</th>
                        <th style="width: 160px">Trạng thái</th>
                        <th style="width: 90px" class="text-center">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listCategories as $item): ?>
                        <tr>
                            <td style="color:black"><?= $item["id"] ?></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($item['icon']) ?>" width="100">
                            </td>
                            <td><?= $item['status'] ? 'Ẩn' : 'Hiển thị' ?></td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <?php if (hasPermission('modules/Admin/Categories/UpdateCategory.php')): ?>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-2" onclick="openEditCategoryModal(
                                                <?= $item['id'] ?>,
                                                '<?= addslashes($item['name']) ?>',
                                                '<?= addslashes($item['icon']) ?>',
                                                <?= $item['status'] ?>
                                                )">
                                                    <i class="fas fa-edit text-primary"></i> Sửa
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (hasPermission('modules/Admin/Categories/DeleteCategory.php')): ?>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-2 delete-category-btn text-danger"
                                                    data-id="<?= $item['id'] ?>" data-name="<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>">
                                                    <i class="fas fa-trash-alt text-danger"></i> Xóa
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </td>


                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="Admin.php?page=modules/Admin/Categories/Category.php&search=<?= $keyword ?>&number=<?= $i ?>">
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
    const addBtn = document.querySelector('a[href*="AddCategory.php"]');
    const loadingOverlay = document.getElementById('loadingOverlay');

    if (addBtn) {
        addBtn.addEventListener('click', function(e) {
            e.preventDefault();
            loadingOverlay.style.display = 'flex';
            setTimeout(() => {
                window.location.href = addBtn.href;
            }, 300);
        });
    }

    const editButtons = document.querySelectorAll('a[href*="UpdateCategory.php"]');
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