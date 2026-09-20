document.addEventListener("DOMContentLoaded", function () {
  let receiverMap = null;
  let receiverMarker = null;
  let currentMap = null;
  let currentMarker = null;

  function loadMapWithMarker(mapType, rawAddress, titleLabel) {
    const address = rawAddress ? rawAddress.trim() : '';
    if (!address) return;

    // Clean address for geocoding
    // E.g., "296/GS, ấp Giồng Sao, xã An Hiệp, tỉnh Bến Tre" -> query "An Hiệp, Bến Tre, Việt Nam" or full
    const addressParts = address.split(',').map(s => s.trim());
    const queryTerm = addressParts.slice(Math.max(0, addressParts.length - 3)).join(', ');

    const nominatimUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(queryTerm || address)}&limit=1`;

    fetch(nominatimUrl)
      .then(response => response.json())
      .then(data => {
        let lat = 10.2536;
        let lon = 105.9722;
        let found = false;

        if (data && data.length > 0) {
          lat = parseFloat(data[0].lat);
          lon = parseFloat(data[0].lon);
          found = true;
        }

        if (mapType === 'receiver') {
          const mapDiv = document.getElementById('receiverMap');
          if (typeof L !== 'undefined' && mapDiv) {
            if (!receiverMap) {
              receiverMap = L.map('receiverMap').setView([lat, lon], 14);
              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
              }).addTo(receiverMap);
            } else {
              receiverMap.setView([lat, lon], 14);
            }

            if (receiverMarker) {
              receiverMap.removeLayer(receiverMarker);
            }

            receiverMarker = L.marker([lat, lon]).addTo(receiverMap)
              .bindPopup(`<div style="font-size:13px; font-weight:600;"><i class="bi bi-geo-alt-fill text-danger me-1"></i>${titleLabel}</div><div style="font-size:12px;" class="text-muted mt-1">${address}</div>`)
              .openPopup();

            setTimeout(() => {
              receiverMap.invalidateSize();
            }, 300);
          }
        } else if (mapType === 'current') {
          const mapDiv = document.getElementById('currentMap');
          if (typeof L !== 'undefined' && mapDiv) {
            if (!currentMap) {
              currentMap = L.map('currentMap').setView([lat, lon], 14);
              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
              }).addTo(currentMap);
            } else {
              currentMap.setView([lat, lon], 14);
            }

            if (currentMarker) {
              currentMap.removeLayer(currentMarker);
            }

            currentMarker = L.marker([lat, lon]).addTo(currentMap)
              .bindPopup(`<div style="font-size:13px; font-weight:600;"><i class="bi bi-geo-alt-fill text-success me-1"></i>${titleLabel}</div><div style="font-size:12px;" class="text-muted mt-1">${address}</div>`)
              .openPopup();

            setTimeout(() => {
              currentMap.invalidateSize();
            }, 300);
          }
        }
      })
      .catch(err => {
        console.error("Geocoding error:", err);
      });
  }

  window.showSenderInfo = function (order) {
    document.getElementById("modal_order_id").textContent = order.id;
    document.getElementById("modal_sender_name").textContent = order.senderName;
    document.getElementById("modal_sender_phone").textContent = order.senderPhone;
    document.getElementById("modal_sender_address").textContent = order.senderAddress;

    const modalElement = document.getElementById("senderLocationModal");
    const modal = new bootstrap.Modal(modalElement);
    modal.show();

    modalElement.addEventListener('shown.bs.modal', function () {
      loadMapWithMarker('receiver', order.senderAddress, 'Vị trí người nhận');
    }, { once: true });
    loadMapWithMarker('receiver', order.senderAddress, 'Vị trí người nhận');
  };

  window.showCurrentLocation = function (order) {
    document.getElementById("current-order-id").textContent = order.id;
    document.getElementById("current-shipper-name").textContent = order.shipperName;
    document.getElementById("current-shipper-phone").textContent = order.shipperPhone;
    document.getElementById("current-address").textContent = order.currentAddress;
    document.getElementById("current-order-status").textContent = order.status;

    const modalElement = document.getElementById("currentLocationModal");
    const modal = new bootstrap.Modal(modalElement);
    modal.show();

    modalElement.addEventListener('shown.bs.modal', function () {
      loadMapWithMarker('current', order.currentAddress, 'Vị trí hiện tại của đơn hàng');
    }, { once: true });
    loadMapWithMarker('current', order.currentAddress, 'Vị trí hiện tại của đơn hàng');
  };

  window.loadTransferForm = function (code, currentLocation = "", shipperId) {
    document.getElementById("transfer-shipping-id").value = shipperId;
    document.getElementById("transfer-order-id").value = code;
    document.getElementById("transfer-current-location").value = currentLocation || "Chưa xác định";
  };
});
