<?php
if (isset($_GET['orderid'])) {

  $orderId = $_GET['orderid'];

  $orderMap = $orderController->getById($orderId);

  $orderItems = $orderItemController->getOrderItemById($orderId);

  $userData = $userController->getById($orderMap["user_id"]);

  $statusData = $statusController->getById($orderMap['status_id']);
?>
  <script>
    (function() {
      function openModal() {
        const el = document.getElementById('UpdateOrderModal');
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

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['UpdateOrder'])) {
  $employeeId = $isAdmin ? 1 : ($employeeData->id ?? null);
  $statusId = $_POST['status'];
  $orderId = $_GET['orderid'];
  $order = $orderController->getById($orderId);
  if ($order['employee_id'] === null) {
    if ($statusId == 1) {

      $orderDetail = $orderItemController->getOrderItemById($orderId);
      foreach ($orderDetail as $item) {
        $productId = $item['product_id'];
        $inventoryByProductId = $inventoryController->getProductInventory($productId, $order['branch_id'], true);

        $totalQuantity = $inventoryByProductId['stock_quantity'] + $item['quantity'];
        $inventoryController->edit($inventoryByProductId['inventory_id'], ['stock_quantity' => $totalQuantity]);
      }
    }
    $result = $orderController->edit($orderId, ['status_id' => $statusId, 'employee_id' => $employeeId]);
  } else {
    if ($statusId == 1) {

      $orderDetail = $orderItemController->getOrderItemById($orderId);
      foreach ($orderDetail as $item) {
        $productId = $item['product_id'];
        $inventoryByProductId = $inventoryController->getProductInventory($productId, $order['branch_id'], true);

        $totalQuantity = $inventoryByProductId['stock_quantity'] + $item['quantity'];
        $inventoryController->edit($inventoryByProductId['inventory_id'], ['stock_quantity' => $totalQuantity]);
      }
    }

    $result =  $orderController->edit($orderId, ['status_id' => $statusId]);
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
?>

<div class="modal fade" id="UpdateOrderModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="viewOrderModalLabel">Chỉnh sửa đơn hàng #<?= $orderMap['code'] ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-4 d-flex">
            <!-- Box khách hàng -->
            <div class="col-md-6">
              <div class="border border-warning rounded p-3 h-100 d-flex flex-column" style="background-color: #fffbea;">
                <h6 class="fw-bold border-bottom pb-1 mb-2">Thông tin khách hàng:</h6>
                <ul class="list-unstyled mb-0 flex-grow-1">
                  <li><strong>Họ tên:</strong> <?= $userData['FullName'] ?></li>
                  <li><strong>Email:</strong> <?= $userData['Email'] ?></li>
                  <li><strong>Số điện thoại:</strong> <?= $userData['Phone'] ?></li>
                  <li><strong>Địa chỉ:</strong> <?= $userData['Address'] ?></li>
                </ul>
              </div>
            </div>

            <!-- Box đơn hàng -->
            <div class="col-md-6">
              <div class="border border-warning rounded p-3 h-100 d-flex flex-column" style="background-color: #fffbea;">
                <h6 class="fw-bold border-bottom pb-1 mb-2">Thông tin đơn hàng:</h6>
                <ul class="list-unstyled mb-0 flex-grow-1">
                  <li><strong>Mã đơn hàng:</strong> <?= $orderMap['code'] ?></li>
                  <li><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($orderMap['create_at'])) ?></li>
                  <li class="d-flex align-items-center gap-2">
                    <strong>Trạng thái:</strong>
                    <select name="status" class="form-select form-select-sm w-auto pe-4" style="padding: 2px 8px; border: none;">
                      <?php
                      $statusOptions = $statusController->getAll();
                      foreach ($statusOptions as $status) {
                        $selected = $orderMap['status_id'] === $status["id"] ? 'selected' : '';
                        echo "<option value='{$status['id']}' $selected>{$status['name']}</option>";
                      }
                      ?>
                    </select>
                  </li>
                  <li><strong>Tổng tiền:</strong> <?= number_format($orderMap['total_amount'], 0) ?> đ</li>
                </ul>
              </div>
            </div>
          </div>

          <h5>Sản phẩm</h5>
          <table class="table table-bordered text-center">
            <thead class="table-warning">
              <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orderItems as $item):
                $subtotal = $item['unit_price'] * $item['quantity'];
              ?>
                <tr>
                  <td><img src="<?= $item['image_url'] ?>" width="60" height="60"></td>
                  <td><?= $item['name'] ?></td>
                  <td><?= number_format($item['unit_price'], 0) ?> đ</td>
                  <td>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(<?= $orderId ?>, <?= $item['product_id'] ?>, -1)">-</button>
                      <span id="qty-<?= $item['product_id'] ?>"><?= $item['quantity'] ?></span>
                      <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(<?= $orderId ?>, <?= $item['product_id'] ?>, 1)">+</button>
                    </div>
                  </td>
                  <td><?= number_format($subtotal, 0) ?> đ</td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="UpdateOrder">Thay đổi</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        </div>
      </form>
    </div>
  </div>