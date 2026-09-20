<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restore_role'])) {
    $id = $_POST['restore_role_id'];
    $result = $roleController->restore($id);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }
    echo "<script>window.location.href = window.location.href;</script>";
    exit;
}
?>

<!-- Modal Khôi phục -->
<div class="modal fade" id="restoreRoleModal" tabindex="-1" aria-labelledby="restoreRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">
            <form method="POST">
                <input type="hidden" name="restore_role" value="1">
                <input type="hidden" name="restore_role_id" id="restoreRoleId">

                <div class="modal-header bg-success text-white">
                    <h6 class="modal-title">
                        <i class="fas fa-undo me-2"></i> Xác nhận khôi phục
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="fas fa-undo fa-3x text-success mb-3"></i>
                    <p>Bạn có chắc muốn khôi phục quyền <strong id="restoreRoleName"></strong> không?</p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-check me-1"></i> Khôi phục
                    </button>
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>