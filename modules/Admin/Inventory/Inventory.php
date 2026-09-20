<?php
$keyword = $_GET['search'] ?? '';


$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$isAdmin = isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
$branch_id = $isAdmin ? null : ($employeeData->branch_id ?? null);


$totalInventory = $inventoryController->countInventory($keyword, $branch_id, $isAdmin);
$totalPages = ceil($totalInventory / $limit);

$listItems = $inventoryController->getProductPagination($keyword, $limit, $offset, $branch_id, $isAdmin);

// var_dump($listItems); exit; 
?>


<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <?php
        if (hasPermission('modules/Admin/Inventory/Warehouse.php')) {

        ?>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importGeneralModal">
                <i class="fas fa-truck-loading me-1"></i> Nhập hàng
            </button>
        <?php
        }
        ?>
        <form class="search-form ms-auto" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Inventory/Inventory.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm sản phẩm trong kho...">
        </form>
    </div>


    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px; text-align:center">ID</th>
                        <th>Tên Sản Phẩm</th>
                        <th style="width: 120px">Số Lượng</th>
                        <th style="width: 200px">Chi nhánh</th>
                        <th style="width: 200px">Lần Cập Nhật Gần Nhất</th>
                        <th class="text-center" style="width: 90px">Chức Năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listItems as $item) { ?>
                        <tr>
                            <td class="text-center" style="color:black"><?= htmlspecialchars($item["id"]) ?></td>
                            <td class="text-center"><?= htmlspecialchars($item['product_name'] ?? 'N/A') ?></td>
                            <td class="text-center"><?= number_format($item['stock_quantity'], 0) ?></td>
                            <td class="text-center"><?= htmlspecialchars($item['branch_name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($item['last_update'] ?? 'N/A') ?></td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <?php if (hasPermission('modules/Admin/Inventory/AddInventory.php')): ?>
                                            <li>
                                                <button
                                                    class="dropdown-item d-flex align-items-center gap-2 text-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#addItemModal"
                                                    data-id="<?= htmlspecialchars($item['id']) ?>"
                                                    data-product-name="<?= htmlspecialchars($item['product_name']) ?>"
                                                    data-stock-quantity="<?= htmlspecialchars($item['stock_quantity']) ?>"
                                                    data-stock-branch="<?= htmlspecialchars($item['branch_name']) ?>">
                                                    <i class="fas fa-plus-circle text-success"></i> Thêm số lượng
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (hasPermission('modules/Admin/Inventory/UpdateInventory.php')): ?>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                                    data-id="<?= htmlspecialchars($item['id']) ?>"
                                                    data-product-name="<?= htmlspecialchars($item['product_name']) ?>"
                                                    data-stock-quantity="<?= htmlspecialchars($item['stock_quantity']) ?>"
                                                    data-branch-id="<?= htmlspecialchars($item['branch_id']) ?>"
                                                    data-product-id="<?= htmlspecialchars($item['product_id']) ?>"
                                                    data-bs-toggle="modal" data-bs-target="#editItemModal">
                                                    <i class="fas fa-edit text-primary"></i> Sửa số lượng
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (hasPermission('modules/Admin/Inventory/TransferWarehouse.php')): ?>
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-2 text-warning"
                                                    data-id="<?= $item['id'] ?>"
                                                    data-product-name="<?= $item['product_name'] ?>"
                                                    data-stock-quantity="<?= $item['stock_quantity'] ?>"
                                                    data-branch-name="<?= $item['branch_name'] ?>"
                                                    data-branch-id="<?= $item['branch_id'] ?>"
                                                    data-product-id="<?= $item['product_id'] ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#transferWarehouseModal">
                                                    <i class="fas fa-random text-warning"></i> Chuyển kho
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
    </div>

    <!-- Phân trang -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="Admin.php?page=modules/Admin/Inventory/Inventory.php&search=<?= urlencode($keyword) ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor ?>
        </ul>
    </nav>
</div>

<?php
require_once './modules/Admin/Inventory/Warehouse.php';
require_once 'modules/Admin/Inventory/AddInventory.php';
require_once 'modules/Admin/Inventory/UpdateInventory.php';
require_once 'modules/Admin/Inventory/TransferWarehouse.php';

?>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Tìm tất cả các form trong các modal và thêm loading khi submit
        document.querySelectorAll(
            "#importGeneralModal form, \
         #addItemModal form, \
         #editItemModal form, \
         #transferWarehouseModal form"
        ).forEach(form => {
            form.addEventListener("submit", function() {
                Loading(true);
            });
        });

        // Nếu có nút AJAX thì cũng thêm loading khi click
        document.querySelectorAll(
            "#importGeneralModal button[type=submit], \
         #addItemModal button[type=submit], \
         #editItemModal button[type=submit], \
         #transferWarehouseModal button[type=submit]"
        ).forEach(btn => {
            btn.addEventListener("click", function() {
                Loading(true);
            });
        });
    });
</script>