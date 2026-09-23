# 📱 Mobile-First Design System Upgrade Specification

**Date**: 2026-09-24  
**Project**: DevPHP_V2 (GARENA E-Sports Store & Admin System)  
**Goal**: Redesign and optimize the entire user interface across all screen sizes (Mobile, Tablet, Laptop, Desktop) following Mobile-First design standards to deliver an exceptional customer experience.

---

## 🛠️ 1. Core Architecture & Design System

### 1.1 Viewport & Responsive Meta Setup
- Add `<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">` to both `index.php` and `Admin.php`.
- Ensure standard mobile browser rendering without unintended zooming or desktop fallback shrinking.

### 1.2 Design Tokens (`Style/Users/Header.css` & CSS Variables)
- **Primary Indigo**: `#4F46E5`
- **Secondary Cyan**: `#06B6D4`
- **Background Slate**: `#F8FAFC` / `#FFFFFF`
- **Text Primary**: `#0F172A`
- **Text Muted**: `#64748B`
- **Breakpoints**:
  - `xs`: `< 576px` (Smartphone Small/Medium)
  - `sm`: `>= 576px` (Smartphone Large / Phablet)
  - `md`: `>= 768px` (Tablet / Mobile Landscape)
  - `lg`: `>= 992px` (Laptop / Small Desktop)
  - `xl`: `>= 1200px` (Desktop / Large Screen)

### 1.3 Touch Target & Accessibility Standards
- Minimum touch target area of **44px x 44px** for all interactive elements (buttons, nav links, form fields, icon triggers).
- Fluid typography using CSS `clamp()` and responsive Bootstrap typography classes (`fs-6`, `fs-5`, `fs-4`).

---

## 🛍️ 2. Storefront UI Modules Enhancement

### 2.1 Responsive Header & Mobile Offcanvas Drawer (`Header.php`, `Header.css`)
- **Mobile (< 768px)**:
  - Top bar with Logo, Search Trigger, Cart Badge, and Hamburger Menu Icon.
  - Offcanvas Navigation Drawer sliding from left containing:
    - User Profile / Login status.
    - Category list dropdown/accordion.
    - Supplier filters.
    - Order tracking quick link.
- **Desktop (>= 768px)**:
  - Full width navigation bar with inline brand search, category mega menu, and account actions.

### 2.2 Homepage & Product Grid (`HomePage.php`, `HomePage.css`)
- **Banner Carousel**: Responsive aspect ratio (`16:9` mobile, `21:9` desktop) with lazy-loaded images.
- **Product Cards**: Responsive 2-column grid on mobile (`col-6 col-sm-6`), 3-column on tablet (`col-md-4`), 4-column on desktop (`col-lg-3`).
- Improved card hover states, clear pricing display, and badges.

### 2.3 Product Detail & Mobile Sticky Bottom Bar (`Detail.php`, `Detail.css`)
- Stacked image gallery & thumbnails for touch sliding.
- **Mobile Sticky Action Bar**: Fixed at bottom (`position: fixed; bottom: 0; left: 0; right: 0; z-index: 1000`) on screen width `< 768px` featuring quick "Thêm vào giỏ" and "Mua ngay" buttons.

### 2.4 Cart & Checkout Transformation (`Cart.php`, `Cart.css`, `CheckOrder.php`)
- **Mobile Responsive Table**: Convert traditional `<table>` structure into stacked responsive Card elements on `< 768px` screens.
- **VietQR Modal & Payment Options**: Auto-resizing QR preview container (`max-width: 100%`) with easy tap-to-copy transaction details.

### 2.5 Live Chat Floating Widget (`chatBox.php`, `chatUser.php`, `Chat.css`)
- Floating toggle button at bottom-right (`bottom: 20px; right: 20px;`).
- Mobile adaptive width: `width: calc(100vw - 32px); max-width: 400px;` to prevent horizontal screen overflow.

---

## 🛡️ 3. Admin Panel Responsive Optimization (`Admin.php`, `Style/Admin/*.css`)

### 3.1 Collapsible Responsive Sidebar (`Admin.php`, `Navbar.php`, `style.css`)
- Mobile toggle button in header to expand/collapse sidebar on Tablet & Mobile.
- Smooth CSS transition drawer for admin navigation links.

### 3.2 Data Tables & Map Widget
- Bọc toàn bộ bảng dữ liệu đơn hàng, kho hàng trong `<div class="table-responsive">`.
- Leaflet JS Map (`Admin.php` shipping map) touch gesture optimization and fluid height container.

---

## 🧪 4. Verification & Testing Strategy

1. **Viewport Verification**: Check devtools responsive preview mode for 360px (iPhone SE), 390px (iPhone 14/15), 768px (iPad/Tablet), 1200px+ (Desktop).
2. **Navigation Test**: Test Offcanvas Hamburger Drawer opening/closing on mobile width.
3. **Cart & Checkout Test**: Verify table-to-card layout switch, button touch targets, and VietQR modal layout on mobile width.
4. **Admin Sidebar Test**: Verify sidebar toggle functionality on small screen widths.
