<?php

$keyword = $_GET['search'] ?? '';

$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalBranch = $branchController->countBranch($keyword);
$totalPages = ceil($totalBranch / $limit);
$listItems = $branchController->getPagination($limit, $offset, $keyword);

require_once './modules/Admin/Branches/DeleteBranch.php';

?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <?php
        if (hasPermission('modules/Admin/Branches/AddBranch.php')) {
        ?>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBranchModal">
                <i class="bi bi-plus-circle me-2"></i> Thêm chi nhánh
            </button>
        <?php
        }
        ?>
        <form class="search-form ms-auto" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Branches/Branch.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm chức năng (Branch)...">
        </form>
    </div>


    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th style="width: 80px">Mã</th>
                    <th>Tên chi nhánh</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Ngày tạo</th>
                    <th class="text-center" style="width: 90px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listItems as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['id'] ?></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['address']) ?></td>
                        <td><?= htmlspecialchars($item['phone']) ?></td>
                        <td><?= htmlspecialchars($item['email']) ?></td>
                        <td><?= htmlspecialchars($item['created_at']) ?></td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <?php if (hasPermission('modules/Admin/Branches/UpdateBranch.php')): ?>
                                        <li>
                                            <button class="dropdown-item d-flex align-items-center gap-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editBranchModal"
                                                data-id="<?= $item['id'] ?>"
                                                data-name="<?= htmlspecialchars($item['name']) ?>"
                                                data-address="<?= htmlspecialchars($item['address']) ?>"
                                                data-phone="<?= htmlspecialchars($item['phone']) ?>"
                                                data-email="<?= htmlspecialchars($item['email']) ?>">
                                                <i class="fas fa-edit text-primary"></i> Sửa
                                            </button>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (hasPermission('modules/Admin/Branches/DeleteBranch.php')): ?>
                                        <li>
                                            <button class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteBranchModal"
                                                data-id="<?= $item['id'] ?>"
                                                data-name="<?= htmlspecialchars($item['name']) ?>">
                                                <i class="fas fa-trash-alt text-danger"></i> Xóa
                                            </button>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link"
                        href="Admin.php?page=modules/Admin/Branches/Branch.php&search=<?= urlencode($keyword) ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>
<?php
require_once './modules/Admin/Branches/AddBranch.php';
require_once './modules/Admin/Branches/UpdateBranch.php';
?>


<script>
    const loadingOverlay = document.getElementById('loadingOverlay');

    document.querySelectorAll('#addBranchForm, #editBranchModal form, #deleteBranchModal form')
        .forEach(form => {
            form.addEventListener('submit', function() {
                loadingOverlay.style.display = 'flex';
            });
        });

    // Loading khi chuyển trang phân trang
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