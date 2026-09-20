<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_customer'])) {
    $id = $_POST['delete_customer_id'];
    $result = $userController->delete($id);
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }
    echo "<script>window.location.href = window.location.href;</script>";
    exit;
}
?>

<div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">
            <form method="POST">
                <input type="hidden" name="delete_customer" value="1">
                <input type="hidden" name="delete_customer_id" id="deleteCustomerId">

                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title" id="deleteCustomerModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Xác nhận xóa vĩnh viễn
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <p>Bạn có chắc chắn muốn xóa vĩnh viễn khách hàng <strong id="deleteCustomerName"></strong>?</p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash me-1"></i> Xóa
                    </button>
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>