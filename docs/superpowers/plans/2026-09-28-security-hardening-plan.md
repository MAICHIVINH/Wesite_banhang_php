# Kế hoạch Gia cố Bảo mật cho Dự án DevPHP_V2 (Security Hardening Implementation Plan)

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Khắc phục các lỗ hổng bảo mật quan trọng (Credentials, CSRF, Session Cookie, Dynamic Column SQLi, Upload Execution, XSS Output Escaping) để đưa website DevPHP_V2 đạt tiêu chuẩn sẵn sàng triển khai thực tế (Production Ready).

**Architecture:** Sử dụng kiến trúc MVC PHP hiện có: tạo helper CSRF chuyên biệt trong `core/Csrf.php`, cấu hình thông tin nhạy cảm tập trung qua `Dotenv`, thắt chặt kiểm tra tên cột trong `core/Models.php`, thêm quy tắc chặn thực thi file trong `uploads/.htaccess`, và áp dụng mã hóa đầu ra chống XSS.

**Tech Stack:** PHP 8.x, PDO MySQL, vlucas/phpdotenv, Apache (.htaccess), Native PHP Sessions.

## Global Constraints

- Không làm thay đổi giao diện hoặc luồng nghiệp vụ hiện tại của ứng dụng.
- Đảm bảo tương thích ngược với dữ liệu và hệ thống Model PDO hiện tại.
- Tất cả dữ liệu đầu ra hiển thị ở Views đều phải qua hàm sanitize/escape HTML.

---

### Task 1: Chuyển cấu hình nhạy cảm sang tập tin môi trường `.env`

**Files:**
- Modify: `config/.env`
- Modify: `config/database.php`

**Interfaces:**
- Consumes: `vlucas/phpdotenv` (đã được nạp ở autoload)
- Produces: `Database::getInstance()` lấy thông tin DB từ `$_ENV` thay vì hardcode.

- [ ] **Step 1: Viết cấu hình mẫu chuẩn trong `config/.env`**

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=electronic_shop
DB_USER=root
DB_PASS=
DB_CHARSET=utf8mb4

APP_ENV=production
APP_DEBUG=false
```

- [ ] **Step 2: Cập nhật `config/database.php` đọc thông tin từ `$_ENV`**

```php
<?php
use Dotenv\Dotenv;

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $envFile = __DIR__ . '/.env';
        if (file_exists($envFile)) {
            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->safeLoad();
        }

        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $db   = $_ENV['DB_NAME'] ?? 'electronic_shop';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';
        $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $this->pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
