document.addEventListener("DOMContentLoaded", function () {
  window.showSenderInfo = function (order) {
    document.getElementById("modal_order_id").textContent = order.id;
    // document.getElementById("modal_order_name").textContent = order.name;
    document.getElementById("modal_sender_name").textContent = order.senderName;
    document.getElementById("modal_sender_phone").textContent =
      order.senderPhone;
    document.getElementById("modal_sender_address").textContent =
      order.senderAddress;

    const mapIframe = document.getElementById("mapIframe");
    const addressEncoded = encodeURIComponent(order.senderAddress);
    mapIframe.src = `https://maps.google.com/maps?q=${addressEncoded}&z=15&output=embed`;

    const modal = new bootstrap.Modal(
      document.getElementById("senderLocationModal")
    );
    modal.show(); 
  };

  window.showCurrentLocation = function (order) {
    document.getElementById("current-order-id").textContent = order.id;
    document.getElementById("current-shipper-name").textContent =
      order.shipperName;
    document.getElementById("current-shipper-phone").textContent =
      order.shipperPhone;
    document.getElementById("current-address").textContent =
      order.currentAddress;
    document.getElementById("current-order-status").textContent = order.status;

    const mapIframe = document.getElementById("current-location-map");
    const encodedAddress = encodeURIComponent(order.currentAddress);
    mapIframe.src = `https://maps.google.com/maps?q=${encodedAddress}&z=15&output=embed`;

    const modal = new bootstrap.Modal(
      document.getElementById("currentLocationModal")
    );
    modal.show();
  };
  window.loadTransferForm = function (code, currentLocation = "", shipperId) {
    document.getElementById("transfer-shipping-id").value = shipperId;
    document.getElementById("transfer-order-id").value = code;
    document.getElementById("transfer-current-location").value =
      currentLocation || "Chưa xác định";
  };

  function submitTransfer(event) {
    event.preventDefault();

    const orderId = document.getElementById("transfer-order-id").value;
    const currentLocation = document.getElementById(
      "transfer-current-location"
    ).value;
    const destination = document.getElementById("transfer-destination").value;
    const note = document.getElementById("transfer-note").value;

    // Gửi về server để xử lý (AJAX hoặc form POST)
    console.log("Chuyển đơn:", orderId);
    console.log("Vị trí hiện tại:", currentLocation);
    console.log("Chuyển đến:", destination);
    console.log("Ghi chú:", note);

    // Đóng modal
    const modal = bootstrap.Modal.getInstance(
      document.getElementById("transferModal")
    );
    modal.hide();

    // Có thể thêm alert/thông báo
    alert(
      `Đã chuyển đơn ${orderId} từ "${currentLocation}" đến "${destination}"`
    );
  }
});
