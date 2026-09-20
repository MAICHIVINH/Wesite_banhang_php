<?php
// require_once '../../../models/Order.php';
// $orderModel = new Order();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ChangeStatus'])) {
    $employeeId = $isAdmin ? 1 : ($employeeData->id ?? null);
    $id = $_POST['id'] ?? null;
    if ($id) {
        $order = $orderController->getById($id);
        if ($order && (int)$order['status_id'] === 4) {
            $_SESSION['error'] = 'Đơn hàng này đang vận chuyển!';
            echo "<script>
                    window.location.href = 'Admin.php?page=modules/Admin/Orders/Order.php';
                </script>";
            exit;
        }
        $currentStatus = (int)$order['status_id'];
        if ($currentStatus == 1) {
            $orderDetail = $orderItemController->getOrderItemById($id);
            foreach ($orderDetail as $item) {
                $productId = $item['product_id'];
                $inventoryByProductId = $inventoryController->getProductInventory($productId, $order['branch_id'], true);

                if ($item['quantity'] >= $inventoryByProductId['stock_quantity']) {
                    $_SESSION['error'] = 'Trong kho hàng không còn đủ sản phẩm cho đơn hàng này!';
                    echo "<script>
                            window.location.href = 'Admin.php?page=modules/Admin/Orders/Order.php';
                        </script>";
                    exit;
                }
                $totalQuantity = $inventoryByProductId['stock_quantity'] - $item['quantity'];
                $inventoryController->edit($inventoryByProductId['inventory_id'], ['stock_quantity' => $totalQuantity]);
            }
        }

        if ($order) {
            $maxStatus = 5;
            $nextStatus = ($currentStatus < $maxStatus) ? $currentStatus + 1 : 1;
            $data = [
                'status_id' => $nextStatus,
                'employee_id' =>  $employeeId
            ];

            $result = $orderController->edit($id, $data);
        }

        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
        echo "<script>
            window.location.href = 'Admin.php?page=modules/Admin/Orders/Order.php';
        </script>";
        exit;
    }
}


?>

<!-- MODAL CHUYỂN TRẠNG THÁI -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST">
            <input type="hidden" name="id" id="change-status-id">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="changeStatusModalLabel">Xác nhận chuyển trạng thái</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn chuyển trạng thái đơn hàng sang <strong>trạng thái kế tiếp</strong> không?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="ChangeStatus">Đồng ý</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.change-status-btn');
        buttons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const orderId = this.getAttribute('data-id');
                document.getElementById('change-status-id').value = orderId;
            });
        });
    });
</script>