# Thiết kế Tính năng AI Tư Vấn & So Sánh Giá Thị Trường (PHP + Python + Gemini API)

## 1. Tổng quan
Tính năng tích hợp AI Trợ lý thông minh vào dự án E-Commerce (DevPHP_V2). Khi khách hàng hỏi trên Chatbox, AI có khả năng:
1. Tra cứu danh sách sản phẩm tại Shop theo tiêu chí (giá, cấu hình, loại sản phẩm).
2. Tra cứu dữ liệu giá thị trường từ các đối thủ (TGDD, CellphoneS, FPT Shop,...) đã được bộ cào Python thu thập vào MySQL.
3. Đưa ra câu trả lời tư vấn và so sánh giá trực quan cho khách hàng.

---

## 2. Kiến trúc Hệ thống (System Architecture)

```
[Khách hàng / Chatbox Frontend]
           │
           ▼
[PHP Backend (ChatController / GeminiService)]
     │                  │
     │ (Function call)  │ (API Call)
     ▼                  ▼
[MySQL Database]    [Google Gemini API]
  - products           (gemini-2.0-flash / 1.5-flash)
  - competitor_prices
     ▲
     │ (Quét định kỳ)
[Python Scraper Script]
  - BeautifulSoup / Playwright
  - Thu thập từ TGDD, CellphoneS, FPT Shop...
```

---

## 3. Chi tiết các Thành phần

### A. Cơ sở dữ liệu (MySQL Database)
Tạo bảng mới `competitor_prices`:
- `id` (INT, Primary Key, AUTO_INCREMENT)
- `product_id` (INT, FK nối với bảng `products.id` - nullable)
- `website_name` (VARCHAR: "TGDD", "CellphoneS", "FPT Shop",...)
- `competitor_product_name` (VARCHAR: Tên sản phẩm trên web đối thủ)
- `price` (DECIMAL/BIGINT: Giá bán hiện tại)
- `competitor_url` (TEXT: Link gốc sản phẩm)
- `updated_at` (DATETIME: Thời gian cập nhật gần nhất)

### B. Bộ Cào Dữ Liệu Python (`python_scraper/`)
- Thư mục: `scripts/scraper/`
- Thư viện: `python-dotenv`, `mysql-connector-python`, `beautifulsoup4`, `requests` (hoặc `playwright` đối với web render JS).
- Chức năng:
  1. Đọc danh sách sản phẩm đang bán tại shop từ bảng `products`.
  2. Tìm kiếm / Cào thông tin giá của sản phẩm tương ứng trên các trang đối thủ.
  3. Cập nhật / Insert dữ liệu vào bảng `competitor_prices`.
  4. Hỗ trợ chạy thủ công hoặc lên lịch tự động bằng Windows Task Scheduler / Cron Job.

### C. Dịch vụ AI & Integration trong PHP Backend
- Thư mục `controllers/GeminiService.php` hoặc `controllers/AiChatController.php`:
- Tích hợp **Google Gemini API** (sử dụng GuzzleHTTP gọi REST API endpoint của Gemini 2.0 Flash / 1.5 Flash).
- Xử lý **Function Calling (Tools)** hoặc **System Prompt Context**:
  - `search_shop_products($keyword, $max_price, $min_price)`: Tìm sản phẩm trong DB nội bộ.
  - `get_competitor_prices($product_id)`: Lấy giá các đối thủ từ bảng `competitor_prices`.
- AI tổng hợp thông tin và trả lời câu hỏi trực tiếp cho người dùng qua khung chat ([chatBox.php](file:///c:/xampp/htdocs/DevPHP_V2/chatBox.php)).

---

## 4. Kịch bản Luồng xử lý (Data Flow)

1. **Khách hàng gửi câu hỏi**: *"Shop mình có laptop nào dưới 15 triệu không?"*
2. **PHP Backend**:
   - Gửi yêu cầu tới Gemini API kèm danh mục/dữ liệu sản phẩm dưới 15 triệu từ DB shop.
   - Gemini phản hồi: *"Hiện shop có 4 mẫu dưới 15 triệu. Trong đó ASUS Vivobook 15 X1504VA có giá 14,99 triệu."*
3. **Khách hỏi tiếp**: *"Laptop này bên ngoài bán bao nhiêu?"*
4. **PHP Backend**:
   - Nhận diện ngữ cảnh sản phẩm "ASUS Vivobook 15 X1504VA".
   - Đọc bảng `competitor_prices` lấy giá từ các web đối thủ.
   - Gửi prompt cùng dữ liệu so sánh giá cho Gemini.
   - Gemini trả lời theo format so sánh như mẫu yêu cầu.

---

## 5. Kế hoạch xác minh (Verification Plan)
- **Kiểm tra Python Scraper**: Chạy script cào thử dữ liệu 1 số laptop mẫu và kiểm tra dữ liệu trong bảng `competitor_prices`.
- **Kiểm tra Gemini Integration**: Test API Gemini trả về thông tin tư vấn và so sánh giá chính xác theo DB.
- **Kiểm tra Chat UI**: Thử nghiệm hội thoại thực tế trên giao diện Chatbox của website.
