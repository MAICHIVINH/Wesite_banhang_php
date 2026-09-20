<div class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="card shadow-lg border-0 p-4 text-center" style="max-width: 600px; width: 100%;">
        <img src="https://cdn-icons-png.flaticon.com/512/1828/1828490.png" alt="Unauthorized" style="width: 100px;" class="mb-3 mx-auto">
        <h2 class="text-danger fw-bold">Bạn cần phải đăng nhập</h2>
        <p class="text-muted">
            Trang bạn đang cố truy cập yêu cầu phải đăng nhập.<br>Vui lòng đăng nhập hoặc quay lại trang chính.
        </p>

        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
            <a href="Auth/Login.php" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right" style="margin-right: 5px;"></i> Đăng nhập ngay
            </a>
            <a href="index.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle" style="margin-right: 5px;"></i> Quay lại trang chủ
            </a>
        </div>

        <div class="mt-4 text-center fw-bold text-muted small border-top pt-2">
            &copy; <?= date("Y") ?> Mai Chí Vĩnh. All rights reserved.
        </div>
    </div>
</div>