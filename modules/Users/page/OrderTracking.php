<?php

$address = "Đại học Đồng Tháp";


if ($_GET['order_id']) {
    $order_id = $_GET['order_id'];
    $order = $orderController->getById($order_id);
    $shipping = $shippingController->getById($order['shipping_id']);
    $address = $shipping['address'];
}

?>

<!-- <div class="map-container">
    <div class="map-header">
        <h2 class="text-primary">📍 Vị trí đơn hàng của bạn</h2>
        <div class="address-info">
            Địa chỉ: <strong><?= htmlspecialchars($address) ?></strong>
        </div>
    </div>

    <div id="map"></div>
</div> -->
<div class="map-container">
    <div class="map-header">
        <h2 class="text-primary">📍 Vị trí đơn hàng của bạn</h2>
        <div class="address-info">
            Địa chỉ: <strong><?= htmlspecialchars($address) ?></strong>
        </div>
    </div>
    <iframe
        width="100%"
        height="500"
        frameborder="0"
        style="border:0"
        src="https://www.google.com/maps?q=<?= urlencode($address) ?>&output=embed"
        allowfullscreen></iframe>
</div>


<!-- <script>
    const address = <?= json_encode($address) ?>;

    fetch(`https://maps.google.com/maps?q=${address}&z=15&output=embed`)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lon = parseFloat(data[0].lon);

                // Hiển thị bản đồ
                const map = L.map('map').setView([lat, lon], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                L.marker([lat, lon]).addTo(map)
                    .bindPopup(address)
                    .openPopup();
            } else {
                alert("Không tìm thấy vị trí cho địa chỉ: " + address);
            }
        })
        .catch(error => {
            console.error("Lỗi khi gọi API Nominatim:", error);
        });
</script> -->