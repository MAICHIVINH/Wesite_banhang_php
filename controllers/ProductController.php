<?php
require_once './models/Product.php';
require_once './models/Order.php';
require_once './models/OrderItem.php';
require_once './models/Image.php';
require_once './models/Review.php';
require_once './models/Category.php';
require_once './models/Supplier.php';

require_once './core/RedisCache.php';
require_once './controllers/BaseController.php';

use Respect\Validation\Validator as v;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends BaseController
{
    private $productModel;
    private $orderItemModel;
    private $orderModel;
    private $inventoryModel;

    private $imageModel;

    private $reviewModel;

    private $categoryModel;
    private $supplierModel;


    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->orderItemModel = new OrderItem();
        $this->orderModel = new Order();
        $this->inventoryModel = new Inventory();
        $this->imageModel = new Image();
        $this->reviewModel = new Review();
        $this->categoryModel = new Category();
        $this->supplierModel = new Supplier();
    }

    public function getAll()
    {

        $cacheKey = 'products:all';
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }


        $products = $this->productModel->all();
        RedisCache::set($cacheKey, json_encode($products));

        return $products;
        // return $this->productModel->all();
    }

    public function getLatestProducts($limit = 20)
    {
        $cacheKey = "products:latest:$limit";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $products = $this->productModel->getLatestProducts($limit);
        RedisCache::set($cacheKey, json_encode($products));

        return $products;
    }

    public function getLatestSaleProducts($limit = 20)
    {
        $cacheKey = "products:latest_sale:$limit";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $products = $this->productModel->getLatestSaleProducts($limit);
        RedisCache::set($cacheKey, json_encode($products));

        return $products;
    }



    public function getById($id)
    {
        $cacheKey = "products:{$id}";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $product = $this->productModel->find($id);
        RedisCache::set($cacheKey, json_encode($product));
        return $product;
        // return $this->productModel->find($id);
    }

    public function getByIdToDB($id)
    {
        return $this->productModel->find($id);
    }

    public function getProductByCategory($id)
    {
        $cacheKey = "products:category:{$id}";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $products = $this->productModel->getProductsByCategory($id);
        RedisCache::set($cacheKey, json_encode($products));
        return $products;
        // return $this->productModel->getProductsByCategory($id);
    }

    public function getFilterProductsToDb($categoryId, $supplierId, $keyword, $limit = 8, $offset = 0, array $priceRanges = [], $isDeleted = 0)
    {
        return $this->productModel->getFilteredProducts($categoryId, $supplierId, $keyword, $limit, $offset);
    }

    public function countProductsToDb($categoryId, $supplierId, $keyword, array $priceRanges = [], $isDeleted = 0)
    {
        return $this->productModel->countFilteredProducts($categoryId, $supplierId, $keyword);
    }

    public function countIsDeleted()
    {
        return $this->productModel->countDeleted();
    }

    public function exportProductsExcel()
    {
        $products = $this->productModel->all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ====== Tiêu đề chính ======
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'DANH SÁCH SẢN PHẨM');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => '2F5597']
            ]
        ]);
        $sheet->getRowDimension('1')->setRowHeight(30);

        // Tiêu đề cột
        $headers = [
            'A1' => 'ID',
            'B1' => 'Tên sản phẩm',
            'C1' => 'Giá',
            'D1' => 'Giảm giá',
            'E1' => 'Mô tả',
            'F1' => 'Ảnh',
            'G1' => 'Loại sản phẩm',
            'H1' => 'Nhà cung cấp',
            'I1' => 'Content',
            'J1' => 'Ngày tạo'
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        // Styling header
        $sheet->getStyle('A2:J2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => '4F81BD']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Ghi dữ liệu
        $row = 3;
        foreach ($products as $product) {
            $category = $this->categoryModel->find($product['category_id']);
            $supplier = $this->supplierModel->find($product['supplier_id']);

            $sheet->setCellValue('A' . $row, $product['id']);
            $sheet->setCellValue('B' . $row, $product['name']);
            $sheet->setCellValue('C' . $row, $product['price']);
            $sheet->setCellValue('D' . $row, $product['discount']);
            $sheet->setCellValue('E' . $row, $product['description']);
            $sheet->setCellValue('F' . $row, $product['image_url']);
            $sheet->setCellValue('G' . $row, $category['name']);
            $sheet->setCellValue('H' . $row, $supplier['name']);
            $sheet->setCellValue('I' . $row, $product['content']);
            $sheet->setCellValue('J' . $row, $product['created_at']);

            $row++;
        }

        // Auto width cho cột
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Bo viền toàn bộ bảng
        $sheet->getStyle('A2:J' . ($row - 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Căn giữa cột số
        $sheet->getStyle('A3:D' . ($row - 1))
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Định dạng tiền tệ cho cột Giá
        $sheet->getStyle('C3:C' . ($row - 1))
            ->getNumberFormat()->setFormatCode('#,##0 "₫"');

        // Xuất file
        $writer = new Xlsx($spreadsheet);
        $filename = 'products_' . date('Y-m-d') . '.xlsx';

        if (ob_get_length()) ob_end_clean();

        $filepath = 'exports/' . $filename;
        $writer->save($filepath);

        echo "<script>
        window.location.href='$filepath';
        setTimeout(function() {
            window.location.href = 'Admin.php?page=modules/Admin/Dashboard/Dashboard.php';
        }, 1000);
    </script>";
    }


    //     public function exportProductsExcel()
    //     {
    //         $products = $this->productModel->all();

    //         $spreadsheet = new Spreadsheet();
    //         $sheet = $spreadsheet->getActiveSheet();

    //         $sheet->setCellValue('A1', 'ID');
    //         $sheet->setCellValue('B1', 'Tên sản phẩm');
    //         $sheet->setCellValue('C1', 'Giá');
    //         $sheet->setCellValue('D1', 'Giảm giá');
    //         $sheet->setCellValue('E1', 'Mô tả');
    //         $sheet->setCellValue('F1', 'Ảnh');
    //         $sheet->setCellValue('G1', 'Loại sản phẩm');
    //         $sheet->setCellValue('H1', 'Nhà cung cấp');
    //         $sheet->setCellValue('I1', 'Content');
    //         $sheet->setCellValue('J1', 'Ngày tạo');

    //         $row = 2;

    //         foreach ($products as $product) {
    //             $category = $this->categoryModel->find($product['category_id']);
    //             $supplier = $this->supplierModel->find($product['supplier_id']);
    //             $sheet->setCellValue('A' . $row, $product['id']);
    //             $sheet->setCellValue('B' . $row, $product['name']);
    //             $sheet->setCellValue('C' . $row, $product['price']);
    //             $sheet->setCellValue('D' . $row, $product['discount']);
    //             $sheet->setCellValue('E' . $row, $product['description']);
    //             $sheet->setCellValue('F' . $row, $product['image_url']);
    //             $sheet->setCellValue('G' . $row, $category['name']);
    //             $sheet->setCellValue('H' . $row, $supplier['name']);
    //             $sheet->setCellValue('I' . $row, $product['content']);
    //             $sheet->setCellValue('J' . $row, $product['created_at']);
    //             $row++;
    //         }

    //         $writer = new Xlsx($spreadsheet);
    //         $filename = 'products_' . date('Y-m-d') . '.xlsx';

    //         if (ob_get_length()) ob_end_clean();

    //         $filepath = 'exports/' . $filename;
    //         $writer->save($filepath);
    //         echo "<script>
    //         window.location.href='$filepath'; 
    // setTimeout(function() {
    //         window.location.href = 'Admin.php?page=modules/Admin/Dashboard/Dashboard.php';
    //     }, 1000);</script>";
    //     }



    public function getFilterProducts($categoryId, $supplierId, $keyword, $limit = 8, $offset = 0, array $priceRanges = [], $isDeleted = 0)
    {
        $start = microtime(true);
        $priceKey = implode(',', $priceRanges);
        $cacheKey = "products:filter:$categoryId:$supplierId:$keyword:$priceKey:$limit:$offset:$isDeleted";
        if (RedisCache::exists($cacheKey)) {

            // $end = microtime(true);
            // echo "⏱ Thời gian xử lý: " . round(($end - $start) * 1000, 2) . " ms";
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $products = $this->productModel->getFilteredProducts($categoryId, $supplierId, $keyword, $limit, $offset, $priceRanges, $isDeleted);
        RedisCache::set($cacheKey, json_encode($products));

        // $end = microtime(true);
        // echo "⏱ Thời gian xử lý: " . round(($end - $start) * 1000, 2) . " ms";

        return $products;
        // return $this->productModel->getFilteredProducts($categoryId, $supplierId, $keyword, $limit, $offset);
    }

    public function countProducts($categoryId, $supplierId, $keyword, array $priceRanges = [], $isDeleted = 0)
    {
        $priceKey = implode(',', $priceRanges);
        $cacheKey = "products:count:$categoryId:$supplierId:$keyword:$priceKey:$isDeleted";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $total = $this->productModel->countFilteredProducts($categoryId, $supplierId, $keyword, $priceRanges, $isDeleted);
        RedisCache::set($cacheKey, json_encode($total));
        return $total;
        // return $this->productModel->countFilteredProducts($categoryId, $supplierId, $keyword);
    }

    public function countProductAll()
    {
        return $this->productModel->countProductAll();
    }

    public function add($data)
    {
        try {
            $rules = [
                'name' => v::stringType()->length(3, 100)
                    ->setTemplate('Tên SP phải 3‑100 ký tự'),
                'price' => v::number()->positive()
                    ->setTemplate('Giá phải là số dương'),
                'discount' => v::intVal()->between(0, 100)
                    ->setTemplate('Giảm giá 0‑100%'),

                'content' => v::stringType()->length(0, 5000)
                    ->setTemplate("Mô tả ngắn phải 0-5000 ký tự"),
            ];

            if (!$this->validator->validate($data, $rules)) {
                return [
                    'success' => false,
                    'errors' => $this->validator->error()
                ];
            }


            if ($this->productModel->existsByName($data['name'])) {
                return [
                    'success' => false,
                    'message' => 'Tên sản phẩm đã tồn tại'
                ];
            }
            $productId = $this->productModel->insert($data);
            $this->clearCacheAfterChange($productId);
            return [
                'success' => true,
                'message' => 'Thêm sản phẩm thành công',
                'product' => $productId
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    public function edit($id, $data)
    {
        try {
            $rules = [
                'name'          => v::stringType()->length(3, 100)
                    ->setTemplate('Tên SP phải 3‑100 ký tự'),
                'price'         => v::number()->positive()
                    ->setTemplate('Giá phải là số dương'),
                'discount'      => v::intVal()->between(0, 100)
                    ->setTemplate('Giảm giá 0‑100%'),

                'content' => v::stringType()->length(0, 5000)
                    ->setTemplate("Mô tả ngắn phải 0-5000 ký tự"),
            ];

            if (!$this->validator->validate($data, $rules)) {
                return [
                    'success' => false,
                    'message' => $this->validator->error(),
                    'errors'  => $this->validator->error()
                ];
            }

            $existingProduct = $this->productModel->find($id);
            if ($existingProduct == null) {
                return [
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại!'
                ];
            }

            $existingByName = $this->productModel->existsByNameExceptId($id, $data['name']);
            if ($existingByName) {
                return [
                    'success' => false,
                    'message' => 'Tên sản phẩm này đã tồn tại, vui lòng chọn tên khác.'
                ];
            }

            $productEdit = $this->productModel->update($id, $data);
            $this->clearCacheAfterChange($id);
            return [
                'success' => true,
                'message' => 'Cập nhật sản phẩm thành công!',
                'product' => $productEdit
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }



    public function deleted($id)
    {
        try {
            $existingProduct = $this->productModel->find($id);
            if ($existingProduct == null) {
                return [
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại!'
                ];
            }

            if ($this->orderItemModel->hasPendingOrCompletedOrdersByProduct($id)) {
                return [
                    'success' => false,
                    'message' => 'Không thể xóa sản phẩm vì đang có đơn hàng liên quan với trạng thái 1 hoặc 6'
                ];
            }
            $orderId = $this->orderItemModel->getOrderIdsByProductId($id);

            if (is_array($orderId) && count($orderId) > 0) {
                foreach ($orderId as $item) {
                    $this->orderModel->updateDeleted($item);
                }
                $this->orderItemModel->updateDeletedByColumn('product_id', $id);
            }


            if ($this->inventoryModel->hasProduct($id)) {

                $this->inventoryModel->updateDeletedByColumn('product_id', $id);
            }

            $deleted = $this->productModel->updateDeleted($id);
            $this->clearCacheAfterChange($id);
            return [
                'success' => true,
                'message' => 'Xóa sản phẩm thành công!',
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function deleteIsDeleted($id)
    {
        try {
            $existingProduct = $this->productModel->findIsDeled($id);

            if ($existingProduct == null) {
                return [
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại!'
                ];
            }
            $orderId = $this->orderItemModel->getOrderIdsByProductId($id);
            if (is_array($orderId) && count($orderId) > 0) {
                foreach ($orderId as $item) {
                    $this->orderModel->delete($item);
                }
                $this->orderItemModel->deleteByColumn('product_id', $id);
            }

            $review = $this->reviewModel->getByColumn('product_id', $id);
            if (is_array($review) && count($review) > 0) {
                $this->reviewModel->deleteByColumn('product_id', $id);
            }

            if ($this->inventoryModel->hasProduct($id)) {

                $this->inventoryModel->deleteByColumn('product_id', $id);
            }

            $image = $this->imageModel->getImagesByProductIdIsDeleted($id);

            if (is_array($image) && count($image) > 0) {
                foreach ($image as $item) {
                    $this->imageModel->delete($item['id']);
                }
            }


            $deleted = $this->productModel->delete($id);
            $this->clearCacheAfterChange($id);
            return [
                'success' => true,
                'message' => 'Xóa sản phẩm thành công!',
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function restore($id, $data)
    {
        try {
            $existingProduct = $this->productModel->findIsDeled($id);

            if ($existingProduct == null) {
                return [
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại!'
                ];
            }

            $orderId = $this->orderItemModel->getOrderIdsByProductId($id);
            if (is_array($orderId) && count($orderId) > 0) {
                foreach ($orderId as $item) {
                    $this->orderModel->delete($item);
                    $this->orderItemModel->deleteByColumn('order_id', $item);
                }
                $this->orderItemModel->deleteByColumn('product_id', $id);
            }

            if ($this->inventoryModel->hasProduct($id)) {

                $this->inventoryModel->deleteByColumn('product_id', $id);
            }

            $result = $this->productModel->updateIsDeleted($id, $data);
            $this->clearCacheAfterChange($id);
            if ($result) {
                return ['success' => true, 'message' => 'Khôi phục thành công'];
            } else {
                return ['success' => false, 'message' => 'khôi phục thất bại'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function clearCacheAfterChange($id)
    {
        try {
            RedisCache::delete("products:all");
            $filterKeys = RedisCache::keys('products:filter:*');
            $countKeys = RedisCache::keys('products:count:*');

            foreach (array_merge($filterKeys, $countKeys) as $key) {
                RedisCache::delete($key);
            }
            if ($id !== null)
                RedisCache::delete("product:$id");
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
