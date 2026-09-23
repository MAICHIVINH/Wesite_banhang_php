<?php
$cart = $_SESSION['cart'] ?? [];

//logic thêm giỏ hàng nằm ở đây
require './modules/Users/logic/add_cart.php';

// require_once __DIR__ . '/../Notification/alertHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    //Xoá đã chọn 
    if ($action === 'delete_selected' && !empty($_POST['selected'])) {
        foreach ($_POST['selected'] as $id) {
            unset($cart[$id]);
        }
    }

    //đặt hàng 
    if ($action === 'checkout') {
        if (empty($_POST['selected'])) {
            swal_alert('warning', 'Chưa chọn sản phẩm', 'Vui lòng tích chọn ít nhất 1 sản phẩm để thanh toán.', 'index.php?subpage=modules/Users/page/Cart.php');
            exit;
        }

        $branch = $_POST['branch_id'];
        $method = $_POST['payment_method'] ?? 'cod';

        // Kiểm tra chi nhánh đã chọn chưa
        if (empty($branch)) {
            swal_alert('warning', 'Chưa chọn chi nhánh', 'Vui lòng chọn chi nhánh nhận hàng để tiếp tục.', 'index.php?subpage=modules/Users/page/Cart.php');
            exit;
        }

        $_SESSION['branch_select'] = $branch; // Lưu lại chi nhánh đã chọn


        //Xử lý thanh toán khi nhận hàng
        if ($method === 'cod') {
            $totalAmount = 0;
            $dataPayment = [
                "method" => 'Thanh toán khi nhận hàng',
                "status" => 'Chưa thanh toán',
                "paid_at" => date("Y-m-d H:i:s")
            ];
            $paymentId = $paymentController->add($dataPayment);

            // logic xử lý đơn hàng thanh toán
            require './modules/Users/logic/checkout.php';

            $_SESSION['cart'] = $cart;
            // echo "<script>
            //                 alert('Mua hàng thành công!');
            //                 window.location.href = 'index.php';
            //             </script>";
            swal_alert('success', 'Mua hàng thành công!', '', 'index.php');
            exit;
        } else {
            require './modules/Users/logic/checkout_online.php';
            exit;
        }
    }


    //Tăng / giảm / xoá từng sản phẩm
    if (preg_match('/^(inc|dec|remove)_(\d+)$/', $action, $m)) {
        [$all, $cmd, $id] = $m;
        if (isset($cart[$id])) {
            switch ($cmd) {
                case 'inc':
                    $branch = $_POST['branch_id'];
                    if (empty($branch)) {
                        swal_alert('warning', 'Chọn cửa hàng', 'Bạn cần chọn cửa hàng để tôi kiểm tra kho hàng cho bạn!');
                        break;
                    } else {
                        $productInventory = $inventoryController->getProductInventory($id, $branch, true);
                        $stockQuantity = (!empty($productInventory) && isset($productInventory['stock_quantity'])) ? (int)$productInventory['stock_quantity'] : 0;
                        if (!isset($_SESSION['branch_select'])) {
                            $_SESSION['branch_select'] = $branch;
                        }
                        if ($cart[$id]['quantity'] >= $stockQuantity) {
                            swal_alert('warning', 'Không đủ hàng', 'Cửa hàng hiện tại không đủ số lượng bạn mua!');
                            break;
                        }
                        $cart[$id]['quantity']++;
                        break;
                    }
                case 'dec':
                    if ($cart[$id]['quantity'] > 1)
                        $cart[$id]['quantity']--;
                    break;
                case 'remove':
                    unset($cart[$id]);
                    break;
            }
        }
    }
    echo '<meta http-equiv="refresh" content="0">';
}

$_SESSION['cart'] = $cart;

$branchList = $branchController->getAll();

