<?php
$categoryGetAll = $category->getAll();
$supplierGetAll = $supplier->getAllToDb();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sendEmail'])) {
    $userController->sendResetToken($_POST['email']);
    $_SESSION['email'] = $_POST['email'];
    // Đặt session để biết modal nào cần mở sau khi reload
    $_SESSION['open_modal'] = 'verifyOtpModal';
    // Redirect lại chính trang để tránh gửi lại form
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmResetBtn'])) {

    $result = $userController->verifyResetToken($_SESSION['email'], $_POST['otpCode']);
    if ($result['success']) {
        $resultPassword = $userController->resetPassword($result['user_id'], $_POST['newPassword']);
        swal_alert('success', $resultPassword['message']);
    } else {
        swal_alert('error', $result['message']);
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $res = $userController->register([
        'FullName' => $_POST['fullname'],
        'Email' => $_POST['email'],
        'Phone' => $_POST['phone'],
        'Address' => $_POST['address'],
        'password' => $_POST['password'],
        'isDeleted' => 0
    ]);
    if ($res['success']) {
        // echo "Đăng ký thành công!";
        swal_alert('success', 'Đăng ký thành công!');
    } else {
        foreach ($res['message'] as $field => $rules) {
            foreach ($rules as $rule => $msg) {
                // echo "$msg<br>";
                swal_alert('error', $msg);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $res = $userController->login($_POST['email'], $_POST['password']);
    if ($res['success']) {
        $_SESSION['jwt'] = $res['token'];
        $userData = $userController->getCurrentUser();
        // echo "{$_SESSION['jwt']}";
    } else {
        // echo "<script>
        //         alert('Tài khoản của bạn đã bị khóa đến {$res['report']['banned_until']}!');
        //         window.location.href = 'index.php';
        //     </script>";
        swal_alert(
            'error',
            'Lỗi đăng nhập',
            $res['message'] . '!',
            'index.php'
        );
        exit;
    }
}


if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['update_account'])) {
    $fullName = $_POST['FullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $data = [
        'FullName' => $fullName,
        'Email' => $email,
        'Phone' => $phone,
        'Address' => $address
    ];

    $res = $userController->updateProfile($userData->id, $data, true);

    if ($res['success']) {
        $_SESSION['jwt'] = $res['token'];
        $userData = $userController->getCurrentUser();
        // echo "<script>
        //     alert('Cập nhật tài khoản thành công!');
        //     window.location.href = 'index.php';
        // </script>";
        swal_alert('success', 'Cập nhật tài khoản thành công!', '', 'index.php');
    }
}

$totalCartItems = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (isset($item['quantity'])) {
            $totalCartItems += $item['quantity'];
        }
    }
}


// echo '<pre>';
// print_r($_SESSION['cart']);
// echo '</pre>';


$activeBanners = isset($bannerController) ? $bannerController->getByPosition('slider_main') : [];
if (empty($activeBanners) && isset($bannerController)) {
    $activeBanners = $bannerController->getAllActive();
}
?>

<!-- Top Notification & Utility Bar Strip (CellphoneS Style) -->
<div class="top-bar-cellphones d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Left: Ticker Highlights -->
        <div class="top-bar-ticker">
            <span><i class="bi bi-arrow-repeat text-warning"></i> <strong>Thu cũ giá ngon</strong> - Lên đời tiết kiệm</span>
            <span class="top-bar-ticker-separator">•</span>
            <span><i class="bi bi-shield-check text-warning"></i> Sản phẩm <strong>Chính hãng</strong> - Xuất VAT đầy đủ</span>
            <span class="top-bar-ticker-separator">•</span>
            <span><i class="bi bi-truck text-warning"></i> <strong>Giao nhanh - Miễn phí</strong> cho đơn từ 300k</span>
        </div>

        <!-- Right: Topbar Utilities -->
        <div class="top-bar-utilities">
            <a href="index.php?subpage=modules/Users/page/ShoppingGuide.php">
                <i class="bi bi-geo-alt-fill text-warning"></i> Cửa hàng gần bạn
            </a>
            <span class="divider">|</span>
            <a href="index.php?subpage=modules/Users/page/CheckOrder.php">
                <i class="bi bi-file-earmark-text text-warning"></i> Tra cứu đơn hàng
            </a>
            <span class="divider">|</span>
            <a href="tel:18006789" class="fw-bold">
                <i class="bi bi-telephone-fill text-warning"></i> 1800.6789
            </a>
        </div>
    </div>
