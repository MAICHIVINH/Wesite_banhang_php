<div class="container-fluid px-4 py-3">

  <!-- Hero Header -->
  <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
    <div class="card-body p-4 p-md-5 text-white">
      <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-4">
        <div class="d-flex flex-column flex-sm-row align-items-center gap-4 text-center text-sm-start">
          <div class="position-relative">
            <img src="<?= !empty($_SESSION['admin']) ? 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION['admin']['username']) . '&background=d70018&color=fff&size=128&bold=true' : (!empty($employeeData->name) ? 'https://ui-avatars.com/api/?name=' . urlencode($employeeData->name) . '&background=0d6efd&color=fff&size=128&bold=true' : 'https://cdn3d.iconscout.com/3d/premium/thumb/employee-avatar-10232456-8264146.png') ?>" 
                 class="rounded-circle border border-4 border-white-50 shadow" width="110" height="110" alt="Avatar">
            <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2" title="Đang hoạt động"></span>
          </div>
          <div>
            <h2 class="fw-bold text-white mb-1">
              <?= !empty($_SESSION['admin']) ? htmlspecialchars($_SESSION['admin']['username']) : htmlspecialchars($employeeData->name ?? 'Người dùng') ?>
            </h2>
            <div class="d-flex align-items-center justify-content-center justify-content-sm-start gap-2 mb-2">
              <span class="badge bg-danger rounded-pill px-3 py-1 font-monospace fs-6">
                <i class="bi bi-shield-check me-1"></i>
                <?= !empty($_SESSION['admin']) ? 'SUPER ADMIN' : htmlspecialchars($employeeData->position ?? 'Nhân viên') ?>
              </span>
              <span class="badge bg-secondary bg-opacity-50 text-white rounded-pill px-3 py-1 fs-6">
                <i class="bi bi-circle-fill text-success fs-6 me-1" style="font-size: 8px !important;"></i> Hoạt động
              </span>
            </div>
            <p class="text-white-50 mb-0 small">
              <i class="bi bi-clock-history me-1"></i> Ngày khởi tạo tài khoản: 
              <?= date('d/m/Y', strtotime(!empty($_SESSION['admin']) ? ($_SESSION['admin']['created_at'] ?? 'now') : ($employeeData->create_at ?? 'now'))) ?>
            </p>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex flex-wrap align-items-center gap-2 justify-content-center">
          <button class="btn btn-warning text-dark fw-bold rounded-pill px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
            <i class="bi bi-key-fill me-1"></i> Đổi mật khẩu
          </button>
          <button class="btn btn-light text-dark fw-bold rounded-pill px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa hồ sơ
          </button>
          <form action="Auth/logout.php" method="post" class="m-0">
            <button type="submit" class="btn btn-outline-light rounded-pill px-3 py-2 fw-bold">
              <i class="bi bi-box-arrow-right me-1"></i> Đăng xuất
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Grid -->
  <div class="row g-4">
    <!-- Left Column: Personal Information -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm rounded-4 h-100">
        <div class="card-header bg-white border-bottom border-light p-4 d-flex align-items-center justify-content-between">
          <h5 class="fw-bold mb-0 text-dark">
            <i class="bi bi-person-lines-fill text-danger me-2"></i>Thông tin cá nhân
          </h5>
          <span class="badge bg-light text-muted border">Chi tiết tài khoản</span>
        </div>
        <div class="card-body p-4">
          <div class="list-group list-group-flush">
            <div class="list-group-item border-0 px-0 py-3 d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center gap-3">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                  <i class="bi bi-envelope-at fs-5"></i>
                </div>
                <div>
                  <div class="text-muted small">Địa chỉ Email</div>
                  <div class="fw-semibold text-dark">
                    <?= !empty($_SESSION['admin']) ? htmlspecialchars($_SESSION['admin']['email']) : htmlspecialchars($employeeData->email ?? 'Chưa cập nhật') ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="list-group-item border-0 px-0 py-3 d-flex align-items-center justify-content-between border-top">
              <div class="d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                  <i class="bi bi-telephone fs-5"></i>
                </div>
                <div>
                  <div class="text-muted small">Số điện thoại</div>
                  <div class="fw-semibold text-dark">
                    <?= !empty($employeeData->phone) ? htmlspecialchars($employeeData->phone) : 'Chưa cập nhật' ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="list-group-item border-0 px-0 py-3 d-flex align-items-center justify-content-between border-top">
              <div class="d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                  <i class="bi bi-geo-alt fs-5"></i>
                </div>
                <div>
                  <div class="text-muted small">Địa chỉ làm việc</div>
                  <div class="fw-semibold text-dark">
                    <?= !empty($employeeData->address) ? htmlspecialchars($employeeData->address) : 'Trụ sở GARENA' ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="list-group-item border-0 px-0 py-3 d-flex align-items-center justify-content-between border-top">
              <div class="d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                  <i class="bi bi-shield-lock fs-5"></i>
                </div>
                <div>
                  <div class="text-muted small">Loại tài khoản</div>
                  <div class="fw-semibold text-dark">
                    <?= !empty($_SESSION['admin']) ? 'Quản trị viên cao nhất (Admin)' : 'Nhân viên hệ thống' ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: System Roles & Permissions -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm rounded-4 h-100">
        <div class="card-header bg-white border-bottom border-light p-4 d-flex align-items-center justify-content-between">
          <h5 class="fw-bold mb-0 text-dark">
            <i class="bi bi-gear-wide-connected text-primary me-2"></i>Quyền hạn & Phạm vi quản lý
          </h5>
          <span class="badge bg-success bg-opacity-10 text-success fw-bold">Đã kích hoạt</span>
        </div>
        <div class="card-body p-4">
          <p class="text-muted small mb-3">Các quyền hạn được cấp cho tài khoản của bạn trong hệ thống quản trị GARENA:</p>
          
          <div class="d-flex flex-wrap gap-2 mb-4">
            <?php
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
              echo '<span class="badge bg-danger rounded-pill px-3 py-2 fs-6"><i class="bi bi-stars me-1"></i> Toàn quyền hệ thống (Full Admin)</span>';
              echo '<span class="badge bg-dark rounded-pill px-3 py-2 fs-6"><i class="bi bi-box-seam me-1"></i> Quản lý sản phẩm</span>';
              echo '<span class="badge bg-dark rounded-pill px-3 py-2 fs-6"><i class="bi bi-cart-check me-1"></i> Quản lý đơn hàng</span>';
              echo '<span class="badge bg-dark rounded-pill px-3 py-2 fs-6"><i class="bi bi-people me-1"></i> Nhân sự &amp; Khách hàng</span>';
            } else {
              if (isset($employeeData->id) && isset($employeeController) && isset($roleController)) {
                $roleIds = $employeeController->getRoleIds($employeeData->id);
                if (!empty($roleIds)) {
                  foreach ($roleIds as $roleId) {
                    $role = $roleController->getById($roleId);
                    echo '<span class="badge bg-primary rounded-pill px-3 py-2 fs-6"><i class="bi bi-check-circle-fill me-1"></i> ' . htmlspecialchars($role['role_name']) . '</span>';
                  }
                } else {
                  echo '<span class="badge bg-secondary rounded-pill px-3 py-2">Quyền hạn cơ bản</span>';
                }
              } else {
                echo '<span class="badge bg-secondary rounded-pill px-3 py-2">Nhân viên bán hàng</span>';
              }
            }
            ?>
          </div>

          <div class="p-3 bg-light rounded-3 border border-light">
            <div class="d-flex align-items-center gap-2 text-dark fw-bold small mb-1">
              <i class="bi bi-info-circle text-primary"></i> Bảo mật tài khoản
            </div>
            <div class="text-muted small">
              Vui lòng bảo vệ thông tin đăng nhập. Không chia sẻ tài khoản quản trị cho người khác. Nên thay đổi mật khẩu định kỳ để đảm bảo an toàn dữ liệu.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
require_once 'modules/Admin/Profile/UpdateProfile.php';
require_once 'modules/Admin/Profile/ChangePassword.php';
?>