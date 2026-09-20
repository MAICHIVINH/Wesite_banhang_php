<?php

require_once './models/Inventory.php';

class InventoryController
{
    private $InventoryController;

    public function __construct()
    {
        $this->InventoryController = new Inventory();
    }

    public function getAll()
    {
        return $this->InventoryController->all();
    }

    public function getById($id)
    {
        return $this->InventoryController->find($id);
    }

    public function getProductInventory($product_id, $branch_id, $isFind = false, $id = null)
    {
        return $this->InventoryController->getInventory($product_id, $branch_id, $isFind, $id);
    }

    public function countInventory($keyword, $branch_id = null, $isAdmin = false)
    {
        return $this->InventoryController->countFiltered($keyword, $branch_id, $isAdmin);
    }

    public function getProductPagination($keyword = '', $limit = 8, $offset = 0, $branch_id = null, $isAdmin = false)
    {
        return $this->InventoryController->getFiltered($keyword, $limit, $offset, $branch_id, $isAdmin);
    }


    public function add($data)
    {
        try {
            $supplier = $this->InventoryController->insert($data);
            return [
                'success' => true,
                'message' => 'Thêm kho hàng thành công',
                'supplier' => $supplier
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function edit($id, $data)
    {
        try {
            $supplierEdit = $this->InventoryController->update($id, $data);
            return [
                'success' => true,
                'message' => 'Cập nhật kho hàng thành công!',
                'supplier' => $supplierEdit
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            return $this->InventoryController->updateDeleted($id);
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
