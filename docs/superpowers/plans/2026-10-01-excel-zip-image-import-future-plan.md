# Future Implementation Plan: Excel + ZIP Images Product Batch Import (Option 2)

> **Status:** ARCHIVED / FUTURE PLAN (DO NOT EXECUTE NOW)
> **Goal:** Support batch product import via Excel file (.xlsx) paired with a ZIP archive containing main & extra image files.

## Overview & Concept
Admin uploads a `.xlsx` Excel file containing product data where image columns list local filenames (e.g. `iphone15.jpg`, `iphone15_side.jpg`). Along with the Excel file, Admin uploads a `.zip` archive containing those images. The backend extracts the ZIP, matches images by filename, uploads them to Cloudinary/local storage, and links them to the imported products.

---

## 1. File & Data Schema Specifications

### 1.1. Excel Columns (.xlsx)
1. `Tên sản phẩm` (Required)
2. `Giá bán (VNĐ)` (Required)
3. `Giảm giá (%)` (Optional, 0-100)
4. `Loại sản phẩm` (Required, auto-match by name or ID)
5. `Nhà cung cấp` (Required, auto-match by name or ID)
6. `Số lượng tồn kho` (Optional, default 10)
7. `Tên file ảnh chính` (Filename inside ZIP, e.g. `macbook_m3.jpg`)
8. `Tên file ảnh phụ` (Comma-separated filenames inside ZIP, e.g. `macbook_m3_1.jpg, macbook_m3_2.jpg`)
9. `Mô tả ngắn` (Optional)
10. `Nội dung chi tiết` (Optional)

---

## 2. Technical Architecture & Workflow

### 2.1. Frontend UI (`modules/Admin/Products/Product.php`)
- Modal with two file inputs:
  - Input 1: `excel_file` (`.xlsx`, `.xls`)
  - Input 2: `zip_file` (`.zip`)

### 2.2. Backend Processing (`controllers/ProductController.php`)
- **Step 1: Extract ZIP Archive**
  - Use PHP `ZipArchive` extension to extract `.zip` contents to a temporary directory in `uploads/tmp_zip/<session_id>/`.
- **Step 2: Parse Excel Spreadsheet**
  - Use `PhpOffice\PhpSpreadsheet\IOFactory::load()` to parse row data.
- **Step 3: Image Matching & Cloudinary Upload**
  - For each product row, look for the main image filename in the extracted temp folder.
  - If found, upload to Cloudinary `products/main` via `(new UploadApi())->upload()`.
  - For extra image filenames, split by comma, look up in temp folder, and upload to `products/extra`.
- **Step 4: Database Insertion & Cleanup**
  - Insert product, category/supplier mappings, and inventory stock.
  - Delete temporary extracted files and folder using recursive directory removal.

---

## 3. Verification & Failure Recovery Strategy
- Validate ZIP file format using `ZipArchive::open()`.
- If an image file listed in Excel is missing in the ZIP, log a warning and fallback to default product image.
- Always clean up temporary unzipped folders in `finally` block to prevent disk space leaks.