</div>

<!-- CellphoneS Red Navbar -->
<nav class="navbar navbar-expand-lg navbar-cellphones sticky-top" style="z-index: 1031;">
    <div class="container">
        <!-- Logo -->
        <a class="brand-logo-cellphones me-3" href="index.php">
            <!-- <i class="bi bi-laptop text-warning"></i> GARENA -->
             GARENA
        </a>

        <button class="navbar-toggler text-white border-white mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center w-100 justify-content-between gap-2 gap-lg-3">
                
                <!-- Group Left: Category Dropdown + Search Bar -->
                <div class="d-flex flex-column flex-md-row align-items-md-center flex-grow-1 gap-2 gap-lg-3">
                    
                    <!-- Mega Menu Danh Mục -->
                    <div class="dropdown">
                        <a class="btn-category-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-list fs-5"></i>
                            <span>Danh mục</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-grid p-2 shadow" aria-labelledby="categoryDropdown">
                            <li>
                                <a class="dropdown-item fw-bold text-danger" href="index.php?subpage=modules/Users/Layout/Main.php">
                                    <i class="bi bi-grid-fill me-1"></i> Tất cả danh mục
                                </a>
                            </li>
                            <?php foreach ($categoryGetAll as $item) {
                                if ($item['status'] === 0) {
                                    ?>
                                    <li>
                                        <a class="dropdown-item" href="index.php?subpage=modules/Users/Layout/Main.php&category=<?= $item['id'] ?><?= isset($_GET['supplier']) ? '&supplier=' . $_GET['supplier'] : '' ?>">
                                            <i class="bi bi-tag me-1 text-danger"></i> <?= htmlspecialchars($item['name']) ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            } ?>
                        </ul>
                    </div>

                    <!-- Search Bar with Hot Keywords -->
                    <div class="search-cellphones-group flex-grow-1">
                        <form action="index.php" method="get" class="d-flex">
                            <input type="hidden" name="subpage" value="modules/Users/Layout/Main.php">
                            <input type="hidden" name="category" value="<?= htmlspecialchars($_GET['category'] ?? '') ?>">
                            <input type="hidden" name="supplier" value="<?= htmlspecialchars($_GET['supplier'] ?? '') ?>">
                            
                            <input type="search" name="search" class="form-control search-cellphones-input"
                                placeholder="Bạn cần tìm sản phẩm gì? (VD: Laptop Gaming, MacBook...)" 
                                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            <button class="btn search-cellphones-btn" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                        
                        <!-- Hot Search Keywords -->
                        <div class="hot-keywords d-none d-md-flex">
                            <a href="index.php?subpage=modules/Users/Layout/Main.php&search=Laptop+Gaming">Laptop Gaming</a>
                            <a href="index.php?subpage=modules/Users/Layout/Main.php&search=MacBook">MacBook Air</a>
                            <a href="index.php?subpage=modules/Users/Layout/Main.php&search=RTX">Card RTX</a>
                            <a href="index.php?subpage=modules/Users/Layout/Main.php&search=Tai+nghe">Tai nghe</a>
                            <a href="index.php?subpage=modules/Users/Layout/Main.php&search=Bàn+phím">Bàn phím cơ</a>
                        </div>
                    </div>

                </div>

                <!-- Group Right: Utility Action Pills -->
                <div class="d-flex align-items-center flex-wrap gap-2">
                    
                    <!-- Hotline Call -->
                    <a href="tel:18006789" class="header-action-item d-none d-xl-flex">
                        <i class="bi bi-telephone-outbound header-action-icon text-warning"></i>
                        <div class="d-flex flex-column leading-tight">
                            <span style="font-size: 10px; opacity: 0.9;">Gọi mua hàng</span>
                            <span>18001234</span>
                        </div>
                    </a>

                    <!-- Tra cứu đơn hàng -->
                    <?php if ($userData === null) { ?>
                        <a data-bs-toggle="modal" data-bs-target="#loginModal" href="#" class="header-action-item">
                            <i class="bi bi-truck header-action-icon text-warning"></i>
                            <span>Đơn hàng</span>
                        </a>
                    <?php } else { ?>
                        <a href="index.php?subpage=modules/Users/page/CheckOrder.php" class="header-action-item">
                            <i class="bi bi-truck header-action-icon text-warning"></i>
                            <span>Đơn hàng</span>
                        </a>
                    <?php } ?>

                    <!-- Giỏ hàng -->
                    <a href="index.php?subpage=modules/Users/page/Cart.php" class="header-action-item">
                        <i class="bi bi-cart3 header-action-icon text-warning"></i>
                        <span>Giỏ hàng</span>
                        <span class="cart-badge-count"><?= $totalCartItems ?></span>
                    </a>

                    <!-- Tài khoản -->
                    <?php if ($userData === null) { ?>
                        <a href="#" class="header-action-item" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="bi bi-person-circle header-action-icon text-warning"></i>
                            <span>Đăng nhập</span>
                        </a>
                    <?php } else { ?>
                        <div class="dropdown">
                            <a class="header-action-item dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle header-action-icon text-warning"></i>
                                <span><?= htmlspecialchars($userData->name) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#accountModal">
                                        <i class="bi bi-person-gear me-2 text-primary"></i> Tài khoản của tôi
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="index.php?subpage=modules/Users/page/CheckOrder.php">
                                        <i class="bi bi-box-seam me-2 text-success"></i> Quản lý đơn hàng
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item py-2 text-danger fw-bold" href="logout.php">
                                        <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>

                </div>

            </div>
        </div>
    </div>
</nav>

<?php if ($userData !== null): ?>
    <!-- Modal Tài khoản của tôi -->
    <div class="modal fade" id="accountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
                <form action="" method="post">
                    <div class="modal-header border-0 text-white position-relative p-4"
                        style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);">
                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="w-100 text-center py-2">
                            <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm mx-auto mb-2"
                                style="width: 64px; height: 64px; font-size: 30px;">
                                <i class="bi bi-person-fill-gear"></i>
                            </div>
                            <h4 class="modal-title fw-bold text-white mb-0">Tài Khoản Của Tôi</h4>
                            <small class="text-white-50">Quản lý và cập nhật thông tin cá nhân</small>
                        </div>
                    </div>
                    <div class="modal-body p-4 bg-light">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted mb-1"><i
                                        class="bi bi-person me-1 text-primary"></i>Họ và Tên</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-primary"><i
                                            class="bi bi-person-vcard"></i></span>
                                    <input type="text" class="form-control user-field border-start-0 bg-light"
                                        name="FullName" value="<?= htmlspecialchars($userData->name ?? '') ?>" disabled
                                        required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted mb-1"><i
                                        class="bi bi-envelope me-1 text-primary"></i>Email (Không thể thay đổi)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i
                                            class="bi bi-envelope-at"></i></span>
                                    <input type="email" class="form-control border-start-0 bg-light text-muted" name="email"
                                        value="<?= htmlspecialchars($userData->email ?? '') ?>" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted mb-1"><i
                                        class="bi bi-telephone me-1 text-primary"></i>Số điện thoại</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-primary"><i
                                            class="bi bi-phone"></i></span>
                                    <input type="text" class="form-control user-field border-start-0 bg-light" name="phone"
                                        value="<?= htmlspecialchars($userData->phone ?? '') ?>" disabled required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted mb-1"><i
                                        class="bi bi-geo-alt me-1 text-primary"></i>Địa chỉ giao hàng</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-primary"><i
                                            class="bi bi-house-door"></i></span>
                                    <input type="text" class="form-control user-field border-start-0 bg-light"
                                        name="address" value="<?= htmlspecialchars($userData->address ?? '') ?>" disabled
                                        required>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="button"
                                    class="btn btn-outline-primary w-100 rounded-pill py-2 fw-bold shadow-sm" id="editBtn">
                                    <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                                </button>
                                <button type="submit"
                                    class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm d-none" id="saveBtn"
                                    name="update_account">
                                    <i class="bi bi-check-circle me-1"></i> Lưu thay đổi
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Modal Đăng nhập -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <form action="" method="post">
                <div class="modal-header border-0 text-white position-relative p-4"
                    style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="w-100 text-center py-2">
                        <div class="bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm mx-auto mb-2"
                            style="width: 64px; height: 64px; font-size: 30px;">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <h4 class="modal-title fw-bold text-white mb-0">Đăng Nhập GARENA</h4>
                        <small class="text-white-50">Chào mừng bạn quay trở lại mua sắm!</small>
                    </div>
                </div>
                <div class="modal-body p-4 bg-light">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted mb-1"><i
                                    class="bi bi-envelope me-1 text-danger"></i>Địa chỉ Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-danger"><i
                                        class="bi bi-envelope-at"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 bg-light"
                                    placeholder="Nhập email của bạn" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-bold text-muted mb-1"><i
                                    class="bi bi-key me-1 text-danger"></i>Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-danger"><i
                                        class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="passwordInput"
                                    class="form-control border-start-0 border-end-0 bg-light"
                                    placeholder="Nhập mật khẩu" required>
                                <span class="input-group-text bg-light border-start-0 text-muted" id="togglePassword"
                                    style="cursor: pointer;">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mb-3">
                            <a href="#" class="small text-danger fw-bold text-decoration-none" data-bs-toggle="modal"
                                data-bs-target="#forgotPasswordModal">
                                Quên mật khẩu?
                            </a>
                        </div>
                        <button class="btn btn-danger w-100 rounded-pill py-2.5 fw-bold shadow-sm" type="submit"
                            name="login">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Đăng Nhập
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <span class="text-muted">Bạn chưa có tài khoản?</span>
                        <a href="#" class="text-danger fw-bold text-decoration-none ms-1" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#registerModal">
                            Đăng ký ngay
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Đăng ký -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 520px;">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <form action="" method="post">
                <div class="modal-header border-0 text-white position-relative p-3"
                    style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="w-100 text-center py-1">
                        <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm mx-auto mb-1"
                            style="width: 52px; height: 52px; font-size: 24px;">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <h5 class="modal-title fw-bold text-white mb-0">Tạo Tài Khoản Mới</h5>
                        <small class="text-white-50 small">Trải nghiệm mua sắm laptop chính hãng tại GARENA</small>
                    </div>
                </div>
                <div class="modal-body p-3 p-md-4 bg-light">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <div class="row g-2">
                            <div class="col-md-6 mb-2">
                                <label class="form-label small fw-bold text-muted mb-1"><i
                                        class="bi bi-person me-1 text-success"></i>Họ và Tên</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-end-0 text-success"><i
                                            class="bi bi-person-vcard"></i></span>
                                    <input type="text" name="fullname" class="form-control border-start-0 bg-light"
                                        placeholder="Nguyễn Văn A" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label small fw-bold text-muted mb-1"><i
                                        class="bi bi-telephone me-1 text-success"></i>Số điện thoại</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-end-0 text-success"><i
                                            class="bi bi-phone"></i></span>
                                    <input type="text" name="phone" class="form-control border-start-0 bg-light"
                                        placeholder="0901234567" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-bold text-muted mb-1"><i
                                    class="bi bi-envelope me-1 text-success"></i>Địa chỉ Email</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0 text-success"><i
                                        class="bi bi-envelope-at"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 bg-light"
                                    placeholder="example@gmail.com" required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-bold text-muted mb-1"><i
                                    class="bi bi-geo-alt me-1 text-success"></i>Địa chỉ giao hàng</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0 text-success"><i
                                        class="bi bi-house-door"></i></span>
                                <input type="text" name="address" class="form-control border-start-0 bg-light"
                                    placeholder="Số nhà, Tên đường, Tỉnh/Thành phố" required>
                            </div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <label class="form-label small fw-bold text-muted mb-1"><i
                                        class="bi bi-lock me-1 text-success"></i>Mật khẩu</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-end-0 text-success"><i
                                            class="bi bi-key"></i></span>
                                    <input type="password" name="password" id="registerPassword"
                                        class="form-control border-start-0 border-end-0 bg-light" placeholder="Mật khẩu"
                                        required>
                                    <span class="input-group-text bg-light border-start-0 text-muted"
                                        id="toggleRegisterPassword" style="cursor: pointer;">
                                        <i class="bi bi-eye" id="eyeRegisterPassword"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted mb-1"><i
                                        class="bi bi-shield-lock me-1 text-success"></i>Nhập lại mật khẩu</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-end-0 text-success"><i
                                            class="bi bi-shield-check"></i></span>
                                    <input type="password" name="passwordChange" id="registerPasswordConfirm"
                                        class="form-control border-start-0 border-end-0 bg-light" placeholder="Xác nhận"
                                        required>
                                    <span class="input-group-text bg-light border-start-0 text-muted"
                                        id="toggleRegisterPasswordConfirm" style="cursor: pointer;">
                                        <i class="bi bi-eye" id="eyeRegisterPasswordConfirm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-success w-100 rounded-pill py-2 fw-bold shadow-sm mt-3" type="submit"
                            name="register">
                            <i class="bi bi-person-check me-1"></i> Đăng Ký Tài Khoản
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <span class="text-muted small">Đã có tài khoản?</span>
                        <a href="#" class="text-success fw-bold text-decoration-none small ms-1" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#loginModal">
                            Đăng nhập ngay
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Quên mật khẩu -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content rounded-4 shadow">
            <form method="post">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-danger fw-bold w-100 text-center">Quên mật khẩu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0 text-center">
                    <p class="text-muted mb-4">Nhập email để nhận mã xác nhận</p>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="forgotEmail" class="form-control" placeholder="Email">
                    </div>
                    <button type="submit" class="btn btn-danger w-100" name="sendEmail">Gửi mã xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Xác nhận mã và đổi mật khẩu -->
<div class="modal fade" id="verifyOtpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content rounded-4 shadow">
            <form method="post">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-success fw-bold w-100 text-center">Xác nhận đổi mật khẩu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0 text-center">
                    <p class="text-muted mb-4">Nhập mã xác nhận và mật khẩu mới</p>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-shield-lock"></i></span>
                        <input type="text" id="otpCode" name="otpCode" class="form-control" placeholder="Mã xác nhận">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="password" id="newPassword" name="newPassword" class="form-control"
                            placeholder="Mật khẩu mới">
                        <span class="input-group-text bg-white" id="toggleNewPassword" style="cursor: pointer;">
                            <i class="bi bi-eye" id="eyeNewPassword"></i>
                        </span>
                    </div>
                    <button class="btn btn-success w-100" id="confirmResetBtn" name="confirmResetBtn">Xác nhận đổi mật
                        khẩu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['open_modal'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const myModal = new bootstrap.Modal(document.getElementById('<?php echo $_SESSION['open_modal']; ?>'));
            myModal.show();
        });
    </script>
    <?php unset($_SESSION['open_modal']);
