<?php
$fullName = $employeeData ? $employeeData->name : '';
$email = $employeeData ? $employeeData->email : '';
$phone = $employeeData ? $employeeData->phone : '';
$address = $employeeData ? $employeeData->address : '';
if ($_SESSION['admin']) {
  $fullName = $_SESSION['admin']['username'];
  $email = $_SESSION['admin']['email'];
}

if ($_SERVER['REQUEST_METHOD'] && isset($_POST['saveChange'])) {
  if ($_SESSION['admin']) {
    $data = [
      'username' => $_POST['fullname'],
      'email' => $_POST['email']
    ];

    $result = $adminController->update($_SESSION['admin']['id'], $data);

    if ($result['success']) {
      $_SESSION['admin'] = $adminController->getById($_SESSION['admin']['id']);
      $_SESSION['success'] = $result['message'];
    } else {
      $_SESSION['error'] = $result['message'];
    }
  } else {
    $data = [
      'name' => $_POST['fullname'],
      'email' => $_POST['email'],
      'phone' => $_POST['phone'],
      'address' => $_POST['address'],
    ];

    $result = $employeeController->update($employeeData->id, $data);
    if ($result['success']) {
      $employeeController->refreshtoken($employeeData->id);
      $employeeData = $employeeController->getCurrentEmployee();
      $_SESSION['success'] = $result['message'];
    } else {
      $_SESSION['error'] = $result['message'];
    }
  }

  echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Profile/index.php';</script>";
  exit;
}

?>



<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
      <form method="POST">
        <div class="modal-header border-0 text-white p-4" style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);">
          <h5 class="modal-title fw-bold" id="editProfileLabel"><i class="bi bi-pencil-square me-2"></i>Chỉnh Sửa Hồ Sơ</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body p-4 bg-light">
          <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="mb-3">
              <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-person me-1 text-primary"></i>Họ và tên</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-primary"><i class="bi bi-person-vcard"></i></span>
                <input type="text" class="form-control border-start-0 bg-light" name="fullname" value="<?= htmlspecialchars($fullName) ?>" required>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-envelope me-1 text-primary"></i>Email</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-primary"><i class="bi bi-envelope-at"></i></span>
                <input type="email" class="form-control border-start-0 bg-light" name="email" value="<?= htmlspecialchars($email) ?>" required>
              </div>
            </div>
            <?php if ($employeeData): ?>
              <div class="mb-3">
                <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-telephone me-1 text-primary"></i>Số điện thoại</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-primary"><i class="bi bi-phone"></i></span>
                  <input type="text" class="form-control border-start-0 bg-light" name="phone" value="<?= htmlspecialchars($phone) ?>">
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-geo-alt me-1 text-primary"></i>Địa chỉ</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-primary"><i class="bi bi-house-door"></i></span>
                  <input type="text" class="form-control border-start-0 bg-light" name="address" value="<?= htmlspecialchars($address) ?>">
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="modal-footer bg-light border-0 p-3 justify-content-end gap-2">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" name="saveChange">
            <i class="bi bi-check-circle me-1"></i> Lưu thay đổi
          </button>
        </div>
      </form>
    </div>
  </div>
</div>