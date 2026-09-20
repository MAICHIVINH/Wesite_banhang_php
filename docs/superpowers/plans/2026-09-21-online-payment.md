# Smart Online Payment (MoMo, ShopeePay, VietQR) Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Implement online payment flow for MoMo, ShopeePay, ZaloPay, and 40+ Bank Apps using dynamic QR code generation (`OnlinePayment.php`) integrated into Cart checkout.

**Architecture:** Update `Cart.php` checkout handler to call `checkout_online.php`, which creates the order, clears session cart items, and redirects to `OnlinePayment.php` where dynamic VietQR image and e-wallet scanning badges are displayed.

**Tech Stack:** PHP, HTML5, CSS3, JavaScript (Clipboard API), Bootstrap 5.

## Global Constraints
- Support MoMo, ShopeePay, ZaloPay & VietQR scanning.
- Styled using GARENA Cyber Indigo theme (`#4F46E5`).

---

### Task 1: Create Online Checkout Handler (`checkout_online.php`)

**Files:**
- Create: `modules/Users/logic/checkout_online.php`
- Modify: `modules/Users/page/Cart.php:53-85`

- [ ] **Step 1: Write `modules/Users/logic/checkout_online.php`**

```php
<?php
// Handles order creation for online payment method
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
$dataShipping = [
    "user_id" => $userData->id,
    "address" => $_POST['address'] ?? ($userData->Address ?? 'Nhận tại cửa hàng'),
    "phone" => $_POST['phone'] ?? ($userData->Phone ?? '0123456789'),
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
$orderId = is_array($orderRes) ? ($orderRes['id'] ?? $orderRes['order_id'] ?? null) : $orderRes;

if ($orderId) {
    foreach ($itemsToBuy as $item) {
        $dataOrderItem = [
            "order_id" => $orderId,
            "product_id" => $item['product_id'],
            "quantity" => $item['quantity'],
            "price" => $item['price']
        ];
        $orderItemController->add($dataOrderItem);
        
        // Deduct inventory
        $inventoryController->decrementStock($item['product_id'], $_POST['branch_id'], $item['quantity']);
        
        // Remove item from session cart
        unset($_SESSION['cart'][$item['product_id']]);
    }
    
    // Redirect to Online Payment page
    header("Location: index.php?subpage=modules/Users/page/OnlinePayment.php&order_id=" . $orderId);
    exit;
} else {
    swal_alert('error', 'Lỗi tạo đơn hàng', 'Không thể tạo đơn hàng thanh toán online.', 'index.php?subpage=modules/Users/page/Cart.php');
    exit;
}
```

- [ ] **Step 2: Update Cart.php to include `checkout_online.php`**

In `modules/Users/page/Cart.php`, replace line 53-85 logic:
```php
        if ($method === 'cod') {
            $totalAmount = 0;
            $dataPayment = [
                "method" => 'Thanh toán khi nhận hàng',
                "status" => 'Chưa thanh toán',
                "paid_at" => date("Y-m-d H:i:s")
            ];
            $paymentId = $paymentController->add($dataPayment);
            require './modules/Users/logic/checkout.php';
            $_SESSION['cart'] = $cart;
            swal_alert('success', 'Mua hàng thành công!', '', 'index.php');
            exit;
        } else {
            require './modules/Users/logic/checkout_online.php';
            exit;
        }
```

- [ ] **Step 3: Lint PHP code**

Run: `php -l modules/Users/page/Cart.php; php -l modules/Users/logic/checkout_online.php`
Expected: PASS

- [ ] **Step 4: Commit**

```bash
git add modules/Users/logic/checkout_online.php modules/Users/page/Cart.php
git commit -m "feat(checkout): add online payment order creation logic"
```

---

### Task 2: Build Dynamic QR & E-Wallet Payment Page (`OnlinePayment.php`)

**Files:**
- Create: `modules/Users/page/OnlinePayment.php`
- Modify: `Style/Users/Cart.css`

- [ ] **Step 1: Write `modules/Users/page/OnlinePayment.php`**

Render payment page showing:
1. GARENA Cyber Indigo Header & Order Summary (`Mã đơn hàng #GAR<id>`, Total Price).
2. Dynamic VietQR code generated via VietQR API (`https://img.vietqr.io/image/MB-0388686789-compact2.jpg?amount=...&addInfo=...`).
3. E-Wallet scanning icons (MoMo, ShopeePay, ZaloPay, MBBank).
4. Copy-to-clipboard fields for Transfer Amount and Transfer Note.
5. Live countdown timer and "Tôi đã hoàn tất thanh toán" button linking to `CheckOrder.php`.

- [ ] **Step 2: Lint PHP code**

Run: `php -l modules/Users/page/OnlinePayment.php`
Expected: PASS

- [ ] **Step 3: Commit**

```bash
git add modules/Users/page/OnlinePayment.php Style/Users/Cart.css
git commit -m "feat(payment): build dynamic QR and E-Wallet online payment page"
```
