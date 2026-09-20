# CellphoneS Red Classic UI/UX Overhaul Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Overhaul the Garena PHP E-Commerce user interface into a high-converting CellphoneS Red Classic theme (`#D70018`) while preserving 100% of existing PHP database logic, routes, and features.

**Architecture:** 
- CSS-driven styling system with CSS custom properties (`--primary-red`, `--bg-light`, `--card-shadow`, etc.).
- Modular UI components in `modules/Users/Layout/` and `modules/Users/page/`.
- Dynamic PHP bindings for categories, products, suppliers, cart session, banners, and user state.

**Tech Stack:** PHP 8, Bootstrap 5.3, Bootstrap Icons, FontAwesome 6, Custom CSS, Vanilla JS.

## Global Constraints

- Primary Red Color: `#D70018`
- Primary Hover Color: `#B20014`
- Light Background: `#F4F6F8`
- Preserve all existing `GET`/`POST` variables, session variables, and subpage routes (`index.php?subpage=...`).
- Zero breakage of PayOS payment flows, AJAX live chat, or cart operations.

---

### Task 1: CSS Design System & Theme Foundations

**Files:**
- Create/Modify: `Style/Users/Header.css`
- Modify: `Style/Users/HomePage.css`
- Modify: `Style/Users/Product.css`

**Interfaces:**
- Produces: CSS Root Variables (`--cellphone-red`, `--cellphone-hover`, `--bg-gray`, `--radius-card`, `--card-shadow`).

- [ ] **Step 1: Define CSS Root Variables & Global Resets in `Header.css`**

Add root variables at top of `Style/Users/Header.css`:
```css
:root {
  --cellphone-red: #d70018;
  --cellphone-dark-red: #b20014;
  --bg-gray: #f4f6f8;
  --text-dark: #111827;
  --text-body: #374151;
  --text-muted: #6b7280;
  --card-radius: 10px;
  --card-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
  --hover-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

body {
  background-color: var(--bg-gray) !important;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  color: var(--text-body);
}
```

- [ ] **Step 2: Verify CSS loads properly without syntax errors**
Inspect `Header.css` and verify syntax integrity.

- [ ] **Step 3: Commit design system changes**

```bash
git add Style/Users/Header.css Style/Users/HomePage.css Style/Users/Product.css
git commit -m "style: define CellphoneS Red design system variables and global resets"
```

---

### Task 2: Header & Top Navigation Overhaul

**Files:**
- Modify: `modules/Users/Layout/Header.php`
- Modify: `Style/Users/Header.css`

**Interfaces:**
- Consumes: `$categoryGetAll`, `$totalCartItems`, `$userData`
- Produces: Sticky Header with Mega Menu, Autosuggest Search Bar, Utility Actions (Hotline, Store, Tracking, Cart, Account).

- [ ] **Step 1: Update Header CSS in `Style/Users/Header.css`**

Add layout rules for `.header-cellphones`:
```css
.navbar-cellphones {
  background-color: var(--cellphone-red) !important;
  padding: 10px 0;
  box-shadow: 0 2px 10px rgba(0,0,0,0.15);
}

.search-cellphones-input {
  border-radius: 50px 0 0 50px !important;
  border: none !important;
  padding-left: 20px;
  font-size: 14px;
}

.search-cellphones-btn {
  border-radius: 0 50px 50px 0 !important;
  background-color: #fff !important;
  border: none !important;
  color: var(--cellphone-red) !important;
  padding-right: 20px;
}

.hot-keywords {
  display: flex;
  gap: 12px;
  font-size: 11.5px;
  margin-top: 4px;
}

.hot-keywords a {
  color: rgba(255, 255, 255, 0.85);
  text-decoration: none;
}

.hot-keywords a:hover {
  color: #fff;
  text-decoration: underline;
}

.header-action-item {
  color: #fff;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  font-weight: 500;
  padding: 6px 12px;
  border-radius: 8px;
  background: rgba(255, 255, 255, 0.15);
  transition: background 0.2s ease;
}

.header-action-item:hover {
  background: rgba(255, 255, 255, 0.28);
  color: #fff;
}
```

- [ ] **Step 2: Restructure Navbar HTML in `modules/Users/Layout/Header.php`**

Implement CellphoneS style Navbar layout:
- Red sticky top bar
- GARENA logo + Laptop icon
- "Danh mục" mega menu toggle
- Centered search box with hot tags
- Action item pills (Hotline, Cửa hàng, Tra cứu đơn hàng, Giỏ hàng, Tài khoản)

