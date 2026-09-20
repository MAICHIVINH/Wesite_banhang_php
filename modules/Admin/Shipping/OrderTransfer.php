<?php

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['transferShipping'])) {
  $shippingId = $_POST['shippingId'];
  $address = trim($_POST['address']);
  $addressPresent = trim($_POST['addressPresent']);


  $getById = $shippingController->getById($shippingId);
  $getAddressUser = $orderController->getUserAddressByShippingId($shippingId);

  if ($getById['status'] === 'Hoàn thành' || strcasecmp($address, $addressPresent) === 0) {
    $_SESSION['error'] = "Đơn hàng đã được người nhận nhận hàng.";
    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Shipping/Shipping.php';</script>";
    exit;
  }

  if ($getAddressUser['address'] === $address) {
    $result = $shippingController->update($shippingId, [
      'address' => $address,
      'method' => 'Đã nhận hàng',
      'status' => 'Hoàn thành'
    ]);
  } else {
    $result = $shippingController->update($shippingId, [
      'address' => $address,
      'method' => 'Đang giao hàng',
      'status' => 'Đang vận chuyển'
    ]);
  }

  if ($result['success']) {
    $_SESSION['success'] = $result['message'];
  } else {
    $_SESSION['error'] = $result['message'];
  }

  echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Shipping/Shipping.php';</script>";
  exit;
}

?>


<!-- Modal Chuyển đơn -->
<div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content shadow">
      <div class="modal-header bg-primary text-dark">
        <h5 class="modal-title text-white" id="transferLabel">
          <i class="bi bi-arrow-left-right me-2"></i> Chuyển đơn hàng
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <form id="transferForm" method="post">
        <div class="modal-body">
          <input type="hidden" class="form-control" name="shippingId" id="transfer-shipping-id" readonly>


          <div class="mb-3">
            <label class="form-label">Mã đơn hàng</label>
            <input type="text" class="form-control" id="transfer-order-id" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">Vị trí hiện tại</label>
            <input type="text" class="form-control" name="addressPresent" id="transfer-current-location" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">Chuyển đến</label>
            <input type="text" class="form-control" name="address" placeholder="Nhập nơi cần chuyển đến" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary text-white" name="transferShipping">Xác nhận chuyển</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        </div>
      </form>
    </div>
  </div>
</div>