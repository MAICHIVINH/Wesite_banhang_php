document.addEventListener("DOMContentLoaded", function () {
  const addButtons = document.querySelectorAll(
    'button[data-bs-target="#addItemModal"]'
  );

  addButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const id = button.getAttribute("data-id");
      const productName = button.getAttribute("data-product-name");
      const stockQuantity = button.getAttribute("data-stock-quantity");

      const idInput = document.getElementById("addItemWarehouseId");
      const productNameInput = document.getElementById("addItemProductName");
      const quantityInput = document.getElementById("quantity_add");

      if (idInput && productNameInput) {
        idInput.value = id || "";
        productNameInput.value = productName || "";
        quantityInput.value = stockQuantity || "0";
      }
    });
  });
});
