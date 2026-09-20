<!-- Modal Chi tiết khách hàng -->
<div class="modal fade" id="detailCustomerModal" tabindex="-1" aria-labelledby="detailCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="detailCustomerModalLabel"><i class="fas fa-user me-2"></i> Chi tiết khách hàng</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Họ tên:</label>
            <div id="detail-fullname" class="fw-bold text-dark"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email:</label>
            <div id="detail-email"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Số điện thoại:</label>
            <div id="detail-phone"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Địa chỉ:</label>
            <div id="detail-address"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Ngày tạo:</label>
            <div id="detail-created"></div>
          </div>
          <!-- Thêm phần dữ liệu nâng cao nếu có -->
          <div class="col-md-6">
            <label class="form-label">Trạng thái:</label>
            <div id="detail-status" class="text-success">Đang hoạt động</div>
          </div>
        </div>
      </div>
      <!-- <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div> -->
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const detailButtons = document.querySelectorAll(".btn-detail-customer");

    detailButtons.forEach(button => {
      button.addEventListener("click", function() {
        const fullname = this.getAttribute("data-fullname");
        const email = this.getAttribute("data-email");
        const phone = this.getAttribute("data-phone");
        const address = this.getAttribute("data-address") || "Chưa có";
        const created = this.getAttribute("data-created") || "Không rõ";
        const status = this.getAttribute("data-status") || "Không rõ";

        document.getElementById("detail-fullname").textContent = fullname;
        document.getElementById("detail-email").textContent = email;
        document.getElementById("detail-phone").textContent = phone;
        document.getElementById("detail-address").textContent = address;
        document.getElementById("detail-created").textContent = created;

        const statusElement = document.getElementById("detail-status");
        statusElement.textContent = status;

        if (status.includes("Bị cấm")) {
          statusElement.classList.remove("text-success");
          statusElement.classList.add("text-danger");
        } else {
          statusElement.classList.remove("text-danger");
          statusElement.classList.add("text-success");
        }
      });
    });
  });
</script>