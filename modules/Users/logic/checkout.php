<?php


// Xử lý đơn hàng giảm giá
foreach ($_POST['selected'] as $id) {
    $productById = $product->getById($id);
    $priceProduct = $productById['price'];
    if ($productById['discount'] > 0) {
        $priceProduct *= (1 - $productById['discount'] / 100);
    }
    $quantity = $cart[$id]['quantity'];

    $totalAmount += $priceProduct * $quantity;
}

// Xử lý đưa dữ liệu vào Shipping
$branchById = $branchController->getById($branch);

$dataShipping = [
    'address' => $branchById['address'],
    'method' => 'Chưa có',
    'status' => 'Chờ giao',
    'isDeleted' => 0,
];

$resultShipping = $shippingController->add($dataShipping);
// if (!$resultShipping['success']) {
//     echo "<script>
//                             alert('{$resultShipping['message']}');
//                             window.location.href = 'index.php';
//                         </script>";
//     exit;
// }

if (!$resultShipping['success']) {
    swal_alert('Thất bại', $resultShipping['message'], 'error', 'index.php');
    exit;
}


// kiểm tra đơn hàng xem đủ số lượng tồn tại cửa hàng đó không
foreach ($_POST['selected'] as $id) {
    $productInventory = $inventoryController->getProductInventory($id, $branch, true);
    $quantity = $cart[$id]['quantity'];
    // if ($quantity >= $productInventory) {
    //     echo "<script>
    //                         alert('Hiện cửa hàng này không đủ số lượng sản phẩm bạn mua!');
    //                         window.location.href = 'index.php?subpage=modules/Users/page/Cart.php';
    //                     </script>";
    //     exit;
    // }
    if ($quantity >= $productInventory) {
        swal_alert('warning', 'Không đủ hàng', 'Hiện cửa hàng này không đủ số lượng sản phẩm bạn mua!', 'index.php?subpage=modules/Users/page/Cart.php');
        exit;
    }
}
$code = strtoupper(string: substr(md5(uniqid(mt_rand(), true)), 0, 8));
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

// nếu tất cả điều kiện trên thỏa mã thì đẩy dữ liệu vào orderItems
foreach ($_POST['selected'] as $id) {
    $productById = $product->getById($id);
    $priceProduct = $productById['price'];
    if ($productById['discount'] > 0) {
        $priceProduct *= (1 - $productById['discount'] / 100);
    }
    $quantity = $cart[$id]['quantity'];

    $dataOrderItem = [
        'quantity' => $quantity,
        'unit_price' => $priceProduct,
        'product_id' => $id,
        'order_id' => $order['order_id'],
    ];

    $orderItemController->add($dataOrderItem);
    unset($cart[$id]);
}
