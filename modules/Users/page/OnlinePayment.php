<?php
$orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

if ($orderId <= 0) {
    swal_alert('error', 'Lỗi truy cập', 'Không tìm thấy thông tin đơn hàng thanh toán.', 'index.php');
    exit;
}

$orderData = $orderController->getById($orderId);

if (!$orderData) {
    swal_alert('error', 'Lỗi truy cập', 'Đơn hàng không tồn tại hoặc đã bị xóa.', 'index.php');
    exit;
}

$orderItems = $orderItemController->getOrderItemById($orderId);
$totalAmount = (float)($orderData['total_amount'] ?? $orderData['total_price'] ?? 0);
$transferNote = "GAR" . $orderId;
$bankAccountNo = "0388686789";
$bankName = "MBBank (Ngân hàng Quân Đội)";
$accountHolder = "GARENA E-SPORTS STORE";

// Dynamic VietQR API URL supporting MoMo, ShopeePay, ZaloPay & 40+ Bank Apps
$qrUrl = "https://img.vietqr.io/image/MB-{$bankAccountNo}-compact2.jpg?amount={$totalAmount}&addInfo={$transferNote}&accountName=" . urlencode($accountHolder);
?>

<style>
    .online-pay-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(79, 70, 229, 0.08);
        overflow: hidden;
    }

    .online-pay-header {
        background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
        color: #ffffff;
        padding: 24px;
        text-align: center;
    }

    .qr-box-wrapper {
        background: #ffffff;
        border: 2px dashed #4f46e5;
        border-radius: 16px;
        padding: 20px;
        display: inline-block;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    }

    .ewallet-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .ewallet-momo {
        background: #fff0f6;
        color: #a50064;
        border-color: #fcc2d7;
    }

    .ewallet-shopeepay {
        background: #fff4e6;
        color: #ee4d2d;
        border-color: #ffd8a8;
    }

    .ewallet-zalopay {
        background: #e6fcf5;
        color: #0068ff;
        border-color: #96f2d7;
    }

    .ewallet-vietqr {
        background: #eef2ff;
        color: #4f46e5;
        border-color: #c7d2fe;
    }

    .copy-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>

<div class="container my-5">
    <!-- 4-Step Checkout Wizard Bar -->
    <div class="checkout-wizard-bar d-none d-md-flex mb-4">
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
        <div class="wizard-step active">
            <div class="wizard-step-number">3</div>
            <span>Thanh toán Online</span>
        </div>
        <i class="bi bi-chevron-right text-muted"></i>
        <div class="wizard-step">
            <div class="wizard-step-number">4</div>
            <span>Hoàn tất đơn hàng</span>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="online-pay-card">
                <!-- Header -->
                <div class="online-pay-header">
                    <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                        <i class="bi bi-qr-code-scan fs-3 text-warning"></i>
                        <h4 class="fw-bold mb-0 text-white">THANH TOÁN ONLINE THÔNG MINH</h4>
                    </div>
                    <p class="mb-0 opacity-90 small">Quét mã bằng Ví MoMo, ShopeePay, ZaloPay hoặc bất kỳ App Ngân hàng nào</p>
                </div>

                <div class="p-4">
                    <!-- Supported Wallets & Apps -->
                    <div class="text-center mb-4">
                        <span class="text-muted small fw-semibold d-block mb-2">HỖ TRỢ THANH TOÁN QUA:</span>
                        <div class="d-flex justify-content-center flex-wrap gap-2">
                            <span class="ewallet-pill ewallet-momo">
                                <i class="bi bi-wallet2"></i> Ví MoMo
                            </span>
                            <span class="ewallet-pill ewallet-shopeepay">
                                <i class="bi bi-bag-check-fill"></i> ShopeePay
                            </span>
                            <span class="ewallet-pill ewallet-zalopay">
                                <i class="bi bi-lightning-charge-fill"></i> ZaloPay
                            </span>
                            <span class="ewallet-pill ewallet-vietqr">
                                <i class="bi bi-qr-code"></i> VietQR / 40+ Ngân Hàng
                            </span>
                        </div>
                    </div>

                    <div class="row align-items-center g-4">
                        <!-- Left: Dynamic QR Code -->
                        <div class="col-md-6 text-center">
                            <div class="qr-box-wrapper">
                                <img src="<?= $qrUrl ?>" alt="Mã QR Thanh Toán" class="img-fluid rounded" style="max-width: 240px; height: auto;">
                            </div>
                            <div class="mt-2 text-muted small">
                                <i class="bi bi-info-circle me-1 text-primary"></i> Tự động điền số tiền & cú pháp
                            </div>
                        </div>

                        <!-- Right: Payment Details & Copy Controls -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="small text-muted fw-bold d-block mb-1">TỔNG TIỀN THANH TOÁN:</label>
                                <div class="copy-box">
                                    <span class="fw-bold text-danger fs-5"><?= number_format($totalAmount, 0, ',', '.') ?>₫</span>
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="copyToClipboard('<?= $totalAmount ?>', 'Số tiền')">
                                        <i class="bi bi-clipboard me-1"></i> Sao chép
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="small text-muted fw-bold d-block mb-1">NỘI DUNG CHUYỂN TIỀN (CÚ PHÁP):</label>
                                <div class="copy-box border-primary">
                                    <span class="fw-bold text-primary fs-5"><?= $transferNote ?></span>
                                    <button class="btn btn-sm btn-primary rounded-pill px-3" onclick="copyToClipboard('<?= $transferNote ?>', 'Cú pháp chuyển tiền')">
                                        <i class="bi bi-clipboard me-1"></i> Sao chép
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="small text-muted fw-bold d-block mb-1">TÊN CHỦ TÀI KHOẢN:</label>
                                <div class="small fw-bold text-dark px-2"><?= $accountHolder ?></div>
                                <div class="small text-muted px-2"><?= $bankName ?> - STK: <?= $bankAccountNo ?></div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Actions -->
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                        <a href="index.php?subpage=modules/Users/page/Cart.php" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-arrow-left me-1"></i> Quay lại giỏ hàng
                        </a>
                        <a href="index.php?subpage=modules/Users/page/CheckOrder.php" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm">
                            <i class="bi bi-check-circle-fill me-1"></i> Tôi đã hoàn tất thanh toán
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text, label) {
        navigator.clipboard.writeText(text).then(function() {
            Swal.fire({
                icon: 'success',
                title: 'Đã sao chép!',
                text: label + ' đã được lưu vào khay nhớ tạm.',
                timer: 1500,
                showConfirmButton: false
            });
        }, function(err) {
            alert('Đã sao chép: ' + text);
        });
    }
</script>