```

- [ ] **Step 3: Kiểm tra kết nối Database hoạt động bình thường**

Chạy kiểm tra lại các trang có truy vấn DB.

---

### Task 2: Cấu hình an toàn cho PHP Session & Session Cookie

**Files:**
- Modify: `index.php:1-15`
- Modify: `Auth/LoginLogic.php`

**Interfaces:**
- Consumes: Native PHP Session
- Produces: Secure Session Cookie flags (`HttpOnly`, `SameSite=Lax`, `Secure` trên HTTPS).

- [ ] **Step 1: Viết mã thiết lập tham số bảo mật session trước khi gọi `session_start()`**

```php
if (session_status() === PHP_SESSION_NONE) {
    $isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    session_set_cookie_params([
        'lifetime' => 86400,
        'path' => '/',
        'domain' => '',
        'secure' => $isSecure,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}
```

- [ ] **Step 2: Thêm cơ chế regenerate session ID khi đăng nhập thành công**

Trong `Auth/LoginLogic.php`, sau khi xác thực tài khoản thành công:

```php
session_regenerate_id(true);
```

---

### Task 3: Xây dựng CSRF Protection & Tích hợp vào Form Đăng nhập / Thao tác

**Files:**
- Create: `core/Csrf.php`
- Modify: `Auth/Login.php`
- Modify: `Auth/LoginLogic.php`

**Interfaces:**
- Consumes: `$_SESSION`, `$_POST`
- Produces: `Csrf::getToken()`, `Csrf::verifyToken($_POST['csrf_token'])`

- [ ] **Step 1: Tạo lớp `core/Csrf.php`**

```php
<?php

class Csrf
{
    public static function generateToken(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyToken(?string $token): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function field(): string
    {
        $token = self::generateToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
```

- [ ] **Step 2: Thêm field CSRF vào Form `Auth/Login.php`**

Chèn `<?= Csrf::field(); ?>` bên trong các `<form method="POST">`.

- [ ] **Step 3: Kiểm tra Token CSRF trong `Auth/LoginLogic.php`**

```php
require_once __DIR__ . '/../core/Csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if (!Csrf::verifyToken($_POST['csrf_token'] ?? '')) {
        die('Yêu cầu không hợp lệ (CSRF Token mismatch).');
    }
    // Tiến hành xác thực đăng nhập...
}
```

---

### Task 4: Chống SQL Injection cho các hàm Dynamic Column trong `core/Models.php`

**Files:**
- Modify: `core/Models.php:99-195`

**Interfaces:**
- Consumes: Tên cột `$column` truyền vào hàm
- Produces: Sanitize / Whitelist kiểm tra tên cột chỉ chứa kí tự chữ cái, số và dấu gạch dưới (`[a-zA-Z0-9_]`).

- [ ] **Step 1: Thêm hàm validate tên cột trong `core/Models.php`**

```php
protected function sanitizeColumn(string $column): string
{
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $column)) {
        throw new InvalidArgumentException("Tên cột không hợp lệ: " . htmlspecialchars($column));
    }
    return $column;
}
```

- [ ] **Step 2: Áp dụng `sanitizeColumn` cho `getByColumn`, `deleteByColumn`, `updateDeletedByColumn`**

```php
public function getByColumn(string $column, $value): array
{
    $cleanColumn = $this->sanitizeColumn($column);
    $sql = "SELECT * FROM {$this->table} WHERE {$cleanColumn} = :value";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['value' => $value]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
```

---

### Task 5: Chặn thực thi mã PHP trong thư mục Uploads

**Files:**
- Create: `uploads/.htaccess`

**Interfaces:**
- Consumes: Cấu hình web server Apache
- Produces: Chặn tuyệt đối việc truy cập/thực thi file `.php` trong `uploads/`.

- [ ] **Step 1: Tạo file `uploads/.htaccess`**

```apache
# Chặn thực thi tập tin script trong thư mục uploads
<FilesMatch "\.(php|php3|php4|php5|phtml|pl|py|jsp|asp|htm|html|shtml|sh|cgi)$">
    SetHandler none
    SetHandler default-handler
    Options -ExecCGI
    RemoveHandler .php .phtml .php5
    <IfModule mod_authz_core.c>
        Require all denied
    </IfModule>
    <IfModule !mod_authz_core.c>
        Order allow,deny
        Deny from all
    </IfModule>
</FilesMatch>
```

---

### Task 6: Escape dữ liệu đầu ra chống XSS (HTML Escaping Helper)

**Files:**
- Create: `core/Helper.php`
- Modify: `index.php` (require helper)

**Interfaces:**
- Consumes: Chuỗi ký tự từ DB hoặc Input
- Produces: Chuỗi ký tự đã được escape an toàn hiển thị ra HTML.

- [ ] **Step 1: Viết hàm `e($string)` trong `core/Helper.php`**

```php
<?php

if (!function_exists('e')) {
    function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}
```

- [ ] **Step 2: Require `core/Helper.php` vào ứng dụng chính và thay thế hiển thị dữ liệu người dùng dùng `<?= e($val) ?>`**

---

## Verification & Final Security Audit Checklist

- [ ] Xóa bỏ hoàn toàn thông tin mật khẩu DB hardcode.
- [ ] Thử submit form Đăng nhập mà không gửi CSRF Token -> Hệ thống phải từ chối.
- [ ] Kiểm tra Session Cookie trong Developer Tools (F12 -> Application -> Cookies) -> Phải có cờ `HttpOnly` và `SameSite=Lax`.
- [ ] Thử truy cập trực tiếp 1 file PHP giả lập trong `uploads/test.php` -> Apache trả về 403 Forbidden.
