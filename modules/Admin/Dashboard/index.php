<?php
// Admin Dashboard Controller Logic

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export_excel'])) {
    $product->exportProductsExcel();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export_excel_user'])) {
    $userController->exportUserExcel();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export_excel_order'])) {
    $orderController->exportOrderThisWeekExcel();
}

// Stats & Metrics
$totalUsers = $userController->countUserAll();
$totalProducts = $product->countProductAll();
$totalOrders = $orderController->getAllCountOrder('');
$ordersThisWeek = $orderController->countOrderThisWeek();
$totalRevenue = $orderController->getTotalRevenue();
$lowStockCount = $product->countLowStock(10);

// Chart Data
$monthlyUserCounts = $userController->countUsersByMonthInYear();
$monthLabels = ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'];

// Revenue last 7 days chart data
$rawRevenue7Days = $orderController->getRevenueLast7Days();
$revenueLabels = [];
$revenueData = [];

// Generate past 7 days dates array
for ($i = 6; $i >= 0; $i--) {
    $dateKey = date('Y-m-d', strtotime("-$i days"));
    $displayLabel = date('d/m', strtotime("-$i days"));
    $revenueLabels[] = $displayLabel;
    
    // Find matching date from SQL result
    $foundAmount = 0;
    foreach ($rawRevenue7Days as $row) {
        if ($row['order_date'] === $dateKey) {
            $foundAmount = (float)$row['daily_revenue'];
            break;
        }
    }
    $revenueData[] = $foundAmount;
}

// Order Status Distribution (All Time)
$statusCounts = [
    $orderController->countOrdersByStatus(1), // Chờ xử lý
    $orderController->countOrdersByStatus(2), // Đã xác nhận
    $orderController->countOrdersByStatus(3), // Đang chuyển hàng
    $orderController->countOrdersByStatus(4), // Đang giao hàng
    $orderController->countOrdersByStatus(5), // Đã hủy
    $orderController->countOrdersByStatus(6), // Thành công
];


