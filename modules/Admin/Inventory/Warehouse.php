<?php

$allProducts = $product->getAll();
$allBranches = $branchController->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_inventory'])) {
    $product_id = $_POST['product_id'];
    $branch_id  = $_POST['branch_id'];
    $quantity   = (int)$_POST['quantity'];
    $isLoading = true;
    $existing = $inventoryController->getProductInventory($product_id, $branch_id);

    if ($existing) {
        foreach ($existing as $item) {
            $newQty = $item['stock_quantity'] + $quantity;

            $result = $inventoryController->edit($item['inventory_id'], [
                'stock_quantity' => $newQty,
                'last_update' => date('Y-m-d H:i:s')
            ]);
        }
        $isLoading = $result['success'];
    } else {
        $result = $inventoryController->add([
            'product_id' => $product_id,
            'branch_id' => $branch_id,
            'stock_quantity' => $quantity,
            'last_update' => date('Y-m-d H:i:s'),
            'isDeleted' => 0
        ]);
        $isLoading = $result['success'];
    }
    if ($isLoading) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Inventory/Inventory.php';</script>";
    exit;
}
?>

<div class="modal fade" id="importGeneralModal" tabindex="-1" aria-labelledby="importGeneralModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="importGeneralModalLabel">Nhập hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Chọn sản phẩm</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <?php foreach ($allProducts as $product) { ?>
                                <option value="<?= $product['id'] ?>">
                                    <?= htmlspecialchars($product['name']) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="branch_id" class="form-label">Chi nhánh</label>
                        <select name="branch_id" id="branch_id" class="form-select" required>
                            <?php foreach ($allBranches as $branch): ?>
                                <option value="<?= $branch['id'] ?>">
                                    <?= htmlspecialchars($branch['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Số lượng nhập</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="add_inventory">Xác nhận</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button></button>
                </div>
            </form>
        </div>
    </div>
</div>