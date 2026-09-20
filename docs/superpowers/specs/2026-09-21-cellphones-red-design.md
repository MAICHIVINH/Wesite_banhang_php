# Design Specification: CellphoneS Red Classic UI/UX Overhaul

- **Date**: 2026-09-21
- **Project**: DevPHP_V2 (Garena Electronics Store)
- **Target Audience**: End-Users (Khách hàng mua laptop & thiết bị công nghệ)
- **Design Inspiration**: CellphoneS / Thế Giới Di Động (TGDD) E-Commerce UI/UX

---

## 1. Overview & Objectives

The goal of this overhaul is to transform the user-facing interface of the Garena PHP E-Commerce platform into a high-converting, modern, premium, and mobile-responsive online retail store inspired by CellphoneS Red Classic theme.

### Key Objectives:
1. **Brand Identity & Color System**: Establish a strong, bold CellphoneS-inspired crimson red palette (`#D70018`) with clean light grey page background (`#F4F6F8`) and crisp white card containers (`#FFFFFF`).
2. **Enhanced Header & Navigation**: Build a sticky header with a mega menu category dropdown, autosuggest search bar with hot keyword tags, quick utility links (Hotline, Store locations, Order lookup, Cart badge, User account).
3. **High-Impact Hero Section**: 3-column top hero layout (Left category menu, Center promo slider with tab previews, Right stacked banners) followed by a 4-pillar trust & service badge bar.
4. **Flash Sale & Hot Deals Container**: Dynamic red gradient box with countdown timer, percentage badges (`-25%`), and stock progress bars (`Đã bán 12/20`).
5. **Modernized Product Card Grid**: Card elevation on hover, high-contrast price tag, discount percentage badge, spec tag pills (RAM, SSD, CPU), star rating, and quick action buttons.
6. **Conversion-Optimized Product Detail (`Detail.php`)**: 2-column layout featuring an image gallery slider, prominent sticky buy box, promotional offer checklist box, color/spec variant pills, bold "MUA NGAY" & "THÊM VÀO GIỎ" actions, and formatted tech spec table.
7. **Seamless Cart & Checkout (`Cart.php`)**: 4-step progress wizard with clear pricing breakdown and PayOS QR Code integration.

---

## 2. Design System & Palette

| Token | Hex / Value | Application |
|---|---|---|
| **Primary Brand** | `#D70018` | Top header background, Primary CTA buttons ("MUA NGAY"), Sale badges, Active indicators |
| **Primary Hover** | `#B20014` | Hover state for primary buttons and interactive elements |
| **Page Background** | `#F4F6F8` | Light cool grey background for section contrast |
| **Card Background** | `#FFFFFF` | Product cards, detail panels, checkout forms |
| **Borders** | `#E5E7EB` | 1px clean neutral border for card structures |
| **Shadow** | `0 2px 8px rgba(0,0,0,0.06)` | Elevated cards and dropdown menus |
| **Text Primary** | `#111827` | Headings, product titles, bold prices |
| **Text Secondary** | `#4B5563` | Body copy, secondary specifications |
| **Text Muted** | `#9CA3AF` | Strikethrough original prices, dates, placeholders |
| **Border Radius** | `10px - 12px` | Consistent card, badge, and button corner rounding |

---

## 3. Detailed Component & Page Specifications

### 3.1 Global Header & Navigation (`modules/Users/Layout/Header.php`, `Style/Users/Header.css`)
- **Sticky Navbar**: Height ~70px, background `#D70018`, text white.
- **Logo**: Bold "GARENA" typography with modern tech laptop icon.
- **Category Button**: Dropdown pill with `bi bi-list`, opening a vertical Mega Menu overlay listing all categories with icons.
- **Search Bar**:
  - Full-rounded input field (`border-radius: 50px`).
  - Search icon button on right.
  - Hot Search Tags below search bar: `Laptop Gaming`, `MacBook Air`, `RAM 16GB`, `Bàn phím cơ`.
  - Dropdown autosuggest results box.
- **Header Utility Actions**:
  - `Hotline: 1800.6789` (Clickable call link)
  - `Cửa hàng` (Store finder modal/page link)
  - `Tra cứu đơn hàng` (Direct link to `CheckOrder.php`)
  - `Giỏ hàng` (Cart icon with yellow/red badge count badge)
  - `Tài khoản` (User dropdown / Modal trigger)

### 3.2 Homepage Layout (`modules/Users/page/HomePage.php`, `Style/Users/HomePage.css`)
1. **3-Column Hero Section**:
   - **Left Column (22% width)**: Vertical category menu with clean icons & sub-flyout menus.
   - **Center Column (56% width)**: Main Banner Carousel + 4 bottom tab preview triggers.
   - **Right Column (22% width)**: 2 stacked promo banners (Trade-in 0%, Installment 0%).
