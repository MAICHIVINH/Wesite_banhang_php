<?php
session_name('user_session');
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once './controllers/ProductController.php';
require_once './controllers/SupplierController.php';
require_once './controllers/CategoryController.php';
require_once './controllers/ImageController.php';
require_once './controllers/UserController.php';
require_once './controllers/OrderController.php';
require_once './controllers/OrderItemController.php';
require_once './controllers/InventoryController.php';
require_once './controllers/PaymentController.php';
require_once './controllers/StatusController.php';
require_once './controllers/ChatController.php';
require_once './controllers/BranchController.php';
require_once './controllers/ShippingController.php';
require_once './controllers/ReviewController.php';
require_once './controllers/BannerController.php';


require_once __DIR__ . '/modules/Users/Notification/alertHelper.php';

require 'vendor/autoload.php';

$product = new ProductController();
$supplier = new SupplierController();
$category = new CategoryController();
$imageController = new ImageController();
$userController = new UserController();
$orderController = new OrderController();
$orderItemController = new OrderItemController();
$inventoryController = new InventoryController();
$paymentController = new PaymentController();
$statusController = new StatusController();
$chatController = new ChatController();
$branchController = new BranchController();
$shippingController = new ShippingController();
$reviewController = new ReviewController();
$bannerController = new BannerController();

$cart = $_SESSION['cart'] ?? [];
// unset($_SESSION['jwt']);

$userData = $userController->getCurrentUser();

if (isset($_GET['ajax_get_user_chat']) || isset($_POST['ajax_send_user_chat'])) {
    require_once './chatUser.php';
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>GARENA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="./Style/Users/Header.css?v=2">
    <link rel="stylesheet" href="./Style/Users/Detail.css?v=2">
    <link rel="stylesheet" href="./Style/Users/Sidebar.css?v=2">
    <link rel="stylesheet" href="./Style/Users/Cart.css?v=2">
    <link rel="stylesheet" href="./Style/Users/Chat.css?v=2">
    <link rel="stylesheet" href="./Style/Users/Review.css?v=2">
    <link rel="stylesheet" href="./Style/Users/Supplier.css?v=2">
    <link rel="stylesheet" href="./Style/Users/Product.css?v=2">
    <link rel="stylesheet" href="./Style/Users/CheckOrder.css?v=2">
    <link rel="stylesheet" href="./Style/Users/HomePage.css?v=2">
    <link rel="stylesheet" href="./Style/Users/OrderTracking.css?v=2">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        .chat-box {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background: white;
            z-index: 9998;
        }

        .hidden {
            display: none !important;
        }

        .chat-toggle-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #e0f0ff;
            /* Màu nền mặc định - cho Admin */
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.3s;
        }

        #chat-toggle-ai {
            background-color: #e6f9ec;
        }

        .chat-toggle-btn:hover {
            transform: scale(1.1);
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        // $chatController->sendMessage(13, 'user', 'Em muốn hỏi về laptop');
        // $history = $chatController->getChatHistory(13);
        // foreach ($history as $entry) {
        //     echo "[{$entry->time}] {$entry->from}: {$entry->message} <br>";
        // }
        require './modules/Users/Layout/Header.php';
        if (isset($_GET['subpage'])) {
            require $_GET['subpage'];
        } else {
            require './modules/Users/page/HomePage.php';
        }
        require './modules/Users/Layout/Supplier.php';

        require './modules/Users/Layout/Footer.php';
        ?>
    </div>

    <!-- Chat Toggle Buttons -->

    <div id="chat-toggle-wrapper" style="position: fixed; bottom: 20px; right: 20px; display: flex; gap: 10px; z-index: 9999;">

        <?php
        if ($userData) {
        ?>
            <div id="chat-toggle-admin" class="chat-toggle-btn" title="Chat với Admin">
                <i class="bi bi-chat-dots-fill fs-3 text-primary"></i>
            </div>
        <?php
        }
        ?>
        <div id="chat-toggle-ai" class="chat-toggle-btn" title="Chat với AI">
            <i class="bi bi-robot fs-3 text-success"></i>
        </div>
    </div>



    <!-- Chat -->
    <?php
    require_once './chatUser.php';
    require_once './chatBox.php';
    ?>

    <script src="https://cdn.tiny.cloud/1/vdvrq3yfn1mvkxu8e58u6aomn76eh0uqy054jbiq8djjjeqz/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chatForm = document.getElementById("chat-form");
            const aiChatForm = document.getElementById("ai-chat-form");
            const chatToggleAdmin = document.getElementById("chat-toggle-admin");
            const chatToggleAi = document.getElementById("chat-toggle-ai");

            if (chatToggleAdmin) {
                chatToggleAdmin.addEventListener("click", () => {
                    if (chatForm) {
                        const isOpening = chatForm.classList.contains("hidden");
                        chatForm.classList.toggle("hidden");
                        if (isOpening) {
                            fetch("?openChat=1");
                            setTimeout(() => {
                                const chatContent = document.getElementById("chat-content");
                                if (chatContent) chatContent.scrollTop = chatContent.scrollHeight;
                            }, 50);
                        } else {
                            fetch("?closeChat=1");
                        }
                    }
                    if (aiChatForm) {
                        aiChatForm.classList.add("hidden");
                    }
                });
            }

            if (chatToggleAi) {
                chatToggleAi.addEventListener("click", () => {
                    if (aiChatForm) {
                        aiChatForm.classList.toggle("hidden");
                    }
                    if (chatForm) {
                        chatForm.classList.add("hidden");
                    }
                });
            }

            const chatClose = document.getElementById("chat-close");
            if (chatClose) {
                chatClose.addEventListener("click", () => {
                    if (chatForm) {
                        chatForm.classList.add("hidden");
                    }
                    fetch("?closeChat=1");
                });
            }

            const aiChatClose = document.getElementById("ai-chat-close");
            if (aiChatClose) {
                aiChatClose.addEventListener("click", () => {
                    if (aiChatForm) {
                        aiChatForm.classList.add("hidden");
                    }
                });
            }
        });
    </script>

    <script>
        tinymce.init({
            selector: '#comment',
            height: 300,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });

        function toggleDropdown(id, event) {
            event.preventDefault(); // ❗ Chặn hành vi mặc định của thẻ <a>
            const el = document.getElementById(id);
            el.classList.toggle('show');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./Style/Script/User/Detail.js"></script>
    <script src="./Style/Script/User/CheckOrder.js"></script>
    <script src="./Style/Script/User/HomePage.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

</body>

</html>