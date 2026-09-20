<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['role_id'])) {
    $id = $_POST['role_id'];

    // Gọi đến controller xóa
    $result = $roleController->delete($id); // Bạn đã có sẵn $roleController rồi

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Roles/Role.php';</script>";
    exit;
}
?>

<!-- Modal xác nhận xóa vai trò -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">
            <form method="POST">
                <input type="hidden" name="role_id" id="deleteRoleId">

                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title" id="deleteRoleModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Xác nhận xóa vai trò
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <p>Bạn có chắc chắn muốn xóa vai trò <strong id="deleteRoleName" class="text-danger"></strong> không?</p>
                    <?php if (!empty($errorMessageDelete)) : ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errorMessageDelete) ?></div>
                    <?php endif; ?>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Xóa
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>