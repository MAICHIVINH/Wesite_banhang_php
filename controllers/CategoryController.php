
<?php

require_once './models/Category.php';
require_once './core/RedisCache.php';
require_once './models/Product.php';
require_once './models/OrderItem.php';
require_once './models/Inventory.php';
require_once './models/Image.php';
require_once './models/Review.php';
require_once './controllers/ProductController.php';

class CategoryController
{
    private $categoryModel;
    private $productModel;
    private $productController;
    private $orderItemModel;
    private $inventoryModel;
    private $imageModel;
    private $reviewModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
        $this->productModel = new Product();
        $this->productController = new ProductController();
        $this->orderItemModel = new OrderItem();
        $this->inventoryModel = new Inventory();
        $this->imageModel = new Image();
        $this->reviewModel = new Review();
    }

    public function getAll()
    {
        $key = 'categories:all';
        if (RedisCache::exists($key)) {
            return json_decode(RedisCache::get($key), true);
        }
        $data = $this->categoryModel->all();
        RedisCache::set($key, json_encode($data));
        return $data;
    }

    public function getAllToDb()
    {
        return $this->categoryModel->all();
    }

    public function getById($id)
    {
        $key = "category:$id";
        if (RedisCache::exists($key)) {
            return json_decode(RedisCache::get($key), true);
        }
        $data = $this->categoryModel->find($id);
        RedisCache::set($key, json_encode($data));
        return $data;
    }

    public function getByIdToDb($id)
    {
        return $this->categoryModel->find($id);
    }

    public function getFilterCategoriesToDb($limit, $offset, $keyword, $isDeleted = 0)
    {
        return $this->categoryModel->getFilteredCategories($limit, $offset, $keyword, $isDeleted);
    }

    public function countCategoriesToDb($keyword = '', $isDeleted = 0)
    {
        return $this->categoryModel->countCategory($keyword, $isDeleted);
    }

    public function countIsDeleted()
    {
        return $this->categoryModel->countDeleted();
    }

    public function getFilterCategories($limit, $offset, $keyword, $isDeleted = 0)
    {
        $key = "categories:filter:$limit:$offset:$keyword:$isDeleted";
        if (RedisCache::exists($key)) {
            return json_decode(RedisCache::get($key), true);
        }
        $data = $this->categoryModel->getFilteredCategories($limit, $offset, $keyword, $isDeleted);
        RedisCache::set($key, json_encode($data));
        return $data;
    }

    public function countCategories($keyword = '', $isDeleted = 0)
    {
        $key = "categories:count:$keyword:$isDeleted";
        if (RedisCache::exists($key)) {
            return (int) RedisCache::get($key);
        }
        $total = $this->categoryModel->countCategory($keyword, $isDeleted);
        RedisCache::set($key, $total);
        return $total;
    }

    public function add($data)
    {
        if ($this->categoryModel->existsByName($data['name'])) {
            return [
                'success' => false,
                'message' => 'Tên thể loại đã tồn tại!'
            ];
        }
        $category = $this->categoryModel->insert($data);
        $this->invalidateCache();
        return [
            'success' => true,
            'message' => 'Thêm thể loại thành công',
            'category' => $category
        ];
    }

    public function edit($id, $data)
    {
        try {
            $existingcategory = $this->categoryModel->find($id);
            if ($existingcategory == null) {
                return [
                    'success' => false,
                    'message' => 'thể loại không tồn tại!'
                ];
            }

            $existingByName = $this->categoryModel->existsByNameExceptId($id, $data['name']);
            if ($existingByName) {
                return [
                    'success' => false,
                    'message' => 'Tên loại sản phẩm này đã tồn tại, vui lòng chọn tên khác.'
                ];
            }
            $categoryEdit = $this->categoryModel->update($id, $data);
            $this->invalidateCache($id);
            return [
                'success' => true,
                'message' => 'Cập nhật thể loại thành công!',
                'category' => $categoryEdit
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
            $existingcategory = $this->categoryModel->find($id);
            if ($existingcategory == null) {
                return [
                    'success' => false,
                    'message' => 'thể loại không tồn tại!'
                ];
            }

            if (!$this->orderItemModel->canDeleteCategory($id)) {
                return [
                    'success' => false,
                    'message' => 'Đang có 1 đơn hàng xử lý của loại sản phẩm này!',
                ];
            }


            $product = $this->productModel->getByColumn('category_id', $id);

            if (is_array($product) && count($product) > 0) {
                foreach ($product as $item) {
                    $this->inventoryModel->deleteByColumn('product_id', $item['id']);
                }
            }

            $this->productModel->updateDeletedByColumn('category_id', $id);

            $categoryDelete = $this->categoryModel->updateDeleted($id);
            $this->invalidateCache($id);
            return [
                'success' => true,
                'message' => 'Xóa thể loại thành công',
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
            $existingBranch = $this->categoryModel->findIsDeled($id);

            if ($existingBranch == null) {
                return [
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại!'
                ];
            }

            $product = $this->productModel->getByColumn('category_id', $id);

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

            $resultProduct = $this->productModel->deleteByColumn('category_id', $id);

            $result = $this->categoryModel->delete($id);
            $this->invalidateCache($id);
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Xóa loại sản phẩm thành công!'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Lỗi Xóa loại sản phẩm!'
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
            $existingBranch = $this->categoryModel->findIsDeled($id);

            if ($existingBranch == null) {
                return [
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại!'
                ];
            }
            $this->productModel->updateNotDeletedByColumn('category_id', $id);
            $result = $this->categoryModel->updateIsDeleted($id, ['isDeleted' => 0]);
            $this->invalidateCache($id);
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Khôi phục loại sản phẩm thành công!'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Khôi phục loại sản phẩm!'
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
        RedisCache::delete('categories:all');
        RedisCache::delete('categories:filter');

        $filterKeys = RedisCache::keys('categories:filter:*');
        $countKeys = RedisCache::keys('categories:count:*');

        $filterKeysProduct = RedisCache::keys('products:filter:*');
        $countKeysProduct = RedisCache::keys('products:count:*');

        foreach (array_merge($filterKeysProduct, $countKeysProduct) as $key) {
            RedisCache::delete($key);
        }

        foreach (array_merge($filterKeys, $countKeys) as $key) {
            RedisCache::delete($key);
        }

        if ($id !== null) {
            RedisCache::delete("category:$id");
        }
    }
}