2. **Trust & Service Badges Bar**:
   - 4-item horizontal grid below Hero:
     - 🛡️ 100% Hàng chính hãng
     - 🚚 Miễn phí vận chuyển toàn quốc
     - 🔄 1 Đổi 1 trong 30 ngày
     - 🎧 Hỗ trợ kỹ thuật 24/7
3. **Flash Sale Container**:
   - Red gradient background (`linear-gradient(135deg, #d70018, #ff4d4d)`).
   - "HOT SALE GIÁ SỐC" title + Live countdown timer (`HH : MM : SS`).
   - Horizontal slider or 5-column product card grid.
   - Progress bar showing units sold ("🔥 Đã bán x/y").
4. **Category Sections (Laptop Gaming, Office Laptops, PC Build, Accessories)**:
   - Header with category title + Brand Tag Pills (ASUS, Acer, MSI, Lenovo, Dell, HP, Apple).
   - 5-column grid on desktop, 2-column grid on mobile.

### 3.3 Product Card Component (`Style/Users/Product.css`)
- **Structure**: White card, `border-radius: 10px`, `border: 1px solid #E5E7EB`.
- **Hover Effect**: `transform: translateY(-4px)`, shadow deepens to `0 8px 20px rgba(0,0,0,0.1)`.
- **Top Badge**: Discount badge top-left (`-15%` or `Giảm 2.5TR`).
- **Product Image**: Square ratio (1:1), centered, object-fit contain, subtle zoom on hover.
- **Product Title**: Max 2 lines with ellipsis, font-weight 600, font-size 14px.
- **Spec Tags**: Small grey pills below title (e.g. `i5-13420H` | `16GB` | `512GB SSD` | `RTX 3050`).
- **Pricing Block**:
  - Current price: Bold red `#D70018`, font-size 16px.
  - Original price: Strikethrough grey, font-size 13px.
- **Rating & Actions**: 5-star rating display + Wishlist heart toggle button.

### 3.4 Product Detail Page (`modules/Users/page/Detail.php`, `Style/Users/Detail.css`)
- **Left Panel (60%)**:
  - Main image gallery slider + thumbnails below.
  - Feature highlights box with green checkmarks.
  - Full specs table (Collapsible / Clean tab view).
  - Customer review breakdown (Star rating bars + write review form).
- **Right Panel (40%)**:
  - Product title, brand link, SKU, stock status.
  - Price display & savings calculation box.
  - **HOT Promotions Checklist Box**: Red dashed border with included gifts / discounts.
  - **Variant Options**: Buttons for color choice & RAM/Storage tiers.
  - **Primary Action Buttons**:
    - **MUA NGAY** (Full width bold red button `#D70018`, 50px height).
    - **THÊM VÀO GIỎ** (Red outline button with cart icon).
    - **TRẢ GÓP 0%** (Secondary payment option button).

### 3.5 Cart & Checkout (`modules/Users/page/Cart.php`, `Style/Users/Cart.css`)
- **Wizard Bar**: 4-step horizontal progress bar (1. Giỏ hàng -> 2. Thông tin -> 3. Thanh toán -> 4. Hoàn tất).
- **Cart Items Table**: Responsive layout with item image, variant, quantity controls (+ / -), subtotal, delete button.
- **Voucher Input**: Coupon field with apply button.
- **Checkout Summary & PayOS QR**: Clean address input form & instant QR Code payment overlay.

### 3.6 Global Footer (`modules/Users/Layout/Footer.php`)
- **Multi-column footer**:
  - Col 1: Brand info, GARENA introduction.
  - Col 2: Customer support hotline, shopping guide, warranty policy links.
  - Col 3: Payment options & Certifications (PayOS, Visa, Mastercard, MoMo).
  - Col 4: Store locations & social media connections.

---

## 4. Technical Implementation Scope & Files

- `modules/Users/Layout/Header.php` & `Style/Users/Header.css`
- `modules/Users/Layout/Footer.php` & `Style/Users/Footer.css`
- `modules/Users/page/HomePage.php` & `Style/Users/HomePage.css`
- `modules/Users/page/Product.php` & `Style/Users/Product.css`
- `modules/Users/page/Detail.php` & `Style/Users/Detail.css`
- `modules/Users/page/Cart.php` & `Style/Users/Cart.css`
- `index.php` (Header asset imports & global page container styling)

---

## 5. Verification Plan

- **Visual Layout Checks**: Ensure responsive behavior across Desktop (1200px+), Tablet (768px - 1024px), and Mobile (<576px).
- **Functional Checks**:
  - Mega Menu hover and click operations.
  - Search autosuggest bar filtering.
  - Cart quantity updating and price calculation.
  - PayOS payment button rendering.
