# Flash Sale Countdown Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Allow Admin users to set the Flash Sale title, end time, and status, and display a real-time countdown timer with dynamic title on the front-end homepage.

**Architecture:** A JSON config file `config/flash_sale.json` holds the settings. The Admin panel includes a management page to update `config/flash_sale.json`. The user homepage ([HomePage.php](file:///c:/xampp/htdocs/DevPHP_V2/modules/Users/page/HomePage.php)) loads the JSON, displays the title dynamically, and runs a client-side JavaScript countdown timer (`setInterval`) updating every second.

**Tech Stack:** PHP, Bootstrap 5, SweetAlert2, Vanilla JavaScript.

## Global Constraints

- Storage: `config/flash_sale.json`
- Timezone: `Asia/Ho_Chi_Minh`
- Front-End File: `modules/Users/page/HomePage.php`
- Admin Management File: `modules/Admin/FlashSale/FlashSale.php`

---

### Task 1: Create Flash Sale Config & Admin Management Page

**Files:**
- Create: `config/flash_sale.json`
- Create: `modules/Admin/FlashSale/FlashSale.php`
- Modify: `Admin.php` (include routing/navigation for FlashSale module)
- Modify: `modules/Admin/Sidebar/Sidebar.php` (add "Quản lý Flash Sale" link)

**Interfaces:**
- Consumes: POST data from Admin form (`title`, `end_time`, `status`).
- Produces: `config/flash_sale.json` used by front-end.

- [ ] **Step 1: Create initial `config/flash_sale.json`**

Create `config/flash_sale.json` with initial payload:
```json
{
  "title": "HOT SALE GIÁ SỐC",
  "end_time": "2026-09-25T23:59",
  "status": 1
}
```

- [ ] **Step 2: Create Admin Flash Sale page (`modules/Admin/FlashSale/FlashSale.php`)**

Create `modules/Admin/FlashSale/FlashSale.php` handling GET (rendering current config) and POST (updating `config/flash_sale.json`):
```php
<?php
$configFile = __DIR__ . '/../../../config/flash_sale.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_flash_sale'])) {
    $newConfig = [
        'title' => trim($_POST['title'] ?? 'HOT SALE GIÁ SỐC'),
        'end_time' => $_POST['end_time'] ?? date('Y-m-d\TH:i'),
        'status' => isset($_POST['status']) ? (int)$_POST['status'] : 0
    ];

    file_put_contents($configFile, json_encode($newConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    swal_alert('Thành công', 'Cập nhật Flash Sale thành công!', 'success', 'Admin.php?page=flash_sale');
    exit;
}

$flashConfig = [
    'title' => 'HOT SALE GIÁ SỐC',
    'end_time' => date('Y-m-d\TH:i', strtotime('+3 days')),
    'status' => 1
];

if (file_exists($configFile)) {
    $decoded = json_decode(file_get_contents($configFile), true);
    if (is_array($decoded)) {
        $flashConfig = array_merge($flashConfig, $decoded);
    }
}
?>

<div class="container-fluid p-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-danger text-white d-flex align-items-center gap-2">
            <i class="bi bi-lightning-fill fs-4"></i>
            <h5 class="mb-0 fw-bold">QUẢN LÝ THỜI GIAN & TIÊU ĐỀ FLASH SALE</h5>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tiêu đề chương trình Hot Sale:</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($flashConfig['title']) ?>" required>
                    <div class="form-text">Tiêu đề này sẽ hiển thị ở trang chủ cạnh biểu tượng sấm sét.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Thời gian kết thúc (Real-time):</label>
                    <input type="datetime-local" name="end_time" class="form-control" value="<?= htmlspecialchars($flashConfig['end_time']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái chương trình:</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="flashStatus" <?= $flashConfig['status'] == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="flashStatus">Kích hoạt hiển thị đếm ngược Flash Sale trên Trang chủ</label>
                    </div>
                </div>

                <button type="submit" name="save_flash_sale" class="btn btn-danger px-4 fw-bold">
                    <i class="bi bi-save me-1"></i> Lưu cài đặt Flash Sale
                </button>
            </form>
        </div>
    </div>
</div>
```

- [ ] **Step 3: Update `Admin.php` and Sidebar routing**

Add page routing handling in `Admin.php` when `$_GET['page'] === 'flash_sale'` or `$_GET['subpage'] === 'modules/Admin/FlashSale/FlashSale.php'`.
Add menu item in `modules/Admin/Sidebar/Sidebar.php`.

- [ ] **Step 4: Test PHP syntax**

Run: `php -l modules/Admin/FlashSale/FlashSale.php; php -l Admin.php`
Expected: `No syntax errors detected`

---

### Task 2: Implement Real-Time Countdown Timer & Dynamic Title on Front-End Homepage

**Files:**
- Modify: `modules/Users/page/HomePage.php`

**Interfaces:**
- Consumes: `config/flash_sale.json`
- Produces: Dynamic title text and live updating countdown HTML elements.

- [ ] **Step 1: Read `config/flash_sale.json` in `HomePage.php`**

At top of `HomePage.php`:
```php
$flashSaleConfigFile = __DIR__ . '/../../../config/flash_sale.json';
$flashSaleConfig = [
    'title' => 'HOT SALE GIÁ SỐC',
    'end_time' => date('Y-m-d\TH:i', strtotime('+3 days')),
    'status' => 1
];
if (file_exists($flashSaleConfigFile)) {
    $decodedFlash = json_decode(file_get_contents($flashSaleConfigFile), true);
    if (is_array($decodedFlash)) {
        $flashSaleConfig = array_merge($flashSaleConfig, $decodedFlash);
    }
}
```

- [ ] **Step 2: Update Flash Sale Header and add Real-Time Countdown JS**

In `HomePage.php` around line 200:
1. Update title: `<?= htmlspecialchars($flashSaleConfig['title']) ?>`
2. Pass `end_time` and `status` to JavaScript:
```html
<div class="flash-sale-header">
    <div class="flash-sale-title">
        <i class="bi bi-lightning-charge-fill text-warning fs-3"></i> <?= htmlspecialchars($flashSaleConfig['title']) ?>
    </div>
    <?php if ($flashSaleConfig['status'] == 1): ?>
        <div class="countdown-box d-none d-sm-flex">
            <span>KẾT THÚC TRONG:</span>
            <span class="countdown-item" id="cd-hours">00</span> :
            <span class="countdown-item" id="cd-minutes">00</span> :
            <span class="countdown-item" id="cd-seconds">00</span>
        </div>
    <?php endif; ?>
</div>

<script>
    (function() {
        const endTimeStr = "<?= htmlspecialchars($flashSaleConfig['end_time']) ?>";
        const status = <?= (int)$flashSaleConfig['status'] ?>;
        
        if (status !== 1 || !endTimeStr) return;

        const targetDate = new Date(endTimeStr).getTime();
        const hoursEl = document.getElementById('cd-hours');
        const minutesEl = document.getElementById('cd-minutes');
        const secondsEl = document.getElementById('cd-seconds');

        function updateCountdown() {
            const now = new Date().getTime();
            const diff = targetDate - now;

            if (diff <= 0) {
                if (hoursEl) hoursEl.textContent = '00';
                if (minutesEl) minutesEl.textContent = '00';
                if (secondsEl) secondsEl.textContent = '00';
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
            if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
            if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
</script>
```

- [ ] **Step 3: Test PHP syntax**

Run: `php -l modules/Users/page/HomePage.php`
Expected: `No syntax errors detected`
