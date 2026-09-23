<?php
$currentPage = $_GET['page'] ?? '';
$is_stats_active = in_array($currentPage, [
  'modules/Admin/RecycleBin/Products/Product.php',
  'modules/Admin/RecycleBin/Category/Category.php',
  'modules/Admin/RecycleBin/Suppliers/Supplier.php',
  'modules/Admin/RecycleBin/Branches/Branch.php',
  'modules/Admin/RecycleBin/Categories/Category.php',
  'modules/Admin/RecycleBin/Customers/Customer.php',
  'modules/Admin/RecycleBin/Orders/Order.php',
  'modules/Admin/RecycleBin/Menus/Menu.php',
  'modules/Admin/RecycleBin/Roles/Role.php',
  'modules/Admin/RecycleBin/Employees/Employee.php'

]);
?>

<div class="sidebar">
  <div class="sidebar-header">
    <a href="Admin.php" style="text-decoration: none;">
      <h2 class="gradient-text">GARENA ADMIN</h2>
    </a>
  </div>

  <div class="sidebar-menu-wrapper">
    <!-- 1. TỔNG QUAN -->
    <div class="sidebar-section-title">TỔNG QUAN</div>
    <ul>
      <li class="<?= ($currentPage === '' || $currentPage == 'dashboard') ? 'active' : '' ?>">
        <a href="Admin.php"><i class="fas fa-chart-line"></i> Thống kê báo cáo</a>
      </li>
    </ul>

    <!-- 2. GIAO DIỆN & BANNER -->
    <div class="sidebar-section-title">GIAO DIỆN & BANNER</div>
    <ul>
      <li class="<?= ($currentPage == 'modules/Admin/Banners/Banner.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/Banners/Banner.php"><i class="fas fa-images"></i> Quản lý Banner</a>
      </li>
      <li class="<?= ($currentPage == 'modules/Admin/FlashSale/FlashSale.php' || $currentPage == 'flash_sale') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/FlashSale/FlashSale.php"><i class="fas fa-bolt"></i> Quản lý Flash Sale</a>
      </li>
    </ul>

    <!-- 3. SẢN PHẨM & KHO HÀNG -->
    <div class="sidebar-section-title">SẢN PHẨM & KHO HÀNG</div>
    <ul>
      <li class="<?= ($currentPage == 'modules/Admin/Products/Product.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/Products/Product.php"><i class="fas fa-box-open"></i> Quản lý sản phẩm</a>
      </li>
      <li class="<?= ($currentPage == 'modules/Admin/Categories/Category.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/Categories/Category.php"><i class="fas fa-tags"></i> Loại sản phẩm</a>
      </li>
      <li class="<?= ($currentPage == 'modules/Admin/Suppliers/Supplier.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/Suppliers/Supplier.php"><i class="fas fa-truck-loading"></i> Nhà cung cấp</a>
      </li>
      <li class="<?= ($currentPage == 'modules/Admin/Branches/Branch.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/Branches/Branch.php"><i class="fas fa-store"></i> Chi nhánh cửa hàng</a>
      </li>
      <li class="<?= ($currentPage == 'modules/Admin/Inventory/Inventory.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/Inventory/Inventory.php"><i class="fas fa-warehouse"></i> Quản lý kho hàng</a>
      </li>
    </ul>

    <!-- 4. ĐƠN HÀNG & GIAO HÀNG -->
    <div class="sidebar-section-title">ĐƠN HÀNG & VẬN CHUYỂN</div>
    <ul>
      <li class="<?= ($currentPage == 'modules/Admin/Orders/Order.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/Orders/Order.php"><i class="fas fa-shopping-bag"></i> Quản lý đơn hàng</a>
      </li>
      <li class="<?= ($currentPage == 'modules/Admin/Shipping/Shipping.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/Shipping/Shipping.php"><i class="fas fa-shipping-fast"></i> Quản lý giao hàng</a>
      </li>
    </ul>

    <!-- 5. NGƯỜI DÙNG & NHÂN VIÊN -->
    <div class="sidebar-section-title">NGƯỜI DÙNG & NHÂN VIÊN</div>
    <ul>
      <li class="<?= ($currentPage == 'modules/Admin/Customers/Customer.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/Customers/Customer.php"><i class="fas fa-users"></i> Khách hàng</a>
      </li>
      <li class="<?= ($currentPage == 'modules/Admin/Employees/Employee.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/Employees/Employee.php"><i class="fas fa-user-shield"></i> Nhân viên</a>
      </li>
    </ul>

    <!-- 6. TRỢ LÝ AI & HUẤN LUYỆN -->
    <div class="sidebar-section-title">TRỢ LÝ AI & HUẤN LUYỆN</div>
    <ul>
      <li class="<?= ($currentPage == 'modules/Admin/AiTraining/index.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/AiTraining/index.php"><i class="fas fa-brain"></i> Huấn luyện & Tri thức AI</a>
      </li>
    </ul>

    <!-- 7. HỆ THỐNG -->
    <div class="sidebar-section-title">HỆ THỐNG</div>
    <ul>
      <li class="<?= ($currentPage == 'modules/Admin/Menus/Menu.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/Menus/Menu.php"><i class="fas fa-cogs"></i> Quản lý chức năng</a>
      </li>
      <li class="<?= ($currentPage == 'modules/Admin/Roles/Role.php') ? 'active' : '' ?>">
        <a href="Admin.php?page=modules/Admin/Roles/Role.php"><i class="fas fa-user-tag"></i> Phân quyền hệ thống</a>
      </li>
      <li class="dropdown">
        <?php if (hasPermission('modules/Admin/RecycleBin')): ?>
          <div id="dropdown-toggle" class="dropdown-toggle">
            <span class="toggle-label">
              <i class="fas fa-trash-alt" style="margin-right: 8px; width: 20px;"></i> Thùng rác
            </span>
            <span class="arrow <?= $is_stats_active ? 'open' : '' ?>">&#9656;</span>
          </div>
        <?php endif; ?>

        <ul id="dropdown-menu" class="dropdown-menu <?= $is_stats_active ? 'show' : '' ?>">
          <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Products/Product.php') ? 'active-sub' : '' ?>">
            <a href="Admin.php?page=modules/Admin/RecycleBin/Products/Product.php"><i class="fas fa-box"></i> Sản phẩm</a>
          </li>
          <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Branches/Branch.php') ? 'active-sub' : '' ?>">
            <a href="Admin.php?page=modules/Admin/RecycleBin/Branches/Branch.php"><i class="fas fa-store"></i> Chi nhánh</a>
          </li>
          <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Categories/Category.php') ? 'active-sub' : '' ?>">
            <a href="Admin.php?page=modules/Admin/RecycleBin/Categories/Category.php"><i class="fas fa-table"></i> Loại sản phẩm</a>
          </li>
          <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Suppliers/Supplier.php') ? 'active-sub' : '' ?>">
            <a href="Admin.php?page=modules/Admin/RecycleBin/Suppliers/Supplier.php"><i class="fas fa-boxes-packing"></i> Nhà cung cấp</a>
          </li>
          <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Customers/Customer.php') ? 'active-sub' : '' ?>">
            <a href="Admin.php?page=modules/Admin/RecycleBin/Customers/Customer.php"><i class="fas fa-users"></i> Khách hàng</a>
          </li>
          <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Orders/Order.php') ? 'active-sub' : '' ?>">
            <a href="Admin.php?page=modules/Admin/RecycleBin/Orders/Order.php"><i class="fas fa-shopping-cart"></i> Đơn hàng</a>
          </li>
          <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Menus/Menu.php') ? 'active-sub' : '' ?>">
            <a href="Admin.php?page=modules/Admin/RecycleBin/Menus/Menu.php"><i class="fas fa-screwdriver-wrench"></i> Chức năng</a>
          </li>
          <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Roles/Role.php') ? 'active-sub' : '' ?>">
            <a href="Admin.php?page=modules/Admin/RecycleBin/Roles/Role.php"><i class="fas fa-sitemap"></i> Quyền</a>
          </li>
          <li class="<?= ($currentPage == 'modules/Admin/RecycleBin/Employees/Employee.php') ? 'active-sub' : '' ?>">
            <a href="Admin.php?page=modules/Admin/RecycleBin/Employees/Employee.php"><i class="fas fa-clipboard-user"></i> Nhân viên</a>
          </li>
        </ul>
      </li>
    </ul>

    <div class="sidebar-section-title">TÀI KHOẢN</div>
    <ul>
      <li>
        <a class="text-danger d-flex align-items-center gap-2" href="Auth/logout.php">
          <i class="fas fa-sign-out-alt"></i> Đăng xuất
        </a>
      </li>
    </ul>
  </div>
