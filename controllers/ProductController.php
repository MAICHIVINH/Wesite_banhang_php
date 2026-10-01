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
use PhpOffice\PhpSpreadsheet\IOFactory;


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

    public function countLowStock($threshold = 10)
    {
        return $this->productModel->countLowStock($threshold);
    }

    public function getTopSellingProducts($limit = 5)
    {
        return $this->productModel->getTopSellingProducts($limit);
    }

    public function exportSampleProductExcel()
    {
        $spreadsheet = new Spreadsheet();
        
        // Sheet 1: Product Template
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Nhập sản phẩm');

        // Header Style
        $sheet1->mergeCells('A1:I1');
        $sheet1->setCellValue('A1', 'MẪU FILE NHẬP SẢN PHẨM HÀNG LOẠT');
        $sheet1->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
        $sheet1->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('198754');
        $sheet1->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Column Headers
        $headers = [
            'A2' => 'Tên sản phẩm (*)',
            'B2' => 'Giá bán (VNĐ) (*)',
            'C2' => 'Giảm giá (%)',
            'D2' => 'Loại sản phẩm (*)',
            'E2' => 'Nhà cung cấp (*)',
            'F2' => 'Số lượng nhập kho',
            'G2' => 'URL hình ảnh',
            'H2' => 'Mô tả ngắn',
            'I2' => 'Nội dung chi tiết'
        ];

        foreach ($headers as $cell => $value) {
            $sheet1->setCellValue($cell, $value);
        }

        $sheet1->getStyle('A2:I2')->getFont()->setBold(true);
        $sheet1->getStyle('A2:I2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('E9ECEF');

        // Sample Data Rows
        $sampleData = [
            [
                'iPhone 16 Pro Max 256GB',
                34990000,
                5,
                'Điện thoại',
                'Apple',
                20,
                'https://images.unsplash.com/photo-1592750475338-74b7b21085ab',
                'Điện thoại cao cấp Apple 2026',
                'Chip A18 Pro mượt mà, khung Titanium siêu bền'
            ],
            [
                'Laptop Dell XPS 15 9530',
                45000000,
                10,
                'Laptop',
                'Dell',
                15,
                'https://images.unsplash.com/photo-1593642632823-8f785ba67e45',
                'Laptop doanh nhân màn hình OLED',
                'Intel Core i9, RAM 32GB, SSD 1TB'
            ]
        ];

        $row = 3;
        foreach ($sampleData as $data) {
            $col = 'A';
            foreach ($data as $val) {
                $sheet1->setCellValue($col . $row, $val);
                $col++;
            }
            $row++;
        }

        foreach (range('A', 'I') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }

        // Sheet 2: Lookup reference
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Danh mục & Nhà cung cấp');

        $sheet2->setCellValue('A1', 'ID Loại SP');
        $sheet2->setCellValue('B1', 'Tên Loại sản phẩm');
        $sheet2->getStyle('A1:B1')->getFont()->setBold(true);

        $categories = $this->categoryModel->all();
        $r = 2;
        foreach ($categories as $cat) {
            $sheet2->setCellValue('A' . $r, $cat['id']);
            $sheet2->setCellValue('B' . $r, $cat['name']);
            $r++;
        }

        $sheet2->setCellValue('D1', 'ID Nhà cung cấp');
        $sheet2->setCellValue('E1', 'Tên Nhà cung cấp');
        $sheet2->getStyle('D1:E1')->getFont()->setBold(true);

        $suppliers = $this->supplierModel->all();
        $r = 2;
        foreach ($suppliers as $sup) {
            $sheet2->setCellValue('D' . $r, $sup['id']);
            $sheet2->setCellValue('E' . $r, $sup['name']);
            $r++;
        }

        foreach (range('A', 'E') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }

        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        $filename = 'mau_nhap_san_pham.xlsx';
        $filepath = 'exports/' . $filename;

        if (!file_exists('exports')) {
            mkdir('exports', 0777, true);
        }

        if (ob_get_length()) ob_end_clean();
        $writer->save($filepath);

        echo "<script>
            window.location.href='$filepath';
            setTimeout(function() {
                window.location.href = 'Admin.php?page=modules/Admin/Products/Product.php';
            }, 1000);
        </script>";
        exit;
    }

    public function importProductsExcel($filePath)
    {
        try {
            if (!file_exists($filePath)) {
                return ['success' => false, 'message' => 'Không tìm thấy file Excel upload!'];
            }

            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();

            $importedCount = 0;

            for ($row = 3; $row <= $highestRow; $row++) {
                $name = trim((string)$sheet->getCell('A' . $row)->getValue());
                if (empty($name)) continue; // Skip empty rows

                $price = (float)$sheet->getCell('B' . $row)->getValue();
                $discount = (float)$sheet->getCell('C' . $row)->getValue();
                $categoryInput = trim((string)$sheet->getCell('D' . $row)->getValue());
                $supplierInput = trim((string)$sheet->getCell('E' . $row)->getValue());
                $stockQty = (int)$sheet->getCell('F' . $row)->getValue();
                if ($stockQty <= 0) $stockQty = 10; // Default stock quantity

                $imageUrl = trim((string)$sheet->getCell('G' . $row)->getValue());
                if (empty($imageUrl)) {
                    $imageUrl = 'public/uploads/default-product.jpg';
                }

                $description = trim((string)$sheet->getCell('H' . $row)->getValue());
                $content = trim((string)$sheet->getCell('I' . $row)->getValue());

                // Resolve Category and Supplier IDs
                $categoryId = $this->categoryModel->findByNameOrCreate($categoryInput);
                $supplierId = $this->supplierModel->findByNameOrCreate($supplierInput);

                $productData = [
                    'name' => $name,
                    'price' => $price,
                    'discount' => $discount,
                    'description' => $description,
                    'content' => $content,
                    'category_id' => $categoryId,
                    'supplier_id' => $supplierId,
                    'image_url' => $imageUrl,
                    'isDeleted' => 0
                ];

                $result = $this->productModel->insert($productData);
                if ($result) {
                    $newProductId = (int)$result;
                    // Initialize inventory record
                    $this->inventoryModel->insert([
                        'product_id' => $newProductId,
                        'branch_id' => 1,
                        'stock_quantity' => $stockQty,
                        'last_update' => date('Y-m-d H:i:s'),
                        'isDeleted' => 0
                    ]);
                    $importedCount++;
                }
            }

            return [
                'success' => true,
                'count' => $importedCount,
                'message' => "Đã nhập thành công {$importedCount} sản phẩm vào hệ thống!"
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi đọc file Excel: ' . $e->getMessage()];
        }
    }
}


