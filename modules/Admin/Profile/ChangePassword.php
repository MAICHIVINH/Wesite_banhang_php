<?php

if ($_SERVER['REQUEST_METHOD'] && isset($_POST['ChangeToPassword'])) {
  $passwordOld = $_POST['current_password'];
  $passwordNew = $_POST['new_password'];
  $changePassword = $_POST['confirm_password'];

  if ($passwordNew == $changePassword) {
    if ($_SESSION['admin']) {
      $result = $adminController->ChangePassword($_SESSION['admin']['email'], $passwordOld, $passwordNew);
      if ($result['success']) {
        $_SESSION['success'] = $result['message'];
      } else {
        $_SESSION['error'] = $result['message'];
      }
    } else {
      $result = $employeeController->ChangeToPassword($employeeData->email, $passwordOld, $passwordNew);
      if ($result['success']) {
        $_SESSION['success'] = $result['message'];
      } else {
        $_SESSION['error'] = $result['message'];
      }
    }
  } else {
    $_SESSION['error'] = "Mật khẩu không trùng khớp!";
  }
  echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Profile/index.php';</script>";
  exit;
}

?>


<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
      <form method="POST">
        <div class="modal-header border-0 text-white p-4" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
          <h5 class="modal-title fw-bold text-dark" id="changePasswordLabel"><i class="bi bi-shield-lock me-2"></i>Đổi Mật Khẩu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body p-4 bg-light">
          <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="mb-3">
              <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-key me-1 text-warning"></i>Mật khẩu hiện tại</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-warning"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control border-start-0 bg-light" name="current_password" placeholder="Nhập mật khẩu hiện tại" required>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-shield-key me-1 text-warning"></i>Mật khẩu mới</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-warning"><i class="bi bi-key"></i></span>
                <input type="password" class="form-control border-start-0 bg-light" name="new_password" placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)" required>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-shield-check me-1 text-warning"></i>Xác nhận mật khẩu mới</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-warning"><i class="bi bi-check-lg"></i></span>
                <input type="password" class="form-control border-start-0 bg-light" name="confirm_password" placeholder="Nhập lại mật khẩu mới" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light border-0 p-3 justify-content-end gap-2">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" name="ChangeToPassword" class="btn btn-warning text-dark rounded-pill px-4 fw-bold shadow-sm">
            <i class="bi bi-shield-check me-1"></i> Lưu mật khẩu mới
          </button>
        </div>
      </form>
    </div>
  </div>
</div>