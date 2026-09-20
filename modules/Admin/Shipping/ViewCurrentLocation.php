<div class="modal fade" id="currentLocationModal" tabindex="-1" aria-labelledby="currentLocationLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="bi bi-geo-fill me-2"></i> Vị trí hiện tại của người giao</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <ul class="list-unstyled mb-3">
          <li>Mã đơn hàng: <strong id="current-order-id"></strong></li>
          <li>Người giao hàng: <strong id="current-shipper-name"></strong></li>
          <li>Số điện thoại: <strong id="current-shipper-phone"></strong></li>
          <li>Địa chỉ hiện tại của đơn hàng: <strong id="current-address"></strong></li>
          <li>Trạng thái: <strong id="current-order-status"></strong></li>
        </ul>
        <div class="ratio ratio-16x9">
          <iframe id="current-location-map" class="border rounded shadow" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>