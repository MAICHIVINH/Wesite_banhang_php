<?php
$keyword = $_GET['search'] ?? '';
$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalRole = $roleController->countRole($keyword, 1);
$totalPages = ceil($totalRole / $limit);

$listDeletedRoles = $roleController->getPagination($keyword, $limit, $offset, 1);

$totalRolesIsDeleted = $roleController->countIsDeleted();

?>

<?php require_once 'RestoreRole.php'; ?>
<?php require_once 'DeleteRole.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap p-3 rounded shadow-sm bg-light border">
        <h4 class="mb-0 fw-bold text-danger d-flex align-items-center">
            <i class="fas fa-trash-alt me-2"></i> Thùng rác - Quyền đã xóa
        </h4>
        <span class="badge bg-danger px-3 py-2 fs-6">
            <?= $totalRolesIsDeleted ?> mục đã xóa
        </span>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên quyền</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($listDeletedRoles)) : ?>
                    <tr>
                        <td colspan="3" class="text-center">Không có quyền nào trong thùng rác.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($listDeletedRoles as $role): ?>
                        <tr>
                            <td><?= $role['id'] ?></td>
                            <td><?= htmlspecialchars($role['role_name']) ?></td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <li>
                                            <button class="dropdown-item d-flex align-items-center gap-2 restore-btn text-success"
                                                data-bs-toggle="modal"
                                                data-bs-target="#restoreRoleModal"
                                                data-id="<?= $role['id'] ?>"
                                                data-name="<?= htmlspecialchars($role['role_name']) ?>">
                                                <i class="fas fa-undo text-success"></i> Khôi phục
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item d-flex align-items-center gap-2 delete-btn text-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteRoleModal"
                                                data-id="<?= $role['id'] ?>"
                                                data-name="<?= htmlspecialchars($role['role_name']) ?>">
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
            document.getElementById('restoreRoleId').value = button.getAttribute('data-id');
            document.getElementById('restoreRoleName').textContent = button.getAttribute('data-name');
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteRoleId').value = button.getAttribute('data-id');
            document.getElementById('deleteRoleName').textContent = button.getAttribute('data-name');
        });
    });
</script>