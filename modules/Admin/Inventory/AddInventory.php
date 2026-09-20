<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $id = $_POST['id'] ?? '';
    $stockQuantity = $_POST['add_quantity'] ?? 0;

    $quantityOld = $inventoryController->getById($id);
    $totalQuantity = $quantityOld['stock_quantity'] + $stockQuantity;

    $data = [
        'stock_quantity' => $totalQuantity,
        'last_update' => date('Y-m-d H:i:s')
    ];

    $result = $inventoryController->edit($id, $data);
    if ($isLoading) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Inventory/Inventory.php';</script>";
    exit;
}
?>

<!-- Modal Thêm kho hàng -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Thêm nhà kho hàng mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="add_item" value="1">
                    <div class="mb-3">
                        <label class="form-label">Mã kho</label>
                        <input type="text" name="id" id="addItemWarehouseId" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="product_name" id="addItemProductName" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số lượng hiện tại</label>
                        <input type="number" id="addItemCurrentQuantity" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Chi nhánh</label>
                        <input type="text" id="addItemBranch" name="branch" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số lượng thêm vào</label>
                        <input type="number" name="add_quantity" class="form-control" required min="1" placeholder="Nhập số lượng thêm">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"> Thêm vào kho </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Hủy </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addButtons = document.querySelectorAll('button[data-bs-target="#addItemModal"]');
        addButtons.forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("addItemWarehouseId").value = button.getAttribute("data-id") || "";
                document.getElementById("addItemProductName").value = button.getAttribute("data-product-name") || "";
                document.getElementById("addItemCurrentQuantity").value = button.getAttribute("data-stock-quantity") || "0";
                document.getElementById("addItemBranch").value = button.getAttribute("data-stock-branch") || "";
            });
        });
    });
</script>