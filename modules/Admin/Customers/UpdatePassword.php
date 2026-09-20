<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'])) {
    $userId = $_POST['user_id'] ?? null;
    $newPassword = $_POST['new_password'] ?? null;

    $result = $userController->updatePasswordByAdmin($userId, $newPassword);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Customers/Customer.php';</script>";
    exit;
}

?>


<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="updatePasswordForm" method="POST">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="updatePasswordModalLabel">Cập nhật mật khẩu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="update-password-user-id">
                    <div class="mb-3">
                        <label for="new-password" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" name="new_password" id="new-password" required minlength="6" maxlength="32">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('.btn-update-password');
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const userId = btn.getAttribute('data-id');
                document.getElementById('update-password-user-id').value = userId;
            });
        });
    });
</script>