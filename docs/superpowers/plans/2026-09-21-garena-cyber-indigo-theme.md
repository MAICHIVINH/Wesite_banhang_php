# GARENA Cyber Indigo & Cyan Brand Theme Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Transform the website theme to the GARENA Cyber Indigo & Cyan (`#4F46E5` / `#06B6D4`) brand identity across all user-facing styles and components.

**Architecture:** Update CSS design system tokens (`--cellphone-red`, `--cellphone-dark-red`, gradients, highlights, badges) in `Style/Users/Header.css`, `Style/Users/HomePage.css`, `Style/Users/Detail.css`, `Style/Users/Cart.css`, `Style/Users/Sidebar.css`, and update layout templates.

**Tech Stack:** PHP, Vanilla CSS, Bootstrap 5, Bootstrap Icons.

## Global Constraints
- Primary Brand Color: `#4F46E5` (Cyber Indigo)
- Primary Hover / Gradient Accent: `#4338CA` / `#06B6D4`
- Maintain 100% database compatibility and PHP dynamic loops.

---

### Task 1: CSS Design System & Header Theme Overhaul

**Files:**
- Modify: `Style/Users/Header.css:1-120`
- Modify: `modules/Users/Layout/Header.php:120-160`

- [ ] **Step 1: Update CSS tokens in Header.css**

Set `:root` variables:
```css
:root {
  --cellphone-red: #4f46e5;
  --cellphone-dark-red: #4338ca;
  --bg-gray: #f8fafc;
  --text-dark: #0f172a;
  --text-body: #334155;
  --text-muted: #64748b;
  --card-radius: 12px;
  --card-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  --hover-shadow: 0 8px 24px rgba(79, 70, 229, 0.15);
}
```

Update `.top-bar-cellphones`:
```css
.top-bar-cellphones {
  background: linear-gradient(90deg, #3730a3 0%, #4f46e5 50%, #3730a3 100%);
  color: #ffffff;
  font-size: 12px;
  padding: 5px 0;
  border-bottom: 1px solid rgba(255, 255, 255, 0.15);
}
```

- [ ] **Step 2: Lint PHP Header**

Run: `php -l modules/Users/Layout/Header.php`
Expected: PASS

- [ ] **Step 3: Commit**

```bash
git add Style/Users/Header.css modules/Users/Layout/Header.php
git commit -m "style(header): update Header CSS tokens to GARENA Cyber Indigo theme"
```

---

### Task 2: Homepage & Flash Sale Styling Update

**Files:**
- Modify: `Style/Users/HomePage.css:215-300`

- [ ] **Step 1: Update Flash Sale & Badge CSS**

```css
.flash-sale-box {
  background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
  border-radius: 14px;
  padding: 20px;
  color: #ffffff;
  margin: 30px 0;
  box-shadow: 0 8px 24px rgba(79, 70, 229, 0.25);
}

.hero-category-item:hover {
  background: #eef2ff;
  color: #4f46e5;
  padding-left: 18px;
}
```

- [ ] **Step 2: Commit**

```bash
git add Style/Users/HomePage.css
git commit -m "style(home): update Flash Sale box gradient and category hover to Cyber Indigo"
```

---

### Task 3: Product Detail, Sidebar & Cart Wizard Styling

**Files:**
- Modify: `Style/Users/Detail.css`
- Modify: `Style/Users/Cart.css`
- Modify: `Style/Users/Sidebar.css`

- [ ] **Step 1: Update Detail.css, Cart.css, and Sidebar.css**

In `Detail.css`: Update CTA buttons and promo box borders to Cyber Indigo (`#4F46E5`).
In `Cart.css`: Update wizard steps active indicator color to `#4F46E5`.
In `Sidebar.css`: Update filter apply button to `#4F46E5`.

- [ ] **Step 2: Commit**

```bash
git add Style/Users/Detail.css Style/Users/Cart.css Style/Users/Sidebar.css
git commit -m "style(theme): update Detail, Cart wizard, and Sidebar colors to Cyber Indigo"
```
