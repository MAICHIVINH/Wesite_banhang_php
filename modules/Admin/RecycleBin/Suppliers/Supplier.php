<?php
// Dữ liệu giả lập nhà cung cấp đã xóa

$keyword = $_GET['search'] ?? '';



$page = $_GET['number'] ?? 1;
$limit = 8;
$offset = ($page - 1) * $limit;



$totalSuppliers = $supplier->countSuppliersToDB($keyword, 1);
$totalPages = ceil($totalSuppliers / $limit);
$listDeletedSuppliers = $supplier->getFilterSuppliersToDB($limit, $offset, $keyword, 1);

$totalSuppliersIsDeleted = $supplier->countIsDeleted();

?>

<?php require_once 'RestoreSupplier.php'; ?>
<?php require_once 'DeleteSupplier.php'; ?>

<div class="product-container">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap p-3 rounded shadow-sm bg-light border">
        <h4 class="mb-0 fw-bold text-danger d-flex align-items-center">
            <i class="fas fa-trash-alt me-2"></i> Thùng rác - Nhà cung cấp đã xóa
        </h4>
        <span class="badge bg-danger px-3 py-2 fs-6">
            <?= $totalSuppliersIsDeleted ?> mục đã xóa
        </span>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Người liên hệ</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Ảnh</th>
                    <th>Địa chỉ</th>
                    <th style="width: 300px">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDeletedSuppliers as $supplier): ?>
                    <tr>
                        <td><?= $supplier['id'] ?></td>
                        <td><?= htmlspecialchars($supplier['name']) ?></td>
                        <td><?= htmlspecialchars($supplier['contact_person']) ?></td>
                        <td><?= $supplier['Phone'] ?></td>
                        <td><?= $supplier['Email'] ?></td>
                        <td><img src="<?= $supplier['image_url'] ?>" width="60"></td>
                        <td><?= $supplier['Address'] ?></td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center gap-2 restore-btn text-success"
                                            data-bs-toggle="modal"
                                            data-bs-target="#restoreSupplierModal"
                                            data-id="<?= $supplier['id'] ?>"
                                            data-name="<?= htmlspecialchars($supplier['name']) ?>">
                                            <i class="fas fa-undo text-success"></i> Khôi phục
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center gap-2 delete-btn text-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteSupplierModal"
                                            data-id="<?= $supplier['id'] ?>"
                                            data-name="<?= htmlspecialchars($supplier['name']) ?>">
                                            <i class="fas fa-trash-alt text-danger"></i> Xóa vĩnh viễn
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const restoreButtons = document.querySelectorAll('.restore-btn');
    const deleteButtons = document.querySelectorAll('.delete-btn');

    restoreButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('restoreSupplierId').value = button.getAttribute('data-id');
            document.getElementById('restoreSupplierName').textContent = button.getAttribute('data-name');
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteSupplierId').value = button.getAttribute('data-id');
            document.getElementById('deleteSupplierName').textContent = button.getAttribute('data-name');
        });
    });
</script>