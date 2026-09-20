<?php

$supplierGetAll = $supplier->getAllToDb();
$categoryGetAll = $category->getAllToDb();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restore_product'])) {
    $id = $_POST['restore_product_id'];
    if ($_POST['category_id'] === "0" || $_POST['supplier_id'] === "0") {
        $_SESSION['error'] = "Bạn cần chọn loại hoặc nhà cung cấp";
    } else {
        $data = [
            'category_id' => $_POST['category_id'],
            'supplier_id' => $_POST['supplier_id'],
            'isDeleted' => 0
        ];
        $result = $product->restore($id, $data);

        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
    }
    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/RecycleBin/Products/Product.php'</script>";
    exit;
}
?>

<div class="modal fade" id="restoreProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header bg-success text-white">
                    <h6 class="modal-title"><i class="fas fa-undo me-2"></i> Xác nhận khôi phục</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="restore_product_id" id="restore-product-id">

                    <div class="text-center mb-3">
                        <i class="fas fa-undo fa-3x text-success mb-3"></i>
                        <p>Bạn có chắc muốn khôi phục sản phẩm <strong id="restore-product-name"></strong> không?</p>
                    </div>

                    <!-- Select Nhà cung cấp -->
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Chọn Nhà cung cấp</label>
                        <select name="supplier_id" id="supplier_id" class="form-select" required>
                            <option value="0">-- Chọn nhà cung cấp --</option>
                            <?php foreach ($supplierGetAll as $sup): ?>
                                <option value="<?= $sup['id'] ?>"><?= htmlspecialchars($sup['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Select Danh mục -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Chọn Danh mục</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="0">-- Chọn danh mục --</option>
                            <?php foreach ($categoryGetAll as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" name="restore_product" class="btn btn-success">Khôi phục</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const restoreModal = document.getElementById('restoreProductModal');
        restoreModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            document.getElementById('restore-product-id').value = id;
            document.getElementById('restore-product-name').textContent = name;
        });
    });
</script>