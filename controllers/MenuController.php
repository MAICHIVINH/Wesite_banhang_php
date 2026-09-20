<?php

require_once './models/Menu.php';
require_once './models/RoleMenu.php';
require_once './models/EmployeeMenu.php';


class MenuController
{
    private $menuModel;
    private $roleMenuModel;
    private $employeeMenuModel;

    public function __construct()
    {
        $this->menuModel = new Menu();
        $this->roleMenuModel = new RoleMenu();
        $this->employeeMenuModel = new EmployeeMenu();
    }

    public function getAll()
    {
        return $this->menuModel->all();
    }

    public function getById($id)
    {
        return $this->menuModel->find($id);
    }

    public function countIsDeleted()
    {
        return $this->menuModel->countDeleted();
    }

    public function getPagination($keyword, $limit, $offset, $isDeleted = 0)
    {
        return $this->menuModel->getFilterMenus($keyword, $limit, $offset, $isDeleted);
    }

    public function countMenu($keyword, $isDeleted = 0)
    {
        return $this->menuModel->countFilteredMenus($keyword, $isDeleted);
    }

    public function add($data)
    {
        try {
            if ($this->menuModel->existsByNameMenu($data['menu_name'])) {
                return [
                    'success' => false,
                    'message' => 'Tên chức năng đã tồn tại!'
                ];
            }

            $menu = $this->menuModel->insert($data);
            return [
                'success' => true,
                'message' => 'Thêm chức năng thành công',
                'menu' => $menu
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function update($id, $data)
    {
        try {
            $existingById = $this->menuModel->find($id);
            if ($existingById == null) {
                return [
                    'success' => false,
                    'message' => 'Chức năng không tồn tại!'
                ];
            }

            $existingByName = $this->menuModel->existsByNameExceptIdMenu($id, $data['name']);
            if ($existingByName) {
                return [
                    'success' => false,
                    'message' => 'Tên chức năng này đã tồn tại, vui lòng chọn tên khác.'
                ];
            }

            $menuEdit = $this->menuModel->update($id, $data);
            return [
                'success' => true,
                'message' => 'Cập chức năng thành công',
                'menu' => $menuEdit
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $existingById = $this->menuModel->find($id);
            if ($existingById == null) {
                return [
                    'success' => false,
                    'message' => 'Chức năng không tồn tại!'
                ];
            }

            $existingRoleMenu = $this->roleMenuModel->getByColumn('menu_id', $id);
            if (is_array($existingRoleMenu) && count($existingRoleMenu) > 0) {
                foreach ($existingRoleMenu as $item) {
                    $this->roleMenuModel->updateIsDeleted($item['id'], ['isDeleted' => 1]);
                }
            }

            $existingEmployeeMenu = $this->employeeMenuModel->getByColumn('menu_id', $id);
            if (is_array($existingEmployeeMenu) && count($existingEmployeeMenu) > 0) {
                foreach ($existingEmployeeMenu as $item) {
                    $this->employeeMenuModel->updateIsDeleted($item['id'], ['isDeleted' => 1]);
                }
            }

            $delete = $this->menuModel->updateDeleted($id);
            return [
                'success' => true,
                'message' => 'Xóa chức năng thành công',
                'menu' => $delete
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function deleteIsDeleted($id)
    {
        try {
            $existing = $this->menuModel->findIsDeled($id);
            if ($existing == null) {
                return [
                    'success' => false,
                    'message' => 'Chức năng không tồn tại!'
                ];
            }

            $existingRoleMenu = $this->roleMenuModel->getByColumn('menu_id', $id);
            if (is_array($existingRoleMenu) && count($existingRoleMenu) > 0) {
                $this->roleMenuModel->deleteByColumn('menu_id', $id);
            }

            $existingEmployeeMenu = $this->employeeMenuModel->getByColumn('menu_id', $id);
            if (is_array($existingEmployeeMenu) && count($existingEmployeeMenu) > 0) {
                $this->employeeMenuModel->deleteByColumn('menu_id', $id);
            }

            $result = $this->menuModel->delete($id);
            if ($result) {
                return ['success' => true, 'message' => 'Đã xóa vĩnh viễn chức năng này!'];
            } else {
                return ['success' => false, 'message' => 'Lỗi xóa chức năng'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    public function restore($id)
    {
        try {
            $existing = $this->menuModel->findIsDeled($id);
            if ($existing == null) {
                return [
                    'success' => false,
                    'message' => 'Chức năng không tồn tại!'
                ];
            }

            $existingRoleMenu = $this->roleMenuModel->getByColumn('menu_id', $id);
            if (is_array($existingRoleMenu) && count($existingRoleMenu) > 0) {
                foreach ($existingRoleMenu as $item) {
                    $this->roleMenuModel->updateIsDeleted($item['id'], ['isDeleted' => 0]);
                }
            }

            $existingEmployeeMenu = $this->employeeMenuModel->getByColumn('menu_id', $id);
            if (is_array($existingEmployeeMenu) && count($existingEmployeeMenu) > 0) {
                foreach ($existingEmployeeMenu as $item) {
                    $this->employeeMenuModel->updateIsDeleted($item['id'], ['isDeleted' => 0]);
                }
            }

            $result = $this->menuModel->updateIsDeleted($id, ['isDeleted' => 0]);
            if ($result) {
                return ['success' => true, 'message' => 'Khôi phục chức năng thành công!'];
            } else {
                return ['success' => false, 'message' => 'Lỗi xóa chức năng'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
