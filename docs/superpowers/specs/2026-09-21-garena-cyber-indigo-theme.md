# Design Specification: GARENA Cyber Indigo & Cyan Brand Identity

- **Date**: 2026-09-21
- **Project**: DevPHP_V2 (GARENA E-Sports & High-Tech Store)
- **Target Audience**: Gaming enthusiasts, PC builders, Tech lovers
- **Brand Aesthetic**: Modern Cyber Indigo & Cyan Neon (`#4F46E5` / `#06B6D4`)

---

## 1. Overview & Objectives

Transform the GARENA PHP E-Commerce platform from a generic red clone into an exclusive, high-tech, futuristic **GARENA Cyber Indigo** brand theme.

### Key Objectives:
1. **Unique Brand Identity**: Transition header, primary buttons, badges, banners, and accents to `#4F46E5` (Cyber Indigo Primary) with `#06B6D4` (Cyan Electric accents).
2. **High-Contrast Slate Page System**: Deep Slate background `#F8FAFC`, pristine white card surfaces `#FFFFFF`, and dark slate text `#0F172A`.
3. **Cohesive Component Overhaul**:
   - Header & Topbar (`Style/Users/Header.css`, `modules/Users/Layout/Header.php`)
   - Hero Section & Flash Sale (`Style/Users/HomePage.css`, `modules/Users/page/HomePage.php`)
   - Product Cards & Filtering (`Style/Users/Product.css`, `Style/Users/Sidebar.css`)
   - Product Details & CTA Buttons (`Style/Users/Detail.css`, `modules/Users/page/Detail.php`)
   - Cart Wizard & Progress Bar (`Style/Users/Cart.css`, `modules/Users/page/Cart.php`)
   - Footer & Trust Badges (`Style/Users/Footer.css`, `modules/Users/Layout/Footer.php`)

---

## 2. Design System Tokens & Color Palette

| Token | Hex / Value | Application |
|---|---|---|
| **Primary Brand** | `#4F46E5` | Navbar background, Primary CTA buttons, Active indicators |
| **Primary Hover** | `#4338CA` | Hover state for primary buttons and interactive elements |
| **Accent Cyan** | `#06B6D4` | Cyber badge highlights, icons, secondary CTA accents |
| **Accent Amber** | `#F59E0B` | Ratings, stars, hot offer tags |
| **Price Red** | `#EF4444` | High-contrast discount price text |
| **Page Background** | `#F8FAFC` | Cool slate ice background |
| **Card Background** | `#FFFFFF` | Product cards, detail containers, modals |
| **Border Neutral** | `#E2E8F0` | Clean 1px card borders |
| **Text Main** | `#0F172A` | Headings, titles, prices |
| **Text Muted** | `#64748B` | Secondary specs, dates, original prices |
| **Border Radius** | `12px` | Modern smooth card & button rounding |

---

## 3. Targeted File Modifications

1. `Style/Users/Header.css`: Update `:root` variables `--cellphone-red: #4F46E5`, `--cellphone-dark-red: #4338CA`, gradient overlays, hover states, logo accent.
2. `Style/Users/HomePage.css`: Update Flash Sale gradient (`linear-gradient(135deg, #4F46E5 0%, #06B6D4 100%)`), badge colors, category hover text.
3. `Style/Users/Detail.css`: Update "MUA NGAY" and promo box border colors to Cyber Indigo.
4. `Style/Users/Cart.css`: Update 4-step wizard active indicator to Cyber Indigo.
5. `Style/Users/Sidebar.css`: Update filter button colors to Cyber Indigo.
6. `modules/Users/Layout/Footer.php`: Update icon badge highlights.

---

## 4. Verification & Testing

1. Validate PHP syntax on modified templates (`php -l`).
2. Verify visual color consistency across Header, Homepage, Product Detail, Filter, Cart, and Footer.
3. Commit all changes cleanly to Git repository.
