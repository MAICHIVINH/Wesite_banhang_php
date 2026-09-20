<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_customer'])) {
  $id = $_POST['delete_customer_id'] ?? null;
  $reason = $_POST['reason'] ?? '';
  if (!$id) {
    $_SESSION['error'] = 'Thiếu ID khách hàng cần xóa.';
    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Customers/Customer.php';</script>";
    exit;
  }

  $data = [
    'deleted_by_id' => 1,
    'deleted_by_type' => 'admin',
    'deleted_at' => date("Y-m-d H:i:s"),
    'reason' => $reason,
    'isDeleted' => 1
  ];

  $checkOrder = $orderController->hasUserOrder($id);
  if (!$checkOrder['success']) {
    $_SESSION['error'] = $checkOrder['message'];
    echo "<script>
            window.location.href = 'Admin.php?page=modules/Admin/Customers/Customer.php';
          </script>";
    exit;
  }

  $result = $userController->updateProfile($id, $data, false);

  if ($result['success']) {
    $_SESSION['success'] = 'Đã chuyển khách hàng vào thùng rác thành công!';
  } else {
    $_SESSION['error'] = !empty($result['message']) ? $result['message'] : 'Xóa khách hàng thất bại!';
  }

  echo "<script>
          window.location.href = 'Admin.php?page=modules/Admin/Customers/Customer.php';
        </script>";
  exit;
}
?>
<!-- Modal xác nhận xóa khách hàng -->
<div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content shadow">
      <form method="POST">
        <input type="hidden" name="delete_customer" value="1">
        <input type="hidden" name="delete_customer_id" id="deleteCustomerId">

        <div class="modal-header bg-danger text-white">
          <h6 class="modal-title d-flex align-items-center" id="deleteCustomerModalLabel">
            <i class="fas fa-exclamation-triangle me-2"></i> Xác nhận xóa khách hàng
          </h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>

        <div class="modal-body">
          <div class="text-center">
            <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
            <p>Bạn có chắc chắn muốn xóa khách hàng <strong id="deleteCustomerName"></strong>?</p>
          </div>

          <div class="mb-3">
            <label for="reason" class="form-label">Lý do xóa</label>
            <textarea class="form-control" name="reason" id="deleteCustomerReason" rows="3" placeholder="Nhập lý do xóa..."></textarea>
          </div>

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