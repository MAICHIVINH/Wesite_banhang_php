# Excel Product Import Implementation Plan (Option 3)

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Implement batch product import from Excel (.xlsx) files with Category/Supplier auto-matching, sample template download, and initial stock initialization.

**Architecture:** Add helper methods in `Category`, `Supplier`, `Inventory`, and `ProductController` for Excel parsing and auto-matching, then add the modal & UI buttons in `modules/Admin/Products/Product.php`.

**Tech Stack:** PHP, PhpSpreadsheet, Bootstrap 5, MySQL.

## Global Constraints
- Target Files: `modules/Admin/Products/Product.php`, `controllers/ProductController.php`, `models/Category.php`, `models/Supplier.php`, `models/Inventory.php`
- Default Fallback Image: `public/uploads/default-product.jpg`
- Default Stock Quantity: `10`

---

### Task 1: Add Category and Supplier Name Resolution Methods

**Files:**
- Modify: `models/Category.php`
- Modify: `controllers/CategoryController.php`
- Modify: `models/Supplier.php`
- Modify: `controllers/SupplierController.php`

- [ ] **Step 1: Add `findByNameOrCreate` method to `models/Category.php`**

```php
public function findByNameOrCreate($name)
{
    $name = trim($name);
    if (empty($name)) return 1;

    if (is_numeric($name)) {
        $found = $this->find((int)$name);
        if ($found) return (int)$name;
    }

    $sql = "SELECT id FROM {$this->table} WHERE LOWER(name) = LOWER(:name) AND isDeleted = 0 LIMIT 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['name' => $name]);
    $catId = $stmt->fetchColumn();

    if ($catId) {
        return (int)$catId;
    }

    // Insert new category if not found
    $insertSql = "INSERT INTO {$this->table} (name, isDeleted) VALUES (:name, 0)";
    $insertStmt = $this->pdo->prepare($insertSql);
    $insertStmt->execute(['name' => $name]);
    return (int)$this->pdo->lastInsertId();
}
```

- [ ] **Step 2: Expose `findByNameOrCreate` in `controllers/CategoryController.php`**

- [ ] **Step 3: Add `findByNameOrCreate` method to `models/Supplier.php`**

```php
public function findByNameOrCreate($name)
{
    $name = trim($name);
    if (empty($name)) return 1;

    if (is_numeric($name)) {
        $found = $this->find((int)$name);
        if ($found) return (int)$name;
    }

    $sql = "SELECT id FROM {$this->table} WHERE LOWER(name) = LOWER(:name) AND isDeleted = 0 LIMIT 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['name' => $name]);
    $supId = $stmt->fetchColumn();

    if ($supId) {
        return (int)$supId;
    }

    // Insert new supplier if not found
    $insertSql = "INSERT INTO {$this->table} (name, isDeleted) VALUES (:name, 0)";
    $insertStmt = $this->pdo->prepare($insertSql);
    $insertStmt->execute(['name' => $name]);
    return (int)$this->pdo->lastInsertId();
}
```

- [ ] **Step 4: Expose `findByNameOrCreate` in `controllers/SupplierController.php`**

- [ ] **Step 5: Syntax check PHP files**

---

### Task 2: Implement Excel Sample Template Generation and Batch Import Logic

**Files:**
- Modify: `controllers/ProductController.php`

- [ ] **Step 1: Implement `exportSampleProductExcel()` in `controllers/ProductController.php`**
  - Create spreadsheet with 2 sheets.
  - Sheet 1: Columns (Tên sản phẩm, Giá bán, Giảm giá %, Loại sản phẩm, Nhà cung cấp, Số lượng tồn kho, URL hình ảnh, Mô tả ngắn, Nội dung chi tiết).
  - Sheet 2: Reference lists of existing categories and suppliers.
  - Output `.xlsx` file download.

- [ ] **Step 2: Implement `importProductsExcel($filePath)` in `controllers/ProductController.php`**
  - Load Excel using PhpSpreadsheet `IOFactory::load`.
  - Loop through rows starting from row 2.
  - Parse fields, resolve `category_id` and `supplier_id` using `CategoryController` and `SupplierController`.
  - Add product via `productModel->insert($data)`.
  - Add initial inventory via `inventoryModel->insert(['product_id' => $newId, 'stock_quantity' => $qty, 'branch_id' => 1])`.
  - Return result array `['success' => true, 'count' => $importedCount]`.

- [ ] **Step 3: Syntax check `controllers/ProductController.php`**

---

### Task 3: Update Product UI and Excel Import Modal

**Files:**
- Modify: `modules/Admin/Products/Product.php`

- [ ] **Step 1: Add "Nhập từ Excel" button and Modal `#importExcelModal`**
- [ ] **Step 2: Add PHP handler for `download_sample_excel` and `import_excel_product`**
- [ ] **Step 3: Syntax check `modules/Admin/Products/Product.php`**

---

### Task 4: Verification and Testing

- [ ] **Step 1: Verify syntax on all touched files**
- [ ] **Step 2: Verify sample template download and import process**
