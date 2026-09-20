<?php

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_banner') {
        $file = $_FILES['image_file'] ?? null;
        $res = $bannerController->add($_POST, $file);
        if ($res['success']) {
            $_SESSION['success'] = $res['message'];
        } else {
            $_SESSION['error'] = $res['message'];
        }
        echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Banners/Banner.php';</script>";
        exit;
    }

    if ($action === 'update_banner') {
        $id = (int)($_POST['id'] ?? 0);
        $file = $_FILES['image_file'] ?? null;
        $res = $bannerController->update($id, $_POST, $file);
        if ($res['success']) {
            $_SESSION['success'] = $res['message'];
        } else {
            $_SESSION['error'] = $res['message'];
        }
        echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Banners/Banner.php';</script>";
        exit;
    }

    if ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);
        $res = $bannerController->toggleStatus($id);
        if ($res['success']) {
            $_SESSION['success'] = $res['message'];
        } else {
            $_SESSION['error'] = $res['message'];
        }
        echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Banners/Banner.php';</script>";
        exit;
    }

    if ($action === 'delete_banner') {
        $id = (int)($_POST['id'] ?? 0);
        $res = $bannerController->delete($id);
        if ($res['success']) {
            $_SESSION['success'] = $res['message'];
        } else {
            $_SESSION['error'] = $res['message'];
        }
        echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Banners/Banner.php';</script>";
        exit;
    }
}

$positions = $bannerController->getPositions();
$filterPosition = $_GET['pos'] ?? '';
$allBanners = $bannerController->getAll();

