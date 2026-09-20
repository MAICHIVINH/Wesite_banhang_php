<?php

require_once './models/Supplier.php';
require_once './core/RedisCache.php';
require_once './models/Product.php';
require_once './models/OrderItem.php';
require_once './models/Inventory.php';
require_once './models/Image.php';
require_once './models/Review.php';


require_once './controllers/ProductController.php';


class SupplierController
{
    private $supplierModel;
    private $productModel;
    private $productController;
    private $imageModel;

    private $orderItemModel;
    private $inventoryModel;
    private $reviewModel;


    public function __construct()
    {
        $this->supplierModel = new Supplier();
        $this->productModel = new Product();
        $this->productController = new ProductController();
        $this->orderItemModel = new OrderItem();
        $this->inventoryModel = new Inventory();
        $this->imageModel = new Image();
        $this->reviewModel = new Review();
    }

    public function getAll()
    {
        $cacheKey = 'supplier:all';
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }
        $suppliers = $this->supplierModel->all();
        RedisCache::set($cacheKey, json_encode($suppliers));
        return $suppliers;
    }

    public function getAllToDb()
    {
        return $this->supplierModel->all();
    }

    public function countIsDeleted()
    {
        return $this->supplierModel->countDeleted();
    }

    public function getById($id)
    {
        $cacheKey = "supplier:$id";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }
        $supplier = $this->supplierModel->find($id);
        RedisCache::set($cacheKey, json_encode($supplier));
        return $supplier;
    }

    public function getFilterSuppliersToDB($limit, $offset, $keyword, $isDeleted = 0)
    {

        return $this->supplierModel->getFilteredSuppliers($limit, $offset, $keyword, $isDeleted);
    }

    public function countSuppliersToDB($keyword = '', $isDeleted = 0)
    {
        return $this->supplierModel->countSupplier($keyword, $isDeleted);
    }

    public function getFilterSuppliers($limit, $offset, $keyword)
    {
        $cacheKey = "suppliers:filter:$limit:$offset:$keyword";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }
        $suppliers = $this->supplierModel->getFilteredSuppliers($limit, $offset, $keyword);
        RedisCache::set($cacheKey, json_encode($suppliers));
        return $suppliers;
    }

    public function countSuppliers($keyword = '')
    {
        $cacheKey = "suppliers:count:$keyword";
        if (RedisCache::exists($cacheKey)) {
            return (int) RedisCache::get($cacheKey);
        }
        $total = $this->supplierModel->countSupplier($keyword);
        RedisCache::set($cacheKey, $total);
        return $total;
    }

    public function add($data)
    {
        try {
            if ($this->supplierModel->existsByName($data['name'])) {
                return [
                    'success' => false,
                    'message' => 'Tên nhà cung cấp đã tồn tại!'
                ];
            }
            $supplier = $this->supplierModel->insert($data);
            $this->invalidateCache($supplier);
            return [
                'success' => true,
                'message' => 'Thêm nhà cung cấp thành công',
                'supplier' => $supplier
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function edit($id, $data)
    {
        try {
            $existingSupplier = $this->supplierModel->find($id);
            if ($existingSupplier == null) {
                return [
                    'success' => false,
                    'message' => 'nhà cung cấp không tồn tại!'
                ];
            }

            $existingByName = $this->supplierModel->existsByNameExceptId($id, $data['name']);
            if ($existingByName) {
                return [
                    'success' => false,
                    'message' => 'Tên sản phẩm này đã tồn tại, vui lòng chọn tên khác.'
                ];
            }

            $supplierEdit = $this->supplierModel->update($id, $data);
            $this->invalidateCache($id);

            return [
                'success' => true,
                'message' => 'Cập nhật nhà cung cấp thành công!',
                'supplier' => $supplierEdit
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {

            if (!$this->orderItemModel->canDeleteSupplier($id)) {
                return [
                    'success' => false,
                    'message' => 'Đang có 1 đơn hàng xử lý của nhà cung cấp sản phẩm này!',
                ];
            }

            $product = $this->productModel->getByColumn('supplier_id', $id);

            if (is_array($product) && count($product) > 0) {
                foreach ($product as $item) {
                    $this->inventoryModel->deleteByColumn('product_id', $item['id']);
                }
            }

            $this->productModel->updateDeletedByColumn('supplier_id', $id);

            $supplierDelete = $this->supplierModel->updateDeleted($id);
            $this->invalidateCache($id);

            return [
                'success' => true,
                'message' => 'Xóa nhà cung cấp thành công!',
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function deleteIsDeleted($id)
    {
        try {
            $existingBranch = $this->supplierModel->findIsDeled($id);

            if ($existingBranch == null) {
                return [
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại!'
                ];
            }

            $product = $this->productModel->deleteByColumn('supplier_id', $id);

            if (is_array($product) && count($product) > 0) {
                foreach ($product as $item) {
                    $review = $this->reviewModel->getByColumn('product_id', $item['id']);
                    $orderItem = $this->orderItemModel->getByColumn('product_id', $item['id']);
                    $imageProduct = $this->imageModel->getByColumn('product_id', $item['id']);
                    if (is_array($orderItem) && count($orderItem) > 0) {
                        $this->orderItemModel->deleteByColumn('product_id', $item['id']);
                    }
                    if (is_array($imageProduct) && count($imageProduct) > 0) {
                        $this->imageModel->deleteByColumn('product_id', $item['id']);
                    }
                    if (is_array($review) && count($review) > 0) {
                        $this->reviewModel->deleteByColumn('product_id', $item['id']);
                    }
                }
            }

            $result = $this->supplierModel->delete($id);
            $this->invalidateCache($id);
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Xóa nhà cung cấp thành công!'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Lỗi xóa nhà cung cấp!'
                ];
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
            $existingBranch = $this->supplierModel->findIsDeled($id);

            if ($existingBranch == null) {
                return [
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại!'
                ];
            }

            $this->productModel->updateNotDeletedByColumn('supplier_id', $id);


            $result = $this->supplierModel->updateIsDeleted($id, ['isDeleted' => 0]);
            $this->invalidateCache($id);
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Khôi phục nhà cung cấp thành công!'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Lỗi khôi phục nhà cung cấp!'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    private function invalidateCache($id = null)
    {
        RedisCache::delete('suppliers:all');
        $filterKeys = RedisCache::keys('suppliers:filter:*');
        $countKeys = RedisCache::keys('suppliers:count:*');

        foreach (array_merge($filterKeys, $countKeys) as $key) {
            RedisCache::delete($key);
        }
        if ($id) RedisCache::delete("supplier:$id");
    }
}
