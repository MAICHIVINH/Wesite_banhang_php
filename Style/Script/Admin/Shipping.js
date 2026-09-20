document.addEventListener("DOMContentLoaded", function () {
  function getCleanAddressForGoogleMaps(address) {
    if (!address) return "Việt Nam";
    let str = address.trim();

    // Strip leading slash numbers e.g. "296/GS, ", "12/3A, ", "Số 45/2, "
    str = str.replace(/^(sô|số)?\s*[\w\d\/\-\.]+\s*,\s*/i, '');

    // Extract hamlet / commune / district parts (ignore trailing merged province if conflicting)
    let parts = str.split(',').map(s => s.trim()).filter(Boolean);
    if (parts.length > 2) {
      str = parts.slice(0, 2).join(', ');
    }

    if (!/Việt Nam|Vietnam/i.test(str)) {
      str += ", Việt Nam";
    }

    return str;
  }

  window.showSenderInfo = function (order) {
    document.getElementById("modal_order_id").textContent = order.id;
    document.getElementById("modal_sender_name").textContent = order.senderName;
    document.getElementById("modal_sender_phone").textContent = order.senderPhone;
    document.getElementById("modal_sender_address").textContent = order.senderAddress;

    const queryAddress = getCleanAddressForGoogleMaps(order.senderAddress);
    const mapIframe = document.getElementById("mapIframe");
    if (mapIframe) {
      mapIframe.src = `https://maps.google.com/maps?q=${encodeURIComponent(queryAddress)}&t=&z=15&ie=UTF8&iwloc=B&output=embed`;
    }

    const modalElement = document.getElementById("senderLocationModal");
    if (modalElement && typeof bootstrap !== 'undefined') {
      const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
      modal.show();
    }
  };

  window.showCurrentLocation = function (order) {
    document.getElementById("current-order-id").textContent = order.id;
    document.getElementById("current-shipper-name").textContent = order.shipperName;
    document.getElementById("current-shipper-phone").textContent = order.shipperPhone;
    document.getElementById("current-address").textContent = order.currentAddress;
    document.getElementById("current-order-status").textContent = order.status;

    const queryAddress = getCleanAddressForGoogleMaps(order.currentAddress);
    const mapIframe = document.getElementById("current-location-map");
    if (mapIframe) {
      mapIframe.src = `https://maps.google.com/maps?q=${encodeURIComponent(queryAddress)}&t=&z=15&ie=UTF8&iwloc=B&output=embed`;
    }

    const modalElement = document.getElementById("currentLocationModal");
    if (modalElement && typeof bootstrap !== 'undefined') {
      const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
      modal.show();
    }
  };

  window.loadTransferForm = function (code, currentLocation = "", shipperId) {
    document.getElementById("transfer-shipping-id").value = shipperId;
    document.getElementById("transfer-order-id").value = code;
    document.getElementById("transfer-current-location").value = currentLocation || "Chưa xác định";
  };
});