- [ ] **Step 3: Test header functionality**
Verify category dropdown links, search form submission (`index.php?subpage=modules/Users/Layout/Main.php&keyword=...`), cart counter badge, and user dropdown menu.

- [ ] **Step 4: Commit header changes**

```bash
git add modules/Users/Layout/Header.php Style/Users/Header.css
git commit -m "feat: overhaul user header with CellphoneS Red layout and utility bar"
```

---

### Task 3: Homepage 3-Column Hero & Hot Sale Section

**Files:**
- Modify: `modules/Users/page/HomePage.php`
- Modify: `Style/Users/HomePage.css`

**Interfaces:**
- Consumes: `$featuredProducts`, `$saleProducts`, `$getCategory`
- Produces: 3-column Hero section, 4-pillar trust badge bar, Red Flash Sale countdown container, Brand Pill filters.

- [ ] **Step 1: Add Styling for Hero & Flash Sale in `HomePage.css`**

```css
.hero-category-menu {
  background: #fff;
  border-radius: 12px;
  padding: 8px 0;
  box-shadow: var(--card-shadow);
}

.hero-category-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 9px 14px;
  color: var(--text-dark);
  text-decoration: none;
  font-size: 13.5px;
  font-weight: 500;
  transition: all 0.2s ease;
}

.hero-category-item:hover {
  background: #fff5f5;
  color: var(--cellphone-red);
}

.trust-badges-bar {
  background: #fff;
  border-radius: 12px;
  padding: 16px 20px;
  box-shadow: var(--card-shadow);
  margin: 20px 0;
}

.flash-sale-container {
  background: linear-gradient(135deg, #d70018 0%, #ff4d4d 100%);
  border-radius: 14px;
  padding: 20px;
  color: #fff;
  margin-bottom: 30px;
}

.countdown-box {
  background: #000;
  color: #fff;
  font-weight: 700;
  padding: 4px 8px;
  border-radius: 6px;
  font-size: 14px;
}
```

- [ ] **Step 2: Restructure Top Hero Section in `HomePage.php`**
Implement the 3-column top grid:
- Left: Category List with icons (`$getCategory`)
- Center: Slider Carousel
- Right: 2 Stacked Promotion Banners

- [ ] **Step 3: Implement Trust Badges & Hot Sale Container in `HomePage.php`**
Add 4 trust badges + Red Flash Sale block with countdown timer & dynamic sale product items (`$saleProducts`).

- [ ] **Step 4: Commit Homepage overhaul**

```bash
git add modules/Users/page/HomePage.php Style/Users/HomePage.css
git commit -m "feat: implement 3-column Hero layout, Trust Badges, and Flash Sale container on Homepage"
```

---

### Task 4: Product Card & Product Grid Modernization

**Files:**
- Modify: `Style/Users/Product.css`
- Modify: `modules/Users/page/Product.php`

**Interfaces:**
- Consumes: `$product` array items (`id`, `name`, `price`, `discount`, `image_url`)
- Produces: Elevated product cards with tag pills, pricing hierarchy, and brand tag filters.

- [ ] **Step 1: Enhance `ecom-product-card` CSS in `Product.css`**

```css
.ecom-product-card {
  background: #ffffff;
  border-radius: 10px;
  border: 1px solid #e5e7eb;
  padding: 12px;
  position: relative;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.ecom-product-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--hover-shadow) !important;
  border-color: #fca5a5;
}

.ecom-product-badge.sale {
  background: var(--cellphone-red) !important;
  color: #ffffff;
  font-weight: 700;
  border-radius: 6px;
  padding: 3px 8px;
  font-size: 11px;
}

.spec-pill-tag {
  background: #f3f4f6;
  color: #4b5563;
  font-size: 11px;
  padding: 2px 6px;
  border-radius: 4px;
  display: inline-block;
  margin-right: 4px;
  margin-bottom: 4px;
}
```

- [ ] **Step 2: Update Product Card markup in `HomePage.php` and `Product.php`**
Ensure product cards include percentage discount badges, clear 2-line truncated titles, spec tags, formatted prices in red (`number_format($finalPrice)`), and rating stars.

- [ ] **Step 3: Commit product card updates**

```bash
git add Style/Users/Product.css modules/Users/page/Product.php
git commit -m "style: elevate product cards with CellphoneS layout, spec tags, and hover shadows"
```

---

