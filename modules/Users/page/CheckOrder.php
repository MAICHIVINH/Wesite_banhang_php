<?php
$keyword = $_GET['search'] ?? '';
$statusGetAll = $statusController->getAll();

$filterStatusId = $_GET['filter_status'] ?? '0';
$searchCode = $_POST['order_code'] ?? '';

$statusId = $_GET['status_id'] ?? '';
$page = max(1, (int) ($_GET['page'] ?? 1));
$limit = 2;
$offset = ($page - 1) * $limit;

if (empty($userData) || !isset($userData->id)) {
    swal_alert('warning', 'Chưa đăng nhập', 'Vui lòng đăng nhập để tra cứu đơn hàng của bạn.', 'index.php');
    exit;
}

$userId = (int) $userData->id;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnReview'])) {
    $order_id = $_POST['order_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $getOrderItem = $orderItemController->getOrderItemById($order_id);
    foreach ($getOrderItem as $item) {
        $data = [
            'rating' => $rating,
            'comment' => $comment,
            'user_id' => $userData->id,
            'product_id' => $item['product_id'],
            'isDeleted' => '0'
        ];
        $result = $reviewController->add($data);
        if ($result) {
            swal_alert('success', 'Đánh giá đơn hàng thành công!', '', "Index.php?subpage=modules/Users/page/CheckOrder.php&filter_status=$filterStatusId");
        } else {
            swal_alert('error', 'Đánh giá đơn hàng thất bại!', 'Hệ thống đang bảo trì!', "Index.php?subpage=modules/Users/page/CheckOrder.php&filter_status=$filterStatusId");
        }
    }
    $orderController->edit($order_id, ['status_id' => 6]);
    exit;
}

if ($filterStatusId == 0) {
    $orders = $orderController->getOrderPagination(
        $userId,
        null,
        $limit,
        $offset,
        $keyword,
    );
    $totalRows = $orderController->getCountOrder(
        $userId,
        null,
        $keyword,
    );
} else {
    $orders = $orderController->getOrderPagination(
        $userId,
        $filterStatusId,
        $limit,
        $offset,
        $keyword,
    );
    $totalRows = $orderController->getCountOrder(
        $userId,
        $filterStatusId,
        $keyword,
    );
}



$totalPages = max(1, ceil($totalRows / $limit));
$groupSize = 3;
$pageGroup = ceil($page / $groupSize);
$startPage = ($pageGroup - 1) * $groupSize + 1;
$endPage = min($startPage + $groupSize - 1, $totalPages);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order'])) {
    $node_cancel = $_POST['cancel_reason'] ?? "";
    $cancel_by = "user." . $userData->id;
    $id = $_POST['cancel_order'];
    $data = [
        "status_id" => 5,
        "cancel_reason" => $node_cancel,
        "cancel_at" => date("Y-m-d H:i:s"),
        "cancel_by" => $cancel_by
    ];
    $result = $orderController->edit($id, $data);

    if ($result['success']) {
        swal_alert('success', 'Hủy đơn hàng thành công!', '', "Index.php?subpage=modules/Users/page/CheckOrder.php&filter_status=$filterStatusId");
    } else {
        swal_alert('error', 'Hủy đơn hàng thất bại!', 'Hệ thống đang bảo trì!', "Index.php?subpage=modules/Users/page/CheckOrder.php&filter_status=$filterStatusId");
    }
}
?>

