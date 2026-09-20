    <?php
    require_once  './core/Models.php';

    class Product extends Model
    {
        protected $table = "products";

        protected $fields = [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(255) NOT NULL',
            'price' => 'DECIMAL(12,2)',
            'discount' => 'DECIMAL(5,2)',
            'description' => 'TEXT',
            'image_url' => 'VARCHAR(500)',
            'category_id' => 'INT',
            'supplier_id' => 'INT',
            'content' => 'TEXT',
            'isDeleted' => 'TINYINT(1)',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ];
        protected $foreignKeys = [
            'category_id' => 'categories(id)',
            'supplier_id' => 'suppliers(id)',
        ];

        public function countProductAll($isDeleted = 0)
        {
            $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE isDeleted = :isDeleted";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['isDeleted' => $isDeleted]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) ($result['total'] ?? 0);
        }
        public function getFilteredProducts($categoryId = null, $supplierId = null, $keyword = null, $limit = 8, $offset = 0, array $priceRanges = [], $isDeleted = 0)
        {
            $sql = "
        SELECT p.*, c.name as category_name, s.name as supplier_name
        FROM products p
        JOIN categories c ON p.category_id = c.id
        JOIN suppliers s ON p.supplier_id = s.id
        WHERE 1=1
    ";

            $params = ['isDeleted' => $isDeleted];
            $sql .= " AND p.isDeleted = :isDeleted";

            if ($categoryId !== null) {
                $sql .= " AND p.category_id = :category_id";
                $params['category_id'] = $categoryId;
            }

            if ($supplierId !== null) {
                $sql .= " AND p.supplier_id = :supplier_id";
                $params['supplier_id'] = $supplierId;
            }

            if (!empty($keyword)) {
                $sql .= " AND p.name LIKE :keyword";
                $params['keyword'] = '%' . $keyword . '%';
            }

            if (!empty($priceRanges)) {
                $priceClauses = [];

                foreach ($priceRanges as $range) {
                    switch ($range) {
                        case 1: // < 5
                            $priceClauses[] = "(p.price < 5000000)";
                            break;
                        case 2: // 5 – <10
                            $priceClauses[] = "(p.price >= 5000000 AND p.price < 10000000)";
                            break;
                        case 3: // 10 – <20
                            $priceClauses[] = "(p.price >= 10000000 AND p.price < 20000000)";
                            break;
                        case 4: // >= 20
                            $priceClauses[] = "(p.price >= 20000000)";
                            break;
                    }
                }

                if ($priceClauses) {
                    $sql .= " AND (" . implode(' OR ', $priceClauses) . ")";
                }
            }

            $sql .= " ORDER BY p.id DESC LIMIT :limit OFFSET :offset";

            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $key => $val) {
                $stmt->bindValue(":$key", $val);
            }

            $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }




        // dưới đây là các hàm xử lý trực tiếp trên server
        public function getProductsByCategory($id)
        {
            $stmt = $this->pdo->query("
                SELECT p.*, c.name as category_name
                FROM products p
                JOIN categories c ON p.category_id = $:id
            ");
            $stmt->execute(['id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function countFilteredProducts($categoryId = null, $supplierId = null, $keyword = null, array $priceRanges = [], $isDeleted = 0)
        {
            $sql = "
        SELECT COUNT(*) as total
        FROM products p
         WHERE 1=1
    ";

            $params = ['isDeleted' => $isDeleted];
            $sql .= " AND p.isDeleted = :isDeleted";

            if ($isDeleted !== null) {
                $sql .= " AND p.isDeleted = :isDeleted";
                $params['isDeleted'] = $isDeleted;
            }

            if ($categoryId !== null) {
                $sql .= " AND p.category_id = :category_id";
                $params['category_id'] = $categoryId;
            }

            if ($supplierId !== null) {
                $sql .= " AND p.supplier_id = :supplier_id";
                $params['supplier_id'] = $supplierId;
            }

            if (!empty($keyword)) {
                $sql .= " AND p.name LIKE :keyword";
                $params['keyword'] = '%' . $keyword . '%';
            }

            if (!empty($priceRanges)) {
                $priceClauses = [];

                foreach ($priceRanges as $range) {
                    switch ($range) {
                        case 1: // < 5
                            $priceClauses[] = "(p.price < 5000000)";
                            break;
                        case 2: // 5 – <10
                            $priceClauses[] = "(p.price >= 5000000 AND p.price < 10000000)";
                            break;
                        case 3: // 10 – <20
                            $priceClauses[] = "(p.price >= 10000000 AND p.price < 20000000)";
                            break;
                        case 4: // >= 20
                            $priceClauses[] = "(p.price >= 20000000)";
                            break;
                    }
                }

                if ($priceClauses) {
                    $sql .= " AND (" . implode(' OR ', $priceClauses) . ")";
                }
            }

            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $key => $val) {
                $stmt->bindValue(":$key", $val);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        }


        public function getLatestProducts($limit = 20)
        {
            $sql = "
                SELECT p.*, c.name AS category_name, s.name AS supplier_name
                FROM products p
                JOIN categories c ON p.category_id = c.id
                JOIN suppliers s ON p.supplier_id = s.id
                WHERE p.isDeleted = 0
                ORDER BY p.created_at DESC
                LIMIT :limit
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getLatestSaleProducts($limit = 20)
        {
            $sql = "
                SELECT p.*, c.name AS category_name, s.name AS supplier_name
                FROM products p
                JOIN categories c ON p.category_id = c.id
                JOIN suppliers s ON p.supplier_id = s.id
                WHERE p.isDeleted = 0 AND p.discount > 0
                ORDER BY p.created_at DESC
                LIMIT :limit
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
