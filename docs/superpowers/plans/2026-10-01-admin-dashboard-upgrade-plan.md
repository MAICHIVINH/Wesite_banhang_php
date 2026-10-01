# Admin Dashboard Upgrade Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Upgrade the Admin Dashboard with real-time revenue metrics, low-stock alerts, Chart.js trends, and actionable insight tables.

**Architecture:** Extend `Order` and `Product` models and controllers with optimized aggregation queries, then overhaul `modules/Admin/Dashboard/index.php` using Bootstrap 5 and Chart.js.

**Tech Stack:** PHP, MySQL (PDO), Bootstrap 5, FontAwesome, Chart.js.

## Global Constraints
- Target File: `modules/Admin/Dashboard/index.php`
- Model Files: `models/Order.php`, `models/Product.php`
- Controller Files: `controllers/OrderController.php`, `controllers/ProductController.php`
- Currency Formatting: `number_format($value, 0, ',', '.') . ' ₫'`

---

### Task 1: Extend Order Model and Controller for Financial and Recent Order Analytics

**Files:**
- Modify: `models/Order.php`
- Modify: `controllers/OrderController.php`

**Interfaces:**
- Produces:
  - `Order::getTotalRevenue(): float`
  - `Order::getRevenueLast7Days(): array`
  - `Order::getRecentOrders(int $limit = 5): array`
  - `OrderController::getTotalRevenue(): float`
  - `OrderController::getRevenueLast7Days(): array`
  - `OrderController::getRecentOrders(int $limit = 5): array`

- [ ] **Step 1: Add `getTotalRevenue`, `getRevenueLast7Days`, and `getRecentOrders` methods in `models/Order.php`**

```php
public function getTotalRevenue()
{
    $sql = "SELECT SUM(total_amount) FROM {$this->table} WHERE isDeleted = 0 AND status_id = 6";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return (float) ($stmt->fetchColumn() ?? 0);
}

public function getRevenueLast7Days()
{
    $sql = "SELECT DATE(create_at) as order_date, SUM(total_amount) as daily_revenue
            FROM {$this->table}
            WHERE isDeleted = 0 AND status_id = 6 AND create_at >= CURDATE() - INTERVAL 6 DAY
            GROUP BY DATE(create_at)
            ORDER BY order_date ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getRecentOrders($limit = 5)
{
    $sql = "SELECT o.id, o.code, o.total_amount, o.create_at, s.name as status_name, u.FullName as user_name
            FROM {$this->table} o
            JOIN status s ON o.status_id = s.id
            JOIN users u ON o.user_id = u.id
            WHERE o.isDeleted = 0
            ORDER BY o.id DESC LIMIT :limit";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
```

- [ ] **Step 2: Expose these methods in `controllers/OrderController.php`**

```php
public function getTotalRevenue()
{
    return $this->orderModel->getTotalRevenue();
}

public function getRevenueLast7Days()
{
    return $this->orderModel->getRevenueLast7Days();
}

public function getRecentOrders($limit = 5)
{
    return $this->orderModel->getRecentOrders($limit);
}
```

- [ ] **Step 3: Syntax check PHP files**

Run: `php -l models/Order.php` and `php -l controllers/OrderController.php`
Expected output: No syntax errors detected.

---

### Task 2: Extend Product Model and Controller for Low-Stock and Top-Selling Products

**Files:**
- Modify: `models/Product.php`
- Modify: `controllers/ProductController.php`

**Interfaces:**
- Produces:
  - `Product::countLowStock(int $threshold = 10): int`
  - `Product::getTopSellingProducts(int $limit = 5): array`
  - `ProductController::countLowStock(int $threshold = 10): int`
  - `ProductController::getTopSellingProducts(int $limit = 5): array`

- [ ] **Step 1: Add `countLowStock` and `getTopSellingProducts` methods in `models/Product.php`**

```php
public function countLowStock($threshold = 10)
{
    $sql = "SELECT COUNT(*) FROM {$this->table} WHERE isDeleted = 0 AND quantity <= :threshold";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':threshold', (int)$threshold, PDO::PARAM_INT);
    $stmt->execute();
    return (int) $stmt->fetchColumn();
}

public function getTopSellingProducts($limit = 5)
{
    $sql = "SELECT p.id, p.name, p.image, SUM(oi.quantity) as total_sold, SUM(oi.quantity * oi.price) as total_revenue
            FROM order_items oi
            JOIN {$this->table} p ON oi.product_id = p.id
            JOIN orders o ON oi.order_id = o.id
            WHERE p.isDeleted = 0 AND o.isDeleted = 0 AND o.status_id = 6
            GROUP BY p.id, p.name, p.image
            ORDER BY total_sold DESC LIMIT :limit";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
```

- [ ] **Step 2: Expose these methods in `controllers/ProductController.php`**

```php
public function countLowStock($threshold = 10)
{
    return $this->productModel->countLowStock($threshold);
}

public function getTopSellingProducts($limit = 5)
{
    return $this->productModel->getTopSellingProducts($limit);
}
```

- [ ] **Step 3: Syntax check PHP files**

Run: `php -l models/Product.php` and `php -l controllers/ProductController.php`
Expected output: No syntax errors detected.

---

### Task 3: Overhaul `modules/Admin/Dashboard/index.php`

**Files:**
- Modify: `modules/Admin/Dashboard/index.php`

**Interfaces:**
- Consumes:
  - `OrderController::getTotalRevenue()`, `getRevenueLast7Days()`, `getRecentOrders()`
  - `ProductController::countLowStock()`, `getTopSellingProducts()`

- [ ] **Step 1: Fetch analytics data from controllers at top of `modules/Admin/Dashboard/index.php`**
- [ ] **Step 2: Render 5 KPI Cards (Users, Products, Orders, Revenue, Low Stock)**
- [ ] **Step 3: Render 3 Charts (Monthly Customers Bar Chart, 7-Day Revenue Line Chart, Order Status Doughnut Chart)**
- [ ] **Step 4: Render 2 Data Tables (Top 5 Selling Products, 5 Recent Orders)**
- [ ] **Step 5: Syntax check `modules/Admin/Dashboard/index.php`**

Run: `php -l modules/Admin/Dashboard/index.php`
Expected output: No syntax errors detected.

---

### Task 4: End-to-End Verification

- [ ] **Step 1: Check all modified PHP files for lint errors**
- [ ] **Step 2: Verify database query execution on actual XAMPP MySQL instance if available**