<style>
    .star {
        cursor: pointer;
        color: #ccc;
        transition: color 0.2s;
    }

    .star.selected {
        color: gold;
    }

    /* Modern Review Modal Styling */
    #reviewModal .modal-dialog {
        max-width: 780px;
        width: 90%;
    }

    #reviewModal .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    #reviewModal .modal-header-gradient {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #ffffff;
        padding: 1.25rem 1.5rem;
    }

    #reviewModal .modal-body {
        max-height: calc(85vh - 120px);
        overflow-y: auto;
    }

    #reviewModal .star-rating-custom .star {
        font-size: 2rem;
        color: #cbd5e1;
        cursor: pointer;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    #reviewModal .star-rating-custom .star:hover,
    #reviewModal .star-rating-custom .star.active,
    #reviewModal .star-rating-custom .star.hovered {
        color: #f59e0b;
    }

    #reviewModal .star-rating-custom .star:hover {
        transform: scale(1.2);
    }

    .quick-tag-chip {
        display: inline-block;
        border: 1px solid #e2e8f0;
        background-color: #ffffff;
        color: #475569;
        border-radius: 50rem;
        padding: 5px 12px;
        font-size: 0.825rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
        margin: 2px 2px;
    }

    .quick-tag-chip:hover,
    .quick-tag-chip.selected {
        background-color: #e0e7ff;
        border-color: #6366f1;
        color: #4338ca;
        transform: translateY(-1px);
    }

    #reviewModal .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
    }

    /* Constrain and style TinyMCE editor inside review modal */
    #reviewModal .tox-tinymce {
        height: 240px !important;
        min-height: 220px !important;
        border-radius: 0.75rem !important;
        border-color: #e2e8f0 !important;
    }

    #reviewModal .tox-edit-area__iframe {
        min-height: 150px !important;
    }

    #reviewModal .btn-submit-review {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        border: none;
        color: #ffffff;
        transition: all 0.2s ease;
    }

    #reviewModal .btn-submit-review:hover {
        background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
</style>


