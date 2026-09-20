document.addEventListener("DOMContentLoaded", function () {
  const editButtons = document.querySelectorAll(
    '[data-bs-target="#editCustomerModal"]'
  );
  const form = document.getElementById("editCustomerForm");
  const phoneInput = document.getElementById("edit-phone");
  const emailInput = document.getElementById("edit-email");
  const phoneError = document.getElementById("phoneError");
  const emailError = document.getElementById("emailError");
  const saveButton = document.getElementById("saveCustomerBtn");

  // Đổ dữ liệu vào modal
  editButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      document.getElementById("edit-customer-id").value = btn.dataset.id;
      document.getElementById("edit-fullname").value = btn.dataset.fullname;
      document.getElementById("edit-address").value = btn.dataset.address;
      phoneInput.value = btn.dataset.phone;
      emailInput.value = btn.dataset.email;
      phoneError.textContent = "";
      emailError.textContent = "";
    });
  });

  // Chỉ cho nhập số điện thoại (tối đa 10)
  phoneInput.addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9]/g, "");
    if (this.value.length > 10) {
      this.value = this.value.slice(0, 10);
      phoneError.textContent = "Không được quá 10 số.";
    } else {
      phoneError.textContent = "";
    }
  });

  // Validate khi lưu
  saveButton.addEventListener("click", function () {
    const phone = phoneInput.value.trim();
    const email = emailInput.value.trim();
    let valid = true;

    if (!/^[0-9]{10}$/.test(phone)) {
      phoneError.textContent = "Số điện thoại phải đúng 10 số.";
      valid = false;
    } else {
      phoneError.textContent = "";
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      emailError.textContent = "Email không hợp lệ.";
      valid = false;
    } else {
      emailError.textContent = "";
    }

    if (valid) form.submit();
  });

  // Xử lý report
  const reportButtons = document.querySelectorAll(".btn-report-customer");
  const inputReportUserId = document.getElementById("report-user-id");

  reportButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      inputReportUserId.value = btn.dataset.id;
    });
  });
  const deleteButtons = document.querySelectorAll('[data-bs-target="#deleteCustomerModal"]');
  const deleteCustomerId = document.getElementById("deleteCustomerId");
  const deleteCustomerName = document.getElementById("deleteCustomerName");
  const deleteCustomerReason = document.getElementById("deleteCustomerReason");

  deleteButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const customerId = btn.getAttribute("data-id");
      const customerName = btn.getAttribute("data-name");

      deleteCustomerId.value = customerId;
      deleteCustomerName.textContent = customerName;
      deleteCustomerReason.value = "";
    });
  });
  if (deleteForm) {
  deleteForm.addEventListener("submit", function (e) {
    if (typeof tinymce !== "undefined") {
      tinymce.triggerSave();
    }

    const content = deleteCustomerReason.value.trim();
    if (content === '') {
      e.preventDefault(); // Ngăn submit
      alert("Vui lòng nhập lý do xóa khách hàng.");
    }
  });
}


  // Bắt TinyMCE ghi nội dung textarea lại khi form submit
  const deleteForm = document.querySelector('#deleteCustomerModal form');

  if (deleteForm) {
    deleteForm.addEventListener("submit", function () {
      if (typeof tinymce !== "undefined") {
        tinymce.triggerSave();
      }
    });
  }
// Xử lý nút "Chi tiết khách hàng"
const detailButtons = document.querySelectorAll(".btn-detail-customer");

detailButtons.forEach((btn) => {
  btn.addEventListener("click", () => {
    document.getElementById("detail-fullname").textContent = btn.dataset.fullname;
    document.getElementById("detail-email").textContent = btn.dataset.email;
    document.getElementById("detail-phone").textContent = btn.dataset.phone;
    document.getElementById("detail-address").textContent = btn.dataset.address || "Chưa cập nhật";
    document.getElementById("detail-created").textContent = btn.dataset.created || "Không rõ";
    document.getElementById("detail-status").textContent = btn.dataset.status || "Không rõ";
  });
});


});
