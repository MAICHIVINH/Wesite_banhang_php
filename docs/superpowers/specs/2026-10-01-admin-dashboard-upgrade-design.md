# Design Spec: Admin Dashboard Upgrade

**Date:** 2026-10-01  
**Status:** Approved  
**Target File:** `modules/Admin/Dashboard/index.php`, `models/Order.php`, `controllers/OrderController.php`, `models/Product.php`, `controllers/ProductController.php`

---

## 1. Overview
The Admin Dashboard (`modules/Admin/Dashboard/index.php`) currently lacks core financial indicators, real-time revenue metrics, product inventory warnings, and actionable tables. This specification outlines the complete architectural and UI upgrade for the Admin Dashboard.

---

## 2. Core Requirements & Metrics

### 2.1. KPI Cards (Top Section)
1. **Total Users (`$totalUsers`):** Total active users with Excel export option.
2. **Total Products (`$totalProducts`):** Total active products with Excel export option.
3. **Total & Weekly Orders (`$totalOrders` & `$ordersThisWeek`):** Total orders all time + orders created this week.
4. **Total Revenue (`$totalRevenue`):** Actual monetary revenue (VND) calculated from completed orders (`status_id = 6`, `isDeleted = 0`).
5. **Low Stock Warning (`$lowStockCount`):** Count of active products with stock quantity <= 10.

### 2.2. Interactive Charts (Chart.js)
1. **Monthly New Customers (Bar Chart):** 12-month registration trend.
2. **Daily Revenue Trend - Last 7 Days (Line Chart):** Real-time daily revenue aggregated from CSDL (`orders` table).
3. **Order Status Distribution (Doughnut Chart):** Visual proportion of orders by status (Pending, Confirmed, Shipping, Delivered, Canceled, Success).

### 2.3. Insight Data Tables (Bottom Section)
1. **Top 5 Selling Products:** Image, Product Name, Units Sold, and Total Generated Revenue.
2. **5 Recent Orders:** Order Code, Customer Name, Total Amount, Status Badge, and Quick Link to Order Detail.

---

## 3. Data Flow & Backend Method Requirements

### 3.1. `Order` Model (`models/Order.php`) & `OrderController`
- `getTotalRevenue()`:
  ```sql
  SELECT SUM(total_amount) FROM orders WHERE isDeleted = 0 AND status_id = 6
  ```
- `getRevenueLast7Days()`:
  ```sql
  SELECT DATE(create_at) as order_date, SUM(total_amount) as daily_revenue
  FROM orders
  WHERE isDeleted = 0 AND status_id = 6 AND create_at >= CURDATE() - INTERVAL 6 DAY
  GROUP BY DATE(create_at)
  ORDER BY order_date ASC
  ```
- `getRecentOrders($limit = 5)`:
  ```sql
  SELECT o.id, o.code, o.total_amount, o.create_at, s.name as status_name, u.FullName as user_name
  FROM orders o
  JOIN status s ON o.status_id = s.id
  JOIN users u ON o.user_id = u.id
  WHERE o.isDeleted = 0
  ORDER BY o.id DESC LIMIT 5
  ```

### 3.2. `Product` Model (`models/Product.php`) & `ProductController`
- `countLowStock($threshold = 10)`:
  ```sql
  SELECT COUNT(*) FROM products WHERE isDeleted = 0 AND quantity <= 10
  ```
- `getTopSellingProducts($limit = 5)`:
  ```sql
  SELECT p.id, p.name, p.image, SUM(oi.quantity) as total_sold, SUM(oi.quantity * oi.price) as total_revenue
  FROM order_items oi
  JOIN products p ON oi.product_id = p.id
  JOIN orders o ON oi.order_id = o.id
  WHERE o.isDeleted = 0 AND o.status_id = 6
  GROUP BY p.id, p.name, p.image
  ORDER BY total_sold DESC LIMIT 5
  ```

---

## 4. UI / UX Design Specifications

- **Theme:** Clean Bootstrap 5 dashboard layout with custom gradient KPI cards and responsive grid.
- **Color Palette:**
  - Users: Blue Gradient (`#6a11cb` to `#2575fc`)
  - Products: Emerald Gradient (`#11998e` to `#38ef7d`)
  - Orders: Warm Amber Gradient (`#f7971e` to `#ffd200`)
  - Revenue: Success Green Gradient (`#56ab2f` to `#a8e063`)
  - Low Stock Warning: Red Crimson Gradient (`#ff416c` to `#ff4b2b`)
- **Formatting:** Currency numbers formatted as `1.500.000 ₫` using `number_format()`.

---

## 5. Verification & Testing Strategy
1. **Database Queries:** Verify query execution efficiency and handling of zero/null revenue.
2. **Chart Rendering:** Ensure Chart.js renders cleanly without console errors when dataset is empty or populated.
3. **UI Responsiveness:** Validate layout on desktop and tablet screens.
