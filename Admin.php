<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_name('admin_session');
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once './controllers/ProductController.php';
require_once './controllers/SupplierController.php';
require_once './controllers/CategoryController.php';
require_once './controllers/ImageController.php';
require_once './controllers/InventoryController.php';
require_once './controllers/OrderController.php';
require_once './controllers/OrderItemController.php';
require_once './controllers/UserController.php';
require_once './controllers/StatusController.php';
require_once './controllers/ChatController.php';
require_once './controllers/ReportController.php';
require_once './controllers/ReportController.php';
require_once './controllers/UserReportController.php';
require_once './controllers/MenuController.php';
require_once './controllers/RoleController.php';
require_once './controllers/EmployeeController.php';
require_once './controllers/BranchController.php';
require_once './controllers/ShippingController.php';
require_once './controllers/AdminController.php';
require_once './controllers/BannerController.php';




require 'vendor/autoload.php';

$product = new ProductController();
$supplier = new SupplierController();
$category = new CategoryController();
$imageController = new ImageController();
$inventoryController = new InventoryController();
$orderController = new OrderController();
$orderItemController = new OrderItemController();
$userController = new UserController();
$statusController = new StatusController();
$chatController = new ChatController();
$reportController = new ReportController();
$userReportController = new UserReportController();
$menuController = new MenuController();
$roleController = new RoleController();
$employeeController = new EmployeeController();
$branchController = new BranchController();
$shippingController = new ShippingController();
$adminController = new AdminController();
$bannerController = new BannerController();

$userList = $chatController->getAllChatUserIdsFromRedis();
$userId = $_GET['chat_user_id'] ?? null;
$showChatList = isset($_GET['show_chat_list']);
$employeeData = $employeeController->getCurrentEmployee() ?? null;


$_SESSION['user_type'] = $_SESSION['user_type'] ?? null;
$_SESSION['admin'] = $_SESSION['admin'] ?? null;

if (isset($_GET['export_excel'])) {
    $this->exportProductsExcel();
    exit;
}

if (isset($_GET['ajax_get_admin_chat']) || isset($_POST['ajax_send_admin_chat'])) {
    require_once './modules/Admin/Chat/AdminChat.php';
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>BVCrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./Style/Admin/style.css">
    <link rel="stylesheet" href="./Style/Admin/Navbar.css">
    <link rel="stylesheet" href="./Style/Admin/Inventory.css">
    <link rel="stylesheet" href="./Style/Admin/Chat.css">
    <link rel="stylesheet" href="./Style/Admin/Product.css">
    <link rel="stylesheet" href="./Style/Admin/AddProduct.css">
    <link rel="stylesheet" href="./Style/Admin/Customer.css">
    <link rel="stylesheet" href="./Style/Admin/notification.css">

</head>

<body>

    <script>
        function Loading(status) {
            if (status) {
                if (!document.getElementById('loadingOverlay')) {
                    const overlay = document.createElement('div');
                    overlay.id = 'loadingOverlay';
                    overlay.style.position = 'fixed';
                    overlay.style.top = 0;
                    overlay.style.left = 0;
                    overlay.style.right = 0;
                    overlay.style.bottom = 0;
                    overlay.style.backgroundColor = 'rgba(0,0,0,0.5)';
                    overlay.style.display = 'flex';
                    overlay.style.flexDirection = 'column';
                    overlay.style.justifyContent = 'center';
                    overlay.style.alignItems = 'center';
                    overlay.style.zIndex = 9999;
                    overlay.innerHTML = `
                    <div class="spinner-border text-light" role="status"></div>
                    <p style="color:white; margin-top: 10px;">Đang xử lý, vui lòng chờ...</p>
                `;
                    document.body.appendChild(overlay);
                }
            } else {
                const overlay = document.getElementById('loadingOverlay');
                if (overlay) overlay.remove();
            }
        }

        document.addEventListener('show.bs.modal', function(e) {
            if (e.target && e.target.parentElement !== document.body) {
                document.body.appendChild(e.target);
            }
        });
    </script>


    <?php
    // $chatController->sendMessage(13, 'admin', 'Bạn cần laptop gaming hay học tập?');
    // $history = $chatController->getChatHistory(13);
    // foreach ($history as $entry) {
    //     echo "[{$entry->time}] {$entry->from}: {$entry->message} <br>";
    // }
    require_once './Auth/LoginLogic.php';
    if ($_SESSION['user_type'] !== null) {
        require './modules/Admin/Navbar/Navbar.php';
    ?>
        <!-- Navbar nên đặt ngoài admin-container -->

        <div class="admin-container">
            <?php require './modules/Admin/Sidebar/Sidebar.php'; ?>
            <div class="content">
                <?php
                if (isset($_GET['page']) && file_exists($_GET['page'])) {
                    require $_GET['page'];
                } else {
                    require './modules/Admin/Dashboard/index.php';
                }
                ?>
            </div>
        </div>
    <?php
    } else {
        // echo "<h1>Bạn cần phải đăng nhập</h1>";
        require './Auth/LoginRequired.php';
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/vdvrq3yfn1mvkxu8e58u6aomn76eh0uqy054jbiq8djjjeqz/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="./Style/Script/Admin/Sidebar.js"></script>
    <script src="./Style/Script/Admin/Inventory.js"></script>
    <script src="./Style/Script/Admin/Customer.js"></script>

    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });

        function toggleDropdown(id, event) {
            event.preventDefault(); // ❗ Chặn hành vi mặc định của thẻ <a>
            const el = document.getElementById(id);
            el.classList.toggle('show');
        }
    </script>
    <!-- Chat -->
    <div id="chat-toggle">
        <i class="bi bi-chat-dots-fill fs-3"></i>
    </div>
    <?php
    require_once './modules/Admin/Chat/AdminChat.php';
    ?>
    <script src="./Style/Script/User/Chat.js"></script>
    <script src="./Style/Script/Admin/Customer.js"></script>
    <script src="./Style/Script/User/Detail.js"></script>
    <script src="./Style/Script/Admin/AddInventory.js"></script>
    <script src="./Style/Script/Admin/DeleteProduct.js"></script>
    <script src="./Style/Script/Admin/AddProduct.js"></script>
    <script src="./Style/Script/Admin/UpdateProduct.js"></script>
    <script src="./Style/Script/Admin/Order.js"></script>
    <script src="./Style/Script/Admin/DeleteCategory.js"></script>
    <script src="./Style/Script/Admin/Supplier.js"></script>
    <script src="./Style/Script/Admin/Profile.js"></script>
    <script src="./Style/Script/Admin/Menu.js"></script>
    <script src="./Style/Script/Admin/Role.js"></script>
    <script src="./Style/Script/Admin/Employee.js"></script>
    <script src="./Style/Script/Admin/Shipping.js"></script>
    <script src="./Style/Script/Admin/Branch.js"></script>
    <script src="./Style/Script/Admin/Category.js"></script>
    <script src="./Style/Script/Admin/Inventory.js"></script>



    <script>
        <?php if (isset($_SESSION['success'])): ?>
            toastr.success("<?= $_SESSION['success'] ?>");
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            toastr.error("<?= $_SESSION['error'] ?>");
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </script>

</body>

</html>