<?php
// Handles order creation for online payment method (MoMo, ShopeePay, ZaloPay, VietQR)

if (empty($_POST['selected'])) {
    swal_alert('warning', 'Chưa chọn sản phẩm', 'Vui lòng chọn sản phẩm cần thanh toán.', 'index.php?subpage=modules/Users/page/Cart.php');
    exit;
}

$branchId = $_POST['branch_id'] ?? '';
if (empty($branchId)) {
    swal_alert('warning', 'Chưa chọn chi nhánh', 'Vui lòng chọn chi nhánh nhận hàng.', 'index.php?subpage=modules/Users/page/Cart.php');
    exit;
}

$totalAmount = 0;
$itemsToBuy = [];

foreach ($_POST['selected'] as $id) {
    if (isset($cart[$id])) {
        $productById = $product->getById($id);
        $priceProduct = (float)$productById['price'];
        if (isset($productById['discount']) && $productById['discount'] > 0) {
            $priceProduct *= (1 - $productById['discount'] / 100);
        }
        $quantity = (int)$cart[$id]['quantity'];

        $totalAmount += $priceProduct * $quantity;
        $itemsToBuy[$id] = [
            'product_id' => $id,
            'quantity' => $quantity,
            'unit_price' => $priceProduct
        ];
    }
}

// 1. Create Payment record
$dataPayment = [
    "method" => 'Thanh toán Online (MoMo/ShopeePay/VietQR)',
    "status" => 'Chờ thanh toán',
    "paid_at" => date("Y-m-d H:i:s")
];
$paymentId = $paymentController->add($dataPayment);

// 2. Create Shipping record
$branchById = $branchController->getById($branchId);
$dataShipping = [
    'address' => isset($branchById['address']) ? $branchById['address'] : 'Nhận tại cửa hàng',
    'method' => 'Chưa có',
    'status' => 'Chờ giao',
    'isDeleted' => 0,
];

$resShipping = $shippingController->add($dataShipping);
$shippingId = isset($resShipping['shipping']) ? $resShipping['shipping'] : null;

// 3. Create Order record
$code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
$note = trim($_POST['note'] ?? '');

$dataOrder = [
    'code' => $code,
    'total_amount' => $totalAmount,
    'status_id' => 1, // Chờ xử lý
    'user_id' => $userData->id,
    'note' => $note,
    'payment_id' => $paymentId,
    'branch_id' => $branchId,
    'shipping_id' => $shippingId,
    'isDeleted' => 0
];

$resOrder = $orderController->add($dataOrder);
$orderId = isset($resOrder['order_id']) ? $resOrder['order_id'] : null;

if ($orderId) {
    // 4. Create OrderItems & remove from cart
    foreach ($itemsToBuy as $item) {
        $dataOrderItem = [
            'quantity' => $item['quantity'],
            'unit_price' => $item['unit_price'],
            'product_id' => $item['product_id'],
            'order_id' => $orderId,
        ];

        $orderItemController->add($dataOrderItem);
        unset($_SESSION['cart'][$item['product_id']]);
    }

    // Redirect to Online Payment Dynamic QR page
    header("Location: index.php?subpage=modules/Users/page/OnlinePayment.php&order_id=" . $orderId);
    exit;
} else {
    swal_alert('error', 'Lỗi tạo đơn hàng', 'Hệ thống không thể tạo đơn hàng thanh toán online.', 'index.php?subpage=modules/Users/page/Cart.php');
    exit;
}
