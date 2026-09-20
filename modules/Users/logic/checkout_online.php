<?php
// Handles order creation for online payment method (MoMo, ShopeePay, ZaloPay, VietQR)

if (empty($_POST['selected'])) {
    swal_alert('warning', 'Chưa chọn sản phẩm', 'Vui lòng chọn sản phẩm cần thanh toán.', 'index.php?subpage=modules/Users/page/Cart.php');
    exit;
}

$totalAmount = 0;
$itemsToBuy = [];

foreach ($_POST['selected'] as $id) {
    if (isset($cart[$id])) {
        $p = $product->getById($id);
        $qty = (int)$cart[$id]['quantity'];
        $originalPrice = (float)$p['price'];
        $discount = (float)($p['discount'] ?? 0);
        $finalPrice = $originalPrice * (1 - $discount / 100);

        $totalAmount += $finalPrice * $qty;
        $itemsToBuy[$id] = [
            'product_id' => $id,
            'quantity' => $qty,
            'price' => $finalPrice
        ];
    }
}

// Create payment record
$dataPayment = [
    "method" => 'Thanh toán Online (MoMo/ShopeePay/VietQR)',
    "status" => 'Chờ thanh toán',
    "paid_at" => date("Y-m-d H:i:s")
];
$paymentId = $paymentController->add($dataPayment);

// Create shipping record
$userAddr = isset($userData->Address) ? $userData->Address : '';
$userPhone = isset($userData->Phone) ? $userData->Phone : '';

$dataShipping = [
    "user_id" => $userData->id,
    "address" => !empty($_POST['address']) ? $_POST['address'] : (!empty($userAddr) ? $userAddr : 'Nhận tại cửa hàng'),
    "phone" => !empty($_POST['phone']) ? $_POST['phone'] : (!empty($userPhone) ? $userPhone : '0123456789'),
    "status_id" => 1,
    "isDeleted" => 0
];
$shippingId = $shippingController->add($dataShipping);

// Create Order
$dataOrder = [
    "user_id" => $userData->id,
    "status_id" => 1,
    "shipping_id" => $shippingId,
    "payment_id" => $paymentId,
    "branch_id" => $_POST['branch_id'],
    "note" => trim($_POST['note'] ?? ''),
    "total_price" => $totalAmount,
    "created_at" => date("Y-m-d H:i:s"),
    "isDeleted" => 0
];

$orderRes = $orderController->add($dataOrder);
$orderId = null;

if (is_array($orderRes)) {
    $orderId = $orderRes['id'] ?? ($orderRes['order_id'] ?? null);
} else if (is_numeric($orderRes)) {
    $orderId = (int)$orderRes;
}

if ($orderId) {
    foreach ($itemsToBuy as $item) {
        $dataOrderItem = [
            "order_id" => $orderId,
            "product_id" => $item['product_id'],
            "quantity" => $item['quantity'],
            "price" => $item['price']
        ];
        $orderItemController->add($dataOrderItem);

        // Deduct inventory if stock available
        if (method_exists($inventoryController, 'decrementStock')) {
            $inventoryController->decrementStock($item['product_id'], $_POST['branch_id'], $item['quantity']);
        }

        // Remove purchased item from cart session
        unset($_SESSION['cart'][$item['product_id']]);
    }

    // Redirect to Online Payment Dynamic QR page
    header("Location: index.php?subpage=modules/Users/page/OnlinePayment.php&order_id=" . $orderId);
    exit;
} else {
    swal_alert('error', 'Lỗi tạo đơn hàng', 'Hệ thống không thể tạo đơn hàng thanh toán online.', 'index.php?subpage=modules/Users/page/Cart.php');
    exit;
}
