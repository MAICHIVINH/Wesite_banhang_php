document.addEventListener("DOMContentLoaded", function () {
  let receiverMap = null;
  let receiverMarker = null;
  let currentMap = null;
  let currentMarker = null;

  // Custom Red Marker Pin Icon
  const redMarkerIcon = (typeof L !== 'undefined') ? L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
  }) : null;

  function renderMapWithPin(type, rawAddress, titleLabel) {
    if (!rawAddress) return;

    // Build geocode query string:
    // Strip leading house numbers like "296/GS, " -> search "ấp Giồng Sao, xã An Hiệp, Việt Nam"
    let address = rawAddress.trim();
    let queryTerm = address.replace(/^(sô|số)?\s*[\w\d\/\-\.]+\s*,\s*/i, '');
    if (!queryTerm) queryTerm = address;

    // Append country if missing
    if (!/Việt Nam|Vietnam/i.test(queryTerm)) {
      queryTerm += ", Việt Nam";
    }

    const searchUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(queryTerm)}&limit=1`;

    fetch(searchUrl)
      .then(res => res.json())
      .then(data => {
        let lat = 10.2536; // Default southern VN fallback
        let lon = 105.9722;

        if (data && data.length > 0) {
          lat = parseFloat(data[0].lat);
          lon = parseFloat(data[0].lon);
        }

        if (type === 'receiver') {
          const mapDiv = document.getElementById('receiverMap');
          if (typeof L !== 'undefined' && mapDiv) {
            if (!receiverMap) {
              receiverMap = L.map('receiverMap').setView([lat, lon], 15);
              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
              }).addTo(receiverMap);
            } else {
              receiverMap.setView([lat, lon], 15);
            }

            // Invalidate size once modal finishes opening animation
            setTimeout(() => {
              if (receiverMap) receiverMap.invalidateSize();
            }, 250);

            if (receiverMarker) {
              receiverMap.removeLayer(receiverMarker);
            }

            receiverMarker = L.marker([lat, lon], { icon: redMarkerIcon }).addTo(receiverMap)
              .bindPopup(`<div style="font-size:13px; font-weight:700; color:#4f46e5;"><i class="bi bi-geo-alt-fill text-danger me-1"></i>${titleLabel}</div><div style="font-size:12px;" class="text-dark mt-1"><b>Địa chỉ:</b> ${address}</div>`)
              .openPopup();
          }
        } else if (type === 'current') {
          const mapDiv = document.getElementById('currentMap');
          if (typeof L !== 'undefined' && mapDiv) {
            if (!currentMap) {
              currentMap = L.map('currentMap').setView([lat, lon], 15);
              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
              }).addTo(currentMap);
            } else {
              currentMap.setView([lat, lon], 15);
            }

            setTimeout(() => {
              if (currentMap) currentMap.invalidateSize();
            }, 250);

            if (currentMarker) {
              currentMap.removeLayer(currentMarker);
            }

            currentMarker = L.marker([lat, lon], { icon: redMarkerIcon }).addTo(currentMap)
              .bindPopup(`<div style="font-size:13px; font-weight:700; color:#10b981;"><i class="bi bi-geo-alt-fill text-danger me-1"></i>${titleLabel}</div><div style="font-size:12px;" class="text-dark mt-1"><b>Vị trí:</b> ${address}</div>`)
              .openPopup();
          }
        }
      })
      .catch(err => {
        console.error("Map rendering error:", err);
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
      renderMapWithPin('receiver', order.senderAddress, 'Vị trí người nhận');
    }, { once: true });
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
      renderMapWithPin('current', order.currentAddress, 'Vị trí hiện tại của đơn hàng');
    }, { once: true });
  };

  window.loadTransferForm = function (code, currentLocation = "", shipperId) {
    document.getElementById("transfer-shipping-id").value = shipperId;
    document.getElementById("transfer-order-id").value = code;
    document.getElementById("transfer-current-location").value = currentLocation || "Chưa xác định";
  };
});
