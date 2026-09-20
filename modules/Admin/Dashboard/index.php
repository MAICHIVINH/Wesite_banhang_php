<?php
// Dữ liệu giả

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export_excel'])) {
    $product->exportProductsExcel();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export_excel_user'])) {
    $userController->exportUserExcel();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export_excel_order'])) {
    $orderController->exportOrderThisWeekExcel();
}
$totalUsers = $userController->countUserAll();
$totalProducts = $product->countProductAll();
$totalOrdersThisWeek = $orderController->countOrderThisWeek();
$totalRevenue = $orderItemController->countProductThisWeek();

$monthlyUserCounts = $userController->countUsersByMonthInYear();

$monthLabels = ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'];

$data1 = [65, 59, 80, 81, 56, 55, 40, 70, 60];
$data2 = [28, 48, 40, 19, 86, 27, 90, 50, 30];
$data3 = [
    $orderController->countOrdersByStatusThisWeek(1),
    $orderController->countOrdersByStatusThisWeek(2),
    $orderController->countOrdersByStatusThisWeek(3),
    $orderController->countOrdersByStatusThisWeek(4),
    $orderController->countOrdersByStatusThisWeek(5),
    $orderController->countOrdersByStatusThisWeek(6),
]; ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Tổng Quan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0c6c5ee.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
        }

        .card .card-header {
            background: none;
            border-bottom: none;
            font-weight: bold;
        }

        canvas {
            max-height: 250px;
        }
    </style>
</head>

<body>

    <div class="container-fluid py-4">
        <h3 class="mb-4 fw-bold">
            <i class="fas fa-chart-bar text-info me-2"></i> Tổng quan
        </h3>

        <!-- Cards thống kê -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card text-white" style="background: linear-gradient(45deg, #6a11cb, #2575fc);">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5><i class="fas fa-box me-2"></i><?= $totalUsers ?></h5>
                            <p class="mb-0">Người dùng</p>
                        </div>
                        <div>
                            <form action="" method="post">
                                <button type="submit" name="export_excel_user"
                                    class="btn btn-light btn-sm"
                                    style="color:#11998e; font-weight:bold;">
                                    <i class="fas fa-file-excel"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white" style="background: linear-gradient(45deg, #11998e, #38ef7d);">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5><i class="fas fa-box me-2"></i><?= $totalProducts ?></h5>
                            <p class="mb-0">Sản phẩm</p>
                        </div>
                        <div>
                            <form action="" method="post">
                                <button type="submit" name="export_excel"
                                    class="btn btn-light btn-sm"
                                    style="color:#11998e; font-weight:bold;">
                                    <i class="fas fa-file-excel"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white" style="background: linear-gradient(45deg, #f7971e, #ffd200);">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div>
                            <h5><i class="fas fa-box me-2"></i><?= $totalOrdersThisWeek ?></h5>
                            <p class="mb-0">Đơn tuần này</p>
                        </div>
                        <div>
                            <form action="" method="post">
                                <button type="submit" name="export_excel_order"
                                    class="btn btn-light btn-sm"
                                    style="color:#11998e; font-weight:bold;">
                                    <i class="fas fa-file-excel"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white" style="background: linear-gradient(45deg, #56ab2f, #a8e063);">
                    <div class="card-body">
                        <h5><i class="fas fa-dollar-sign me-2"></i><?= $totalRevenue ?></h5>
                        <p class="mb-0">Tổng sản phẩm / tuần</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ -->
        <div class="row g-3">
            <!-- Bar Chart -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">Biểu đồ cột</div>
                    <div class="card-body">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Polar Area -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">Biểu đồ vùng cực</div>
                    <div class="card-body">
                        <canvas id="polarChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Line Chart
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">Doanh thu 7 ngày gần nhất</div>
                    <div class="card-body">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">Tỷ lệ số lượng</div>
                    <div class="card-body">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    <!-- Chart.js Script -->
    <script>
        const labels = <?= json_encode($monthLabels) ?>;
        const userByMonthData = <?= json_encode(array_values($monthlyUserCounts)) ?>;


        const data1 = <?= json_encode($data1) ?>;
        const data2 = <?= json_encode($data2) ?>;
        const data3 = <?= json_encode($data3) ?>;

        // Bar Chart
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Khách hàng mới theo tháng',
                    data: userByMonthData,
                    backgroundColor: '#4bc0c0'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });

        // Polar Area Chart
        new Chart(document.getElementById('polarChart'), {
            type: 'polarArea',
            data: {
                labels: ['Chờ xử lý', 'Đã xác nhận', 'Đang chuyển hàng', 'Đang giao hàng', 'Đã hủy', 'Thành công'],
                datasets: [{
                    data: data3,
                    backgroundColor: ['#36a2eb', '#ff6384', '#4bc0c0', '#ff9f40', '#FF6666', '#00b894'],
                }]
            },
            options: {
                responsive: true
            }
        });

        // Line Chart
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: data1,
                    fill: true,
                    borderColor: '#4bc0c0',
                    backgroundColor: 'rgba(75,192,192,0.2)',
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: '#4bc0c0',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat().format(value) + '₫';
                            }
                        }
                    }
                }
            }
        });

        // Pie Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'doughnut',
            data: {
                labels: ['Người dùng', 'Sản phẩm', 'Đơn hàng'],
                datasets: [{
                    data: [<?= $totalUsers ?>, <?= $totalProducts ?>, <?= $totalOrdersThisWeek ?>],
                    backgroundColor: ['#36a2eb', '#4bc0c0', '#ff6384']
                }]
            },
            options: {
                responsive: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

</body>

</html>