<?php

$keyword = $_GET['search'] ?? '';

$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalMenu = $menuController->countMenu($keyword);

$totalPages = ceil($totalMenu / $limit);

$listItems = $menuController->getPagination($keyword, $limit, $offset);

?>



<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <?php
        if (hasPermission('modules/Admin/Menus/AddMenu.php')) {
        ?>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                <i class="bi bi-plus-circle me-2"></i> Thêm chức năng
            </button>
        <?php
        }
        ?>
        <form class="search-form ms-auto" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Menus/Menu.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm chức năng (menu)...">
        </form>
    </div>


    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th style="width: 80px">ID</th>
                    <th>Tên chức năng</th>
                    <th>Đường dẫn</th>
                    <th>Ngày tạo</th>
                    <th class="text-center" style="width: 90px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listItems as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['id'] ?></td>
                        <td><?= htmlspecialchars($item['menu_name']) ?></td>
                        <td><?= htmlspecialchars($item['menu_url']) ?></td>
                        <td><?= htmlspecialchars($item['created_at']) ?></td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <?php if (hasPermission('modules/Admin/Menus/UpdateMenu.php')): ?>
                                        <li>
                                            <button
                                                type="button"
                                                class="dropdown-item d-flex align-items-center gap-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editMenuModal"
                                                data-id="<?= $item['id'] ?>"
                                                data-name="<?= htmlspecialchars($item['menu_name']) ?>"
                                                data-url="<?= htmlspecialchars($item['menu_url']) ?>">
                                                <i class="fas fa-edit text-primary"></i> Sửa
                                            </button>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (hasPermission('modules/Admin/Menus/DeleteMenu.php')): ?>
                                        <li>
                                            <button
                                                type="button"
                                                class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteMenuModal"
                                                data-id="<?= $item['id'] ?>"
                                                data-name="<?= htmlspecialchars($item['menu_name']) ?>">
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
                        href="Admin.php?page=modules/Admin/Menus/Menu.php&search=<?= urlencode($keyword) ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>

</div>
<!-- Các form xử lý ẩn -->

<?php
// xử lý xóa

require_once './modules/Admin/Menus/DeleteMenu.php';
require_once './modules/Admin/Menus/AddMenu.php';
require_once './modules/Admin/Menus/UpdateMenu.php';

?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteModal = document.getElementById('deleteMenuModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Nút bấm mở modal
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');

            // Gán vào input hidden và hiển thị tên
            document.getElementById('deleteMenuId').value = id;
            document.getElementById('deleteBranchName').textContent = name;
        });

        // Lắng nghe submit form trong các modal menu
        document.querySelectorAll(
            "#addMenuModal form, \
         #editMenuModal form, \
         #deleteMenuModal form"
        ).forEach(form => {
            form.addEventListener("submit", function() {
                Loading(true);
            });
        });

        // Lắng nghe click nút submit trong các modal menu
        document.querySelectorAll(
            "#addMenuModal button[type=submit], \
         #editMenuModal button[type=submit], \
         #deleteMenuModal button[type=submit]"
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