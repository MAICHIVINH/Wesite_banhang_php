<?php

require_once  './././config/cloudinary.php';

use Cloudinary\Api\Upload\UploadApi;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_supplier'])) {
    $name = $_POST['name'] ?? '';
    $contact_person = $_POST['contact_person'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $imageUrl = $_POST['image_supplier'] ?? '';
    if (isset($_FILES['image_supplier']) && $_FILES['image_supplier']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = (new UploadApi())->upload($_FILES['image_supplier']['tmp_name'], [
            'folder' => 'products/main'
        ]);

        $imageUrl = $uploadResult['secure_url'];
    }

    $data = [
        'name' => $name,
        'contact_person' => $contact_person,
        'email' => $email,
        'phone' => $phone,
        'image_url' => $imageUrl,
        'address' => $address,
        'isDeleted' => 0

    ];
    $result = $supplier->add($data);
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Suppliers/Supplier.php';</script>";
    exit;
}

$listSupplier = $supplier->getAll();
?>

<!-- Modal thêm nhà cung cấp -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="add_supplier" value="1">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addSupplierModalLabel">
                        <i class="bi bi-plus-circle me-2"></i> Thêm nhà cung cấp mới
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <?php if (!empty($errorMessage)) : ?>
                        <div class="alert alert-danger"><?= $errorMessage ?></div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tên nhà cung cấp</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Người liên hệ</label>
                            <input type="text" name="contact_person" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ảnh đại diện thương hiệu</label>
                            <input type="file" name="image_supplier" class="form-control" accept="image/*" id="supplierImageInput">
                            <div id="supplierImagePreview" class="mt-2"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" name="address" id="editSupplierAddress" class="form-control">
                        </div>
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


