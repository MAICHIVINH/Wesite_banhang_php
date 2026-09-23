# GARENA - E-Commerce Store & Admin Management System

![GARENA Theme](https://img.shields.io/badge/Theme-GARENA%20Cyber%20Indigo-4F46E5?style=for-the-badge)
![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-5.7%20%2F%208.0-4479A1?style=for-the-badge&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap)

---

# PHẦN 1: MÔ TẢ TỔNG QUAN HỆ THỐNG

## Giới Thiệu Dự Án
**GARENA E-Sports Store** là hệ thống website thương mại điện tử chuyên nghiệp cung cấp thiết bị công nghệ, phụ kiện gaming và linh kiện máy tính cao cấp. 

Hệ thống được thiết kế theo kiến trúc **Custom PHP MVC Pattern** linh hoạt, sử dụng nhận diện thương hiệu **GARENA Cyber Indigo (`#4F46E5`) & Cyan (`#06B6D4`)** mang phong cách công nghệ hiện đại, sang trọng và tối ưu trải nghiệm người dùng trên cả nền tảng Desktop và Mobile.

---

## Tính Năng Nổi Bật

### 1. Trang Khách Hàng (Storefront Portal)
- **Giao diện nhận diện GARENA Cyber Indigo**: Phối màu Indigo & Cyan ấn tượng, chuyển động mượt mà.
- **Trang chủ & Banner Slider**: Banner khuyến mãi 3 cột chuẩn độ cao 360px, tích hợp danh mục sản phẩm và ưu đãi hot.
- **Tìm kiếm & Bộ lọc nâng cao**: Lọc sản phẩm theo danh mục, nhà cung cấp, khoảng giá và chi nhánh cửa hàng.
- **Giỏ hàng thông minh**: Quản lý Session giỏ hàng, tự động tính tổng tiền, chiết khấu và giữ nguyên sản phẩm khi chưa hoàn tất thanh toán.
- **Thanh toán Online QR linh hoạt**:
  - Tự động sinh mã **VietQR Code động** điền sẵn số tiền và cú pháp chuyển khoản (`code` đơn hàng).
  - Hỗ trợ thanh toán qua **Ví MoMo, ShopeePay, ZaloPay** và **40+ ứng dụng Ngân hàng**.
  - Tự động cập nhật trạng thái đơn hàng sang *`Đã xác nhận chuyển khoản (Chờ đối soát)`*.
- **Tra cứu & Theo dõi đơn hàng**: Hiển thị chi tiết đơn hàng, badge trạng thái thanh toán & trạng thái đơn hàng, hỗ trợ hủy đơn linh hoạt.
- **Đánh giá & Nhận xét**: Đánh giá sao và gửi phản hồi sản phẩm đã mua.

### 2. Trang Quản Trị (Admin Panel - `Admin.php`)
- **Báo cáo Thống kê**: Tổng quan doanh thu, thống kê đơn hàng theo tuần/tháng, hỗ trợ xuất báo cáo Excel (`PhpSpreadsheet`).
- **Quản lý Đơn hàng & Giao hàng**: Duyệt đơn hàng, đối soát chuyển khoản online, cập nhật luồng vận chuyển.
- **Bản đồ Giao hàng Thông minh (Interactive Shipping Map)**:
  - Tích hợp **OpenStreetMap & Leaflet JS**.
  - Tự động chuẩn hóa địa chỉ và **cắm Ghim Đỏ (`Marker Pin`) trực quan** lên địa chỉ nhận hàng của khách.
- **Quản lý Kho & Sản phẩm**: Thêm, sửa, xóa, khôi phục sản phẩm từ Thùng rác.
- **Quản lý Banner**: Bật/tắt trạng thái hiển thị banner quảng cáo tức thì.
- **Phân quyền Nhân viên (RBAC)**: Quản lý menu và phân quyền truy cập chi tiết theo vai trò công việc.

---

## Công Nghệ Sử Dụng

- **Backend**: PHP 8.1+ (Custom MVC Pattern, PDO Database Wrapper, Redis Cache)
- **Database**: MySQL / MariaDB (`utf8mb4_unicode_ci`)
- **Frontend**: HTML5, Vanilla CSS3 (Custom Design System), ES6 JavaScript
- **Thư viện & Plugins**:
  - Bootstrap 5.3 & Bootstrap Icons
  - SweetAlert2 (Thông báo & Pop-up xác nhận)
  - Leaflet JS (Bản đồ tương tác cắm ghim vị trí)
  - FontAwesome 6 & Slick Carousel
  - PhpSpreadsheet & Firebase PHP-JWT

---

## Cấu Trúc Thư Mục Dự Án

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
├── docker-compose.yml       # File cấu hình chạy Redis Container
├── electronic_shop.sql      # File dữ liệu SQL mẫu của hệ thống
├── index.php                # Entry Point Trang Khách Hàng
├── Admin.php                # Entry Point Trang Quản Trị
└── composer.json            # Quản lý thư viện phụ thuộc PHP
```

---

# PHẦN 2: HƯỚNG DẪN CÀI ĐẶT & KHỞI CHẠY

## Yêu Cầu Hệ Thống

Dự án chạy tốt trên các môi trường Localhost như **XAMPP, WAMP, Laragon, MAMP**:

| Thành phần | Yêu cầu tối thiểu |
| :--- | :--- |
| **PHP** | `>= 8.1` |
| **MySQL / MariaDB** | `>= 5.7` hoặc `>= 8.0` |
| **Web Server** | Apache / Nginx |
| **Composer** | `>= 2.0` |
| **Docker** (Tùy chọn) | Chạy Redis Cache Service |
| **PHP Extensions** | `pdo_mysql`, `gd`, `zip`, `mbstring`, `fileinfo` |

---

## Hướng Dẫn Các Bước Khởi Chạy

### Bước 1: Download / Clone Source Code
Chép thư mục dự án vào thư mục gốc của Web Server (đối với XAMPP: `C:\xampp\htdocs\DevPHP_V2`).

### Bước 2: Import Cơ Sở Dữ Liệu MySQL
1. Truy cập phpMyAdmin: `http://localhost/phpmyadmin`
2. Tạo database mới tên là: **`electronic_shop`** (Collation: `utf8mb4_unicode_ci`).
3. Chọn tab **Import** và chọn file **`electronic_shop.sql`** tại thư mục gốc dự án.
4. Nhấn **Import** để nạp dữ liệu mẩu.

### Bước 3: Cấu Hình Kết Nối Database
File cấu hình kết nối nằm tại `config/database.php`. Vui lòng chỉnh sửa thông số phù hợp với môi trường của bạn:

```php
// config/database.php
$host = "localhost";
$db   = "electronic_shop";
$user = "root";
$pass = ""; // Mật khẩu MySQL của bạn nếu có
```

### Bước 4: Cài Đặt Thư Viện Composer
Mở Terminal / Command Prompt tại thư mục dự án và chạy:

```bash
composer install
```

### Bước 5: Khởi Chạy Redis Server Bằng Docker (Tùy Chọn Cache)
Hệ thống sử dụng Redis (`RedisCache.php`) để lưu Cache Banner và Chat Session. Khởi chạy nhanh bằng **Docker Compose**:

```bash
# Khởi chạy dịch vụ Redis ngầm
docker-compose up -d
```

*Hoặc chạy lệnh Docker trực tiếp:*
```bash
docker run -d --name garena_redis -p 6379:6379 redis:alpine
```

### Bước 6: Truy Cập Ứng Dụng
1. Bật dịch vụ **Apache** và **MySQL** từ XAMPP Control Panel.
2. Mở trình duyệt và truy cập các đường dẫn:

- **Trang Khách Hàng (Storefront)**:  
  `http://localhost/DevPHP_V2/`

- **Trang Quản Trị (Admin Panel)**:  
  `http://localhost/DevPHP_V2/Admin.php`

---

## Hướng Dẫn Chạy Tool Cào Dữ Liệu Giá Thị Trường (Data Scraper)

Hệ thống tích hợp công cụ tự động cào dữ liệu giá đối thủ (Thế Giới Di Động, FPT Shop, CellphoneS...) để hỗ trợ tính năng **So sánh giá thị trường** trong Trang Admin và Trang chi tiết sản phẩm.

Thư mục công cụ: `scripts/scraper/`

### Cách 1: Chạy bằng PHP Script (Cào thực tế - Khuyên dùng)

File `real_scraper.php` sẽ tự động tìm kiếm thông tin và cập nhật bảng `competitor_prices` trong MySQL:

```bash
# Chạy trực tiếp script PHP từ thư mục gốc dự án
php scripts/scraper/real_scraper.php
```

### Cách 2: Chạy bằng Python Script

Nếu môi trường của bạn đã cài đặt Python 3, bạn có thể sử dụng script Python `scrape_prices.py`:

1. **Cài đặt các thư viện cần thiết**:
   ```bash
   pip install -r scripts/scraper/requirements.txt
   ```
   *(Thư viện bao gồm: `requests`, `beautifulsoup4`, `mysql-connector-python`)*

2. **Chạy script**:
   ```bash
   python scripts/scraper/scrape_prices.py
   ```

### Cách 3: Nạp dữ liệu giả lập mẫu (Seeder Nhanh)

Để nạp dữ liệu so sánh giá mẫu tức thì (dùng cho việc test offline hoặc chưa có kết nối mạng):

```bash
php scripts/scraper/seed_prices.php
```

---

## Đóng Góp & Hỗ Trợ
Dự án được phát triển và duy trì bởi **Mai Chí Vĩnh**. Nếu bạn gặp bất kỳ vấn đề gì trong quá trình cài đặt hoặc vận hành, vui lòng liên hệ bộ phận hỗ trợ kỹ thuật.

*Chúc bạn cài đặt và trải nghiệm thành công!*
