# Flash Sale Countdown & Admin Management Design Document

## 1. Overview
This feature allows Admin users to manage Flash Sale promotions dynamically. Administrators can set the Flash Sale title, end datetime, and toggle enable/disable state from the Admin panel. The front-end homepage ([HomePage.php](file:///c:/xampp/htdocs/DevPHP_V2/modules/Users/page/HomePage.php)) will dynamically display the program title and render a real-time countdown timer (Hours:Minutes:Seconds) updating every second.

## 2. Configuration Storage
File: `config/flash_sale.json`
```json
{
  "title": "HOT SALE GIÁ SỐC",
  "end_time": "2026-09-25T23:59:00",
  "status": 1
}
```

## 3. Admin Management Page
File: `modules/Admin/FlashSale/FlashSale.php`
Route: `Admin.php?page=flash_sale` or `Admin.php?subpage=modules/Admin/FlashSale/FlashSale.php`

### Form Controls:
- **Title (Tiêu đề chương trình)**: Text input (e.g., "HOT SALE GIÁ SỐC", "SIÊU SALE 10/10").
- **End Datetime (Thời gian kết thúc)**: Datetime picker (`<input type="datetime-local" name="end_time">`).
- **Status (Trạng thái)**: Toggle checkbox or radio buttons (Bật / Tắt).
- **Save Action**: POST request writes JSON payload back to `config/flash_sale.json` and triggers a SweetAlert success alert.

### Admin Sidebar Integration:
File: `modules/Admin/Sidebar/Sidebar.php`
- Add menu item **"Quản lý Flash Sale"** with icon `bi bi-lightning-fill`.

## 4. User Front-End Integration
File: `modules/Users/page/HomePage.php`

- Loads `config/flash_sale.json`.
- Displays dynamic Title next to the lightning bolt icon:
  `<?= htmlspecialchars($flashSaleConfig['title'] ?? 'HOT SALE GIÁ SỐC') ?>`
- Real-time JavaScript countdown timer script (`setInterval` 1000ms):
  - Parses target `end_time`.
  - Calculates remaining Hours, Minutes, Seconds.
  - Updates `<span class="countdown-item">HH</span> : <span class="countdown-item">MM</span> : <span class="countdown-item">SS</span>` elements live.
  - If `status == 0` or target time reached/passed, displays `00 : 00 : 00` or hides countdown gracefully.

## 5. Verification Plan
- Admin tests setting title, date/time, and status in `FlashSale.php`.
- Front-end tests loading `HomePage.php` and verifying title matches Admin setting and timer decrements every second.