</div>

<script>
  const toggle = document.getElementById('dropdown-toggle');
  const menu = document.getElementById('dropdown-menu');
  const arrow = toggle ? toggle.querySelector('.arrow') : null;

  if (toggle && menu && arrow) {
    toggle.addEventListener('click', () => {
      menu.classList.toggle('show');
      arrow.classList.toggle('open');
    });
  }
</script>

<style>
  .sidebar {
    width: 250px;
    background-color: #f8f9fa;
    position: fixed;
    top: 0;
    bottom: 0;
    overflow-y: auto;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
  }

  .sidebar-section-title {
    padding: 16px 20px 6px 20px;
    font-size: 11px;
    font-weight: 700;
    color: #8898aa;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border-top: 1px solid #edf2f7;
    margin-top: 4px;
  }

  .sidebar-section-title:first-of-type {
    border-top: none;
    margin-top: 0;
  }

  .sidebar ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
  }

  .sidebar ul li {
    padding: 8px 20px;
    margin: 2px 0;
  }

  .gradient-text {
    padding: 15px 10px 10px;
    text-align: center;
    font-weight: 800;
    font-size: 20px;
    letter-spacing: 1px;
    background: linear-gradient(90deg, #ff4e50, #ef4cf5, #1e90ff, #7b2ff7);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
    margin: 0;
  }

  .sidebar a i {
    margin-right: 10px;
    width: 18px;
    text-align: center;
  }

  .sidebar ul li a,
  .sidebar .dropdown-toggle {
    text-decoration: none;
    color: #4a5568;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: background-color 0.2s, color 0.2s;
    border-radius: 6px;
    padding: 6px 10px;
  }

  .sidebar ul li:hover a,
  .sidebar .dropdown-toggle:hover {
    background-color: #edf2f7;
    color: #2d3748;
  }

  .sidebar ul li.active a,
  .sidebar ul li.active-sub a,
  .sidebar .dropdown-toggle.active {
    background-color: #d70018;
    color: #ffffff !important;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(215, 0, 24, 0.2);
  }

  .sidebar .dropdown {
    position: relative;
  }

  .sidebar .dropdown-menu {
    display: none;
    list-style-type: none;
    padding-left: 20px;
    margin: 4px 0 0 0;
    border-left: 2px solid #cbd5e1;
    position: static;
    background-color: transparent;
    box-shadow: none;
    border-top: none;
    border-right: none;
    border-bottom: none;
  }

  .sidebar .dropdown-menu.show {
    display: block;
  }

  .sidebar .dropdown-menu li {
    padding: 4px 10px;
  }

  .sidebar .dropdown-menu li a {
    font-size: 13px;
  }

  .dropdown-toggle {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .arrow {
    display: inline-block;
    transition: transform 0.3s ease;
    font-size: 14px;
    color: inherit;
  }

  .arrow.open {
    transform: rotate(90deg);
  }

  .content {
    margin-left: 250px;
    padding: 80px 20px 20px 20px;
  }

  #dropdown-toggle::after {
    content: none !important;
    display: none !important;
  }
</style>