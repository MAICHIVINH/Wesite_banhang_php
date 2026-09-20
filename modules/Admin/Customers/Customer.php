<?php
$keyword = $_GET['search'] ?? '';

$limit = 8;
$totalUsers = $userController->countUser($keyword);

$totalPages = ceil($totalUsers / $limit);

$page = $_GET['number'] ?? 1;
$page = max(1, min($page, $totalPages));

$offset = ($page - 1) * $limit;
$customers = $userController->getPagination($limit, $offset, $keyword);


?>

<!-- Form tìm kiếm -->
<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <form class="search-form ms-auto" method="GET" action="Admin.php">
            <input type="hidden" name="page" value="modules/Admin/Customers/Customer.php">
            <button class="btn search-btn" type="submit">
                <i class="bi bi-search text-muted"></i>
            </button>
            <input type="search"
                name="search"
                value="<?= htmlspecialchars($keyword) ?>"
                class="form-control search-input"
                placeholder="Tìm khách hàng...">
        </form>
    </div>

    <?php
    require_once 'modules/Admin/Customers/UpdateCustomer.php';
    require_once 'modules/Admin/Customers/DeleteCustomer.php';
    require_once 'modules/Admin/Customers/ReportCustomer.php';
    require_once 'modules/Admin/Customers/DetailCustomer.php';
    require_once 'modules/Admin/Customers/DeleteCustomerReport.php';
    require_once 'modules/Admin/Customers/UpdatePassword.php';

    ?>

    <div class="d-flex justify-content-center">
        <div class="table-container">
            <table class="table table-bordered table-hover custom-table">
                <thead class="table-dark">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 20px; text-align: center">ID</th>
                            <th style="width: 150px">Họ tên</th>
                            <th style="width: 30px">Điện thoại</th>
                            <th style="width: 120px">Email</th>
                            <th style="width: 120px">Trạng thái</th>
                            <th class="text-center" style="width: 250px">Chức năng</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php foreach ($customers as $cus): ?>
                        <tr>
                            <td class="text-center"><?= $cus['id'] ?></td>
                            <td><?= htmlspecialchars($cus['FullName']) ?></td>
                            <td><?= htmlspecialchars($cus['Phone']) ?></td>
                            <td><?= htmlspecialchars($cus['Email']) ?></td>
                            <td>
                                <?php
                                $reportByUserId = $userReportController->getByUserId($cus['id']);

                                if ($reportByUserId && strtotime($reportByUserId['banned_until']) > time()) {
                                    echo "<span class='text-danger'>Bị cấm đến " . date('d/m/Y', strtotime($reportByUserId['banned_until'])) . "</span>";
                                } else {
                                    echo "<span class='text-success'>Đang hoạt động</span>";
                                }

                                ?>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <!-- Chi tiết -->
                                        <li>
                                            <button class="dropdown-item d-flex align-items-center gap-2 btn-detail-customer"
                                                data-id="<?= $cus['id'] ?>"
                                                data-fullname="<?= htmlspecialchars($cus['FullName']) ?>"
                                                data-phone="<?= htmlspecialchars($cus['Phone']) ?>"
                                                data-email="<?= htmlspecialchars($cus['Email']) ?>"
                                                data-address="<?= htmlspecialchars($cus['Address']) ?>"
                                                data-created="<?= htmlspecialchars($cus['CreatedAt']) ?>"
                                                data-status="<?= ($reportByUserId && strtotime($reportByUserId['banned_until']) > time()) ? 'Bị cấm đến ' . date('d/m/Y', strtotime($reportByUserId['banned_until'])) : 'Đang hoạt động' ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#detailCustomerModal">
                                                <i class="fas fa-info-circle text-info"></i> Chi tiết
                                            </button>
                                        </li>
                                        <?php if (hasPermission('modules/Admin/Customers/ReportCustomer.php')): ?>
                                            <!-- Báo cáo -->
                                            <li>
                                                <button class="dropdown-item d-flex align-items-center gap-2 btn-report-customer"
                                                    data-id="<?= $cus['id'] ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#reportCustomerModal">
                                                    <i class="fas fa-chart-bar text-warning"></i> Báo cáo
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (hasPermission('modules/Admin/Customers/UpdateCustomer.php')): ?>
                                            <!-- Sửa -->
                                            <li>
                                                <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                                    data-id="<?= $cus['id'] ?>"
                                                    data-fullname="<?= htmlspecialchars($cus['FullName']) ?>"
                                                    data-phone="<?= htmlspecialchars($cus['Phone']) ?>"
                                                    data-email="<?= htmlspecialchars($cus['Email']) ?>"
                                                    data-address="<?= htmlspecialchars($cus['Address']) ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCustomerModal">
                                                    <i class="fas fa-edit text-primary"></i> Sửa
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (hasPermission('modules/Admin/Customers/UpdatePassword.php')): ?>
                                            <!-- Đổi mật khẩu -->
                                            <li>
                                                <button class="dropdown-item d-flex align-items-center gap-2 btn-update-password"
                                                    data-id="<?= $cus['id'] ?>" data-bs-toggle="modal" data-bs-target="#updatePasswordModal">
                                                    <i class="fas fa-key text-dark"></i> Đổi mật khẩu
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (hasPermission('modules/Admin/Customers/DeleteCustomerReport.php')): ?>
                                            <li>
                                                <button
                                                    class="dropdown-item d-flex align-items-center gap-2 btn-delete-customer text-danger"
                                                    data-id="<?= $cus['id'] ?>"
                                                    data-name="<?= htmlspecialchars($cus['FullName']) ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteCustomerReportModal">
                                                    <i class="fas fa-trash-alt text-danger"></i> Gỡ báo cáo
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (hasPermission('modules/Admin/Customers/DeleteCustomer.php')): ?>
                                            <!-- Nút Xóa -->
                                            <li>
                                                <button
                                                    class="dropdown-item d-flex align-items-center gap-2 btn-delete-customer text-danger"
                                                    data-id="<?= $cus['id'] ?>"
                                                    data-name="<?= htmlspecialchars($cus['FullName']) ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteCustomerModal">
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

    <!-- Phân trang -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link"
                        href="Admin.php?page=modules/Admin/Customers/Customer.php&search=<?= urlencode($keyword) ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor ?>
        </ul>
    </nav>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(
            "#detailCustomerModal form, \
         #reportCustomerModal form, \
         #editCustomerModal form, \
         #deleteCustomerModal form, \
         #deleteCustomerReportModal form, \
         #updatePasswordModal form"
        ).forEach(form => {
            form.addEventListener("submit", function() {
                Loading(true);
            });
        });

        document.querySelectorAll(
            "#detailCustomerModal button[type=submit], \
         #reportCustomerModal button[type=submit], \
         #editCustomerModal button[type=submit], \
         #deleteCustomerModal button[type=submit], \
         #deleteCustomerReportModal button[type=submit], \
         #updatePasswordModal button[type=submit]"
        ).forEach(btn => {
            btn.addEventListener("click", function() {
                Loading(true);
            });
        });
    });
</script>