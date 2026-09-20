<div class="modal fade" id="currentLocationModal" tabindex="-1" aria-labelledby="currentLocationLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow rounded-4 border-0">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="bi bi-geo-fill me-2"></i> Vị trí hiện tại của đơn hàng</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body p-4">
        <div class="bg-light p-3 rounded-3 mb-3 border">
          <div class="row g-2">
            <div class="col-md-6">Mã đơn hàng: <strong id="current-order-id" class="text-success"></strong></div>
            <div class="col-md-6">Người giao hàng: <strong id="current-shipper-name" class="text-dark"></strong></div>
            <div class="col-md-6">Số điện thoại: <strong id="current-shipper-phone" class="text-dark"></strong></div>
            <div class="col-md-6">Trạng thái: <strong id="current-order-status" class="text-info"></strong></div>
            <div class="col-md-12">Địa chỉ hiện tại: <strong id="current-address" class="text-danger"></strong></div>
          </div>
        </div>

        <!-- Google Maps Embed Container -->
        <div class="ratio ratio-16x9 border rounded-3 shadow-sm overflow-hidden">
          <iframe id="current-location-map" style="border:0; width:100%; height:100%;" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>