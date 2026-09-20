document.addEventListener("DOMContentLoaded", function () {
  function formatAddressForPin(address) {
    if (!address) return "";
    let str = address.trim();
    // Clean house numbers with slashes e.g. "296/GS, " -> "ấp Giồng Sao, xã An Hiệp, tỉnh Bến Tre"
    // Google Maps pin locator works best when query is a recognized village/commune/street
    let cleaned = str.replace(/^(sô|số)?\s*[\w\d\/\-\.]+\s*,\s*/i, '');
    return cleaned || str;
  }

  window.showSenderInfo = function (order) {
    document.getElementById("modal_order_id").textContent = order.id;
    document.getElementById("modal_sender_name").textContent = order.senderName;
    document.getElementById("modal_sender_phone").textContent = order.senderPhone;
    document.getElementById("modal_sender_address").textContent = order.senderAddress;

    const mapIframe = document.getElementById("mapIframe");
    const queryAddress = formatAddressForPin(order.senderAddress);
    mapIframe.src = `https://maps.google.com/maps?q=${encodeURIComponent(queryAddress)}&t=&z=15&ie=UTF8&iwloc=B&output=embed`;

    const modal = new bootstrap.Modal(
      document.getElementById("senderLocationModal")
    );
    modal.show(); 
  };

  window.showCurrentLocation = function (order) {
    document.getElementById("current-order-id").textContent = order.id;
    document.getElementById("current-shipper-name").textContent = order.shipperName;
    document.getElementById("current-shipper-phone").textContent = order.shipperPhone;
    document.getElementById("current-address").textContent = order.currentAddress;
    document.getElementById("current-order-status").textContent = order.status;

    const mapIframe = document.getElementById("current-location-map");
    const queryAddress = formatAddressForPin(order.currentAddress);
    mapIframe.src = `https://maps.google.com/maps?q=${encodeURIComponent(queryAddress)}&t=&z=15&ie=UTF8&iwloc=B&output=embed`;

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
});
