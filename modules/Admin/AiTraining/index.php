<?php
require_once __DIR__ . '/../../../controllers/AiTrainingController.php';

$controller = new AiTrainingController();
$controller->handlePostRequest();

$knowledgeList = $controller->getKnowledgeList();
$unresolvedLogs = $controller->getUnresolvedLogs();

$flashMessage = $_SESSION['flash_message'] ?? null;
$flashError = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_message'], $_SESSION['flash_error']);
?>

<div class="container-fluid py-4">
    <!-- Alert Messages -->
    <?php if ($flashMessage): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($flashMessage) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if ($flashError): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($flashError) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-secondary small fw-bold text-uppercase">Cơ Sở Tri Thức Đã Học</div>
                        <h2 class="fw-bold mb-0 text-dark mt-1"><?= count($knowledgeList) ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center p-3" style="background-color: rgba(220, 53, 69, 0.12); width: 54px; height: 54px;">
                        <i class="fas fa-book-open text-danger fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-secondary small fw-bold text-uppercase">Câu Hỏi Cần Dạy AI</div>
                        <h2 class="fw-bold mb-0 text-warning mt-1"><?= count($unresolvedLogs) ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center p-3" style="background-color: rgba(255, 193, 7, 0.18); width: 54px; height: 54px;">
                        <i class="fas fa-question-circle text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-secondary small fw-bold text-uppercase">Trạng Thái AI Engine</div>
                        <h2 class="fw-bold mb-0 text-success mt-1">Sẵn Sàng</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center p-3" style="background-color: rgba(40, 167, 69, 0.15); width: 54px; height: 54px;">
                        <i class="fas fa-check-double text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-pills nav-fill mb-4 p-1 bg-light rounded-4 border shadow-sm" id="aiTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active rounded-4 fw-bold py-2" id="knowledge-tab" data-bs-toggle="tab" data-bs-target="#knowledge-pane" type="button">
                <i class="fas fa-list me-2"></i>Bảng Tri Thức AI (<?= count($knowledgeList) ?>)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-4 fw-bold py-2 position-relative" id="unresolved-tab" data-bs-toggle="tab" data-bs-target="#unresolved-pane" type="button">
                <i class="fas fa-lightbulb me-2 text-warning"></i>Nhật Ký & Dạy AI (<?= count($unresolvedLogs) ?>)
                <?php if (count($unresolvedLogs) > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                <?php endif; ?>
            </button>
        </li>
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content" id="aiTabContent">
        <!-- TAB 1: KNOWLEDGE LIST -->
        <div class="tab-pane fade show active" id="knowledge-pane">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <div class="row align-items-center g-2">
                        <div class="col-md-5">
                            <h5 class="fw-bold mb-0">Danh Sách Tri Thức Đã Huấn Luyện</h5>
                        </div>
                        <div class="col-md-7 d-flex align-items-center gap-2">
                            <input type="text" id="searchKnowledge" class="form-control rounded-pill" placeholder="Tìm kiếm theo từ khóa hoặc câu hỏi...">
                            <button class="btn btn-danger rounded-pill shadow-sm px-3 text-nowrap" data-bs-toggle="modal" data-bs-target="#addKnowledgeModal">
                                <i class="fas fa-plus-circle me-1"></i>Thêm Tri Thức AI Mới
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="knowledgeTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">STT</th>
                                <th style="width: 150px;">Chủ Đề</th>
                                <th style="width: 250px;">Từ Khóa Nhận Diện</th>
                                <th>Câu Hỏi Mẫu & Phản Hồi Chuẩn</th>
                                <th style="width: 100px;">Độ Ưu Tiên</th>
                                <th style="width: 130px;" class="text-end">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($knowledgeList)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        Chưa có tri thức nào. Hãy nhấn <strong>Thêm Tri Thức AI Mới</strong> để huấn luyện cho AI!
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($knowledgeList as $idx => $item): ?>
                                    <tr>
                                        <td class="fw-bold text-muted"><?= $idx + 1 ?></td>
                                        <td>
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill fw-bold">
                                                <?= htmlspecialchars($item['intent_category']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small fw-bold text-dark">
                                                <?= htmlspecialchars($item['keywords']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (!empty($item['question_pattern'])): ?>
                                                <div class="fw-bold text-primary mb-1">
                                                    <i class="fas fa-question-circle me-1"></i><?= htmlspecialchars($item['question_pattern']) ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="bg-light p-2 rounded-3 text-secondary small" style="white-space: pre-line;">
                                                <?= htmlspecialchars($item['answer_template']) ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary rounded-pill px-3"><?= $item['priority'] ?></span>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary rounded-circle me-1" onclick="editKnowledge(<?= htmlspecialchars(json_encode($item)) ?>)" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa tri thức này?');">
                                                <input type="hidden" name="action" value="delete_knowledge">
                                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 2: UNRESOLVED QUERIES & 1-CLICK TRAINING -->
        <div class="tab-pane fade" id="unresolved-pane">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0">Lịch Sử Câu Hỏi Cần Huấn Luyện (Unanswered / Feedback Log)</h5>
                    <p class="text-muted small mb-0">Dưới đây là các câu hỏi từ khách hàng mà AI chưa chắc chắn hoặc khách bấm không hài lòng. Bạn có thể huấn luyện AI trực tiếp bằng cách bấm <strong>"Dạy AI câu này"</strong>.</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">STT</th>
                                <th style="width: 250px;">Câu Hỏi Khách Đã Hỏi</th>
                                <th>AI Đã Trả Lời (Tạm thời)</th>
                                <th style="width: 150px;">Thời Gian</th>
                                <th style="width: 140px;" class="text-end">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($unresolvedLogs)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-check-circle fa-3x text-success mb-3 d-block"></i>
                                        Tuyệt vời! Hiện không có câu hỏi nào bị tồn đọng chưa được huấn luyện.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($unresolvedLogs as $idx => $log): ?>
                                    <tr>
                                        <td class="fw-bold text-muted"><?= $idx + 1 ?></td>
                                        <td class="fw-bold text-danger">
                                            <i class="fas fa-comment-dots me-2"></i><?= htmlspecialchars($log['user_query']) ?>
                                        </td>
                                        <td>
                                            <div class="bg-light p-2 rounded-3 text-muted small" style="white-space: pre-line;">
                                                <?= htmlspecialchars($log['ai_response']) ?>
                                            </div>
                                        </td>
                                        <td class="small text-muted"><?= date('H:i d/m/Y', strtotime($log['created_at'])) ?></td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-warning text-dark fw-bold rounded-pill px-3 shadow-sm" onclick="trainFromLog(<?= htmlspecialchars(json_encode($log)) ?>)">
                                                <i class="fas fa-graduation-cap me-1"></i>Dạy AI
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Knowledge -->
<div class="modal fade" id="addKnowledgeModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST">
                <input type="hidden" name="action" value="add_knowledge">
                <input type="hidden" name="log_id" id="addLogId" value="0">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fas fa-brain me-2"></i>Huấn Luyện Tri Thức Mới Cho AI</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Chủ Đề / Phân Loại <span class="text-danger">*</span></label>
                        <input type="text" name="intent_category" class="form-control rounded-3" placeholder="VD: Địa chỉ, Bảo hành, Giờ mở cửa, Khuyến mãi..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Từ Khóa Nhận Diện (Phân cách bằng dấu phẩy) <span class="text-danger">*</span></label>
                        <input type="text" name="keywords" id="addKeywords" class="form-control rounded-3" placeholder="VD: mở cửa, giờ làm việc, shop mở mấy giờ, mấy giờ đóng cửa" required>
                        <div class="form-text">AI sẽ dùng từ khóa này để tự động bắt đúng câu hỏi tương tự từ khách hàng.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Câu Hỏi Mẫu (Tùy chọn)</label>
                        <input type="text" name="question_pattern" id="addQuestionPattern" class="form-control rounded-3" placeholder="VD: Shop mở cửa từ mấy giờ đến mấy giờ?">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nội Dung Trả Lời Chuẩn <span class="text-danger">*</span></label>
                        <textarea name="answer_template" id="addAnswerTemplate" class="form-control rounded-3" rows="5" placeholder="Nhập câu trả lời chuẩn xác mà AI sẽ dùng để ứng biến với khách hàng..." required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Độ Ưu Tiên</label>
                            <input type="number" name="priority" class="form-control rounded-3" value="10">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4"><i class="fas fa-save me-2"></i>Lưu Tri Thức</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Knowledge -->
<div class="modal fade" id="editKnowledgeModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST">
                <input type="hidden" name="action" value="update_knowledge">
                <input type="hidden" name="id" id="editId">
                <div class="modal-header bg-dark text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Chỉnh Sửa Tri Thức AI</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Chủ Đề / Phân Loại</label>
                        <input type="text" name="intent_category" id="editCategory" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Từ Khóa Nhận Diện</label>
                        <input type="text" name="keywords" id="editKeywords" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Câu Hỏi Mẫu</label>
                        <input type="text" name="question_pattern" id="editQuestion" class="form-control rounded-3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nội Dung Trả Lời Chuẩn</label>
                        <textarea name="answer_template" id="editAnswer" class="form-control rounded-3" rows="5" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Độ Ưu Tiên</label>
                            <input type="number" name="priority" id="editPriority" class="form-control rounded-3">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Trạng Thái</label>
                            <select name="status" id="editStatus" class="form-select rounded-3">
                                <option value="1">Hoạt động (Active)</option>
                                <option value="0">Tạm dừng (Disabled)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="fas fa-save me-2"></i>Cập Nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Search filter for Knowledge Table
    document.getElementById('searchKnowledge').addEventListener('keyup', function() {
        const val = this.value.toLowerCase();
        const rows = document.querySelectorAll('#knowledgeTable tbody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(val) ? '' : 'none';
        });
    });

    function editKnowledge(item) {
        document.getElementById('editId').value = item.id;
        document.getElementById('editCategory').value = item.intent_category;
        document.getElementById('editKeywords').value = item.keywords;
        document.getElementById('editQuestion').value = item.question_pattern || '';
        document.getElementById('editAnswer').value = item.answer_template;
        document.getElementById('editPriority').value = item.priority;
        document.getElementById('editStatus').value = item.status;

        const modal = new bootstrap.Modal(document.getElementById('editKnowledgeModal'));
        modal.show();
    }

    function trainFromLog(log) {
        document.getElementById('addLogId').value = log.id;
        document.getElementById('addKeywords').value = log.user_query;
        document.getElementById('addQuestionPattern').value = log.user_query;
        document.getElementById('addAnswerTemplate').value = '';

        const modal = new bootstrap.Modal(document.getElementById('addKnowledgeModal'));
        modal.show();
    }
</script>
