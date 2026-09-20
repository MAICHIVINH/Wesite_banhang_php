<?php

$keyword = $_GET['search'] ?? '';

$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$totalBranch = $branchController->countBranch($keyword, 1);
$totalPages = ceil($totalBranch / $limit);
$deletedBranches = $branchController->getPagination($limit, $offset, $keyword, 1);

$totalBranchIsDeleted = $branchController->countIsDeleted();

require_once 'RestoreBranch.php';
require_once 'DeleteBranch.php';
?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap p-3 rounded shadow-sm bg-light border">
        <h4 class="mb-0 fw-bold text-danger d-flex align-items-center">
            <i class="fas fa-trash-alt me-2"></i> Thùng rác - Chi nhánh đã xóa
        </h4>
        <span class="badge bg-danger px-3 py-2 fs-6">
            <?= $totalBranchIsDeleted ?> mục đã xóa
        </span>
    </div>


    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th>Mã</th>
                    <th>Tên chi nhánh</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Ngày tạo</th>
                    <th style="width: 250px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($deletedBranches)) : ?>
                    <tr>
                        <td colspan="7" class="text-center">Không có chi nhánh nào trong thùng rác.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($deletedBranches as $branch) : ?>
                        <tr>
                            <td><?= $branch['id'] ?></td>
                            <td><?= htmlspecialchars($branch['name']) ?></td>
                            <td><?= htmlspecialchars($branch['address']) ?></td>
                            <td><?= $branch['phone'] ?></td>
                            <td><?= $branch['email'] ?></td>
                            <td><?= $branch['created_at'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-success restore-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#restoreBranchModal"
                                    data-id="<?= $branch['id'] ?>"
                                    data-name="<?= htmlspecialchars($branch['name']) ?>">
                                    <i class="fas fa-undo-alt me-1"></i> Khôi phục
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteBranchModal"
                                    data-id="<?= $branch['id'] ?>"
                                    data-name="<?= htmlspecialchars($branch['name']) ?>">
                                    <i class="fas fa-trash-alt me-1"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link"
                        href="Admin.php?page=modules/Admin/RecyleBin/Branches/Branch.php&search=<?= urlencode($keyword) ?>&number=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>

<script>
    document.querySelectorAll('.restore-btn').forEach(btn => {
        btn.onclick = () => {
            document.getElementById('restoreBranchId').value = btn.getAttribute('data-id');
            document.getElementById('restoreBranchName').textContent = btn.getAttribute('data-name');
        };
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.onclick = () => {
            document.getElementById('deleteBranchId').value = btn.getAttribute('data-id');
            document.getElementById('deleteBranchName').textContent = btn.getAttribute('data-name');
        };
    });
</script>