<?php
$roleWithMenu = $roleController->getRoleWithMenu();
$allBranches = $branchController->getAll();
if ($_SERVER['REQUEST_METHOD'] && isset($_POST['update_employee'])) {
    $id = $_POST['edit_employee_id'];
    $name = $_POST['edit_name'];
    $email = $_POST['edit_email'];
    $phone = $_POST['edit_phone'];
    $position = $_POST['edit_position'];
    $address = $_POST['edit_address'];
    $roleIds = $_POST['edit_role_ids'] ?? [];
    $menuIds = $_POST['edit_menu_ids'] ?? [];
    $branchId = $_POST['branch_id'];
    $data = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'position' => $position,
        'address' => $address,
        'branch_id' => $branchId,
        'isDeleted' => 0
    ];
    $result = $employeeController->update($id, $data, $roleIds, $menuIds);
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }
    echo "<script>window.location.href = 'Admin.php?page=modules/Admin/Employees/Employee.php';</script>";
    exit;
}

?>

<div class="modal fade" id="editEmployeeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="Admin.php?page=modules/Admin/Employees/Employee.php">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Cập nhật nhân viên</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- ID ẩn -->
                    <input type="hidden" name="edit_employee_id" id="edit_employee_id">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tên nhân viên</label>
                            <input type="text" name="edit_name" id="edit_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="edit_email" id="edit_email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SĐT</label>
                            <input type="text" name="edit_phone" id="edit_phone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Vị trí</label>
                            <input type="text" name="edit_position" id="edit_position" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" name="edit_address" id="edit_address" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Chi nhánh</label>
                            <select name="branch_id" id="edit_branch_id" class="form-select" required>
                                <?php foreach ($allBranches as $branch) { ?>
                                    <option value="<?= $branch['id'] ?>">
                                        <?= htmlspecialchars($branch['name']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Phân quyền -->
                    <label class="form-label">Phân quyền & chức năng:</label>
                    <div class="border p-3 rounded" style="max-height: 300px; overflow-y: auto;">
                        <?php
                        foreach ($roleWithMenu as $role) {
                        ?>
                            <div class="mb-2">
                                <div class="form-check mb-1">
                                    <input class="form-check-input role-checkbox-edit" type="checkbox" name="edit_role_ids[]" value="<?= $role['role_id'] ?>" data-role-id="<?= $role['role_id'] ?>">
                                    <label class="form-check-label fw-bold"><?= htmlspecialchars($role['role_name']) ?></label>
                                </div>

                                <?php
                                if (!empty($role['menus'])) {
                                    foreach ($role['menus'] as $menu) {
                                ?>
                                        <div class="form-check ms-4">
                                            <input class="form-check-input menu-checkbox-edit" type="checkbox" name="edit_menu_ids[]" value="<?= $menu['menu_id'] ?>" data-role-id="<?= $role['role_id'] ?>">
                                            <label class="form-check-label"><?= htmlspecialchars($menu['menu_name']) ?></label>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" name="update_employee">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>