if ($filterPosition !== '') {
    $banners = array_filter($allBanners, function($b) use ($filterPosition) {
        return ($b['position'] ?? 'slider_main') === $filterPosition;
    });
} else {
    $banners = $allBanners;
}
?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addBannerModal">
            <i class="bi bi-plus-circle me-2"></i>Thêm Banner Mới
        </button>
    </div>

    <!-- Filter by Position -->
    <div class="bg-white p-3 rounded shadow-sm border mb-4">
        <div class="d-flex align-items-center flex-wrap gap-2">
            <span class="fw-bold me-2"><i class="bi bi-funnel me-1"></i>Lọc theo vị trí:</span>
            <a href="Admin.php?page=modules/Admin/Banners/Banner.php" class="btn btn-sm <?= $filterPosition === '' ? 'btn-danger' : 'btn-outline-secondary' ?>">
                Tất cả vị trí
            </a>
            <?php foreach ($positions as $key => $name): ?>
                <a href="Admin.php?page=modules/Admin/Banners/Banner.php&pos=<?= $key ?>" class="btn btn-sm <?= $filterPosition === $key ? 'btn-danger' : 'btn-outline-secondary' ?>">
                    <?= htmlspecialchars($name) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="table-container bg-white p-3 rounded shadow-sm border">
        <table class="table table-bordered table-hover align-middle custom-table mb-0">
            <thead class="table-dark text-center">
                <tr>
                    <th style="width: 60px;">STT</th>
                    <th style="min-width: 220px;">Hình ảnh Banner</th>
                    <th style="min-width: 180px;">Tiêu đề & Link</th>
                    <th style="width: 200px;">Vị trí hiển thị</th>
                    <th style="width: 130px;">Trạng thái</th>
                    <th style="width: 160px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($banners)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Chưa có banner nào ở vị trí này. Bấm "Thêm Banner Mới" để tạo!</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($banners as $index => $b):
                        $posKey = $b['position'] ?? 'slider_main';
                        $posName = $positions[$posKey] ?? 'Carousel chính';
                    ?>
                        <tr>
                            <td class="text-center font-weight-bold"><?= $index + 1 ?></td>
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-start">
                                    <img src="<?= htmlspecialchars($b['image']) ?>" alt="Banner" class="rounded border mb-1" style="width: 180px; height: 60px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/180x60?text=Loi+Anh';">
                                    <span class="small text-muted text-break" style="max-width: 200px; font-size: 11px;">
                                        <?= htmlspecialchars($b['image']) ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-1"><?= htmlspecialchars($b['title'] ?? 'Chưa đặt tiêu đề') ?></div>
                                <?php if (!empty($b['link'])): ?>
                                    <a href="<?= htmlspecialchars($b['link']) ?>" target="_blank" class="small text-primary text-decoration-none">
                                        <i class="bi bi-link-45deg"></i> <?= htmlspecialchars($b['link']) ?>
                                    </a>
                                <?php else: ?>
                                    <span class="small text-muted">Không có liên kết</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($posKey === 'slider_main'): ?>
                                    <span class="badge bg-primary fs-6"><i class="bi bi-pip me-1"></i><?= htmlspecialchars($posName) ?></span>
                                <?php elseif ($posKey === 'side_banner'): ?>
                                    <span class="badge bg-info text-dark fs-6"><i class="bi bi-layout-sidebar me-1"></i><?= htmlspecialchars($posName) ?></span>
                                <?php elseif ($posKey === 'middle_home'): ?>
                                    <span class="badge bg-warning text-dark fs-6"><i class="bi bi-card-heading me-1"></i><?= htmlspecialchars($posName) ?></span>
                                <?php else: ?>
                                    <span class="badge bg-secondary fs-6"><i class="bi bi-border-bottom me-1"></i><?= htmlspecialchars($posName) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                    <?php if (isset($b['status']) && (int)$b['status'] === 1): ?>
                                        <button type="submit" class="btn btn-sm btn-success border-0 px-3 py-1 rounded-pill" title="Click để ẩn banner">
                                            <i class="bi bi-check-circle me-1"></i> Hiển thị
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-sm btn-secondary border-0 px-3 py-1 rounded-pill" title="Click để hiện banner">
                                            <i class="bi bi-eye-slash me-1"></i> Đang ẩn
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <li>
                                            <button type="button" class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#editBannerModal<?= $b['id'] ?>">
                                                <i class="bi bi-pencil-square me-2"></i> Chỉnh sửa
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteBannerModal<?= $b['id'] ?>">
                                                <i class="bi bi-trash me-2"></i> Xóa banner
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit Banner -->
                        <div class="modal fade" id="editBannerModal<?= $b['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="update_banner">
                                        <input type="hidden" name="id" value="<?= $b['id'] ?>">

                                        <div class="modal-header bg-warning text-dark">
                                            <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Cập nhật Banner #<?= $b['id'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tiêu đề Banner / Mô tả</label>
                                                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($b['title'] ?? '') ?>" placeholder="VD: Khuyến mãi Laptop Gaming Asus">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-danger">Vị trí hiển thị Banner</label>
                                                <select name="position" class="form-select border-danger">
                                                    <?php foreach ($positions as $k => $n): ?>
                                                        <option value="<?= $k ?>" <?= ($posKey === $k) ? 'selected' : '' ?>><?= htmlspecialchars($n) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Đường dẫn khi click (Link URL)</label>
                                                <input type="text" name="link" class="form-control" placeholder="index.php?subpage=..." value="<?= htmlspecialchars($b['link'] ?? '') ?>">
                                            </div>

                                            <div class="mb-3 text-center">
                                                <label class="form-label d-block fw-bold text-secondary">Hình ảnh hiện tại</label>
                                                <img src="<?= htmlspecialchars($b['image']) ?>" class="img-fluid rounded border mb-2" style="max-height: 100px;" onerror="this.src='https://via.placeholder.com/300x100?text=Loi+Anh';">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tải lên tệp ảnh mới (nếu thay đổi)</label>
                                                <input type="file" name="image_file" class="form-control" accept="image/*">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Hoặc nhập URL hình ảnh mới</label>
                                                <input type="text" name="image_url" class="form-control" placeholder="https://example.com/banner.jpg" value="<?= htmlspecialchars($b['image']) ?>">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Trạng thái</label>
                                                <select name="status" class="form-select">
                                                    <option value="1" <?= (isset($b['status']) && (int)$b['status'] === 1) ? 'selected' : '' ?>>Hiển thị</option>
                                                    <option value="0" <?= (isset($b['status']) && (int)$b['status'] === 0) ? 'selected' : '' ?>>Đang ẩn</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-save me-1"></i>Lưu Thay Đổi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Delete Banner -->
                        <div class="modal fade" id="deleteBannerModal<?= $b['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST">
                                        <input type="hidden" name="action" value="delete_banner">
                                        <input type="hidden" name="id" value="<?= $b['id'] ?>">

                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle me-2"></i>Xác nhận xóa Banner</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p class="mb-2 fs-5">Bạn có chắc chắn muốn xóa Banner <strong>#<?= $b['id'] ?></strong>?</p>
                                            <img src="<?= htmlspecialchars($b['image']) ?>" class="img-fluid rounded border mb-2" style="max-height: 100px;">
                                            <p class="text-danger small mb-0">Hành động này sẽ xóa banner khỏi hệ thống.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <button type="submit" class="btn btn-danger fw-bold"><i class="bi bi-trash me-1"></i>Xác Nhận Xóa</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Add Banner -->
<div class="modal fade" id="addBannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_banner">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Thêm Banner Quảng Cáo Mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề Banner / Mô tả ngắn</label>
                        <input type="text" name="title" class="form-control" placeholder="VD: Khuyến mãi Laptop Gaming Asus 2025">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-danger">Chọn Vị trí hiển thị Banner</label>
                        <select name="position" class="form-select border-danger">
                            <?php foreach ($positions as $k => $n): ?>
                                <option value="<?= $k ?>" <?= ($filterPosition === $k || ($filterPosition === '' && $k === 'slider_main')) ? 'selected' : '' ?>><?= htmlspecialchars($n) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Chọn vị trí mà bạn muốn banner xuất hiện trên website.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Đường dẫn khi click (Link URL - Không bắt buộc)</label>
                        <input type="text" name="link" class="form-control" placeholder="VD: index.php?subpage=modules/Users/page/Product.php">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tải tệp hình ảnh từ máy tính</label>
                        <input type="file" name="image_file" class="form-control" accept="image/*">
                    </div>

                    <div class="text-center text-muted fw-bold my-2">- HOẶC -</div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nhập đường dẫn URL hình ảnh</label>
                        <input type="text" name="image_url" class="form-control" placeholder="https://example.com/hinh-banner.jpg">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="1" selected>Hiển thị ngay</option>
                            <option value="0">Đang ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger fw-bold"><i class="bi bi-plus-lg me-1"></i>Thêm Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>
