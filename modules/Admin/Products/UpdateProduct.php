<?php

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<h3>Không tìm thấy sản phẩm!</h3>";
    exit;
}



$oldProduct = $product->getByIdToDB($id);
if (!$oldProduct) {
    echo "<h3>Sản phẩm không tồn tại!</h3>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateProduct'])) {
    $name = $_POST['nameProduct'] ?? '';
    $price = $_POST['priceProduct'] ?? 0;
    $discount = $_POST['discountProduct'] ?? 0;
    $description = $_POST['descriptionProduct'] ?? '';
    $category_id = $_POST['category_id'] ?? 1;
    $supplier_id = $_POST['supplier_id'] ?? 1;
    $imageUrl = $_POST['image_url'] ?? $oldProduct['image_url'];
    $content = $_POST['contentProduct'] ?? '';
    $uploadDir = __DIR__ . '/../../../uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imageUrl = 'uploads/' . $fileName;
        }
    }

    $updateData = [
        'name' => $name,
        'price' => $price,
        'discount' => $discount,
        'description' => $description,
        'category_id' => $category_id,
        'supplier_id' => $supplier_id,
        'image_url' => $imageUrl,
        'content' => $content,
        'isDeleted' => 0
    ];

    $result = $product->edit($id, $updateData);

    if ($result['success']) {
        $hasNewExtraImages = false;

        if (isset($_FILES['extra_images'])) {
            foreach ($_FILES['extra_images']['error'] as $err) {
                if ($err === UPLOAD_ERR_OK) {
                    $hasNewExtraImages = true;
                    break;
                }
            }
        }

        if ($hasNewExtraImages) {
            $imageController->deleteProductId($id);

            $imageFiles = $_FILES['extra_images'];
            for ($i = 0; $i < count($imageFiles['name']) && $i < 4; $i++) {
                if ($imageFiles['error'][$i] === UPLOAD_ERR_OK) {
                    $extraName = uniqid() . '_' . basename($imageFiles['name'][$i]);
                    $extraTarget = $uploadDir . $extraName;

                    if (move_uploaded_file($imageFiles['tmp_name'][$i], $extraTarget)) {
                        $extraUrl = 'uploads/' . $extraName;
                        $imageController->add([
                            'image_url' => $extraUrl,
                            'product_id' => $id,
                            'isDeleted' => 0
                        ]);
                    }
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
}
?>

<div class="add-product-container">
    <div class="header-add-product">
        <h2>Cập Nhật Sản Phẩm</h2>
    </div>
    <div class="product-content">
        <form id="updateProductForm" method="post" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="group mb-3">
                    <label class="form-label">Mã sản phẩm</label>
                    <input type="text" name="idProduct" class="form-control" readonly="readonly" required re value="<?= htmlspecialchars($oldProduct['id']) ?>">
                </div>
                <div class="group mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="nameProduct" class="form-control" required value="<?= htmlspecialchars($oldProduct['name']) ?>">
                </div>
            </div>
            <div class="form-grid">
                <div class="group mb-3">
                    <label class="form-label">Giá</label>
                    <input type="number" name="priceProduct" class="form-control" required value="<?= (int)$oldProduct['price'] ?>">
                </div>
                <div class="group mb-3">
                    <label class="form-label">Giảm giá (%)</label>
                    <input type="number" name="discountProduct" class="form-control" step="0.01" min="0" max="100" value="<?= (int)$oldProduct['discount'] ?>">
                </div>
            </div>
            <div class="form-grid">
                <div class="group mb-3">
                    <label class="form-label">Hình ảnh</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <p class="form-label mt-2">Hình ảnh hiện tại:</p>
                    <div class="image-preview-container">
                        <div class="image-wrapper">
                            <img src="<?= $oldProduct['image_url'] ?>" alt="Ảnh hiện tại">
                            <p>Ảnh chính</p>
                        </div>
                    </div>

                </div>
                <div class="group mb-3">
                    <label class="form-label">Hình ảnh phụ (tối đa 4 ảnh)</label>
                    <input type="file" name="extra_images[]" class="form-control" accept="image/*" multiple>
                    <p class="form-label mt-2">Hình ảnh phụ hiện tại:</p>
                    <div class="image-preview-container">
                        <?php
                        $images = $imageController->getImageById($id);
                        foreach ($images as $index => $img) {
                            echo "<div class='image-wrapper'>
                                    <img src='{$img['image_url']}' alt='Ảnh phụ {$index}'>
                                    <p>Ảnh phụ " . ($index + 1) . "</p>
                                </div>";
                        }
                        ?>
                    </div>

                </div>
            </div>
            <div class="form-grid">
                <div class="group mb-3">
                    <label class="form-label">Loại</label>
                    <select name="category_id" class="form-select">
                        <?php
                        $categories = $category->getAll();
                        foreach ($categories as $cat) {
                            $selected = ($cat['id'] == $oldProduct['category_id']) ? 'selected' : '';
                            echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="group mb-3">
                    <label class="form-label">Nhà cung cấp</label>
                    <select name="supplier_id" class="form-select">
                        <?php
                        $suppliers = $supplier->getAll();
                        foreach ($suppliers as $sup) {
                            $selected = ($sup['id'] == $oldProduct['supplier_id']) ? 'selected' : '';
                            echo "<option value='{$sup['id']}' $selected>{$sup['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="group mb-3">
                <label class="form-label">Mô tả ngắn</label>
                <textarea id="content" name="contentProduct" class="form-control"><?= htmlspecialchars($oldProduct['content']) ?></textarea>
            </div>
            <div class="group mb-3">
                <label class="form-label">Mô tả</label>
                <textarea id="content" name="descriptionProduct" class="form-control"><?= htmlspecialchars($oldProduct['description']) ?></textarea>
            </div>
            <div class="button-group">
                <button type="submit" name="updateProduct" class="btn btn-primary">Cập nhật</button>
                <a href="Admin.php?page=modules/Admin/Products/Product.php" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<div id="imageModal">
    <span class="close-btn">&times;</span>
    <img id="modalImage" src="" alt="Phóng to ảnh">
</div>

<script>
    document.getElementById("updateProductForm").addEventListener("submit", function() {
        Loading(true);
    });
</script>