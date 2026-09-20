<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restore_category'])) {
    $id = $_POST['restore_category_id'];
    $result = $category->restore($id);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }
    echo "<script>window.location.href = window.location.href;</script>";
    exit;
}
?>

<div class="modal fade" id="restoreCategoryModal" tabindex="-1" aria-labelledby="restoreCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="restore_category" value="1">
                <input type="hidden" name="restore_category_id" id="restoreCategoryId">

                <div class="modal-header bg-success text-white">
                    <h6 class="modal-title" id="restoreCategoryModalLabel">
                        <i class="fas fa-undo me-2"></i> Xác nhận khôi phục
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="fas fa-undo fa-3x text-success mb-3"></i>
                    <p>Bạn có chắc muốn khôi phục danh mục <strong id="restoreCategoryName"></strong> không?</p>
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