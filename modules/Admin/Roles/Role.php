<?php

$keyword = $_GET['search'] ?? '';
$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalRole = $roleController->countRole($keyword);
$totalPages = ceil($totalRole / $limit);

$listItems = $roleController->getPagination($keyword, $limit, $offset);

?>

<div class="product-container">

    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <?php
        if (hasPermission('modules/Admin/Roles/AddRole.php')) {
        ?>
            <!-- Nút thêm quyền -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                <i class="bi bi-plus-circle me-2"></i> Thêm quyền
            </button>
        <?php
        }
        ?>

        <!-- Form tìm kiếm quyền -->
        <form class="search-form ms-auto" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Roles/Role.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm kiếm quyền...">
        </form>
    </div>

    <table class="table table-bordered custom-table">
        <thead class="table-dark">
            <tr>
                <th style="width: 100px">ID</th>
                <th>Tên quyền</th>
                <th class="text-center" style="width: 90px">Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listItems as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['id'] ?></td>
                    <td><?= htmlspecialchars($item['role_name']) ?></td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <?php if (hasPermission('modules/Admin/Roles/UpdateRole.php')): ?>
                                    <li>
                                        <a href="Admin.php?page=modules/Admin/Roles/Role.php&edit_id=<?= $item['id'] ?>" class="dropdown-item d-flex align-items-center gap-2">
                                            <i class="fas fa-edit text-primary"></i> Sửa
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (hasPermission('modules/Admin/Role/DeleteRole.php')): ?>
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteRoleModal"
                                            data-id="<?= $item['id'] ?>"
                                            data-name="<?= htmlspecialchars($item['role_name']) ?>">
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

    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="Admin.php?page=modules/Admin/Roles/Role.php&search=<?= urlencode($keyword) ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>

<?php
require_once './modules/Admin/Roles/DeleteRole.php';

require_once './modules/Admin/Roles/UpdateRole.php';

require_once './modules/Admin/Roles/AddRole.php';
?>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lắng nghe submit form trong các modal role
        document.querySelectorAll(
            "#addRoleModal form, \
         #editRoleModal form, \
         #deleteRoleModal form"
        ).forEach(form => {
            form.addEventListener("submit", function() {
                Loading(true);
            });
        });

        // Lắng nghe click nút submit trong các modal role
        document.querySelectorAll(
            "#addRoleModal button[type=submit], \
         #editRoleModal button[type=submit], \
         #deleteRoleModal button[type=submit]"
        ).forEach(btn => {
            btn.addEventListener("click", function() {
                Loading(true);
            });
        });

        // Lắng nghe submit form tìm kiếm
        const searchForm = document.querySelector(".search-form");
        if (searchForm) {
            searchForm.addEventListener("submit", function() {
                Loading(true);
            });
        }

        // Lắng nghe click phân trang
        document.querySelectorAll(".pagination .page-link").forEach(link => {
            link.addEventListener("click", function() {
                Loading(true);
            });
        });
    });
</script>