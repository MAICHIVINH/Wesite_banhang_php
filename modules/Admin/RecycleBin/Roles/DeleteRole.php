<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_role'])) {

    $id = $_POST['delete_role_id'];

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

<!-- Modal Xóa -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">
            <form method="POST">
                <input type="hidden" name="delete_role" value="1">
                <input type="hidden" name="delete_role_id" id="deleteRoleId">

                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title">
                        <i class="fas fa-trash-alt me-2"></i> Xác nhận xóa vĩnh viễn
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p>Bạn có chắc muốn xóa vĩnh viễn quyền <strong id="deleteRoleName"></strong> không?</p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash-alt me-1"></i> Xóa
                    </button>
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>