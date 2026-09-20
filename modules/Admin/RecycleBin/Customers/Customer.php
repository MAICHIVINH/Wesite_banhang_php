<?php
// Dữ liệu ảo khách hàng đã xóa
$keyword = $_GET['search'] ?? '';

$limit = 8;
$totalUsers = $userController->countUser($keyword, 1);

$totalPages = ceil($totalUsers / $limit);

$page = $_GET['number'] ?? 1;
$page = max(1, min($page, $totalPages));

$offset = ($page - 1) * $limit;
$listDeletedCustomers = $userController->getPagination($limit, $offset, $keyword, 1);

?>

<?php require_once 'RestoreCustomer.php'; ?>
<?php require_once 'DeleteCustomer.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap p-3 rounded shadow-sm bg-light border">
        <h4 class="mb-0 fw-bold text-danger d-flex align-items-center">
            <i class="fas fa-trash-alt me-2"></i> Thùng rác - Khách hàng đã xóa
        </h4>
        <span class="badge bg-danger px-3 py-2 fs-6">
            <?= $totalUsers ?> mục đã xóa
        </span>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Trạng thái</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($listDeletedCustomers)) : ?>
                    <tr>
                        <td colspan="6" class="text-center">Không có khách hàng nào trong thùng rác.</td>
                    </tr>
                <?php else : ?>
                <?php foreach ($listDeletedCustomers as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= htmlspecialchars($item['FullName']) ?></td>
                        <td><?= htmlspecialchars($item['Phone']) ?></td>
                        <td><?= htmlspecialchars($item['Email']) ?></td>
                        <td> <?php
                                $reportByUserId = $userReportController->getByUserId($item['id']);

                                if ($reportByUserId && strtotime($reportByUserId['banned_until']) > time()) {
                                    echo "<span class='text-danger'>Bị cấm đến " . date('d/m/Y', strtotime($reportByUserId['banned_until'])) . "</span>";
                                } else {
                                    echo "<span class='text-success'>Đang bị xóa</span>";
                                }

                                ?></td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center gap-2 restore-btn text-success"
                                            data-bs-toggle="modal"
                                            data-bs-target="#restoreCustomerModal"
                                            data-id="<?= $item['id'] ?>"
                                            data-name="<?= htmlspecialchars($item['FullName']) ?>">
                                            <i class="fas fa-undo text-success"></i> Khôi phục
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center gap-2 delete-btn text-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteCustomerModal"
                                            data-id="<?= $item['id'] ?>"
                                            data-name="<?= htmlspecialchars($item['FullName']) ?>">
                                            <i class="fas fa-trash-alt text-danger"></i> Xóa vĩnh viễn
                                        </button>
                                    </li>
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

<script>
    const restoreButtons = document.querySelectorAll('.restore-btn');
    const deleteButtons = document.querySelectorAll('.delete-btn');

    restoreButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('restoreCustomerId').value = button.getAttribute('data-id');
            document.getElementById('restoreCustomerName').textContent = button.getAttribute('data-name');
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteCustomerId').value = button.getAttribute('data-id');
            document.getElementById('deleteCustomerName').textContent = button.getAttribute('data-name');
        });
    });
</script>