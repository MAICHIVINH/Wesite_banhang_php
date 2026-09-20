<?php

require_once  './././config/cloudinary.php';

use Cloudinary\Api\Upload\UploadApi;
use Respect\Validation\Rules\Date;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnAddProduct'])) {
    try {
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $discount = $_POST['discount'] ?? 0;
        $description = $_POST['description'] ?? '';
        $category_id = $_POST['category_id'] ?? 1;
        $supplier_id = $_POST['supplier_id'] ?? 1;
        $content = $_POST['content'] ?? '';

        // Xử lý ảnh chính
        $imageUrl = $_POST['image_url'] ?? '';
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = (new UploadApi())->upload($_FILES['main_image']['tmp_name'], [
                'folder' => 'products/main'
            ]);

            $imageUrl = $uploadResult['secure_url'];
        }

        $data = [
            'name' => $name,
            'price' => $price,
            'discount' => $discount,
            'description' => $description,
            'category_id' => $category_id,
            'supplier_id' => $supplier_id,
            'isDeleted' => 0,
            'content' => $content,
            'image_url' => $imageUrl
        ];
        $result = $product->add($data);

        if ($result['success']) {
            $productId = $result['product'];

            // xử lý thêm các ảnh liên quan
            if (isset($_FILES['extra_images'])) {
                $imageFiles = $_FILES['extra_images'];
                for ($i = 0; $i < count($imageFiles['name']) && $i < 4; $i++) {
                    if ($imageFiles['error'][$i] === UPLOAD_ERR_OK) {
                        $uploadExtra = (new UploadApi())->upload($imageFiles['tmp_name'][$i], [
                            'folder' => 'products/extra'
                        ]);

                        $extraUrl = $uploadExtra['secure_url'];

                        $imageController->add([
                            'image_url' => $extraUrl,
                            'product_id' => $productId,
                            'isDeleted' => 0
                        ]);
                    }
                }
            }
            $_SESSION['success'] = $result['message'];


            echo "<script>
                Loading(false);
                    window.location.href = 'Admin.php?page=modules/Admin/Products/Product.php';
            </script>";

            exit;
        } else {
            if ($result['errors']) {
                $_SESSION['error'] = $result['message'];

                foreach ($result['errors'] as $field => $rules) {
                    foreach ($rules as $rule => $msg) {
                        echo "<div class='alert alert-danger'>$msg</div>";
                    }
                }
            } else {
                echo "<div class='alert alert-danger'>{$result['message']}</div>";
            }
        }
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>


<div class="add-product-container">
    <div class="header-add-product">
        <h2>Thêm Sản Phẩm</h2>
    </div>
    <div class="product-content">
        <form id="addProductForm" action="" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="group mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="group mb-3">
                    <label class="form-label">Giá</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
            </div>
            <div class="form-grid">
                <div class="group mb-3">
                    <label class="form-label">Giảm giá (%)</label>
                    <input type="number" name="discount" class="form-control" step="0" min="0" max="100">
                </div>
            </div>
            <div class="form-grid">
                <div class="group mb-3">
                    <label class="form-label">Ảnh sản phẩm</label>
                    <input type="file" name="main_image" class="form-control" accept="image/*" id="mainImageInput">
                    <div id="mainImagePreview" class="image-preview"></div>
                </div>
                <div class="group mb-3">
                    <label class="form-label">Ảnh phụ (tối đa 4 ảnh)</label>
                    <input type="file" name="extra_images[]" class="form-control" accept="image/*" multiple id="extraImagesInput">
                    <div id="extraImagesPreview" class="image-preview"></div>
                </div>
            </div>
            <div class="form-grid">
                <div class="group mb-3">
                    <label class="form-label">Loại sản phẩm</label>
                    <select name="category_id" class="form-select">
                        <?php
                        $categoriesItem = $category->getAll();
                        foreach ($categoriesItem as $cat) {
                            echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="group mb-3">
                    <label class="form-label">Nhà cung cấp</label>
                    <select name="supplier_id" class="form-select">
                        <?php
                        $suppliersItem = $supplier->getAll();
                        foreach ($suppliersItem as $sup) {
                            echo "<option value='{$sup['id']}'>{$sup['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="group mb-3">
                <label class="form-label">Mô tả ngắn</label>
                <textarea id="content" name="content" class="form-control"></textarea>
            </div>
            <div class="group mb-3">
                <label class="form-label">Mô tả</label>
                <textarea id="content" name="description" class="form-control"></textarea>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-primary" name="btnAddProduct">Thêm</button>
                <a href="Admin.php?page=modules/Admin/Products/Product.php" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>

<div id="lightbox" class="lightbox">
    <img id="lightbox-img" src="" alt="Preview">
</div>

<script>
    document.getElementById("addProductForm").addEventListener("submit", function() {
        Loading(true);
    });
</script>