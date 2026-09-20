<?php
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add_menu'])) {
    $name = $_POST['menu_name'];
    $url = $_POST['menu_url'];

    $data = [
        'menu_name' => $name,
        'menu_url' => $url,
        'isDeleted' => 0
    ];

    $result = $menuController->add($data);
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Menus/Menu.php';</script>";
    exit;
}
?>


<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="Admin.php?page=modules/Admin/Menus/Menu.php">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addMenuModalLabel">Thêm chức năng mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="menuName" class="form-label">Tên chức năng</label>
                        <input type="text" name="menu_name" id="menuName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="menuUrl" class="form-label">Đường dẫn (URL)</label>
                        <input type="text" name="menu_url" id="menuUrl" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_menu" class="btn btn-primary">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>