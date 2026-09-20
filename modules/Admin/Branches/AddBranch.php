<?php
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add_branch'])) {
    $name = $_POST['branch_name'];
    $address = $_POST['branch_address'];
    $phone = $_POST['branch_phone'];
    $email = $_POST['email'];

    $data = [
        'name' => $name,
        'address' => $address,
        'phone' => $phone,
        'email' => $email,
        'isDeleted' => 0
    ];

    $result = $branchController->add($data);
    if ($result['success']) {
        $_SESSION['success'] = 'Thêm chi nhánh mới thành công!';
    } else {
        $_SESSION['error'] = $result['message'];
    }

    echo "<script>
                    window.location.href = 'Admin.php?page=modules/Admin/Branches/Branch.php';
            </script>";
    exit;
}
?>

<div class="modal fade" id="addBranchModal" tabindex="-1" aria-labelledby="addBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addBranchForm" method="POST" action="Admin.php?page=modules/Admin/Branches/Branch.php">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addBranchModalLabel">Thêm chức năng mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="branchName" class="form-label">Tên chi nhánh</label>
                        <input type="text" name="branch_name" id="branchName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="branchName" class="form-label">Địa chỉ</label>
                        <input type="text" name="branch_address" id="branchAddress" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="branchName" class="form-label">Số điện thoại liên hệ</label>
                        <input type="text" name="branch_phone" id="branchPhone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="branchName" class="form-label">Địa chỉ Email</label>
                        <input type="email" name="email" id="branchEmail" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_branch" class="btn btn-primary">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>

            </form>
        </div>
    </div>
</div>