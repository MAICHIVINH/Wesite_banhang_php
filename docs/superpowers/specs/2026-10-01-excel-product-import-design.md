# Design Spec: Excel Batch Product Import (Option 3 - Active Implementation)

**Date:** 2026-10-01  
**Status:** Approved for Active Execution  
**Target Files:**
- `modules/Admin/Products/Product.php`
- `controllers/ProductController.php`
- `models/Product.php`
- `models/Category.php`
- `models/Supplier.php`
- `models/Inventory.php`

---

## 1. Overview
This specification defines the Excel Batch Product Import feature for the Product Management page. Admins can download a pre-formatted sample Excel file, fill in product information, and upload it to import dozens or hundreds of products at once.

---

## 2. Core Requirements & Features

### 2.1. Excel Sample Template Download
- Admin can click **"Tải File Excel Mẫu"** to download `mau_nhap_san_pham.xlsx`.
- **Sheet 1 ("Sản phẩm"):** Contains header row + sample rows.
- **Sheet 2 ("Danh mục & Nhà cung cấp"):** Auto-populated list of current Categories and Suppliers (ID + Name) from the database to guide Admin.

### 2.2. Intelligent Category & Supplier Auto-Matching
When reading Category / Supplier columns:
1. First, check if input is numeric (ID). If `category_id` or `supplier_id` exists in DB $\rightarrow$ use ID.
2. If input is string (e.g. `"Laptop"`, `"Apple"`): Search DB by `name` (case-insensitive & trimmed).
   - If match found $\rightarrow$ use matched ID.
   - If match NOT found $\rightarrow$ automatically create new Category / Supplier in DB and use new ID.

### 2.3. Image Handling (URL & Default Fallback)
- **Main Image:** Reads `image_url` column. If a valid URL is provided $\rightarrow$ save `image_url`. If empty $\rightarrow$ fallback to `'public/uploads/default-product.jpg'`.
- **Extra Images:** If comma-separated URLs are provided in the Extra Images column, parse and insert into `images` table.

### 2.4. Initial Inventory Stock Creation
- If `stock_quantity` is provided in Excel (e.g. `20`) $\rightarrow$ insert stock quantity into `inventory` table for default branch.
- If omitted $\rightarrow$ default to `10` stock items.

---

## 3. UI / UX Design Specifications (`modules/Admin/Products/Product.php`)

- **Top Action Bar:**
  - Add **"Nhập từ Excel"** button (`btn-outline-success`) next to **"Thêm sản phẩm"** button.
- **Modal `#importExcelModal`:**
  - Header: "Nhập sản phẩm hàng loạt từ Excel"
  - Action button: "Tải file Excel mẫu (.xlsx)" (`btn-info btn-sm`)
  - File input: `excel_file` (`accept=".xlsx, .xls"`)
  - Footer: "Bắt đầu Nhập" (`btn-success`) and "Hủy" (`btn-secondary`)

---

## 4. Backend Processing Specs (`ProductController.php`)

Method: `importProductsExcel($filePath)`
1. Load Excel workbook via `PhpOffice\PhpSpreadsheet\IOFactory::load($filePath)`.
2. Select active worksheet, read rows starting from index 2.
3. Validate row data (`name` != '', `price` > 0).
4. Resolve `category_id` & `supplier_id`.
5. Insert product into `products` table.
6. Insert inventory record into `inventory` table (`stock_quantity`, `product_id`, `branch_id`).
7. Return summary: `['success' => true, 'imported_count' => N, 'message' => "Đã nhập thành công N sản phẩm"]`.
