<?php

require_once './models/Role.php';
require_once './models/RoleMenu.php';
require_once './models/RoleEmployee.php';

class RoleController
{
    private $roleModel;
    private $roleMenuModel;
    private $roleEmployeeModel;

    public function __construct()
    {
        $this->roleModel = new Role();
        $this->roleMenuModel = new RoleMenu();
        $this->roleEmployeeModel = new RoleEmployee();
    }

    public function getAll()
    {
        return $this->roleModel->all();
    }

    public function getById($id)
    {
        return $this->roleModel->find($id);
    }

    public function getPagination($keyword, $limit, $offset, $isDeleted = 0)
    {
        return $this->roleModel->getFilterRoles($keyword, $limit, $offset, $isDeleted);
    }

    public function countRole($keyword, $isDeleted = 0)
    {
        return $this->roleModel->countFilteredRoles($keyword, $isDeleted);
    }

    public function add($data)
    {
        try {
            if ($this->roleModel->existsByNameRole($data['name'])) {
                return [
                    'success' => false,
                    'message' => 'Tên quyền đã tồn tại'
                ];
            }
            $Role = $this->roleModel->insert($data);
            return [
                'success' => true,
                'message' => 'Thêm quyền thành công',
                'Role' => $Role
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getMenuByRole($id)
    {
        return $this->roleMenuModel->getMenuIdsByRole($id);
    }

    public function countIsDeleted()
    {
        return $this->roleMenuModel->countDeleted();
    }

    public function getRoleWithMenu()
    {
        return $this->roleModel->getAllRolesWithMenus();
    }

    public function createRoleWithMenus($roleName, $menuIds)
    {
        if ($roleName === '' || empty($menuIds)) {
            return ['success' => false, 'message' => 'Phải nhập tên quyền và chọn ít nhất 1 chức năng'];
        }

        if ($this->roleModel->existsByNameRole($roleName)) {
            return [
                'success' => false,
                'message' => 'Tên chức năng đã tồn tại!'
            ];
        }

        $roleId = $this->roleModel->insert([
            'role_name' => $roleName,
            'isDeleted' => 0
        ]);

        foreach ($menuIds as $item) {
            $this->roleMenuModel->insert([
                'menu_id' => $item,
                'role_id' => $roleId,
                'isDeleted' => 0
            ]);
        }

        return ['success' => true, 'role_id' => $roleId, 'message' => 'Thêm quyền thành công'];
    }

    public function updateRoleMenus($roleId, array $menuIds)
    {
        $this->roleMenuModel->updateByRoleId($roleId, ['isDeleted' => 1]);

        foreach ($menuIds as $mid) {
            $existing = $this->roleMenuModel->first([
                'role_id' => $roleId,
                'menu_id' => $mid
            ]);

            if ($existing) {
                $this->roleMenuModel->forceUpdate($existing['id']);
            } else {
                $this->roleMenuModel->insert([
                    'menu_id' => $mid,
                    'role_id' => $roleId,
                    'isDeleted' => 0
                ]);
            }
        }
        return ['success' => true];
    }

    public function update($id, $data)
    {
        try {

            $existingById = $this->roleModel->find($id);
            if ($existingById == null) {
                return [
                    'success' => false,
                    'message' => 'Quyền không tồn tại!'
                ];
            }

            $existingByName = $this->roleModel->existsByNameExceptIdRole($id, $data['role_name']);
            if ($existingByName) {
                return [
                    'success' => false,
                    'message' => 'Tên quyền này đã tồn tại, vui lòng chọn tên khác.'
                ];
            }

            $RoleEdit = $this->roleModel->update($id, $data);
            return [
                'success' => true,
                'message' => 'Cập nhật quyền thành công',
                'Role' => $RoleEdit
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {

            $existingMenu = $this->roleMenuModel->getByColumn('role_id', $id);

            if (is_array($existingMenu) && count($existingMenu) > 0) {
                foreach ($existingMenu as $item) {
                    $this->roleMenuModel->updateIsDeleted($item['id'], ['isDeleted' => 1]);
                }
            }

            $existingEmployee = $this->roleEmployeeModel->getByColumn('role_id', $id);
            if (is_array($existingEmployee) && count($existingEmployee) > 0) {
                foreach ($existingEmployee as $item) {
                    $this->roleEmployeeModel->updateIsDeleted($item['id'], ['isDeleted' => 1]);
                }
            }
            $delete = $this->roleModel->updateDeleted($id);

            return [
                'success' => true,
                'message' => 'Xóa quyền thành công',
                'Role' => $delete
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function deleteIsDeleted($id)
    {
        try {
            $existing = $this->roleModel->findIsDeled($id);
            if ($existing == null) {
                return [
                    'success' => false,
                    'message' => 'Quyền không tồn tại!'
                ];
            }

            $existingMenu = $this->roleMenuModel->getByColumn('role_id', $id);
            if (is_array($existingMenu) && count($existingMenu) > 0) {
                $this->roleMenuModel->deleteByColumn('role_id', $id);
            }

            $existingEmployee = $this->roleEmployeeModel->getByColumn('role_id', $id);
            if (is_array($existingEmployee) && count($existingEmployee) > 0) {
                $this->roleEmployeeModel->deleteByColumn('role_id', $id);
            }

            $result = $this->roleModel->delete($id);
            if ($result) {
                return ['success' => true, 'message' => 'Đã xóa Vĩnh viễn quyền này!'];
            } else {
                return ['success' => false, 'message' => 'Lỗi xóa quyền'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function restore($id)
    {
        try {
            $existing = $this->roleModel->findIsDeled($id);
            if ($existing == null) {
                return [
                    'success' => false,
                    'message' => 'Quyền không tồn tại!'
                ];
            }

            $existingMenu = $this->roleMenuModel->getByColumn('role_id', $id);
            if (is_array($existingMenu) && count($existingMenu) > 0) {
                foreach ($existingMenu as $item) {
                    $this->roleMenuModel->updateIsDeleted($item['id'], ['isDeleted' => 0]);
                }
            }

            $existingEmployee = $this->roleEmployeeModel->getByColumn('role_id', $id);
            if (is_array($existingEmployee) && count($existingEmployee) > 0) {
                foreach ($existingEmployee as $item) {
                    $this->roleEmployeeModel->updateIsDeleted($item['id'], ['isDeleted' => 0]);
                }
            }

            $result = $this->roleModel->updateIsDeleted($id, ['isDeleted' => 0]);
            if ($result) {
                return ['success' => true, 'message' => 'Đã xóa Vĩnh viễn quyền này!'];
            } else {
                return ['success' => false, 'message' => 'Lỗi xóa quyền'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
