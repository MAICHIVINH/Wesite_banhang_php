<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restore_supplier'])) {
    $id = $_POST['restore_supplier_id'];
    $result = $supplier->restore($id);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }
    echo "<script>window.location.href ='Admin.php?page=modules/Admin/RecycleBin/Suppliers/Supplier.php';</script>";
    exit;
}
?>
<!-- Modal Khôi phục -->
<div class="modal fade" id="restoreSupplierModal" tabindex="-1" aria-labelledby="restoreSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">
            <form method="POST">
                <input type="hidden" name="restore_supplier" value="1">
                <input type="hidden" name="restore_supplier_id" id="restoreSupplierId">

                <div class="modal-header bg-success text-white">
                    <h6 class="modal-title"><i class="fas fa-undo me-2"></i> Xác nhận khôi phục</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="fas fa-undo fa-3x text-success mb-3"></i>
                    <p>Bạn có chắc muốn khôi phục nhà cung cấp <strong id="restoreSupplierName"></strong> không?</p>
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