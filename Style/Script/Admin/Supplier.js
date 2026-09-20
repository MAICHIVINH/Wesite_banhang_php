document.addEventListener("DOMContentLoaded", () => {
  //   const editModal = document.getElementById('editSupplierModal');
  //   if (editModal) {
  //     editModal.addEventListener('show.bs.modal', event => {
  //       const button = event.relatedTarget;

  //       document.getElementById('editSupplierId').value = button.getAttribute('data-id');
  //       document.getElementById('editSupplierName').value = button.getAttribute('data-name');
  //       document.getElementById('editSupplierContact').value = button.getAttribute('data-contact');
  //       document.getElementById('editSupplierPhone').value = button.getAttribute('data-phone');
  //       document.getElementById('editSupplierEmail').value = button.getAttribute('data-email');
  //       document.getElementById('editSupplierAddress').value = button.getAttribute('data-address');

  //       const imageUrl = button.getAttribute('data-image');
  //       document.getElementById('editSupplierPreview').src = imageUrl && imageUrl !== '' ? imageUrl : 'path/to/no-image.png';
  //     });
  //   }

  // Xử lý modal xóa nhà cung cấp
  const deleteModal = document.getElementById("deleteSupplierModal");
  if (deleteModal) {
    deleteModal.addEventListener("show.bs.modal", (event) => {
      const button = event.relatedTarget;
      document.getElementById("deleteSupplierId").value =
        button.getAttribute("data-id");
      document.getElementById("deleteSupplierName").innerText =
        button.getAttribute("data-name");
    });
  }

  // Xử lý backdrop khi modal đóng
  document.querySelectorAll(".modal").forEach((modalEl) => {
    modalEl.addEventListener("hidden.bs.modal", () => {
      document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
    });
  });

  // Xử lý xem trước ảnh cho input file trong modal thêm nhà cung cấp
  const supplierImageInput = document.getElementById("supplierImageInput");
  const supplierImagePreview = document.getElementById("supplierImagePreview");
  if (supplierImageInput && supplierImagePreview) {
    supplierImageInput.addEventListener("change", function (event) {
      supplierImagePreview.innerHTML = ""; // Xóa ảnh xem trước cũ
      const file = event.target.files[0]; // Lấy file đầu tiên
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          const img = document.createElement("img");
          img.src = e.target.result;
          img.style.maxWidth = "150px"; // Kích thước ảnh xem trước
          img.style.marginTop = "10px";
          img.style.border = "1px solid #ddd";
          img.style.borderRadius = "4px";
          supplierImagePreview.appendChild(img);
        };
        reader.readAsDataURL(file); // Đọc file dưới dạng URL
      }
    });
  }
});
