<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_menu'])) {
    $id = $_POST['edit_id'];
    $name = $_POST['edit_menu_name'];
    $url = $_POST['edit_menu_url'];

    $data = [
        'menu_name' => $name,
        'menu_url' => $url,
    ];

    $result = $menuController->update($id, $data);
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Menus/Menu.php';</script>";
    exit;
}

?>

<div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="Admin.php?page=modules/Admin/Menus/Menu.php">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editMenuModalLabel">Sửa chức năng</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="editMenuId">
                    <div class="mb-3">
                        <label for="editMenuName" class="form-label">Tên chức năng</label>
                        <input type="text" name="edit_menu_name" id="editMenuName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMenuUrl" class="form-label">Đường dẫn (URL)</label>
                        <input type="text" name="edit_menu_url" id="editMenuUrl" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update_menu" class="btn btn-primary">Cập nhật</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>