endif; ?>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const editBtn = document.getElementById("editBtn");
        const saveBtn = document.getElementById("saveBtn");
        const fields = document.querySelectorAll(".user-field");

        editBtn?.addEventListener("click", function () {
            fields.forEach(field => {
                field.disabled = false;
                field.classList.remove("bg-light");
                field.classList.add("bg-white");
            });
            saveBtn.classList.remove("d-none");
            editBtn.classList.add("d-none");
        });

        // Đăng nhập
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword?.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });

        // Đăng ký - Mật khẩu
        const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
        const registerPassword = document.getElementById('registerPassword');
        const eyeRegisterPassword = document.getElementById('eyeRegisterPassword');

        toggleRegisterPassword?.addEventListener('click', function () {
            const type = registerPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            registerPassword.setAttribute('type', type);
            eyeRegisterPassword.classList.toggle('bi-eye');
            eyeRegisterPassword.classList.toggle('bi-eye-slash');
        });

        // Đăng ký - Nhập lại mật khẩu
        const toggleRegisterPasswordConfirm = document.getElementById('toggleRegisterPasswordConfirm');
        const registerPasswordConfirm = document.getElementById('registerPasswordConfirm');
        const eyeRegisterPasswordConfirm = document.getElementById('eyeRegisterPasswordConfirm');

        toggleRegisterPasswordConfirm?.addEventListener('click', function () {
            const type = registerPasswordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            registerPasswordConfirm.setAttribute('type', type);
            eyeRegisterPasswordConfirm.classList.toggle('bi-eye');
            eyeRegisterPasswordConfirm.classList.toggle('bi-eye-slash');
        });

        // Modal đổi mật khẩu - Mật khẩu mới
        const toggleNewPassword = document.getElementById('toggleNewPassword');
        const newPassword = document.getElementById('newPassword');
        const eyeNewPassword = document.getElementById('eyeNewPassword');

        toggleNewPassword?.addEventListener('click', function () {
            const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            newPassword.setAttribute('type', type);
            eyeNewPassword.classList.toggle('bi-eye');
            eyeNewPassword.classList.toggle('bi-eye-slash');
        });
    });
</script>