<?php
require_once './././config/cloudinary.php';

use Cloudinary\Api\Upload\UploadApi;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_category'])) {
    $id = $_POST['category_id'] ?? null;
    $name = $_POST['name'] ?? '';
    $status = $_POST['status'] ?? 1;

    // Lấy icon hiện tại
    $currentCategory = $category->getById($id);
    $icon = $currentCategory['icon'] ?? '';

    // Upload mới nếu có file
    if (!empty($_FILES['main_image']['tmp_name']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = (new UploadApi())->upload($_FILES['main_image']['tmp_name'], [
            'folder' => 'products/main'
        ]);
        $icon = $uploadResult['secure_url'];
    }

    $data = [
        'name' => $name,
        'status' => $status,
        'icon' => $icon
    ];

    $result = $category->edit($id, $data);
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Categories/Category.php';</script>";
    exit;
}


?>

<!-- Modal sửa danh mục -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="update_category" value="1">
                <input type="hidden" name="category_id" id="editCategoryId">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editCategoryModalLabel">
                        <i class="fas fa-pen-to-square me-2"></i> Cập nhật loại sản phẩm
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên danh mục</label>
                        <input type="text" name="name" id="editCategoryName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Biểu tượng loại sản phẩm</label>
                        <input type="file" name="main_image" class="form-control" accept="image/*" id="editCategoryImageInput">
                        <div id="editCategoryImagePreview" class="mt-2" style="text-align:center;"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" id="editCategoryStatus" class="form-select">
                            <option value="0">Hiển thị</option>
                            <option value="1">Ẩn</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Cập nhật
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function openEditCategoryModal(id, name, icon, status) {
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;
        document.getElementById('editCategoryStatus').value = status;

        const preview = document.getElementById('editCategoryImagePreview');
        preview.innerHTML = '';
        if (icon) {
            const img = document.createElement('img');
            img.src = icon;
            img.style.maxWidth = "120px";
            img.style.marginTop = "10px";
            img.style.border = "1px solid #ddd";
            img.style.borderRadius = "4px";
            preview.appendChild(img);
        }

        let modal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        modal.show();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("editCategoryImageInput");
        const preview = document.getElementById("editCategoryImagePreview");

        if (input && preview) {
            input.addEventListener("change", function(event) {
                preview.innerHTML = "";
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement("img");
                        img.src = e.target.result;
                        img.style.maxWidth = "120px";
                        img.style.marginTop = "10px";
                        img.style.border = "1px solid #ddd";
                        img.style.borderRadius = "4px";
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>