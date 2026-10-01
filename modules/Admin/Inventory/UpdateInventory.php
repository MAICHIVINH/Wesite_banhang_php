<?php
$allBranches = $branchController->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_item'])) {
    $id = $_POST['id'] ?? null;
    $product_id = $_POST['product_id'] ?? null;

    $branch_id  = $_POST['branch_id'] ?? null;
    $stockQuantity = $_POST['stock_quantity'] ?? 0;

    $result = $inventoryController->edit($id, [
        'stock_quantity' => (int)$stockQuantity,
        'last_update' => date('Y-m-d H:i:s')
    ]);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Inventory/Inventory.php';</script>";
    exit;
}
?>
<div class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addInventoryModalLabel">
                        Sửa kho hàng
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="update_item" value="1">
                    <input type="hidden" name="id" id="editItemWarehouseId">
                    <input type="hidden" name="product_id" id="editIdProduct">

                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="product_name" id="editItemProductName" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số lượng</label>
                        <input type="number" name="stock_quantity" id="editItemQuantity" class="form-control" required min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Chi nhánh</label>
                        <select disabled id="editItemBranch" class="form-select">
                            <?php foreach ($allBranches as $branch) { ?>
                                <option value="<?= $branch['id'] ?>"><?= htmlspecialchars($branch['name']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Lưu thay đổi
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>