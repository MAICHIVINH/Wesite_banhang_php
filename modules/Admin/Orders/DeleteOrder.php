<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {
    $id = $_POST['delete_order_id'] ?? null;
    $order = $orderController->getById($id);

    if ($id) {
        if ($order && (int)$order['status_id'] === 4) {
            $_SESSION['error'] = 'Đơn hàng này đang vận chuyển! Bạn không thể xóa đơn hàng này.';
            echo "<script>
                    window.location.href = 'Admin.php?page=modules/Admin/Orders/Order.php';
                </script>";
            exit;
        }
        $result = $orderController->delete($id);

        if ($result['success']) {
            $_SESSION['success'] = !empty($result['message']) ? $result['message'] : 'Xóa đơn hàng thành công!';
        } else {
            $_SESSION['error'] = !empty($result['message']) ? $result['message'] : 'Xóa đơn hàng thất bại!';
        }

        echo "<script>
            window.location.href = 'Admin.php?page=modules/Admin/Orders/Order.php';
        </script>";
        exit;
    }
}
?>
<!-- Modal xác nhận xóa danh mục -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">
            <form method="POST">
                <input type="hidden" name="delete_order" value="1">
                <input type="hidden" name="delete_order_id" id="deleteOrderId">

                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title d-flex align-items-center" id="deleteOrderModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Xác nhận xóa đơn hàng
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <p>Bạn có chắc chắn muốn xóa đơn hàng không <strong id="deleteOrderName"></strong>?</p>
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

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.delete-order-btn');
        buttons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const orderId = this.getAttribute('data-id');
                const orderCode = this.getAttribute('data-code') || orderId;

                document.getElementById('deleteOrderId').value = orderId;
                document.getElementById('deleteOrderName').textContent = orderCode;
            });
        });
    });
</script> -->

<script>
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-order-btn')) {
            const btn = e.target.closest('.delete-order-btn');
            const orderId = btn.dataset.id;
            const orderCode = btn.dataset.code || orderId;
            document.getElementById('deleteOrderId').value = orderId;
            document.getElementById('deleteOrderName').textContent = orderCode;
        }
    });
</script>