<?php

require_once  './././config/cloudinary.php';

use Cloudinary\Api\Upload\UploadApi;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = $_POST['name'] ?? '';
    $status = $_POST['status'] ?? 1;
    $imageUrl = $_POST['main_image'] ?? '';
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = (new UploadApi())->upload($_FILES['main_image']['tmp_name'], [
            'folder' => 'products/main'
        ]);

        $imageUrl = $uploadResult['secure_url'];
    }
    $data = [
        'name' => $name,
        'status' => $status,
        'icon' => $imageUrl,
        'isDeleted' => 0
    ];


    $result = $category->add($data);
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>
                    window.location.href = 'Admin.php?page=modules/Admin/Categories/Category.php';
            </script>";
    exit;
}


$listCategory = $category->getAll();
?>

<!-- Modal thêm danh mục -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form id="addCategoryForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="add_category" value="1">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addCategoryModalLabel">
                        <i class="bi bi-plus-circle me-2"></i> Thêm loại sản phẩm
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <?php if (!empty($errorMessage)) : ?>
                        <div class="alert alert-danger"><?= $errorMessage ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Tên danh mục</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Biểu tượng loại sản phẩm</label>
                        <input type="file" name="main_image" class="form-control" accept="image/*" id="categoryImageInput" style="width: 466px;">
                        <div id="categoryImagePreview" class="mt-2" style="text-align:center; margin-left: 180px;"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="0">Hiển thị</option>
                            <option value="1">Ẩn</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Thêm
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const categoryImageInput = document.getElementById("categoryImageInput");
        const categoryImagePreview = document.getElementById("categoryImagePreview");

        if (categoryImageInput && categoryImagePreview) {
            categoryImageInput.addEventListener("change", function(event) {
                categoryImagePreview.innerHTML = ""; // Clear previous preview
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement("img");
                        img.src = e.target.result;
                        img.style.maxWidth = "150px";
                        img.style.marginTop = "10px";
                        img.style.border = "1px solid #ddd";
                        img.style.borderRadius = "4px";
                        categoryImagePreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>