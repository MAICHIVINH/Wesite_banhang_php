<?php
$allBranches = $branchController->getAll();
if ($_SERVER['REQUEST_METHOD'] && isset($_POST['transferWarehouseModal'])) {
    $id = $_POST['inventory_id'] ?? null;
    $branch_id = $_POST['from_branch_id'];
    $product_id = $_POST['product_id'];

    $stock_quantity = $_POST['quantity'];
    $stock_to_branch = $_POST['to_branch_id'];
    if ($branch_id === $stock_to_branch) {
        $_SESSION['error'] = 'Bạn cần phải chọn kho hàng khác với khó hàng cần chuyển';
    } else {
        $existing = $inventoryController->getProductInventory(
            $product_id,
            $stock_to_branch,
            true,
            $id
        );

        if ($existing) {
            $newQty = $existing['stock_quantity'] + $stock_quantity;

            $resultTrans = $inventoryController->edit($existing['inventory_id'], [
                'stock_quantity' => $newQty,
                'last_update' => date('Y-m-d H:i:s')
            ]);

            if ($resultTrans['success']) {
                $inventoryById = $inventoryController->getById($id);
                if ($inventoryById) {
                    $newQtyById = $inventoryById['stock_quantity'] - $stock_quantity;

                    $result = $inventoryController->edit($id, [

                        'stock_quantity' => $newQtyById,
                        'last_update' => date('Y-m-d H:i:s')

                    ]);

                    $isLoading = $result['success'];
                }
            } else {
                $_SESSION['error'] = $result['message'];
                $isLoading = $result['success'];
            }
        } else {
            $result = $inventoryController->add([
                'brand_id' => $stock_to_branch,
                'product_id' => $product_id,
                'stock_quantity' => $stock_quantity,
                'isDeleted' => 0
            ]);
            $isLoading = $result['success'];
        }
        if ($isLoading) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
    }



    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Inventory/Inventory.php';</script>";
    exit;
}
?>

<!-- Modal Chuyển Kho -->
<div class="modal fade" id="transferWarehouseModal" tabindex="-1" aria-labelledby="transferWarehouseLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="transferWarehouseLabel">
                    <i class="fas fa-random me-2"></i> Chuyển kho sản phẩm
                </h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST">
                <div class="modal-body row">
                    <!-- Bên trái: Thông tin sản phẩm -->
                    <div class="col-md-6 border-end">
                        <h6 class="fw-bold">Thông tin sản phẩm:</h6>
                        <p>ID: <strong id="transferProductId"></strong></p>
                        <p>Tên sản phẩm: <strong id="transferProductName"></strong></p>
                        <p>Số lượng hiện tại: <strong id="transferStockQuantity"></strong></p>
                        <p>Chi nhánh hiện tại: <strong id="transferBranchName"></strong></p>
                    </div>

                    <!-- Bên phải: Form chuyển -->
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Chuyển sản phẩm đến chi nhánh khác:</h6>

                        <input type="hidden" name="inventory_id" id="transferInventoryId">
                        <input type="hidden" name="from_branch_id" id="transferFromBranchId">
                        <input type="hidden" name="product_id" id="transferProductIdHidden">

                        <div class="mb-3">
                            <label for="transferQuantity" class="form-label">Số lượng cần chuyển</label>
                            <input type="number" min="1" class="form-control" id="transferQuantity" name="quantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="transferToBranch" class="form-label">Chuyển đến chi nhánh</label>
                            <select class="form-select" name="to_branch_id" id="transferToBranch" required>
                                <option value="" selected disabled>-- Chọn chi nhánh --</option>
                                <?php foreach ($allBranches as $branch) { ?>
                                    <option value="<?= $branch['id'] ?>">
                                        <?= htmlspecialchars($branch['name']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success" name="transferWarehouseModal">
                                <i class="fas fa-exchange-alt me-1"></i> Xác nhận chuyển
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const transferButtons = document.querySelectorAll("button[data-bs-target='#transferWarehouseModal']");

        transferButtons.forEach(button => {
            button.addEventListener("click", () => {
                // Lấy dữ liệu từ data-*
                const id = button.getAttribute("data-id");
                const productName = button.getAttribute("data-product-name");
                const stockQuantity = button.getAttribute("data-stock-quantity");
                const branchName = button.getAttribute("data-branch-name");
                const productId = button.getAttribute("data-product-id");
                const branchId = button.getAttribute("data-branch-id");

                // Đổ vào modal
                document.getElementById("transferProductId").textContent = id;
                document.getElementById("transferProductName").textContent = productName;
                document.getElementById("transferStockQuantity").textContent = stockQuantity;
                document.getElementById("transferBranchName").textContent = branchName;

                // Hidden inputs
                document.getElementById("transferInventoryId").value = id;
                document.getElementById("transferFromBranchId").value = branchId;
                document.getElementById("transferProductIdHidden").value = productId;
            });
        });
    });
</script>