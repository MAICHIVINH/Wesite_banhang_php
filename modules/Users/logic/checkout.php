<?php

// 1. Kiểm tra tồn kho tại chi nhánh đã chọn TRƯỚC KHI tạo thanh toán / giao hàng
foreach ($_POST['selected'] as $id) {
    if (isset($cart[$id])) {
        $productInventory = $inventoryController->getProductInventory($id, $branch, true);
        $stockQuantity = (!empty($productInventory) && isset($productInventory['stock_quantity'])) ? (int)$productInventory['stock_quantity'] : 0;
        $quantity = (int)$cart[$id]['quantity'];

        if ($stockQuantity < $quantity) {
            $productById = $product->getById($id);
            $pName = $productById['name'] ?? 'sản phẩm';
            if ($stockQuantity <= 0) {
                swal_alert('warning', 'Hết hàng tại chi nhánh', "Cửa hàng hiện tại không có sẵn \"{$pName}\". Vui lòng chọn cửa hàng khác!", 'index.php?subpage=modules/Users/page/Cart.php');
            } else {
                swal_alert('warning', 'Không đủ hàng', "Cửa hàng hiện tại chỉ còn {$stockQuantity} \"{$pName}\", không đủ số lượng bạn mua ({$quantity})!", 'index.php?subpage=modules/Users/page/Cart.php');
            }
            exit;
        }
    }
}

// 2. Xử lý tính tổng tiền
$totalAmount = 0;
foreach ($_POST['selected'] as $id) {
    if (isset($cart[$id])) {
        $productById = $product->getById($id);
        $priceProduct = (float)$productById['price'];
        if (!empty($productById['discount']) && $productById['discount'] > 0) {
            $priceProduct *= (1 - $productById['discount'] / 100);
        }
        $quantity = (int)$cart[$id]['quantity'];
        $totalAmount += $priceProduct * $quantity;
    }
}

// 3. Xử lý đưa dữ liệu vào Shipping
$branchById = $branchController->getById($branch);

$dataShipping = [
    'address' => $branchById['address'] ?? 'Nhận tại cửa hàng',
    'method' => 'Chưa có',
    'status' => 'Chờ giao',
    'isDeleted' => 0,
];

$resultShipping = $shippingController->add($dataShipping);

if (!$resultShipping['success']) {
    swal_alert('Thất bại', $resultShipping['message'], 'error', 'index.php?subpage=modules/Users/page/Cart.php');
    exit;
}

$code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
$note = $_POST['note'] ?? '';
$data = [
    'code' => $code,
    'total_amount' => $totalAmount,
    'status_id' => 1, // Chờ xử lý
    'user_id' => $userData->id,
    'note' => $note,
    'payment_id' => $paymentId,
    'branch_id' => $branch,
    'shipping_id' => $resultShipping['shipping'],
    'isDeleted' => 0
];
$order = $orderController->add($data);

// 4. Đẩy dữ liệu vào orderItems
foreach ($_POST['selected'] as $id) {
    if (isset($cart[$id])) {
        $productById = $product->getById($id);
        $priceProduct = (float)$productById['price'];
        if (!empty($productById['discount']) && $productById['discount'] > 0) {
            $priceProduct *= (1 - $productById['discount'] / 100);
        }
        $quantity = (int)$cart[$id]['quantity'];

        $dataOrderItem = [
            'quantity' => $quantity,
            'unit_price' => $priceProduct,
            'product_id' => $id,
            'order_id' => $order['order_id'],
        ];

        $orderItemController->add($dataOrderItem);
        unset($cart[$id]);
    }
}

