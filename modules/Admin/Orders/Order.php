<?php
$keyword = $_GET["search"] ?? "";
$page    = max(1, ($_GET['pageNumber'] ?? 1));
$limit   = 6;
$offset  = ($page - 1) * $limit;
$status_id = $_GET['status_id'] ?? null;
if ($status_id === '0') {
    $status_id = null;
}

$getAllStatus = $statusController->getAll();

$isAdmin = isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
$employeeId = $isAdmin ? null : ($employeeData->id ?? null);
$branch_id = $isAdmin ? null : ($employeeData->branch_id ?? null);

// Lấy dữ liệu từ controller
$listOrders = $orderController->getOrderWithStatusPagination($status_id, $limit, $offset, $keyword, $branch_id, $employeeId, $isAdmin);
$totalRows = $orderController->getCountOrderWithStatus($status_id, $keyword, $employeeId, $branch_id, $isAdmin);
$totalPages = max(1, ceil($totalRows / $limit));
?>


<!-- Form tìm kiếm -->
<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <form class="search-form ms-auto d-flex align-items-center gap-2" method="GET" style="width: 100%; max-width: 600px;">
            <input type="hidden" name="page" value="modules/Admin/Orders/Order.php">
            <input type="hidden" name="pageNumber" value="1">

            <!-- Thanh chọn trạng thái -->
            <select name="status_id"
                class="form-select rounded-pill"
                style="padding: 6px 15px; margin: 0; border: 1px solid #ccc; background-color: #fff; cursor: pointer; width: 320px"
                onchange="this.form.submit()">
                <option value="0">Tất cả trạng thái</option>
                <?php foreach ($getAllStatus as $status): ?>
                    <option value="<?= $status['id'] ?>" <?= (isset($_GET['status_id']) && $_GET['status_id'] == $status['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($status['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="input-group rounded-pill overflow-hidden" style="border: 1px solid #ccc;">
                <button class="input-group-text bg-white border-0" type="submit" style="cursor: pointer;">
                    <i class="bi bi-search text-muted"></i>
                </button>
                <input type="search"
                    name="search"
                    value="<?= htmlspecialchars($keyword) ?>"
                    class="form-control border-0"
                    placeholder="Tìm mã đơn hàng..."
                    style="padding: 5px;">
            </div>
        </form>
    </div>

    <!-- Bảng danh sách -->
    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="width: 70px">ID</th>
                        <th style="width: 250px">Người đặt</th>
                        <th>Ngày đặt</th>
                        <th style="width: 200px">Trạng thái</th>
                        <th style="width: 210px">Tổng tiền</th>
                        <th style="width: 100px">Nhân viên phụ trách</th>
                        <th style="width: 90px">Chức năng</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if (empty($listOrders)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Không tìm thấy đơn hàng nào.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($listOrders as $item): ?>
                            <tr>
                                <td><?= $item['code'] ?></td>
                                <td><?= htmlspecialchars($item['FullName']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($item['create_at'])) ?></td>
                                <td><?= htmlspecialchars($item['status_name']) ?></td>
                                <td><?= number_format((float)$item['total_amount'], decimals: 0) ?> đ</td>
                                <td>
                                    <?= $item['employee_id'] ? "Đã có người nhận" : 'không có nhân viên phụ trách' ?>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                            <li>
                                                <a href="Admin.php?page=modules/Admin/Orders/Order.php&id=<?= $item['order_id'] ?>"
                                                    class="dropdown-item d-flex align-items-center gap-2">
                                                    <i class="fas fa-eye text-info"></i> Xem
                                                </a>
                                            </li>
                                            <li>
                                                <a href="Admin.php?page=modules/Admin/Orders/Order.php&orderid=<?= $item['order_id'] ?>"
                                                    class="dropdown-item d-flex align-items-center gap-2">
                                                    <i class="fas fa-edit text-warning"></i> Sửa
                                                </a>
                                            </li>
                                            <?php if (hasPermission('modules/Admin/Orders/ChangeStatusOrder.php')): ?>
                                                <li>
                                                    <button type="button"
                                                        class="dropdown-item d-flex align-items-center gap-2 change-status-btn"
                                                        data-id="<?= $item['order_id'] ?>"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#changeStatusModal">
                                                        <i class="fas fa-sync-alt text-primary"></i> Chuyển trạng thái
                                                    </button>
                                                </li>
                                            <?php endif; ?>
                                            <?php if (hasPermission('modules/Admin/Inventory/DeleteOrder.php')): ?>
                                                <li>
                                                    <button type="button"
                                                        class="dropdown-item d-flex align-items-center gap-2 delete-order-btn text-danger"
                                                        data-id="<?= $item['order_id'] ?>"
                                                        data-code="<?= htmlspecialchars(trim($item['code'])) ?>"
                                                        data-customer="<?= htmlspecialchars($item['FullName']) ?>"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteOrderModal">
                                                        <i class="fas fa-trash-alt text-danger"></i> Xóa
                                                    </button>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- PHÂN TRANG -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="Admin.php?page=modules/Admin/Orders/Order.php&search=<?= urlencode($keyword) ?>&status_id=<?= urlencode($_GET['status_id'] ?? 0) ?>&pageNumber=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>


<?php
require_once 'modules/Admin/Orders/ChangeStatusOrder.php';
require_once 'modules/Admin/Orders/DeleteOrder.php';
require_once 'modules/Admin/Orders/UpdateOrder.php';
require_once 'modules/Admin/Orders/ViewOrder.php';
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const buttons = document.querySelectorAll('.delete-order-btn');

        buttons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const orderId = this.getAttribute('data-id');
                const orderCode = this.getAttribute('data-code');
                const customerName = this.getAttribute('data-customer');

                // Gán vào input hidden để submit
                document.getElementById('deleteOrderId').value = orderId;

                // Gán vào chỗ hiển thị trong modal
                document.getElementById('deleteOrderName').textContent =
                    `${orderCode} - ${customerName}`;
            });
        });
        // Lắng nghe submit form trong các modal đơn hàng
        document.querySelectorAll(
            "#changeStatusModal form, \
         #deleteOrderModal form, \
         #updateOrderModal form, \
         #viewOrderModal form"
        ).forEach(form => {
            form.addEventListener("submit", function() {
                Loading(true);
            });
        });

        // Lắng nghe click vào nút submit trong các modal đơn hàng
        document.querySelectorAll(
            "#changeStatusModal button[type=submit], \
         #deleteOrderModal button[type=submit], \
         #updateOrderModal button[type=submit], \
         #viewOrderModal button[type=submit]"
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