<div class="order-page-container container my-4">
    <div class="order-layout">
        <div class="order-content">
            <div class="order-header">
                <h5>Đơn hàng đã mua</h5>
                <div class="search-filter">
                    <form method="get" class="order-search-form">
                        <input type="hidden" name="subpage" value="modules/Users/page/CheckOrder.php">
                        <input type="hidden" name="filter_status" value="<?= $filterStatusId ?>">
                        <div class="search-box">
                            <input type="text" name="search" placeholder="Nhập mã đơn hàng..." value="<?= $keyword ?>">
                            <button type="submit" class="btn btn-primary">Tra cứu</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bộ lọc trạng thái -->
            <form method="post" class="status-filter-form mb-3">
                <input type="hidden" name="filter_status" id="filter_status"
                    value="<?= htmlspecialchars($filterStatusId) ?>">
                <div class="order-status-filter">
                    <a class="status-btn text-decoration-none <?= ($filterStatusId == 0) ? 'active' : '' ?>"
                        href="index.php?subpage=modules/Users/page/CheckOrder.php&filter_status=0">Tất cả</a>

                    <?php foreach ($statusGetAll as $status): ?>
                        <a type="button"
                            class="status-btn text-decoration-none <?= ($filterStatusId == $status['id']) ? 'active' : '' ?>"
                            href="index.php?subpage=modules/Users/page/CheckOrder.php&filter_status=<?= $status['id'] ?>">
                            <?= htmlspecialchars($status['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </form>

            <?php
            $filter = $_POST['filter_status'] ?? 'Tất cả';
            $searchCode = $_POST['order_id'] ?? '';
            $filteredOrders = [];

            foreach ($orders as $order) {
                if (
                    ($filter === 'Tất cả' || $order['status_id'] === $filter) &&
                    ($searchCode === '' || stripos($order['order_id'], $searchCode) !== false)
                ) {
                    $filteredOrders[] = $order;
                }
            }
            ?>

            <?php if (count($orders) > 0) {
                ?>
                <?php foreach ($orders as $order) { ?>
                    <?php
                    $orderItems = $orderItemController->getOrderItemById($order["order_id"]);
                    ?>
                    <div class="order-item">
                        <div class="order-item-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h6>Mã đơn: <?= htmlspecialchars($order['code']) ?> | Trạng thái đơn: <span
                                        class="badge bg-primary text-white me-1"><?= htmlspecialchars($order['status_name']) ?></span><?php if (!empty($order['payment_status'])) { ?>
                                    <?php } ?></h6>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <?php if ($order['status_id'] === 4 && $order['status_shipping'] === 'Hoàn thành') { ?>
                                    <button type="button" class="btn btn-outline-success btn-sm open-review-modal"
                                        data-order-id="<?= htmlspecialchars($order['order_id']) ?>" data-bs-toggle="modal"
                                        data-bs-target="#reviewModal" style=" background-color: #28a745; 
                                                color: #fff; 
                                                border: none;
                                                padding: 5px 14px;
                                                border-radius: 20px;
                                                font-size: 0.9rem;
                                                transition: background-color 0.3s ease;
                                                box-shadow: 0 2px 5px rgba(40, 167, 69, 0.2);
                                                text-decoration: none;
                                                display: inline-block;"
                                        onmouseover="this.style.backgroundColor='#218838'"
                                        onmouseout="this.style.backgroundColor='#28a745'">
                                        Đã nhận được hàng
                                    </button>
                                <?php } ?>
                                <?php if ($order['status_id'] === 4) { ?>
                                    <a href="index.php?subpage=modules/Users/page/OrderTracking.php&order_id=<?= htmlspecialchars($order['order_id']) ?>"
                                        class="btn btn-outline-primary btn-sm" style=" background-color: #007bff; 
                                                color: #fff; 
                                                border: none;
                                                padding: 5px 14px;
                                                border-radius: 20px;
                                                font-size: 0.9rem;
                                                transition: background-color 0.3s ease;
                                                box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
                                                text-decoration: none;
                                                display: inline-block;"
                                        onmouseover="this.style.backgroundColor='#0056b3'"
                                        onmouseout="this.style.backgroundColor='#007bff'">
                                        Xem vị trí đơn hàng
                                    </a>
                                <?php } ?>
                                <?php if ($order['status_name'] === 'Chờ xử lý') { ?>
                                    <a href="index.php?subpage=modules/Users/page/OnlinePayment.php&order_id=<?= htmlspecialchars($order['order_id']) ?>"
                                        class="btn btn-warning btn-sm fw-bold me-1 text-dark"
                                        style="border-radius: 20px; box-shadow: 0 2px 5px rgba(255, 193, 7, 0.3); text-decoration: none;">
                                        <i class="bi bi-qr-code-scan me-1"></i> Thanh toán Online (QR)
                                    </a>
                                <?php } ?>
                                <strong class="mb-0">Tổng tiền:
                                    <?= number_format($order['total_amount'], 0, ',', '.') ?>₫</strong>
                            </div>
                        </div>

                        <div class="order-item-info-row">
                            <div class="shipping-info">
                                <h5>Thông tin nhận hàng:</h5>
                                <p><strong>Họ tên:</strong> <?= htmlspecialchars($order['FullName']) ?></p>
                                <p><strong>SĐT:</strong> <?= htmlspecialchars($order['Phone']) ?></p>
                                <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['Address']) ?></p>
                                <p><strong>Email:</strong> <?= htmlspecialchars($order['Email']) ?></p>
                            </div>

                            <div class="order-product-list">
                                <h5>Thông tin sản phẩm:</h5>
                                <?php foreach ($orderItems as $product) { ?>
                                    <div class="order-product">
                                        <img src="<?= htmlspecialchars($product['image_url']) ?>"
                                            alt="<?= htmlspecialchars($product['name']) ?>">
                                        <div class="order-product-info">
                                            <h6><?= htmlspecialchars($product['name']) ?></h6>
                                            <div class="order-product-price">
                                                <?= number_format($product['unit_price'], 0, ',', '.') ?>₫</div>
                                            <p>Số lượng: <?= $product['quantity'] ?></p>
                                        </div>
                                    </div>
                                <?php }
                                ; ?>
                            </div>
                        </div>
                        <?php if ($order['status_name'] === 'Chờ xử lý' || (int) $order['status_id'] === 7) { ?>
                            <button type="button" class="cancel-btn" data-bs-toggle="modal" data-bs-target="#cancelModal"
                                data-order-id="<?= htmlspecialchars($order['order_id']) ?>">
                                Hủy đơn hàng
                            </button>
                        <?php } ?>

                    </div>
                <?php }
            } else { ?>
                <div class="empty-order">
                    <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" alt="No order">
                    <h6>Rất tiếc, không tìm thấy đơn hàng nào phù hợp</h6>
                </div>
            <?php } ?>
            <?php if (count($orders) > 0 && $totalPages > 1) { ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">

                        <?php if ($totalPages > $groupSize && $startPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="index.php?subpage=modules/Users/page/CheckOrder.php&search=<?= $keyword ?>&page=<?= $startPage - 1 ?>&filter_status=<?= $filterStatusId ?>&order_code=<?= urlencode($searchCode) ?>">
                                    «
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="index.php?subpage=modules/Users/page/CheckOrder.php&search=<?= $keyword ?>&page=<?= $i ?>&filter_status=<?= $filterStatusId ?>&order_code=<?= urlencode($searchCode) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($totalPages > $groupSize && $endPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="index.php?subpage=modules/Users/page/CheckOrder.php&search=<?= $keyword ?>&page=<?= $endPage + 1 ?>&filter_status=<?= $filterStatusId ?>&order_code=<?= urlencode($searchCode) ?>">
                                    »
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Xử lý Map -->
<!-- <h1>Vị trí đơn hàng của bạn</h1>
<div id="map" style="width:100%;height:400px;"></div> -->

<?php
$cancelReasons = [
    "Muốn đổi sản phẩm",
    "Đặt nhầm",
    "Thời gian giao hàng lâu",
    "Tìm được giá tốt hơn",
    "Không còn nhu cầu",
    "Khác"
];
?>

<!-- Modal chọn lý do hủy -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"
        style="display: flex; align-items: center; justify-content: center;">
        <form method="post" id="cancelForm">
            <input type="hidden" name="cancel_order" id="cancel_order_id">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-semibold text-primary">
                        <i class="bi bi-x-circle-fill me-2 text-danger"></i>Chọn lý do hủy đơn
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-white">
                    <p class="mb-3 text-muted">
                        Trước khi hủy đơn, bạn vui lòng cho chúng tôi biết lý do. Điều này giúp chúng tôi cải thiện chất
                        lượng dịch vụ tốt hơn.
                    </p>
                    <select class="form-select rounded-3 py-3 px-4" id="reasonSelect" name="cancel_reason" required>
                        <option disabled selected>-- Chọn lý do --</option>
                        <?php foreach ($cancelReasons as $reason): ?>
                            <option value="<?= htmlspecialchars($reason) ?>"><?= htmlspecialchars($reason) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="submit" class="btn btn-danger px-4 py-2 rounded-3 fs-6">Xác nhận hủy</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Modal nhập lý do khác -->
<div class="modal fade" id="customReasonModal" tabindex="-1" aria-labelledby="customReasonModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"
        style="display: flex; align-items: center; justify-content: center;">
        <form method="post">
            <input type="hidden" name="cancel_order" id="custom_order_id">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-semibold text-primary">
                        Nhập lý do hủy đơn
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-white">
                    <p class="mb-3 text-muted">
                        Bạn đã chọn "Khác" là lý do hủy đơn. Hãy cho chúng tôi biết thêm chi tiết để có thể cải thiện
                        dịch vụ trong tương lai.
                    </p>
                    <div class="form-group">
                        <label class="form-label fw-semibold mb-2">Lý do cụ thể</label>
                        <textarea class="form-control rounded-3 py-2 px-3 fs-6" name="cancel_reason" rows="4" required
                            placeholder="Ví dụ: Tôi cần thay đổi địa chỉ giao hàng, đơn bị lỗi thanh toán, v.v..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="submit" class="btn btn-danger px-4 py-2 rounded-3">Xác nhận hủy</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Modal đánh giá -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form method="post" novalidate id="reviewForm" class="w-100">
            <div class="modal-content">
                <div class="modal-header modal-header-gradient border-0 align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-white text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-star-fill text-warning fs-5"></i>
                        </span>
                        <div>
                            <h5 class="modal-title fw-bold text-white mb-0" id="reviewModalLabel">Đánh giá sản phẩm</h5>
                            <small class="text-white-50">Ý kiến của bạn giúp chúng tôi cải thiện chất lượng dịch vụ</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <input type="hidden" name="order_id" id="review_order_id">

                    <!-- Top 2-Column Grid for Rating and Quick Tags -->
                    <div class="row g-3 mb-3">
                        <!-- Left Column: Star Rating -->
                        <div class="col-md-5">
                            <div class="h-100 p-3 bg-light rounded-3 border border-light-subtle text-center d-flex flex-column justify-content-center">
                                <label class="form-label d-block text-secondary fw-semibold mb-1 fs-7">Trải nghiệm mua hàng:</label>
                                <div class="star-rating-custom d-flex justify-content-center gap-2 mb-1">
                                    <i class="bi bi-star star" data-value="1"></i>
                                    <i class="bi bi-star star" data-value="2"></i>
                                    <i class="bi bi-star star" data-value="3"></i>
                                    <i class="bi bi-star star" data-value="4"></i>
                                    <i class="bi bi-star star" data-value="5"></i>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span id="rating-emoji" class="fs-4">🌟</span>
                                    <span id="rating-text" class="fw-bold text-secondary fs-7">Chọn số sao</span>
                                </div>
                                <input type="hidden" name="rating" id="rating" required>
                            </div>
                        </div>

                        <!-- Right Column: Quick Suggestion Tags -->
                        <div class="col-md-7">
                            <div class="h-100 p-3 bg-light rounded-3 border border-light-subtle d-flex flex-column justify-content-center">
                                <label class="form-label text-secondary fw-semibold mb-2 fs-7">Gợi ý đánh giá nhanh:</label>
                                <div class="d-flex flex-wrap gap-1" id="quickTagsContainer">
                                    <span class="quick-tag-chip" data-tag="Giao hàng nhanh 🚚">Giao hàng nhanh 🚚</span>
                                    <span class="quick-tag-chip" data-tag="Đóng gói cẩn thận 🎁">Đóng gói cẩn thận 🎁</span>
                                    <span class="quick-tag-chip" data-tag="Sản phẩm chất lượng ⭐">Sản phẩm chất lượng ⭐</span>
                                    <span class="quick-tag-chip" data-tag="Tư vấn nhiệt tình 💬">Tư vấn nhiệt tình 💬</span>
                                    <span class="quick-tag-chip" data-tag="Giá cả hợp lý 💰">Giá cả hợp lý 💰</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comment Textarea Section -->
                    <div class="mb-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="comment" class="form-label text-secondary fw-semibold mb-0 fs-6">Nhận xét chi tiết:</label>
                            <small class="text-muted"><span id="char-count">0</span>/500 ký tự</small>
                        </div>
                        <textarea class="form-control rounded-3 p-3" id="comment" name="comment" rows="4" maxlength="500" placeholder="Hãy chia sẻ trải nghiệm về sản phẩm, đóng gói và thái độ giao hàng..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-light border px-4 py-2 rounded-3 text-secondary fw-semibold"
                        data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-submit-review px-4 py-2 rounded-3 fw-semibold shadow-sm"
                        name="btnReview" id="btnSubmitReview">
                        <i class="bi bi-send-fill me-2"></i>Gửi đánh giá
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cancelButtons = document.querySelectorAll(".cancel-btn");
        const cancelInput = document.getElementById("cancel_order_id");
        const reviewButtons = document.querySelectorAll(".open-review-modal");
        const orderIdInput = document.getElementById("review_order_id");
        const stars = document.querySelectorAll("#reviewModal .star");
        const ratingInput = document.getElementById("rating");
        const ratingText = document.getElementById("rating-text");
        const ratingEmoji = document.getElementById("rating-emoji");
        const commentTextarea = document.getElementById("comment");
        const charCount = document.getElementById("char-count");
        const quickTags = document.querySelectorAll(".quick-tag-chip");
        const reviewForm = document.getElementById("reviewForm");

        const ratingLabels = {
            1: { text: "Rất không hài lòng", emoji: "😞", color: "text-danger" },
            2: { text: "Không hài lòng", emoji: "🙁", color: "text-warning" },
            3: { text: "Bình thường", emoji: "😐", color: "text-info" },
            4: { text: "Hài lòng", emoji: "🙂", color: "text-primary" },
            5: { text: "Tuyệt vời!", emoji: "😍", color: "text-success" }
        };

        cancelButtons.forEach(button => {
            button.addEventListener("click", function () {
                const orderId = this.getAttribute("data-order-id");
                if (cancelInput) cancelInput.value = orderId;
            });
        });

        reviewButtons.forEach(button => {
            button.addEventListener("click", function () {
                const orderId = this.getAttribute("data-order-id");
                if (orderIdInput) orderIdInput.value = orderId;

                // Reset form state when modal opens
                ratingInput.value = "";
                if (commentTextarea) commentTextarea.value = "";
                if (typeof tinymce !== 'undefined' && tinymce.get('comment')) {
                    tinymce.get('comment').setContent('');
                }
                if (charCount) charCount.textContent = "0";
                if (ratingText) {
                    ratingText.textContent = "Chọn số sao";
                    ratingText.className = "fw-bold text-secondary fs-7";
                }
                if (ratingEmoji) ratingEmoji.textContent = "🌟";

                stars.forEach(s => {
                    s.classList.remove("active", "hovered");
                    s.classList.replace("bi-star-fill", "bi-star");
                });

                quickTags.forEach(tag => tag.classList.remove("selected"));
            });
        });

        function updateStarDisplay(value, isHover = false) {
            stars.forEach((s, i) => {
                const starVal = i + 1;
                if (starVal <= value) {
                    if (isHover) {
                        s.classList.add("hovered");
                    } else {
                        s.classList.add("active");
                    }
                    s.classList.replace("bi-star", "bi-star-fill");
                } else {
                    s.classList.remove("active", "hovered");
                    s.classList.replace("bi-star-fill", "bi-star");
                }
            });

            if (value in ratingLabels) {
                ratingText.textContent = ratingLabels[value].text;
                ratingText.className = `fw-bold ${ratingLabels[value].color} fs-7`;
                ratingEmoji.textContent = ratingLabels[value].emoji;
            }
        }

        stars.forEach(star => {
            star.addEventListener("mouseenter", function () {
                const val = parseInt(this.getAttribute("data-value"));
                updateStarDisplay(val, true);
            });

            star.addEventListener("mouseleave", function () {
                const currentVal = parseInt(ratingInput.value) || 0;
                if (currentVal > 0) {
                    updateStarDisplay(currentVal, false);
                } else {
                    stars.forEach(s => {
                        s.classList.remove("active", "hovered");
                        s.classList.replace("bi-star-fill", "bi-star");
                    });
                    ratingText.textContent = "Chọn số sao";
                    ratingText.className = "fw-bold text-secondary fs-7";
                    ratingEmoji.textContent = "🌟";
                }
            });

            star.addEventListener("click", function () {
                const val = parseInt(this.getAttribute("data-value"));
                ratingInput.value = val;
                updateStarDisplay(val, false);
            });
        });

        // Quick Tag Chip Toggle Logic with TinyMCE Sync
        quickTags.forEach(chip => {
            chip.addEventListener("click", function () {
                const tagText = this.getAttribute("data-tag");
                this.classList.toggle("selected");

                let currentVal = "";
                if (typeof tinymce !== 'undefined' && tinymce.get('comment')) {
                    currentVal = tinymce.get('comment').getContent({ format: 'text' }).trim();
                } else {
                    currentVal = commentTextarea.value.trim();
                }

                let newVal = "";
                if (this.classList.contains("selected")) {
                    if (currentVal.length > 0) {
                        newVal = currentVal + ". " + tagText;
                    } else {
                        newVal = tagText;
                    }
                } else {
                    newVal = currentVal.replace(tagText, "").replace(/\.\s*\./g, ".").trim();
                }

                commentTextarea.value = newVal;
                if (typeof tinymce !== 'undefined' && tinymce.get('comment')) {
                    tinymce.get('comment').setContent(newVal);
                }

                if (charCount) {
                    charCount.textContent = newVal.length;
                }
            });
        });

        // Character counter logic
        if (commentTextarea && charCount) {
            commentTextarea.addEventListener("input", function () {
                charCount.textContent = this.value.length;
            });
        }

        // Form submit validation & TinyMCE Sync
        if (reviewForm) {
            reviewForm.addEventListener("submit", function (e) {
                if (typeof tinymce !== 'undefined' && tinymce.get('comment')) {
                    tinymce.triggerSave();
                }

                if (!ratingInput.value || ratingInput.value === "") {
                    e.preventDefault();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Chưa chọn số sao',
                            text: 'Vui lòng chọn đánh giá từ 1 đến 5 sao trước khi gửi!',
                            confirmColor: '#4f46e5'
                        });
                    } else {
                        alert('Vui lòng chọn đánh giá từ 1 đến 5 sao trước khi gửi!');
                    }
                    return false;
                }
            });
        }

        // Cancel order reason change handler
        const reasonSelect = document.getElementById('reasonSelect');
        if (reasonSelect) {
            reasonSelect.addEventListener('change', function () {
                if (this.value === 'Khác') {
                    const orderId = document.getElementById('cancel_order_id').value;
                    const cancelModalInstance = bootstrap.Modal.getInstance(document.getElementById('cancelModal'));
                    if (cancelModalInstance) cancelModalInstance.hide();

                    document.getElementById('custom_order_id').value = orderId;
                    const customModal = new bootstrap.Modal(document.getElementById('customReasonModal'));
                    customModal.show();
                }
            });
        }
    });
</script>