# 🚀 GARENA - E-Commerce Store & Admin Management System

![GARENA Theme](https://img.shields.io/badge/Theme-GARENA%20Cyber%20Indigo-4F46E5?style=for-the-badge)
![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-5.7%20%2F%208.0-4479A1?style=for-the-badge&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap)

> **GARENA E-Sports Store** là hệ thống website thương mại điện tử chuyên nghiệp cung cấp thiết bị công nghệ, phụ kiện gaming và linh kiện máy tính cao cấp. Hệ thống được xây dựng trên nền tảng **Custom PHP MVC Architecture**, đi kèm giao diện phong cách **GARENA Cyber Indigo & Cyan** hiện đại, mượt mà và tối ưu trải nghiệm người dùng.

---

## ✨ Tính năng nổi bật

### 🛍️ Trang Khách Hàng (Storefront)
- **Giao diện GARENA Cyber Indigo**: Tone màu Indigo (`#4F46E5`) và Cyan (`#06B6D4`) mang phong cách công nghệ & gaming ấn tượng.
- **Trang chủ & Banner Slider**: Hiển thị Banner khuyến mãi động 3 cột chuẩn độ cao 360px, tích hợp danh mục sản phẩm và ưu đãi hot.
- **Tìm kiếm & Lọc sản phẩm**: Lọc sản phẩm theo danh mục, nhà cung cấp, khoảng giá và chi nhánh cửa hàng.
- **Giỏ hàng thông minh**: Lưu trạng thái giỏ hàng qua Session, tự động tính tổng tiền, giảm giá chiết khấu và giữ nguyên sản phẩm khi chưa hoàn tất thanh toán.
- **Thanh toán Online QR thông minh**: 
  - Tạo mã **VietQR Code động** tự động điền số tiền và cú pháp chuyển khoản (`code` đơn hàng).
  - Hỗ trợ quét mã bằng **Ví MoMo, ShopeePay, ZaloPay** và **40+ ứng dụng Ngân hàng**.
  - Tự động chuyển đổi trạng thái đơn hàng sang *`Đã xác nhận chuyển khoản (Chờ đối soát)`*.
- **Tra cứu & Theo dõi đơn hàng**: Hiển thị chi tiết đơn hàng, badge trạng thái thanh toán & trạng thái đơn hàng, hỗ trợ hủy đơn linh hoạt.
- **Đánh giá & Nhận xét**: Đánh giá sao và gửi nhận xét cho sản phẩm đã mua thành công.

### 🛡️ Trang Quản Trị (Admin Panel - `Admin.php`)
- **Báo cáo Thống kê**: Tổng quan doanh thu, số lượng đơn hàng theo tuần/tháng, xuất báo cáo Excel (`PhpSpreadsheet`).
- **Quản lý Đơn hàng & Giao hàng**: Xem danh sách đơn hàng, cập nhật trạng thái đơn và duyệt đối soát chuyển khoản.
- **Bản đồ Giao hàng Thông minh (Interactive Shipping Map)**:
  - Tích hợp **OpenStreetMap & Leaflet JS**.
  - Tự động chuẩn hóa địa chỉ và **cắm Ghim Đỏ (`Marker Pin`) trực quan** lên địa chỉ của Người nhận / Khách hàng.
- **Quản lý Kho hàng & Sản phẩm**: Thêm, sửa, xóa, khôi phục sản phẩm từ Thùng rác.
- **Quản lý Banner**: Bật/tắt trạng thái hiển thị banner quảng cáo tức thì.
- **Phân quyền Nhân viên (RBAC)**: Quản lý menu và phân quyền truy cập theo vai trò công việc.

---

## 🛠️ Công Nghệ Sử Dụng

- **Backend**: PHP 8.1+ (Custom MVC Pattern, PDO Database Wrapper, Redis Cache)
- **Database**: MySQL / MariaDB (`utf8mb4_unicode_ci`)
- **Frontend**: HTML5, Vanilla CSS3 (Custom Design System), ES6 JavaScript
- **Libraries & Plugins**:
  - Bootstrap 5.3 & Bootstrap Icons
  - SweetAlert2 (Hộp thoại thông báo & xác nhận đẹp mắt)
  - Leaflet JS (Bản đồ tương tác cắm ghim vị trí)
  - FontAwesome 6 & Slick Carousel
  - PhpSpreadsheet & Firebase PHP-JWT

---

## 📋 Yêu Cầu Hệ Thống

Dự án có thể chạy tốt trên các môi trường Localhost như **XAMPP, WAMP, Laragon, MAMP**:

| Thành phần | Yêu cầu tối thiểu |
| :--- | :--- |
| **PHP** | `>= 8.1` |
| **MySQL / MariaDB** | `>= 5.7` hoặc `>= 8.0` |
| **Web Server** | Apache / Nginx |
| **Composer** | `>= 2.0` |
| **PHP Extensions** | `pdo_mysql`, `gd`, `zip`, `mbstring`, `fileinfo` |

---

## 🚀 Hướng Dẫn Cài Đặt & Khởi Chạy

### 1. Download / Clone Source Code
Chép thư mục dự án vào thư mục gốc của Web Server (ví dụ đối với XAMPP: `C:\xampp\htdocs\DevPHP_V2`).

### 2. Import Cơ Sở Dữ Liệu MySQL
1. Mở trình quản lý cơ sở dữ liệu phpMyAdmin: `http://localhost/phpmyadmin`
2. Tạo một database mới đặt tên là: **`electronic_shop`** (Collation: `utf8mb4_unicode_ci`).
3. Chọn tab **Import** và chọn file **`electronic_shop.sql`** nằm tại thư mục gốc của dự án.
4. Nhấn **Import** để hoàn tất nạp dữ liệu mẫu.

### 3. Cấu Hình Kết Nối Database
File cấu hình kết nối nằm tại `config/database.php`. Nếu MySQL của bạn sử dụng Mật khẩu khác mặc định, vui lòng chỉnh sửa tại đây:

```php
// config/database.php
$host = "localhost";
$db   = "electronic_shop";
$user = "root";
$pass = ""; // Nhập mật khẩu MySQL của bạn nếu có
```

### 4. Cài Đặt Thư viện Composer
Mở Terminal / Command Prompt tại thư mục dự án và chạy lệnh sau để tải các vendor cần thiết:

```bash
composer install
```

### 5. Khởi Chạy Hệ Thống
1. Bật **Apache** và **MySQL** từ XAMPP Control Panel.
2. Truy cập các đường dẫn sau trên trình duyệt:

- **Trang Khách Hàng (User)**:  
  `http://localhost/DevPHP_V2/`

- **Trang Quản Trị (Admin)**:  
  `http://localhost/DevPHP_V2/Admin.php`

---

## 📁 Cấu Trúc Thư Mục Dự Án

```
DevPHP_V2/
├── config/                  # Cấu hình hệ thống & kết nối Database
│   └── database.php
├── core/                    # Lớp cốt lõi Custom MVC Framework
│   ├── Database.php
│   ├── Models.php
│   └── RedisCache.php
├── controllers/             # Logic Xử lý Điều khiển (Controllers)
│   ├── OrderController.php
│   ├── PaymentController.php
│   ├── ProductController.php
│   └── ...
├── models/                  # Lớp Thao Tác Cơ Sở Dữ Liệu (Models)
│   ├── Order.php
│   ├── Payment.php
│   ├── Product.php
│   └── ...
├── modules/                 # Các Module Giao diện & Trang chức năng
│   ├── Admin/               # Quản trị Admin (Orders, Shipping, Banners, Products...)
│   └── Users/               # Trang người dùng (Cart.php, OnlinePayment.php, CheckOrder.php...)
├── Style/                   # Tài nguyên CSS, JS và Hình ảnh
│   ├── Admin/
│   ├── Users/
│   └── Script/
├── electronic_shop.sql      # File dữ liệu SQL mẫu của hệ thống
├── index.php                # Entry Point Trang Khách Hàng
├── Admin.php                # Entry Point Trang Quản Trị
└── composer.json            # Quản lý thư viện phụ thuộc PHP
```

---

## 📝 Đóng Góp & Hỗ Trợ
Dự án được phát triển và duy trì bởi đội ngũ **GARENA E-Sports Store**. Nếu bạn gặp bất kỳ vấn đề gì trong quá trình cài đặt hoặc vận hành, vui lòng tạo Issue hoặc liên hệ bộ phận hỗ trợ kỹ thuật.

*Chúc bạn cài đặt và trải nghiệm thành công! 🎉*
