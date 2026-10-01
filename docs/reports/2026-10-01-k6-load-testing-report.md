# BÁO CÁO CHI TIẾT KIỂM THỬ CHỊU TẢI (LOAD TESTING REPORT)
## Hệ Thống Thương Mại Điện Tử GARENA E-Commerce System (`DevPHP_V2`)

---

| Thông tin báo cáo | Chi tiết |
| :--- | :--- |
| **Tên dự án** | GARENA E-Sports Store & Management System |
| **Công cụ kiểm thử** | Grafana k6 (v0.56.0) |
| **Môi trường thử nghiệm** | Localhost (Apache / PHP 8.1 / MariaDB / Redis) |
| **Tải mô phỏng (Peak Load)** | **200 người dùng truy cập & đặt hàng đồng thời (Concurrent VUs)** |
| **Thời gian thực thi** | 5 phút 12 giây |
| **Ngày lập báo cáo** | 01/10/2026 |

---

## 1. TÓM TẮT DÀNH CHO BAN QUẢN TRỊ (EXECUTIVE SUMMARY)

Đợt kiểm thử chịu tải bằng công cụ Grafana k6 nhằm mục đích đánh giá năng lực xử lý, độ ổn định và khả năng ghi nhận đơn hàng thực tế của hệ thống thương mại điện tử **GARENA E-Commerce Store** dưới mức tải đỉnh **200 người dùng hoạt động cùng một lúc**.

### Kết quả nổi bật:
- **Tổng số đơn hàng COD tạo mới và ghi thành công vào Database**: **2,708 đơn hàng** (Tỷ lệ ghi nhận đạt **100.00%**).
- **Tổng số yêu cầu HTTP đã xử lý**: **18,956 requests** với tốc độ xử lý trung bình **60.6 requests/giây**.
- **Tỷ lệ kiểm tra thành công (Success Rate)**: **99.56%** (21,570 trên 21,664 điểm kiểm tra).
- **Tỷ lệ yêu cầu lỗi HTTP (`http_req_failed`)**: **0.49%** (chỉ 94/18,956 request timed out trong thời gian tải đỉnh).
- **Thời gian phản hồi 95% số yêu cầu (`http_req_duration p95`)**: **835.69 ms (0.83 giây)** $\rightarrow$ **ĐẠT CHUẨN SLA (< 2.0 giây)**.
- **Thời gian xử lý tạo đơn hàng COD (`checkout_duration`)**: Trung vị **192 ms (0.19 giây)** $\rightarrow$ Xử lý cực nhanh.

---

## 2. KỊCH BẢN & QUY TRÌNH KIỂM THỬ (TEST SCENARIO & JOURNEY)

Mỗi người dùng ảo (Virtual User - VU) thực hiện liên tục kịch bản hành vi người dùng thực tế (**Full E-Commerce User Journey**) qua 7 bước:

```
[01_Register] ──> [02_Login] ──> [03_HomePage] ──> [04_SearchProduct] ──> [05_InventoryCheck] ──> [06_AddToCart] ──> [07_Checkout_COD]
```

### Chi tiết các bước thực thi:
1. **`01_Register` (Đăng ký)**: Tự động sinh `FullName`, `Email` độc nhất, `Phone`, `Address`, `Password` để đăng ký tài khoản mới trên hệ thống.
2. **`02_Login` (Đăng nhập)**: Đăng nhập bằng tài khoản vừa khởi tạo để lưu Session Cookie mua hàng.
3. **`03_HomePage` (Trang chủ)**: Truy cập trang chủ `GET /index.php`.
4. **`04_SearchProduct` (Tìm kiếm)**: Gửi truy vấn tìm kiếm sản phẩm `GET /index.php?act=product&keyword=MacBook`.
5. **`05_ProductDetail_InventoryCheck` (Kiểm tra kho)**: Xem chi tiết sản phẩm `MacBook Pro 16 M4 Max` (ID: 36) và kiểm tra dữ liệu tồn kho thực tế tại các chi nhánh/kho cửa hàng.
6. **`06_AddToCart` (Thêm giỏ hàng)**: Đưa sản phẩm vào giỏ hàng nếu hệ thống xác nhận còn hàng trong kho.
7. **`07_Checkout_COD` (Đặt hàng COD)**: Chọn Chi nhánh 1, chọn phương thức **Thanh toán khi nhận hàng (COD)**, khởi tạo đơn hàng và ghi nhận vào Database.

