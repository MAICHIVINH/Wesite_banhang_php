<?php

if (isset($_GET['id'])) {
  $orderId = $_GET['id'];

  $orderMap = $orderController->getById($orderId);
  $orderItems = $orderItemController->getOrderItemById($orderId);
  $userData = $userController->getById($orderMap["user_id"]);
  $statusData = $statusController->getById($orderMap['status_id']);
  $branchData = $branchController->getById($orderMap['branch_id']);
  $employeeData = $employeeController->getById($orderMap['employee_id']);
?>

  <!-- MODAL CHI TIẾT -->
  <div class="modal fade" id="viewOrderModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Chi tiết đơn hàng #<?= htmlspecialchars($orderMap['code']) ?> | Nhân viên phụ trách: <?= $employeeData ? htmlspecialchars($employeeData['name']) : "Chưa có" ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-4 d-flex align-items-stretch">
            <!-- Box khách hàng -->
            <div class="col-md-6">
              <div class="border border-warning rounded p-3 h-100" style="background-color:rgb(236, 240, 242);">
                <h6 class="fw-bold border-bottom pb-1 mb-2">Thông tin khách hàng:</h6>
                <ul class="list-unstyled mb-0">
                  <li><strong>Họ tên:</strong> <?= htmlspecialchars($userData['FullName'] ?? '') ?></li>
                  <li><strong>Email:</strong> <?= htmlspecialchars($userData['Email'] ?? '') ?></li>
                  <li><strong>Số điện thoại:</strong> <?= htmlspecialchars($userData['Phone'] ?? '') ?></li>
                  <li><strong>Địa chỉ:</strong> <?= htmlspecialchars($userData['Address'] ?? '') ?></li>
                </ul>
              </div>
            </div>

            <!-- Box đơn hàng -->
            <div class="col-md-6">
              <div class="border border-warning rounded p-3" style="background-color: rgb(236, 240, 242);">
                <h6 class="fw-bold border-bottom pb-1 mb-2">Thông tin đơn hàng:</h6>
                <ul class="list-unstyled mb-0">
                  <li><strong>Mã đơn hàng:</strong> <?= htmlspecialchars($orderMap['code']) ?></li>
                  <li><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($orderMap['create_at'])) ?></li>
                  <li><strong>Trạng thái:</strong> <?= htmlspecialchars($statusData['name']) ?></li>
                  <li><strong>Tổng tiền:</strong> <?= number_format($orderMap['total_amount'], 0) ?> đ</li>
                </ul>
              </div>
            </div>
          </div>


          <!-- Sản phẩm -->
          <h5>Sản phẩm thuộc cửa hàng <?= htmlspecialchars($branchData['name'] ?? '') ?></h5>
          <table class="table table-bordered table-hover custom-table">
            <thead class="table-secondary">
              <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total = 0;
              foreach ($orderItems as $item) {
                $subtotal = $item['unit_price'] * $item['quantity'];
                $total += $subtotal;
              ?>
                <tr>
                  <td><img src="<?= htmlspecialchars($item['image_url']) ?>" width="80"></td>
                  <td><?= htmlspecialchars($item['name']) ?></td>
                  <td><?= number_format($item['unit_price'], 0) ?> đ</td>
                  <td><?= $item['quantity'] ?></td>
                  <td><?= number_format($subtotal, 0) ?> đ</td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="4" class="text-end">Tổng cộng:</th>
                <th><?= number_format($total, 0) ?> đ</th>
              </tr>
            </tfoot>
          </table>
        </div>


        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    (function() {
      function openModal() {
        const el = document.getElementById('viewOrderModal');
        if (el) {
          if (el.parentElement !== document.body) {
            document.body.appendChild(el);
          }
          const modal = new bootstrap.Modal(el);
          modal.show();
        }
      }
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', openModal);
      } else {
        openModal();
      }
    })();
  </script>
<?php
}
?>