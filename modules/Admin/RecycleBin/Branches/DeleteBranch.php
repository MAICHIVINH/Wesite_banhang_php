<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_branch_isDeleted'])) {
    $id = $_POST['delete_branch_id'];

    $result = $branchController->deleteIsDeleted($id);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href='Admin.php?page=modules/Admin/RecycleBin/Branches/Branch.php'</script>";
    exit;
}
?>

<div class="modal fade" id="deleteBranchModal" tabindex="-1" aria-labelledby="deleteBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">
            <form method="POST">
                <input type="hidden" name="delete_branch_isDeleted" value="1">
                <input type="hidden" name="delete_branch_id" id="deleteBranchId">
                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title d-flex align-items-center" id="deleteBranchModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Xác nhận xóa
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <p>Bạn có chắc muốn xóa vĩnh viễn chi nhánh <strong id="deleteBranchName"></strong>?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash me-1"></i> Xóa
                    </button>
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>