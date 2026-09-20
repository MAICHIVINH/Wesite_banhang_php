# Design Specification: Smart Dynamic Online Payment (MoMo, ShopeePay, VietQR)

- **Date**: 2026-09-21
- **Project**: DevPHP_V2 (GARENA E-Commerce)
- **Feature**: Online Payment Integration for MoMo, ShopeePay, ZaloPay & Banking Apps

---

## 1. Overview & Objectives

Provide a seamless, high-converting online payment experience for GARENA customers using dynamic QR technology (VietQR / Napas247 / MoMo / ShopeePay).

### Key Features:
1. **Cart Checkout Integration (`modules/Users/page/Cart.php`)**:
   - Add radio option for **"Thanh toán Online (MoMo, ShopeePay, ZaloPay, VietQR)"** with branded icons.
   - Validate items and branch selection before proceeding.
2. **Online Checkout Handler (`modules/Users/logic/checkout_online.php`)**:
   - Create payment entry (`method = 'Thanh toán Online (MoMo/ShopeePay/VietQR)'`, `status = 'Chờ thanh toán'`).
   - Create order and order items linked to user & selected branch inventory.
   - Clear purchased items from `$_SESSION['cart']`.
   - Redirect to `OnlinePayment.php`.
3. **Dynamic QR Payment Page (`modules/Users/page/OnlinePayment.php`)**:
   - Styled with GARENA Cyber Indigo theme.
   - Dynamic VietQR API generation (`https://img.vietqr.io/image/970422-0388686789-compact2.png?amount=XXX&addInfo=GARXXXX`).
   - Supported E-Wallet badges: MoMo, ShopeePay, ZaloPay, VietQR.
   - 1-Click Copy buttons for Transfer Amount and Transfer Syntax (`GAR<order_id>`).
   - Live payment countdown timer (15 minutes).
   - "Tôi đã thanh toán" action button + Order lookup redirect (`CheckOrder.php`).

---

## 2. Component & File Changes

| File | Type | Description |
|---|---|---|
| `modules/Users/page/Cart.php` | Modify | Update payment method radio selection & form handler for `online` method |
| `modules/Users/logic/checkout_online.php` | Create | Handle order & payment insertion for online orders |
| `modules/Users/page/OnlinePayment.php` | Create | Render dynamic QR payment page with MoMo, ShopeePay, ZaloPay & VietQR support |
| `Style/Users/Cart.css` | Modify | Add styles for payment option pills, QR modal, and copy buttons |

---

## 3. Data Flow

```
[Cart.php] 
  ──(Select Online Payment & Submit)──> 
[checkout_online.php]
  ──(Insert Order & Payment DB records)──> 
[OnlinePayment.php]
  ──(Display Dynamic QR & E-Wallet Icons)──> 
[Customer Scans via MoMo / ShopeePay / Bank App]
  ──(Clicks "Tôi đã thanh toán")──> 
[CheckOrder.php]
```

---

## 4. Verification Plan

1. Select items in cart, select branch, select "Thanh toán Online (MoMo, ShopeePay...)".
2. Submit checkout form and verify redirection to `OnlinePayment.php`.
3. Confirm QR image renders with correct amount and transfer syntax (`GAR<order_id>`).
4. Test 1-click copy buttons.
5. Click "Tôi đã thanh toán" and verify order appears in `CheckOrder.php`.
