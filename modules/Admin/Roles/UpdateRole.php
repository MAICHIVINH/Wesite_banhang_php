<?php
$allMenus = $menuController->getAll();
$editRole = null;
$checkedMenus = [];
if (isset($_GET['edit_id'])) {
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editModal = new bootstrap.Modal(document.getElementById('editRoleModal'));
            editModal.show();
        });
    </script>
<?php
    $editRole = $roleController->getById($_GET['edit_id']);
    $checkedMenus = $roleController->getMenuByRole($_GET['edit_id']);
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_role_id'])) {
    $id = $_POST['edit_role_id'];
    $name = $_POST['edit_role_name'];
    $menuIds = $_POST['edit_menu_ids'] ?? [];

    $result = $roleController->update($id, ['role_name' => $name]);

    if (!empty($menuIds)) {
        $roleController->updateRoleMenus($id, $menuIds);
    }


    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Roles/Role.php';</script>";
    exit;
}

?>

<div class="modal fade" id="editRoleModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="Admin.php?page=modules/Admin/Roles/Role.php">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Cập nhật quyền</h5>
                    <a href="Admin.php?page=modules/Admin/Roles/Role.php" class="btn-close btn-close-white"></a>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_role_id" value="<?= $editRole['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Tên quyền</label>
                        <input type="text" name="edit_role_name" class="form-control"
                            value="<?= htmlspecialchars($editRole['role_name']) ?>" required>
                    </div>

                    <label class="form-label">Chức năng:</label>
                    <div class="row">
                        <?php foreach ($allMenus as $menu): ?>
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox"
                                        name="edit_menu_ids[]"
                                        value="<?= $menu['id'] ?>"
                                        <?= in_array($menu['id'], $checkedMenus) ? 'checked' : '' ?>>
                                    <label class="form-check-label">
                                        <?= htmlspecialchars($menu['menu_name']) ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" name="update_role_with_menus">Cập nhật</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>