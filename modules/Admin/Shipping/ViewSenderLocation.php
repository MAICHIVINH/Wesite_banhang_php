<!-- Modal Thông tin người gửi (bản đồ to full chiều rộng) -->
<div class="modal fade" id="senderLocationModal" tabindex="-1" aria-labelledby="senderLocationLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="senderLocationLabel">
          <i class="bi bi-geo-alt-fill me-2"></i> Vị trí & Thông tin người nhận
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <!-- Thông tin -->
        <ul class="list-unstyled mb-4">
          <li>Mã đơn hàng: <strong id="modal_order_id"></strong></li>
          <li><strong id="modal_order_name"></strong></li>
          <li>Người nhận: <strong id="modal_sender_name"></strong></li>
          <li>Số điện thoại: <strong id="modal_sender_phone"></strong></li>
          <li>Địa chỉ nhận: <strong id="modal_sender_address"></strong></li>
        </ul>

        <!-- Bản đồ to full chiều ngang -->
        <div id="receiverMap" style="height: 380px; width: 100%; border-radius: 12px; border: 2px solid #e2e8f0; position: relative; z-index: 1;" class="shadow-sm"></div>
        <div class="ratio ratio-16x9 border rounded shadow d-none" id="mapIframeWrapper">
          <iframe
            id="mapIframe"
            src=""
            style="border:0;"
            allowfullscreen
            loading="lazy">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</div>