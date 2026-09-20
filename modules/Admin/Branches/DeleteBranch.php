<?php

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete_branch'])) {
    $id = $_POST['branch_id'];

    $result = $branchController->delete($id);
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Branches/Branch.php';</script>";
    exit;
}
?>
<!-- Modal xác nhận xóa chi nhánh -->
<div class="modal fade" id="deleteBranchModal" tabindex="-1" aria-labelledby="deleteBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">
            <form method="POST">
                <input type="hidden" name="delete_branch" value="1">
                <input type="hidden" name="branch_id" id="deleteBranchId">

                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title" id="deleteBranchModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Xác nhận xóa chi nhánh
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <p>Bạn có chắc chắn muốn xóa chi nhánh <strong id="deleteBranchName" class="text-danger"></strong> không?</p>
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
<script>
    document.getElementById("deleteBranchModal").addEventListener("submit", function() {
        Loading(true);
    });
</script>