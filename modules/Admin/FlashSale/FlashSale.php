<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_flash_sale'])) {
    $title = trim($_POST['title'] ?? 'HOT SALE GIÁ SỐC');
    $endTime = $_POST['end_time'] ?? date('Y-m-d H:i:s', strtotime('+3 days'));
    $status = isset($_POST['status']) ? 1 : 0;

    $flashSaleController->updateConfig($title, $endTime, $status);

    if (function_exists('swal_alert')) {
        swal_alert('Thành công', 'Cập nhật Flash Sale vào Cơ sở dữ liệu thành công!', 'success', 'Admin.php?page=flash_sale');
    } else {
        echo "<script>alert('Cập nhật Flash Sale thành công!'); window.location.href='Admin.php?page=flash_sale';</script>";
    }
    exit;
}

$flashConfig = $flashSaleController->getConfig();
$displayEndTime = !empty($flashConfig['end_time']) ? date('Y-m-d\TH:i', strtotime($flashConfig['end_time'])) : date('Y-m-d\TH:i', strtotime('+3 days'));
?>

<div class="container-fluid p-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-danger text-white d-flex align-items-center gap-2 py-3">
            <i class="bi bi-lightning-fill fs-4"></i>
            <h5 class="mb-0 fw-bold">QUẢN LÝ THỜI GIAN & TIÊU ĐỀ FLASH SALE</h5>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="">
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Tiêu đề chương trình Hot Sale:</label>
                    <input type="text" name="title" class="form-control form-control-lg fs-6" value="<?= htmlspecialchars($flashConfig['title']) ?>" placeholder="Nhập tiêu đề chương trình..." required>
                    <div class="form-text text-muted">
                        <i class="bi bi-info-circle me-1"></i> Tiêu đề này sẽ hiển thị trực tiếp ở trang chủ bên cạnh biểu tượng sấm sét.
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Thời gian kết thúc (Real-time Countdown):</label>
                    <input type="datetime-local" name="end_time" class="form-control form-control-lg fs-6" value="<?= htmlspecialchars($displayEndTime) ?>" required>
                    <div class="form-text text-muted">
                        <i class="bi bi-clock-history me-1"></i> Đồng hồ đếm ngược ở trang chủ sẽ nhảy tự động theo từng giây đến đúng mốc thời gian này.
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark d-block">Trạng thái chương trình:</label>
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="flashStatus" <?= $flashConfig['status'] == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label fs-6 fw-semibold" for="flashStatus">
                            Hiển thị Đồng hồ đếm ngược & Tiêu đề Flash Sale trên Trang chủ
                        </label>
                    </div>
                </div>

                <hr class="my-4">

                <button type="submit" name="save_flash_sale" class="btn btn-danger btn-lg px-4 fs-6 fw-bold shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> Lưu cài đặt Flash Sale
                </button>
            </form>
        </div>
    </div>
</div>
