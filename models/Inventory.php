 <?php
    require_once  './core/Models.php';

    class Inventory extends Model
    {
        protected $table = 'inventory';
        protected $fields = [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'stock_quantity' => 'INT',
            'last_update' => 'DATETIME',
            'product_id' => 'INT',
            'branch_id' => 'INT',
            'isDeleted' => 'TINYINT(1)',
        ];

        protected $foreignKeys = [
            'branch_id' => 'branches(id)',
            'product_id' => 'products(id)'
        ];
        public function hasProduct(int $productId): bool
        {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE product_id = :product_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['product_id' => $productId]);
            $count = $stmt->fetchColumn();

            return $count > 0;
        }

        public function hasBranch(int $branch_id): bool
        {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE branch_id = :branch_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['branch_id' => $branch_id]);
            $count = $stmt->fetchColumn();

            return $count > 0;
        }

        public function getInventoryWithProducts($branch_id = null)
        {
            $sql = "SELECT inv.*, inv.id AS inventory_id, p.*, b.name AS branch_name
            FROM inventory inv
            JOIN products p ON inv.product_id = p.id
            JOIN branches b ON inv.branch_id = b.id
            WHERE inv.isDeleted = 0";

            $params = [];

            if ($branch_id !== null) {
                $sql .= " AND inv.branch_id = :branch_id";
                $params['branch_id'] = $branch_id;
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function getFiltered($keyword = '', int $limit = 8, int $offset = 0, $branch_id = null, $isAdmin = false)
        {
            $sql = "
        SELECT inv.*, p.name AS product_name, p.id AS product_id ,b.name AS branch_name, b.id AS branch_id
        FROM {$this->table} inv
        JOIN products p ON p.id = inv.product_id
        JOIN branches b ON b.id = inv.branch_id
        WHERE inv.isDeleted = 0
    ";

            $params = [];

            if ($keyword !== '') {
                $sql            .= " AND p.name LIKE :kw";
                $params['kw']    = '%' . $keyword . '%';
            }

            if (!$isAdmin && $branch_id !== null) {
                $sql .= " AND b.id = :branch_id";
                $params['branch_id'] = $branch_id;
            }

            $sql .= " ORDER BY inv.id DESC LIMIT :limit OFFSET :offset";

            $stmt = $this->pdo->prepare($sql);
            foreach ($params as $k => $v) {
                $stmt->bindValue(':' . $k, $v);
            }
            $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function countFiltered($keyword = '', $branch_id = null, $isAdmin = false)
        {
            $sql = "
        SELECT COUNT(*) AS total
        FROM {$this->table} inv
        JOIN products p ON p.id = inv.product_id
        JOIN branches b ON b.id = inv.branch_id
        WHERE inv.isDeleted = 0
    ";
            $params = [];
            if ($keyword !== '') {
                $sql           .= " AND p.name LIKE :kw";
                $params['kw']   = '%' . $keyword . '%';
            }

            if (!$isAdmin && $branch_id !== null) {
                $sql .= " AND b.id = :branch_id";
                $params['branch_id'] = $branch_id;
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        }

        public function getInventory($product_id = null, $branch_id = null, $isFind = false, $id = null)
        {
            $sql = "SELECT *,inv.id AS inventory_id   FROM inventory inv
                    JOIN branches b ON inv.branch_id = b.id
                    WHERE inv.isDeleted = 0";
            $params = [];

            if ($id !== null) {
                $sql .= " AND inv.id != :id";
                $params['id'] = $branch_id;
            }

            if ($product_id !== null) {
                $sql .= " AND product_id = :product_id";
                $params['product_id'] = $product_id;
            }

            if ($branch_id !== null) {
                $sql .= " AND branch_id = :branch_id";
                $params['branch_id'] = $branch_id;
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            return $isFind ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
