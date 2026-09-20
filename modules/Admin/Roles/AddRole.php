<?php
$allMenus = $menuController->getAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_role'])) {
    $name = $_POST['role_name'];
    $menuIds  = $_POST['menu_ids'] ?? [];
    $result = $roleController->createRoleWithMenus($name, $menuIds);
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Roles/Role.php';</script>";
    exit;
}

?>

<div class="modal fade" id="addRoleModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="Admin.php?page=modules/Admin/Roles/Role.php">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Thêm quyền mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"> Tên quyền</label>
                        <input type="text" name="role_name" class="form-control" required>
                    </div>

                    <label class="form-label"> Chọn chức năng (ít nhất 1):</label>
                    <div class="row">
                        <?php foreach ($allMenus as $m) { ?>
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" style="border: 1px solid #232323ff;" type="checkbox"
                                        id="menu<?= $m['id'] ?>" name="menu_ids[]"
                                        value="<?= $m['id'] ?>">
                                    <label class="form-check-label" for="menu<?= $m['id'] ?>">
                                        <?= htmlspecialchars($m['menu_name']) ?>
                                    </label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" name="create_role" type="submit">Lưu</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>