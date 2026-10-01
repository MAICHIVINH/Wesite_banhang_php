# Hướng Dẫn Kiểm Thử Chịu Tải (Load Testing) Với Grafana k6

Tài liệu này hướng dẫn cách cài đặt và chạy kịch bản kiểm thử chịu tải k6 cho hệ thống website **GARENA E-Commerce Store** (`DevPHP_V2`) với các mốc **500 người dùng -> 1,000 người dùng -> 5,000 người dùng concurrent (VUs)**.

---

## 1. Cài Đặt Grafana k6 trên Windows

Bạn có thể cài đặt k6 theo một trong các cách sau:

### Cách 1: Sử dụng Winget (Khuyến nghị trên Windows 10/11)
Mở PowerShell (hoặc CMD) với quyền Administrator và chạy:
```powershell
winget install k6 --source winget
```

### Cách 2: Sử dụng Chocolatey
```powershell
choco install k6
```

### Cách 3: Sử dụng Docker (Không cần cài k6 trực tiếp)
```bash
docker run --rm -i grafana/k6 run - <scripts/k6_load_test.js
```

### Cách 4: Tải file `.exe` cài đặt thủ công
Tải bản cài đặt mới nhất từ trang chủ Grafana k6: https://k6.io/docs/get-started/installation/

---

## 2. Cấu Trúc Kịch Bản Kiểm Thử (`scripts/k6_load_test.js`)

Kịch bản mô phỏng luồng người dùng (User Journey) gồm 4 bước:
1. **01_Homepage**: Truy cập trang chủ (`/index.php`).
2. **02_SearchProduct**: Tìm kiếm sản phẩm (`/index.php?act=product&keyword=laptop`).
3. **03_ProductDetail**: Xem chi tiết sản phẩm (`/index.php?act=product_detail&id=1`).
4. **04_AddToCart**: Thao tác thêm sản phẩm vào giỏ hàng.

### Mức tải & Thời gian kiểm thử (Stages):
- **Giai đoạn 1 (0 -> 500 VUs)**: Ramp-up trong 1 phút.
- **Giai đoạn 2 (Duy trì 500 VUs)**: Chạy ổn định trong 2 phút.
- **Giai đoạn 3 (500 -> 1,000 VUs)**: Tăng tải trong 1 phút.
- **Giai đoạn 4 (Duy trì 1,000 VUs)**: Chạy ổn định trong 2 phút.
- **Giai đoạn 5 (1,000 -> 5,000 VUs)**: Tăng tải đỉnh (Peak Load) trong 2 phút.
- **Giai đoạn 6 (Duy trì 5,000 VUs)**: Chạy đỉnh điểm trong 3 phút.
- **Giai đoạn 7 (5,000 -> 0 VUs)**: Giảm tải hoàn tất trong 1 phút.

---

## 3. Khởi Chạy Kiểm Thử

### 3.1. Chạy với URL mặc định (`http://localhost/DevPHP_V2`)
Mở PowerShell / Terminal tại thư mục gốc của dự án:
```powershell
k6 run scripts/k6_load_test.js
```

### 3.2. Chạy với URL tùy chỉnh (Ví dụ server ảo hoặc IP khác)
```powershell
k6 run -e BASE_URL=http://localhost:8000/DevPHP_V2 scripts/k6_load_test.js
```

### 3.3. Kiểm thử nhanh (Quick Smoke Test - Ví dụ 50 VUs trong 30s)
Nếu bạn muốn thử nghiệm nhanh trước khi chạy bản 5000 users:
```powershell
k6 run --vus 50 --duration 30s scripts/k6_load_test.js
```

---

## 4. Đọc Và Phân Tích Kết Quả

Sau khi chạy xong, k6 sẽ xuất bảng báo cáo với các chỉ số quan trọng:

* **`http_req_failed`**: Tỷ lệ request bị lỗi (SLA yêu cầu `< 5%`).
* **`http_req_duration`**:
  * `avg`: Thời gian phản hồi trung bình.
  * `p(95)`: 95% request hoàn tất dưới mức này (SLA yêu cầu `< 2000ms`).
  * `p(99)`: 99% request hoàn tất dưới mức này.
* **`http_reqs`**: Tổng số request/giây (RPS - Requests Per Second).
* **`vus` & `vus_max`**: Số lượng người dùng ảo đồng thời tại thời điểm test.

---

## 5. Các Mẹo Tối Ưu Hệ Thống Khi Chịu Tải 5,000 VUs

Để XAMPP / Apache / PHP / MariaDB không bị nghẽn ở mức **5,000 VUs**:
1. **Bật Redis Cache**: Kiểm tra file `core/RedisCache.php` và Docker Redis để giảm tải truy vấn SQL lặp lại.
2. **Cấu hình Apache `httpd-mpm.conf`**:
   * Tăng `MaxRequestWorkers` lên 1000 - 2000.
   * Tăng `ThreadsPerChild` trên Windows.
3. **MariaDB `my.ini`**:
   * Tăng `max_connections = 1000`.
   * Tăng `innodb_buffer_pool_size`.
