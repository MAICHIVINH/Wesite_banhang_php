<?php

require_once './models/Category.php';
require_once  './models/Product.php';
require_once  './models/Supplier.php';
require_once  './models/Payment.php';
require_once  './models/Shipping.php';
require_once  './models/User.php';
require_once  './models/Order.php';
require_once  './models/OrderItem.php';
require_once  './models/Inventory.php';
require_once  './models/Review.php';
require_once  './models/Admin.php';
require_once './controllers/ProductController.php';
require_once  './models/Banner.php';
require_once  './models/Status.php';
require_once  './models/ReportReasons.php';
require_once  './models/UserReports.php';
require_once  './models/ChatMessage.php';
require_once  './models/Role.php';
require_once  './models/Menu.php';
require_once  './models/Employee.php';
require_once  './models/EmployeeMenu.php';
require_once  './models/RoleMenu.php';
require_once  './models/RoleEmployee.php';
require_once  './models/Branch.php';
require_once  './models/PasswordResetToken.php';


require_once  './models/Image.php';

$passwordReset = new PasswordResetToken();
$passwordReset->createTable();


$branch = new Branch();
$branch->createTable();

$employee = new Employee();
$employee->createTable();

$role = new Role();
$role->createTable();

$menu = new Menu();
$menu->createTable();

$roleMenu = new RoleMenu();
$roleMenu->createTable();

$employeeMenu = new EmployeeMenu();
$employeeMenu->createTable();

$roleEmployee = new RoleEmployee();
$roleEmployee->createTable();




$chatMessage = new ChatMessage();
$chatMessage->createTable();


$report = new ReportReasons();
$report->createTable();
// $reportData = [
//     ['reason_text' => 'Spam', 'ban_days' => 1, "isDeleted" => 0],
//     ['reason_text' => 'Hành vi thù địch', 'ban_days' => 7, "isDeleted" => 0],
//     ['reason_text' => 'Lạm dụng tính năng', 'ban_days' => 3, "isDeleted" => 0],
//     ['reason_text' => 'Vi phạm nội quy nghiêm trọng', 'ban_days' => 30, "isDeleted" => 0],
// ];

// foreach ($reportData as $item) {
//     $report->insert($item);
// }

$userReport = new UserReports();
$userReport->createTable();


$status = new Status();
$status->createTable();

// $statusData = [
//     ["name" => 'Chờ xử lý', "isDeleted" => 0],
//     ["name" => 'Đã xác nhận', "isDeleted" => 0],
//     ["name" => 'Đang chuyển hàng', "isDeleted" => 0],
//     ["name" => 'Đang giao hàng', "isDeleted" => 0],
//     ["name" => 'Đã hủy', "isDeleted" => 0],
//     ["name" => 'Thành công', "isDeleted" => 0],
// ];

// foreach ($statusData as $item) {
//     $status->insert($item);
// }

$banner = new Banner();
$banner->createTable();

// $user = new User();
// $user->createTable();

$category = new Category();
$category->createTable();

// $categoryData = [
//     ['name' => 'Laptop', 'status' => 0, 'icon' => 'bi-laptop', 'isDeleted' => 0],
//     ['name' => 'PC Gaming', 'status' => 0, 'icon' => 'bi-controller', 'isDeleted' => 0],
//     ['name' => 'Phụ kiện', 'status' => 0, 'icon' => 'bi-headphones', 'isDeleted' => 0],
//     ['name' => 'Màn hình', 'status' => 0, 'icon' => 'bi-display', 'isDeleted' => 0],
//     ['name' => 'Bàn phím', 'status' => 0, 'icon' => 'bi-keyboard', 'isDeleted' => 0],
// ];

// foreach ($categoryData as $item) {
//     $category->insert($item);
// }


$supplier = new Supplier();
$supplier->createTable();

// $supplierData = [
//     ['name' => 'ASUS', 'contact_person' => 'Nguyễn Văn A', 'Phone' => '0901234567', 'Email' => 'asus@example.com', 'Address' => 'TP.HCM', 'isDeleted' => 0],
//     ['name' => 'MSI', 'contact_person' => 'Trần Thị B', 'Phone' => '0912345678', 'Email' => 'msi@example.com', 'Address' => 'Hà Nội', 'isDeleted' => 0],
//     ['name' => 'Gigabyte', 'contact_person' => 'Lê Văn C', 'Phone' => '0923456789', 'Email' => 'gigabyte@example.com', 'Address' => 'Đà Nẵng', 'isDeleted' => 0],
//     ['name' => 'Razer', 'contact_person' => 'Phạm Thị D', 'Phone' => '0934567890', 'Email' => 'razer@example.com', 'Address' => 'TP.HCM', 'isDeleted' => 0],
//     ['name' => 'Logitech', 'contact_person' => 'Hoàng Văn E', 'Phone' => '0945678901', 'Email' => 'logitech@example.com', 'Address' => 'Hà Nội', 'isDeleted' => 0],
// ];