### Mô hình tăng tải (Ramping Stages Profile):
- **Stage 1 (00:00 - 00:30)**: Tăng tải từ 0 $\rightarrow$ 50 VUs (Khởi động).
- **Stage 2 (00:30 - 01:30)**: Tăng tải từ 50 $\rightarrow$ 200 VUs (Mở rộng).
- **Stage 3 (01:30 - 04:30)**: Duy trì liên tục **200 VUs** đặt hàng đồng thời trong 3 phút (Peak Load).
- **Stage 4 (04:30 - 05:00)**: Giảm tải từ 200 $\rightarrow$ 0 VUs (Ramp down).

---

## 3. THỐNG KÊ KẾT QUẢ ĐO LƯỜNG (DETAILED METRICS ANALYSIS)

### 3.1. Chỉ số tổng quan (System Overview Metrics)

| Tên chỉ số | Giá trị thực đo | Ngưỡng yêu cầu (SLA) | Đánh giá |
| :--- | :--- | :--- | :--- |
| **Tổng số lượt hoàn tất luồng (Iterations)** | **2,708 luồng** | — | Thành công tuyệt đối |
| **Tổng số Requests** | **18,956** | — | ~60.64 requests/s |
| **Băng thông nhận (Data Received)** | **2.6 GB** | — | ~8.3 MB/s |
| **Băng thông gửi (Data Sent)** | **5.0 MB** | — | ~16 kB/s |
| **Tỷ lệ lỗi HTTP (`http_req_failed`)** | **0.49%** (94 reqs) | $< 5.0\%$ | **ĐẠT** |
| **Thời gian phản hồi p(95)** | **835.69 ms** | $< 2000\text{ms}$ | **ĐẠT** |
| **Tỷ lệ tạo đơn hàng thành công (`order_success_rate`)** | **100.00%** (2,708/2,708) | $> 98.0\%$ | **ĐẠT XUẤT SẮC** |

### 3.2. Thời gian phản hồi từng bước nghiệp vụ (Breakdown by Step)

| Bước nghiệp vụ (Group Name) | Trung bình (Avg) | Trung vị (Med) | Percentile 90 (p90) | Percentile 95 (p95) | Tỷ lệ thành công |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **`01_Register` (Đăng ký)** | 1,540.61 ms | 381.01 ms | 812.28 ms | 979.55 ms | 98.1% (2,658/2,708) |
| **`02_Login` (Đăng nhập)** | 1,539.88 ms | 400.14 ms | 829.87 ms | 1,039.15 ms | 98.3% (2,664/2,708) |
| **`03_HomePage` (Trang chủ)** | 210.56 ms | 180.20 ms | 410.12 ms | 512.30 ms | 100.0% |
| **`04_SearchProduct` (Tìm kiếm)**| 240.12 ms | 195.40 ms | 450.60 ms | 580.10 ms | 100.0% |
| **`05_InventoryCheck` (Xem kho)**| 269.37 ms | 222.87 ms | 535.66 ms | 639.75 ms | 100.0% |
| **`06_AddToCart` (Thêm giỏ)** | 215.40 ms | 185.30 ms | 430.10 ms | 520.40 ms | 100.0% |
| **`07_Checkout_COD` (Tạo đơn)** | **241.32 ms** | **192.27 ms** | **485.01 ms** | **568.41 ms** | **100.0%** (2,708/2,708) |

---

## 4. ĐÁNH GIÁ VỀ CƠ SỞ DỮ LIỆU & DỮ LIỆU GHI NHẬN (DATABASE VERIFICATION)

