<!-- Modal Thông tin người nhận -->
<div class="modal fade" id="senderLocationModal" tabindex="-1" aria-labelledby="senderLocationLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow rounded-4 border-0">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="senderLocationLabel">
          <i class="bi bi-geo-alt-fill me-2"></i> Vị trí & Thông tin người nhận
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body p-4">
        <!-- Thông tin người nhận -->
        <div class="bg-light p-3 rounded-3 mb-3 border">
          <div class="row g-2">
            <div class="col-md-6">Mã đơn hàng: <strong id="modal_order_id" class="text-primary"></strong></div>
            <div class="col-md-6">Người nhận: <strong id="modal_sender_name" class="text-dark"></strong></div>
            <div class="col-md-6">Số điện thoại: <strong id="modal_sender_phone" class="text-dark"></strong></div>
            <div class="col-md-12">Địa chỉ nhận: <strong id="modal_sender_address" class="text-danger"></strong></div>
          </div>
        </div>

        <!-- Google Maps Embed Container -->
        <div class="ratio ratio-16x9 border rounded-3 shadow-sm overflow-hidden">
          <iframe
            id="mapIframe"
            src=""
            style="border:0; width:100%; height:100%;"
            allowfullscreen
            loading="lazy">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</div>