$total = 0;
?>
<form method="post" action="">
    <div class="container my-4 cart-container">
        
        <!-- 4-Step Checkout Wizard Bar -->
        <div class="checkout-wizard-bar d-none d-md-flex">
            <div class="wizard-step active">
                <div class="wizard-step-number">1</div>
                <span>Giỏ hàng</span>
            </div>
            <i class="bi bi-chevron-right text-muted"></i>
            <div class="wizard-step active">
                <div class="wizard-step-number">2</div>
                <span>Thông tin giao hàng</span>
            </div>
            <i class="bi bi-chevron-right text-muted"></i>
            <div class="wizard-step">
                <div class="wizard-step-number">3</div>
                <span>Thanh toán QR PayOS</span>
            </div>
            <i class="bi bi-chevron-right text-muted"></i>
            <div class="wizard-step">
                <div class="wizard-step-number">4</div>
                <span>Hoàn tất đơn hàng</span>
            </div>
        </div>

        <div class="cart-layout">
            <div class="cart-left">
                <?php if (empty($cart)) { ?>
                    <div class="text-center">
                        <img src="Style/Images/emptyCart.png" alt="Giỏ hàng trống" style="max-width: 700px; width: 100%;">
                        <p class="mt-3 fw-bold fs-4">Chưa có sản phẩm nào trong giỏ hàng</p>
                        <p class="text-muted">Hãy thêm sản phẩm để bắt đầu mua sắm!</p>
                    </div>
                <?php } else { ?>
                    <!-- Nút xoá selected -->
                    <div class="cart-header d-flex justify-content-between">
                        <div>
                            <input type="checkbox" id="checkAll"> <label for="checkAll">Chọn tất cả</label>
                        </div>
                        <button type="submit" name="action" value="delete_selected"
                            class="btn btn-outline-none text-danger">
                            <i class="bi bi-trash"></i> Xoá đã chọn
                        </button>
                    </div>

                    <?php
                    $total = 0;
                    foreach ($cart as $item) {
                        $price = (float) preg_replace('/[^\d.]/', '', $item['price']); // 1.200.000₫ -> 1200000
                
                        // 2. Ép kiểu số nguyên cho quantity
                        $qty = (int) $item['quantity'];

                        // 3. Tính tiền dòng
                        $itemTotal = $price * $qty;
                        $total += $itemTotal;
                        ?>
                        <div class="cart-item">
                            <input type="checkbox" name="selected[]" value="<?= $item['id'] ?>" class="item-checkbox me-2">

                            <img src="<?= $item['image'] ?>" alt="">
                            <div class="product-info">
                                <h6><?= $item['name'] ?></h6>
                                <p><?= number_format($item['price'], 0, ',', '.') ?>₫</p>
                            </div>

                            <!-- tăng / giảm / xoá 1 sản phẩm -->
                            <div class="quantity-control">
                                <button name="action" value="dec_<?= $item['id'] ?>"
                                    class="btn btn-outline-secondary btn-sm">-</button>
                                <span class="mx-1"><?= $item['quantity'] ?></span>
                                <button name="action" value="inc_<?= $item['id'] ?>"
                                    class="btn btn-outline-secondary btn-sm">+</button>
                            </div>

                            <button name="action" value="remove_<?= $item['id'] ?>" class="btn btn-link remove-btn">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="cart-right">
                <input type="hidden" name="totalAmount" value="<?= $total ?>">
                <h5 class="text-primary">Tổng tiền: <?= number_format($total, 0, ',', '.') ?>₫</h5>
                <hr>
                <div class="mb-3">
                    <label for="branch_id" class="fw-bold">Chọn chi nhánh nhận hàng:</label>
                    <select name="branch_id" id="branch_id" class="form-select">
                        <option value="">-- Chọn chi nhánh --</option>
                        <?php foreach ($branchList as $b): ?>
                            <option value="<?= $b['id'] ?>" <?= (isset($_SESSION['branch_select']) && $_SESSION['branch_select'] == $b['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($b['name']) ?> - <?= htmlspecialchars($b['address']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="branch-error" class="text-danger small mt-1" style="display: none;"></div>

                </div>

                <div class="mb-3">
                    <p class="fw-bold mb-2">Phương thức thanh toán:</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                        <label class="form-check-label" for="cod">
                            Thanh toán khi nhận hàng (COD)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="online" value="online">
                        <label class="form-check-label fw-semibold" for="online">
                            <span class="text-primary"><i class="bi bi-qr-code-scan me-1"></i> Thanh toán Online</span>
                            <span class="d-block small text-muted">Ví MoMo, ShopeePay, ZaloPay, VietQR (Napas247)</span>
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <p class="fw-bold">Ghi chú đơn hàng:</p>
                    <textarea name="note" id="note" placeholder="Ghi chú thêm nếu cần..."></textarea>
                </div>
                <p class="text-danger small mb-2">
                    Lưu ý: Bạn cần phải chọn những sản phẩm muốn thanh toán
                </p>
                <?php if ($userData === null) { ?>
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Đăng nhập để mua hàng
                    </button>
                <?php } else { ?>
                    <button type="submit" name="action" value="checkout" class="btn btn-primary w-100">
                        Mua hàng
                    </button>
                <?php } ?>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('checkAll').addEventListener('change', function () {
        document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
    });

    document.querySelector('form').addEventListener('submit', function (e) {
        const branchSelect = document.getElementById('branch_id');
        const branchError = document.getElementById('branch-error');
        const selectedBranch = branchSelect.value.trim();

        if (!selectedBranch) {
            e.preventDefault(); // chặn form submit
            branchError.textContent = 'Vui lòng chọn chi nhánh nhận hàng';
            branchError.style.display = 'block';
            branchSelect.classList.add('is-invalid');
            branchSelect.focus();
        } else {
            branchError.textContent = '';
            branchError.style.display = 'none';
            branchSelect.classList.remove('is-invalid');
        }
    });
</script>