// Insight Tables Data
$topProducts = $product->getTopSellingProducts(5);
$recentOrders = $orderController->getRecentOrders(5);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Quản Trị - Tổng Quan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0c6c5ee.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .dashboard-header {
            font-weight: 700;
            color: #2c3e50;
        }

        .card-stat {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            color: #fff;
        }

        .card-stat:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-stat .stat-icon {
            font-size: 2.5rem;
            opacity: 0.85;
        }

        .card-stat .stat-value {
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .card-stat .stat-label {
            font-size: 0.88rem;
            opacity: 0.9;
        }

        .bg-gradient-blue {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }

        .bg-gradient-emerald {
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        }

        .bg-gradient-amber {
            background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
        }

        .card-panel {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.04);
            background: #ffffff;
        }

        .card-panel .card-header {
            background: transparent;
            border-bottom: 1px solid #edf2f7;
            font-weight: 700;
            color: #2d3748;
            font-size: 1.05rem;
            padding: 1.1rem 1.25rem;
        }

        .table-custom th {
            font-weight: 600;
            color: #718096;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom-width: 1px;
        }

        .table-custom td {
            vertical-align: middle;
            font-size: 0.92rem;
        }

        .product-img-thumb {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .badge-status-pending { background-color: #36a2eb; }
        .badge-status-confirmed { background-color: #ff6384; }
        .badge-status-shipping { background-color: #4bc0c0; }
        .badge-status-delivering { background-color: #ff9f40; }
        .badge-status-canceled { background-color: #e74a3b; }
        .badge-status-success { background-color: #1cc88a; }

        canvas {
            max-height: 260px;
        }
    </style>
</head>

<body>

    <div class="container-fluid py-4 px-4">
        <!-- Dashboard Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="dashboard-header mb-0">
                
            </h3>
            <span class="badge bg-light text-dark px-3 py-2 border shadow-sm">
                <i class="fas fa-calendar-alt me-1 text-muted"></i> Hôn nay: <?= date('d/m/Y') ?>
            </span>
        </div>

        <!-- 5 KPI Cards -->
        <div class="row g-3 mb-4 d-flex align-items-stretch">
            <!-- Total Users -->
            <div class="col-md-2-4 col-sm-6 col-12 d-flex" style="width: 20%;">
                <div class="card card-stat bg-gradient-blue p-3 w-100 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2" style="min-height: 31px;">
                        <span class="stat-label">Người dùng</span>
                        <form action="" method="post">
                            <button type="submit" name="export_excel_user" class="btn btn-light btn-sm rounded-circle shadow-sm" title="Xuất Excel">
                                <i class="fas fa-file-excel text-primary"></i>
                            </button>
                        </form>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="stat-value"><?= number_format($totalUsers) ?></div>
                        <i class="fas fa-users stat-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Total Products -->
            <div class="col-md-2-4 col-sm-6 col-12 d-flex" style="width: 20%;">
                <div class="card card-stat bg-gradient-emerald p-3 w-100 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2" style="min-height: 31px;">
                        <span class="stat-label">Sản phẩm</span>
                        <form action="" method="post">
                            <button type="submit" name="export_excel" class="btn btn-light btn-sm rounded-circle shadow-sm" title="Xuất Excel">
                                <i class="fas fa-file-excel text-success"></i>
                            </button>
                        </form>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="stat-value"><?= number_format($totalProducts) ?></div>
                        <i class="fas fa-box-open stat-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Orders -->
            <div class="col-md-2-4 col-sm-6 col-12 d-flex" style="width: 20%;">
                <div class="card card-stat bg-gradient-amber p-3 w-100 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2" style="min-height: 31px;">
                        <span class="stat-label">Đơn hàng (Tuần / Tổng)</span>
                        <form action="" method="post">
                            <button type="submit" name="export_excel_order" class="btn btn-light btn-sm rounded-circle shadow-sm" title="Xuất Excel">
                                <i class="fas fa-file-excel text-warning"></i>
                            </button>
                        </form>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="stat-value"><?= number_format($ordersThisWeek) ?> <small class="fs-6 opacity-75">/ <?= number_format($totalOrders) ?></small></div>
                        <i class="fas fa-shopping-cart stat-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="col-md-2-4 col-sm-6 col-12 d-flex" style="width: 20%;">
                <div class="card card-stat bg-gradient-success p-3 w-100 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2" style="min-height: 31px;">
                        <span class="stat-label">Tổng doanh thu</span>
                        <span class="btn btn-light btn-sm rounded-circle shadow-sm border-0 pe-none" style="width:31px; height:31px; display:inline-flex; align-items:center; justify-content:center;">
                            <i class="fas fa-coins text-success"></i>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="stat-value" style="font-size: 1.2rem;"><?= number_format($totalRevenue, 0, ',', '.') ?> ₫</div>
                        <i class="fas fa-wallet stat-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Low Stock Warning -->
            <div class="col-md-2-4 col-sm-6 col-12 d-flex" style="width: 20%;">
                <div class="card card-stat bg-gradient-danger p-3 w-100 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-2" style="min-height: 31px;">
                        <span class="stat-label">Cảnh báo tồn kho</span>
                        <span class="btn btn-light btn-sm rounded-circle shadow-sm border-0 pe-none" style="width:31px; height:31px; display:inline-flex; align-items:center; justify-content:center;">
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="stat-value"><?= number_format($lowStockCount) ?> <small class="fs-6 opacity-75">SP</small></div>
                        <i class="fas fa-warehouse stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>


        <!-- 3 Charts Section -->
        <div class="row g-3 mb-4">
            <!-- Line Chart: Revenue 7 Days -->
            <div class="col-lg-5 col-md-12">
                <div class="card card-panel h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-chart-line text-success me-2"></i>Doanh thu 7 ngày gần nhất</span>
                        <small class="text-muted">VNĐ</small>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueLineChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bar Chart: Monthly Users -->
            <div class="col-lg-4 col-md-7">
                <div class="card card-panel h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-user-plus text-primary me-2"></i>Khách hàng mới theo tháng</span>
                    </div>
                    <div class="card-body">
                        <canvas id="userBarChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Doughnut Chart: Order Status -->
            <div class="col-lg-3 col-md-5">
                <div class="card card-panel h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-pie-chart text-warning me-2"></i>Phân bố trạng thái đơn hàng</span>

                    </div>
                    <div class="card-body">
                        <canvas id="statusDoughnutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2 Insight Data Tables -->
        <div class="row g-3">
            <!-- Top Selling Products -->
            <div class="col-lg-6 col-md-12">
                <div class="card card-panel h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-fire text-danger me-2"></i>Top 5 Sản phẩm bán chạy nhất</span>
                        <a href="Admin.php?page=modules/Admin/Products/Product.php" class="btn btn-sm btn-light text-primary">Xem tất cả</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-custom mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="ps-3">Sản phẩm</th>
                                        <th class="text-center">Đã bán</th>
                                        <th class="text-end pe-3">Doanh thu mang lại</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($topProducts)): ?>
                                        <?php foreach ($topProducts as $item): ?>
                                            <tr>
                                                <td class="ps-3">
                                                    <div class="d-flex align-items-center">
                                                        <?php 
                                                            $imgSrc = !empty($item['image_url']) ? $item['image_url'] : 'public/uploads/default-product.jpg';
                                                        ?>
                                                        <img src="<?= htmlspecialchars($imgSrc) ?>" class="product-img-thumb me-2" alt="product" onerror="this.src='https://via.placeholder.com/42';">
                                                        <span class="fw-semibold text-dark text-truncate" style="max-width: 200px;"><?= htmlspecialchars($item['name']) ?></span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary rounded-pill px-3"><?= number_format($item['total_sold']) ?></span>
                                                </td>
                                                <td class="text-end pe-3 fw-bold text-success">
                                                    <?= number_format($item['total_revenue'], 0, ',', '.') ?> ₫
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">Chưa có dữ liệu bán hàng</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="col-lg-6 col-md-12">
                <div class="card card-panel h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-clock text-info me-2"></i>Đơn hàng mới nhất</span>
                        <a href="Admin.php?page=modules/Admin/Orders/Order.php" class="btn btn-sm btn-light text-primary">Quản lý đơn hàng</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-custom mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="ps-3">Mã đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recentOrders)): ?>
                                        <?php foreach ($recentOrders as $order): ?>
                                            <tr>
                                                <td class="ps-3 fw-bold text-primary">#<?= htmlspecialchars($order['code']) ?></td>
                                                <td><?= htmlspecialchars($order['user_name']) ?></td>
                                                <td class="fw-semibold text-dark"><?= number_format($order['total_amount'], 0, ',', '.') ?> ₫</td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        <?= htmlspecialchars($order['status_name']) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Chưa có đơn hàng nào</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Setup Script -->
    <script>
        // Data from PHP
        const monthLabels = <?= json_encode($monthLabels) ?>;
        const userByMonthData = <?= json_encode(array_values($monthlyUserCounts)) ?>;

        const revenueLabels = <?= json_encode($revenueLabels) ?>;
        const revenueData = <?= json_encode($revenueData) ?>;

        const statusData = <?= json_encode($statusCounts) ?>;

        // 1. Revenue Line Chart (7 Days)
        const revCtx = document.getElementById('revenueLineChart').getContext('2d');
        const revGradient = revCtx.createLinearGradient(0, 0, 0, 240);
        revGradient.addColorStop(0, 'rgba(28, 200, 138, 0.35)');
        revGradient.addColorStop(1, 'rgba(28, 200, 138, 0.0)');

        new Chart(revCtx, {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: revenueData,
                    borderColor: '#1cc88a',
                    borderWidth: 3,
                    backgroundColor: revGradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#1cc88a',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#1cc88a'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(30, 41, 59, 0.9)',
                        titleFont: { size: 13, family: "'Segoe UI', sans-serif" },
                        bodyFont: { size: 13, family: "'Segoe UI', sans-serif" },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return ' Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context.raw) + ' ₫';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(226, 232, 240, 0.6)', drawBorder: false },
                        ticks: {
                            font: { size: 11 },
                            callback: function(value) {
                                if (value >= 1000000) return (value / 1000000).toFixed(1) + 'M ₫';
                                if (value >= 1000) return (value / 1000).toFixed(0) + 'K ₫';
                                return value + ' ₫';
                            }
                        }
                    }
                }
            }
        });

        // 2. User Registration Bar Chart
        const userCtx = document.getElementById('userBarChart').getContext('2d');
        const userGradient = userCtx.createLinearGradient(0, 0, 0, 240);
        userGradient.addColorStop(0, '#4e73df');
        userGradient.addColorStop(1, '#224abe');

        new Chart(userCtx, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Khách hàng mới',
                    data: userByMonthData,
                    backgroundColor: userGradient,
                    hoverBackgroundColor: '#2e59d9',
                    borderRadius: 8,
                    borderSkipped: false,
                    maxBarThickness: 28
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(30, 41, 59, 0.9)',
                        titleFont: { size: 13, family: "'Segoe UI', sans-serif" },
                        bodyFont: { size: 13, family: "'Segoe UI', sans-serif" },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return ' Khách hàng mới: ' + new Intl.NumberFormat('vi-VN').format(context.raw) + ' người';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(226, 232, 240, 0.6)', drawBorder: false },
                        ticks: {
                            precision: 0,
                            font: { size: 11 }
                        }
                    }
                }
            }
        });

        // 3. Order Status Doughnut Chart (Visual Scaling for Equal Visibility)
        const realStatusData = statusData;
        // Apply soft scale (Math.pow) so small values (e.g. 5, 8) are clearly visible alongside large values (e.g. 2700) on the same circle
        const visualStatusData = realStatusData.map(val => val > 0 ? Math.pow(val, 0.35) : 0);

        new Chart(document.getElementById('statusDoughnutChart'), {
            type: 'doughnut',
            data: {
                labels: ['Chờ xử lý', 'Đã xác nhận', 'Đang chuyển hàng', 'Đang giao hàng', 'Đã hủy', 'Thành công'],
                datasets: [{
                    data: visualStatusData,
                    backgroundColor: ['#36a2eb', '#ff6384', '#4bc0c0', '#ff9f40', '#e74a3b', '#1cc88a'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            usePointStyle: true,
                            font: { size: 11, family: "'Segoe UI', sans-serif" },
                            padding: 8,
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function(label, i) {
                                        const meta = chart.getDatasetMeta(0);
                                        const ds = data.datasets[0];
                                        const realVal = realStatusData[i] || 0;
                                        return {
                                            text: label + ' (' + new Intl.NumberFormat('vi-VN').format(realVal) + ')',
                                            fillStyle: ds.backgroundColor[i],
                                            strokeStyle: ds.borderColor || '#fff',
                                            lineWidth: ds.borderWidth || 1,
                                            hidden: isNaN(ds.data[i]) || (meta.data[i] && meta.data[i].hidden),
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 41, 59, 0.9)',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                const index = context.dataIndex;
                                const realVal = realStatusData[index] || 0;
                                const total = realStatusData.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((realVal / total) * 100).toFixed(1) : 0;
                                return ' ' + context.label + ': ' + new Intl.NumberFormat('vi-VN').format(realVal) + ' đơn (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });


    </script>


</body>

</html>