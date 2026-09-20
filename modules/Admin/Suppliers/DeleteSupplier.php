<?php
// Xử lý xóa mềm nhà cung cấp
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_supplier'])) {
    $id = $_POST['supplier_id'] ?? null;

    $result = $supplier->delete($id); // Giả sử là xóa mềm (cập nhật isDeleted = 1)
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Suppliers/Supplier.php';</script>";
    exit;
}
?>

<!-- Modal xác nhận xóa nhà cung cấp -->
<div class="modal fade" id="deleteSupplierModal" tabindex="-1" aria-labelledby="deleteSupplierModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">
            <form method="POST">
                <input type="hidden" name="delete_supplier" value="1">
                <input type="hidden" name="supplier_id" id="deleteSupplierId">

                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title" id="deleteSupplierModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Xác nhận xóa nhà cung cấp
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <p>Bạn có chắc chắn muốn xóa nhà cung cấp <strong id="deleteSupplierName"></strong> không?</p>
                    <?php if (!empty($errorMessageDelete)) : ?>
                        <div class="alert alert-danger"><?= $errorMessageDelete ?></div>
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
    document.addEventListener('DOMContentLoaded', function() {
        const deleteBtns = document.querySelectorAll('.delete-supplier-btn');
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;

                document.getElementById('deleteSupplierId').value = id;
                document.getElementById('deleteSupplierName').innerText = name;

                const modal = new bootstrap.Modal(document.getElementById('deleteSupplierModal'));
                modal.show();
            });
        });
    });
</script>