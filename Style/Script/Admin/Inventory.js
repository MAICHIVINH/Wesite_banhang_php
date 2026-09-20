document.addEventListener("DOMContentLoaded", function () {
  const editButtons = document.querySelectorAll(
    'button.btn-primary[data-bs-toggle="modal"][data-bs-target="#editItemModal"]'
  );

  editButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();

      const id = button.getAttribute("data-id");
      const productName = button.getAttribute("data-product-name");
      const stockQuantity = button.getAttribute("data-stock-quantity");
      const productId = button.getAttribute("data-product-id");
      const branch = button.getAttribute("data-branch-id");

      const warehouseIdInput = document.getElementById("editItemWarehouseId");
      const productNameInput = document.getElementById("editItemProductName");
      const quantityInput = document.getElementById("editItemQuantity");
      const productIdInput = document.getElementById("editIdProduct");
      const branchSelect = document.getElementById("editItemBranch");

      if (
        warehouseIdInput &&
        productNameInput &&
        quantityInput &&
        productIdInput &&
        branchSelect
      ) {
        warehouseIdInput.value = id || "";
        productNameInput.value = productName || "";
        quantityInput.value = stockQuantity || "0";
        productIdInput.value = productId || "";

        // ✅ Set branch selected
        for (const option of branchSelect.options) {
          option.selected = option.value === branch;
        }
      } else {
        console.error("Thiếu element trong modal SỬA");
      }
    });
  });

  // Cleanup modal backdrop
  const modals = document.querySelectorAll(".modal");
  modals.forEach((modal) => {
    modal.addEventListener("hidden.bs.modal", function () {
      const backdrop = document.querySelector(".modal-backdrop");
      if (backdrop) backdrop.remove();
    });
  });
});