### Task 5: Product Detail Page Redesign (`Detail.php`)

**Files:**
- Modify: `modules/Users/page/Detail.php`
- Modify: `Style/Users/Detail.css`

**Interfaces:**
- Consumes: Product details array (`$productDetail`), images (`$productImages`), reviews (`$productReviews`)
- Produces: 2-column Detail layout with Gallery, Hot Promo Offer Box, Option Pills, Large "MUA NGAY" CTA, and formatted specs table.

- [ ] **Step 1: Style Detail Components in `Detail.css`**

```css
.hot-promo-box {
  border: 1.5px dashed var(--cellphone-red);
  background: #fff5f5;
  border-radius: 10px;
  padding: 14px 18px;
  margin: 16px 0;
}

.hot-promo-title {
  color: var(--cellphone-red);
  font-weight: 700;
  font-size: 15px;
  display: flex;
  align-items: center;
  gap: 6px;
  margin-bottom: 10px;
}

.btn-buy-now {
  background-color: var(--cellphone-red) !important;
  color: #ffffff !important;
  font-weight: 700;
  font-size: 16px;
  text-transform: uppercase;
  padding: 14px;
  border-radius: 8px;
  border: none;
  width: 100%;
  transition: background 0.2s ease;
}

.btn-buy-now:hover {
  background-color: var(--cellphone-dark-red) !important;
}

.btn-add-cart-outline {
  border: 2px solid var(--cellphone-red) !important;
  color: var(--cellphone-red) !important;
  font-weight: 700;
  background: #fff;
  border-radius: 8px;
  padding: 12px;
  width: 100%;
}
```

- [ ] **Step 2: Restructure HTML in `modules/Users/page/Detail.php`**
Update product detail page layout:
- Left Column: Image carousel + Feature checklist + Reviews
- Right Column: Pricing & savings, Hot Promo Box, Variant selector buttons, "MUA NGAY" & "THÊM VÀO GIỎ" buttons, Specs card.

- [ ] **Step 3: Test Product Detail page**
Verify adding to cart, review submission, and layout alignment.

- [ ] **Step 4: Commit Detail page changes**

```bash
git add modules/Users/page/Detail.php Style/Users/Detail.css
git commit -m "feat: overhaul product detail page with promo box and CellphoneS CTA layout"
```

---

### Task 6: Cart & Checkout Wizard Modernization (`Cart.php`)

**Files:**
- Modify: `modules/Users/page/Cart.php`
- Modify: `Style/Users/Cart.css`

**Interfaces:**
- Consumes: `$_SESSION['cart']`, PayOS helper
- Produces: 4-step wizard progress bar, responsive cart table, and clean PayOS payment integration.

- [ ] **Step 1: Add Checkout Wizard CSS in `Cart.css`**

```css
.checkout-wizard-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #fff;
  border-radius: 10px;
  padding: 16px 24px;
  box-shadow: var(--card-shadow);
  margin-bottom: 24px;
}

.wizard-step {
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 600;
  color: var(--text-muted);
}

.wizard-step.active {
  color: var(--cellphone-red);
}

.wizard-step-number {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: #e5e7eb;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
}

.wizard-step.active .wizard-step-number {
  background: var(--cellphone-red);
  color: #fff;
}
```

- [ ] **Step 2: Update `Cart.php` layout & PayOS QR render**
Integrate the 4-step progress wizard bar and clean item list formatting.

- [ ] **Step 3: Commit Cart page changes**

```bash
git add modules/Users/page/Cart.php Style/Users/Cart.css
git commit -m "feat: modernize cart & checkout page with step wizard and PayOS formatting"
```

---

### Task 7: Footer Modernization & End-to-End Verification

**Files:**
- Modify: `modules/Users/Layout/Footer.php`
- View: `index.php`

**Interfaces:**
- Produces: Professional multi-column footer and end-to-end clean user experience.

- [ ] **Step 1: Restructure Footer layout in `Footer.php`**
Add 4 structured columns (GARENA info, Support links, Payment partners & Certifications, Store location).

- [ ] **Step 2: Perform End-to-End verification across all user pages**
Inspect Homepage, Product Listing, Detail Page, Cart, and Footer. Ensure responsive behavior across Mobile and Desktop.

- [ ] **Step 3: Commit final layout polish**

```bash
git add modules/Users/Layout/Footer.php
git commit -m "feat: complete CellphoneS Red Classic UI/UX overhaul across all user pages"
```
