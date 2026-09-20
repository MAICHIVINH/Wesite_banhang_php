<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category'])) {
    $id = $_POST['delete_category_id'] ?? null;

    if ($id) {
        $result = $category->delete($id); // Xóa mềm: cập nhật isDeleted = 1

        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }

        echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Categories/Category.php';</script>";
        exit;
    }
}
?>
<!-- Modal xác nhận xóa danh mục -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">
            <form method="POST">
                <input type="hidden" name="delete_category" value="1">
                <input type="hidden" name="delete_category_id" id="deleteCategoryId">

                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title d-flex align-items-center" id="deleteCategoryModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Xác nhận xóa loại sản phẩm
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <p>Bạn có chắc chắn muốn xóa loại sản phẩm <strong id="deleteCategoryName"></strong>?</p>
                    <?php if (!empty($deleteError)): ?>
                        <div class="alert alert-danger"><?= $deleteError ?></div>
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