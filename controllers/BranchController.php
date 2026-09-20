<?php

require_once './models/Branch.php';

class BranchController
{
    private $branchController;
    private $inventoryModel;

    private $orderItemModel;
    private $orderModel;
    public function __construct()
    {
        $this->branchController = new Branch();
        $this->inventoryModel = new Inventory();
        $this->orderItemModel = new OrderItem();
        $this->orderModel = new Order();
    }

    public function getAll()
    {
        return $this->branchController->all();
    }

    public function getById($id)
    {
        return $this->branchController->find($id);
    }

    public function countIsDeleted()
    {
        return $this->branchController->countDeleted();
    }

    public function getPagination($limit, $offset, $keyword, $isDeleted = 0)
    {
        return $this->branchController->getFilteredBranch($limit, $offset, $keyword, $isDeleted);
    }

    public function countBranch($keyword, $isDeleted = 0)
    {
        return $this->branchController->countCategory($keyword, $isDeleted);
    }

    public function add($data)
    {
        try {
            $existingBranch = $this->branchController->existsByName($data['name']);
            if ($existingBranch) {
                return [
                    'success' => false,
                    'message' => 'Chi nhánh này đã tồn tại!'
                ];
            }
            $branch = $this->branchController->insert($data);
            return [
                'success' => true,
                'message' => 'Thêm dữ liệu thành công',
                'branch' => $branch
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    public function update($id, $data)
    {
        try {
            $existingById = $this->branchController->find($id);
            if ($existingById == null) {
                return [
                    'success' => false,
                    'message' => 'Chi nhánh này không tồn tại, vui lòng chọn tên khác.'
                ];
            }
            $existingBranch = $this->branchController->existsByNameExceptId($id, $data['name']);

            if ($existingBranch) {
                return [
                    'success' => false,
                    'message' => 'Tên chi nhánh đã tồn tại, vui lòng chọn tên khác.'
                ];
            }
            $editBranch = $this->branchController->update($id, $data);
            return [
                'success' => true,
                'message' => 'Cập nhật dữ liệu thành công',
                'branch' => $editBranch
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    public function delete($id)
    {
        try {
            $existingById = $this->branchController->find($id);
            if ($existingById == null) {
                return [
                    'success' => false,
                    'message' => 'Chi nhánh này không tồn tại, vui lòng chọn tên khác.'
                ];
            }
            $editBranch = $this->branchController->updateDeleted($id);
            return [
                'success' => true,
                'message' => 'Xóa dữ liệu thành công',
                'branch' => $editBranch
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    public function deleteIsDeleted($id)
    {
        try {
            $existingBranch = $this->branchController->findIsDeled($id);

            if ($existingBranch == null) {
                return [
                    'success' => false,
                    'message' => 'Cửa hàng không tồn tại!'
                ];
            }

            if ($this->inventoryModel->hasBranch($id)) {
                $this->inventoryModel->deleteByColumn('branch_id', $id);
            }

            $orderId = $this->orderModel->getByColumn('branch_id', $id);
            if (is_array($orderId) && count($orderId) > 0) {
                foreach ($orderId as $item) {
                    $this->orderItemModel->deleteByColumn('order_id', $item['id']);

                    $this->orderModel->delete($item['id']);
                }
            }
            $result = $this->branchController->delete($id);
            if ($result) {
                return ['success' => true, 'message' => 'Xóa vĩnh viễn thành công'];
            } else {
                return ['success' => false, 'message' => 'Xóa thất bại'];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    public function restore($id)
    {
        try {
            $existingBranch = $this->branchController->findIsDeled($id);

            if ($existingBranch == null) {
                return [
                    'success' => false,
                    'message' => 'Cửa hàng không tồn tại!'
                ];
            }

            if ($this->inventoryModel->hasBranch($id)) {
                $this->inventoryModel->deleteByColumn('branch_id', $id);
            }

            $orderId = $this->orderModel->getByColumn('branch_id', $id);
            if (is_array($orderId) && count($orderId) > 0) {
                foreach ($orderId as $item) {
                    $this->orderItemModel->deleteByColumn('order_id', $item['id']);

                    $this->orderModel->delete($item['id']);
                }
            }
            $result = $this->branchController->updateIsDeleted($id, ['isDeleted' => 0]);
            if ($result) {
                return ['success' => true, 'message' => 'Khôi phục thành công'];
            } else {
                return ['success' => false, 'message' => 'Khôi phục thất bại'];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }
}