// foreach ($supplierData as $item) {
//     $supplier->insert($item);
// }


$product = new Product();
$product->createTable();

// $productData = [
//     ['name' => 'Laptop Gaming ASUS TUF', 'price' => 25000000, 'discount' => 10, 'description' => 'Laptop mạnh mẽ cho game thủ', 'image_url' => 'images/asus_tuf.jpg', 'category_id' => 1, 'supplier_id' => 1, 'isDeleted' => 0],
//     ['name' => 'PC Gaming MSI RTX', 'price' => 32000000, 'discount' => 5, 'description' => 'Cấu hình cao chiến mọi game', 'image_url' => 'images/msi_pc.jpg', 'category_id' => 2, 'supplier_id' => 2, 'isDeleted' => 0],
//     ['name' => 'Tai nghe Razer Kraken', 'price' => 2200000, 'discount' => 0, 'description' => 'Âm thanh sống động, đeo êm', 'image_url' => 'images/razer_kraken.jpg', 'category_id' => 3, 'supplier_id' => 4, 'isDeleted' => 0],
//     ['name' => 'Màn hình LG UltraGear', 'price' => 7500000, 'discount' => 8, 'description' => 'Tốc độ 144Hz, chơi game mượt', 'image_url' => 'images/lg_ultragear.jpg', 'category_id' => 4, 'supplier_id' => 3, 'isDeleted' => 0],
//     ['name' => 'Bàn phím Logitech G Pro', 'price' => 1900000, 'discount' => 15, 'description' => 'Switch chất lượng cao', 'image_url' => 'images/logitech_gpro.jpg', 'category_id' => 5, 'supplier_id' => 5, 'isDeleted' => 0],
//     ['name' => 'Laptop ASUS VivoBook', 'price' => 17000000, 'discount' => 5, 'description' => 'Mỏng nhẹ, hiệu năng ổn định', 'image_url' => 'images/vivobook.jpg', 'category_id' => 1, 'supplier_id' => 1, 'isDeleted' => 0],
//     ['name' => 'PC Gigabyte Ryzen 5', 'price' => 28000000, 'discount' => 12, 'description' => 'Hiệu suất đa nhiệm mạnh mẽ', 'image_url' => 'images/gigabyte_pc.jpg', 'category_id' => 2, 'supplier_id' => 3, 'isDeleted' => 0],
//     ['name' => 'Tai nghe Logitech G733', 'price' => 2500000, 'discount' => 10, 'description' => 'Không dây, đèn RGB đẹp mắt', 'image_url' => 'images/g733.jpg', 'category_id' => 3, 'supplier_id' => 5, 'isDeleted' => 0],
//     ['name' => 'Màn hình ASUS ProArt', 'price' => 9200000, 'discount' => 7, 'description' => 'Chuẩn màu cho dân thiết kế', 'image_url' => 'images/proart.jpg', 'category_id' => 4, 'supplier_id' => 1, 'isDeleted' => 0],
//     ['name' => 'Bàn phím cơ Razer BlackWidow', 'price' => 2300000, 'discount' => 0, 'description' => 'Cảm giác gõ tuyệt vời', 'image_url' => 'images/blackwidow.jpg', 'category_id' => 5, 'supplier_id' => 4, 'isDeleted' => 0],
// ];

// foreach ($productData as $item) {
//     $product->insert($item);
// }

$image = new Image();
$image->createTable();


$payment = new Payment();
$payment->createTable();

$shipping = new Shipping();
$shipping->createTable();

$order = new Order();
$order->createTable();

$order_item = new OrderItem();
$order_item->createTable();

$inventory = new Inventory();
$inventory->createTable();

$review = new Review();
$review->createTable();

$admin = new Admin();
$admin->createTable();





// $productController = new ProductController();
// // $categoryId = $category->insert(['name' => 'Laptop']);
// // $productId = $product->insert([
// //     'name' => 'Macbook Pro',
// //     'price' => 2500,
// //     'category_id' => $categoryId
// // ]);

// $products = $productController->getAll();
// if (count($products) > 0) {
//     foreach ($products as $item) {
//         echo $item['name'];
//     }
// }
echo " <h1>✅TẠO CƠ SỞ DỮ LIỆU THÀNH CÔNG!</h1>";
