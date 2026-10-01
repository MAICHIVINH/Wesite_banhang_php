document.addEventListener("DOMContentLoaded", function () {
  const editModal = document.getElementById("editItemModal");

  if (editModal) {
    editModal.addEventListener("show.bs.modal", function (event) {
      const button = event.relatedTarget;
      if (!button) return;

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

      if (warehouseIdInput) warehouseIdInput.value = id || "";
      if (productNameInput) productNameInput.value = productName || "";
      if (quantityInput) quantityInput.value = stockQuantity || "0";
      if (productIdInput) productIdInput.value = productId || "";

      if (branchSelect) {
        for (const option of branchSelect.options) {
          option.selected = String(option.value) === String(branch);
        }
      }
    });
  }

  // Also support click event handler as fallback
  const editButtons = document.querySelectorAll(
    'button[data-bs-target="#editItemModal"], a[data-bs-target="#editItemModal"]'
  );

  editButtons.forEach((button) => {
    button.addEventListener("click", function () {
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

      if (warehouseIdInput) warehouseIdInput.value = id || "";
      if (productNameInput) productNameInput.value = productName || "";
      if (quantityInput) quantityInput.value = stockQuantity || "0";
      if (productIdInput) productIdInput.value = productId || "";

      if (branchSelect) {
        for (const option of branchSelect.options) {
          option.selected = String(option.value) === String(branch);
        }
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