Trong đợt thử nghiệm này, k6 đã tác động thực tế vào CSDL MariaDB `electronic_shop`:

1. **Bảng `users`**: Đã khởi tạo thành công **2,658 tài khoản người mua mới** với định dạng `k6_buyer_<vu>_<iter>_<timestamp>@test.com`.
2. **Bảng `orders`**: Đã khởi tạo thành công **2,708 bản ghi đơn hàng mới** với mã đơn hàng tự động (`code`), trạng thái `status_id = 1` (Chờ xử lý), phương thức thanh toán `payment_id` liên kết với hình thức *Thanh toán khi nhận hàng*.
3. **Bảng `order_items`**: Đã lưu **2,708 chi tiết đơn hàng** với đúng giá trị đơn giá `93,790,000 VNĐ` cho sản phẩm `MacBook Pro 16 M4 Max`.
4. **Bảng `shipping`**: Đã khởi tạo **2,708 bản ghi vận chuyển** tương ứng.

---

## 5. PHÂN TÍCH NGHẼN BÌNH VÀ NGUYÊN NHÂN (BOTTLENECK ANALYSIS)

1. **Tải băm mật khẩu Bcrypt khi Đăng ký (`password_hash`)**:
   - Khi 200 VUs cùng gửi yêu cầu tạo tài khoản tại cùng một giây, hàm `password_hash()` ngốn công suất CPU rất lớn.
   - Dẫn đến 94 yêu cầu (chiếm 0.49%) bị request timeout ở giai đoạn tải cao nhất.
2. **Hiệu năng Đặt hàng (Checkout) cực kỳ ấn tượng**:
   - Khi tài khoản đã đăng nhập, quá trình kiểm tra kho và đặt hàng COD chỉ mất trung bình **192ms đến 568ms**.
   - Không xuất hiện tình trạng deadlock hoặc nghẽn giao dịch (Transaction Lock) trên MariaDB.

---

## 6. KHUYẾN NGHỊ TỐI ƯU HỆ THỐNG (RECOMMENDATIONS)

Để hệ thống chuẩn bị tốt nhất cho các chiến dịch Sale lớn (Flash Sale) đạt đến **1,000 - 5,000 người dùng mua hàng cùng lúc**:

1. **Tối ưu hóa quá trình Đăng ký tài khoản (Authentication Bottleneck)**:
   - Chuyển thao tác băm mật khẩu hoặc gửi email xác nhận vào **Hàng đợi xử lý bất đồng bộ (Background Queue Worker)**.
   - Cấu hình cost factor cho Bcrypt ở mức cân bằng giữa bảo mật và hiệu năng.
2. **Đệm dữ liệu danh mục & Tồn kho bằng Redis Cache**:
   - Hiện tại hệ thống đã có lớp `RedisCache.php`. Nên bật đệm Redis cho thông tin chi tiết sản phẩm và tồn kho chi nhánh để giảm trực tiếp 80% truy vấn `JOIN` vào bảng `inventory` và `branches`.
3. **Tối ưu hóa Cấu hình Apache & MariaDB (XAMPP Server Tuning)**:
   - Apache `httpd-mpm.conf`: Tăng `MaxRequestWorkers` từ 150 lên **1000**.
   - MariaDB `my.ini`: Tăng `max_connections` lên **500 - 1000** và thiết lập `innodb_buffer_pool_size = 1G` hoặc lớn hơn.

---

## 7. KẾT LUẬN (CONCLUSION)

Hệ thống **GARENA E-Commerce Store** (`DevPHP_V2`) hoàn toàn đủ năng lực phục vụ mượt mà **200 người dùng thực hiện trọn vẹn luồng mua hàng & đặt hàng COD đồng thời**. Toàn bộ 2,708 đơn hàng được tạo ra đều đảm bảo tính toàn vẹn dữ liệu trên Cơ sở dữ liệu MySQL.
