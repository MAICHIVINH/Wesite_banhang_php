document.addEventListener("DOMContentLoaded", function () {
    // Gán dữ liệu vào modal khi bấm nút xóa
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".delete-btn");
        if (btn) {
            const idInput = document.getElementById("deleteProductId");
            const nameEl = document.getElementById("deleteProductName");
            if (idInput) idInput.value = btn.dataset.id;
            if (nameEl) nameEl.textContent = btn.dataset.name;
        }
    });

    // Xử lý Xóa qua AJAX không load lại trang
    const deleteForm = document.getElementById("deleteProductForm");
    if (deleteForm) {
        deleteForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const productId = document.getElementById("deleteProductId").value;
            const modalEl = document.getElementById("deleteProductModal");
            const modalInstance = bootstrap.Modal.getInstance(modalEl);

            const formData = new FormData(deleteForm);

            fetch("Admin.php?page=modules/Admin/Products/Product.php", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (modalInstance) {
                    modalInstance.hide();
                }
                if (data.success) {
                    toastr.success(data.message || "Đã xóa sản phẩm thành công!");
                    const row = document.getElementById("product-row-" + productId);
                    if (row) {
                        row.style.transition = "all 0.4s ease";
                        row.style.opacity = "0";
                        row.style.transform = "translateX(30px)";
                        setTimeout(() => row.remove(), 400);
                    }
                } else {
                    toastr.error(data.message || "Xóa sản phẩm thất bại!");
                }
            })
            .catch(err => {
                if (modalInstance) modalInstance.hide();
                toastr.error("Có lỗi xảy ra khi xóa sản phẩm!");
            });
        });
    }
});
