<?php
// Xử lý khi submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_customer_id'])) {
  $id = $_POST['edit_customer_id'];
  $name = $_POST['edit_fullname'];
  $phone = $_POST['edit_phone'];
  $email = $_POST['edit_email'];
  $address = $_POST['edit_address'];

  $data = [
    'FullName' => $name,
    'Phone' => $phone,
    'email' => $email,
    'address' => $address
  ];

  $result = $userController->updateProfile($id, $data, false);

  if ($result['success']) {
    $_SESSION['success'] = !empty($result['message']) ? $result['message'] : 'Cập nhật thông tin khách hàng thành công!';
  } else {
    $_SESSION['error'] = !empty($result['message']) ? $result['message'] : 'Cập nhật thất bại.';
  }

  echo "<script>
          window.location.href = 'Admin.php?page=modules/Admin/Customers/Customer.php';
      </script>";
  exit;
}
?>
<!-- Modal Sửa Khách Hàng -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="editCustomerForm" method="POST" action="Admin.php?page=modules/Admin/Customers/Customer.php">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Sửa khách hàng</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="edit_customer_id" id="edit-customer-id">
          <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" name="edit_fullname" id="edit-fullname" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="edit_phone" id="edit-phone" class="form-control" required>
            <div id="phoneError" class="text-danger small mt-1"></div>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="edit_email" id="edit-email" class="form-control" required>
            <div id="emailError" class="text-danger small mt-1"></div>
          </div>
          <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="edit_address" id="edit-address" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="saveCustomerBtn">Lưu thay đổi</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        </div>
      </form>
    </div>
  </div>
</div>