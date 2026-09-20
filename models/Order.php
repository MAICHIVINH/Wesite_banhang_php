<?php
require_once  './core/Models.php';

class Order extends Model
{
    protected $table = "orders";
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'code' => 'VARCHAR(50) NOT NULL',
        'total_amount' => 'DECIMAL(12,2)',
        'status_id' => 'INT',
        'payment_id' => 'INT',
        'shipping_id' => 'INT',
        'user_id' => 'INT',
        'branch_id' => 'INT',
        'employee_id' => 'INT',
        'note' => 'TEXT',
        'cancel_reason' => 'TEXT',
        'cancel_at' => 'DATETIME',
        'cancel_by' => 'NVARCHAR(255)',
        'create_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        'isDeleted' => 'TINYINT(1)',
    ];

    protected $foreignKeys = [
        'user_id' => 'users(id)',
        'shipping_id' => 'shipping(id)',
        'payment_id' => 'payments(id)',
        'status_id' => 'status(id)',
        'branch_id' => 'branches(id)',
        'employee_id' => 'employees(id)',
    ];

    public function getOrderIdsByUser($userId)
    {
        if ($userId === null) {
            return [];
        }

        $sql = "SELECT id 
            FROM {$this->table} 
            WHERE isDeleted = 0 
              AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        // Lấy tất cả ID về dạng mảng
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


    public function hasUserOrder($id)
    {
        // Nếu không truyền id thì mặc định false
        if ($id === null) {
            return false;
        }

        $sql = "SELECT COUNT(*) 
            FROM {$this->table} 
            WHERE isDeleted = 0 
              AND user_id = :user_id 
              AND status_id != 6";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $id]);
        $count = (int) $stmt->fetchColumn();

        return $count > 0;
    }


    public function countOrdersThisWeek()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE isDeleted = 0 
                                                    AND YEARWEEK(create_at, 1) = YEARWEEK(CURDATE(), 1)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function GetOrdersThisWeek()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE isDeleted = 0 
                                                    AND YEARWEEK(create_at, 1) = YEARWEEK(CURDATE(), 1)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }


    public function countOrdersByStatusThisWeek($statusId)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE isDeleted = 0 
                                                    AND YEARWEEK(create_at, 1) = YEARWEEK(CURDATE(), 1) AND status_id = :status_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["status_id" => $statusId]);
        return (int) $stmt->fetchColumn();
    }

    public function findByCode($code)
    {
        $sql = "
            SELECT  o.*, u.* ,s.name AS status_name, o.id AS order_id, e.name AS employee_name
            FROM    orders o
            JOIN    status s   ON o.status_id = s.id
            JOIN    users u ON o.user_id = u.id
            JOIN    employees e ON e.id = o.employee_id 
            WHERE   o.code  = :code
              AND   o.isDeleted = 0
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['code' => $code]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOrders(
        int $userId,
        ?int $statusId = null,
        string $keyword    = '',
        int    $limit      = 10,
        int    $offset     = 0
    ) {
        $sql = "
            SELECT  o.*, u.* ,s.name AS status_name, o.id AS order_id, sh.status AS status_shipping
            FROM    orders o
            JOIN    status s   ON o.status_id = s.id
            JOIN    shipping sh ON sh.id = o.shipping_id
            JOIN    users u ON o.user_id = u.id
            WHERE   o.user_id  = :user_id
              AND   o.isDeleted = 0
        ";

        $params = ['user_id' => $userId];

        if ($statusId !== null) {
            $sql .= " AND o.status_id = :status_id";
            $params['status_id'] = $statusId;
        }

        if ($keyword !== '') {
            $sql .= " AND o.code LIKE :kw";
            $params['kw'] = '%' . $keyword . '%';
        }


        $sql .= " ORDER BY o.id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countOrders(int $userId, ?int $statusId = null, $keyword = '', $isDeleted = 0): int
    {
        $sql = "SELECT COUNT(*) FROM orders WHERE user_id = :uid AND isDeleted = 0";
        $params = ['uid' => $userId, 'isDeleted' => $isDeleted];
        $sql .= " AND isDeleted = :isDeleted";


        if ($statusId !== null) {
            $sql .= " AND status_id = :sid";
            $params['sid'] = $statusId;
        }
        if ($keyword !== '') {
            $sql .= " AND code LIKE :kw";
            $params['kw'] = '%' . $keyword . '%';
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function findOrderWithStatus(
        ?int $statusId = null,
        string $keyword    = '',
        int    $limit      = 10,
        int    $offset     = 0,
        ?int $branch_id = null,
        ?int $employeeId = null,
        bool $isAdmin = false,
        $isDeleted = 0
    ) {
        $sql = "
            SELECT  o.*, u.* ,s.name AS status_name, o.id AS order_id, sh.status AS status_shipping
            FROM    orders o
            JOIN    status s   ON o.status_id = s.id
            JOIN    shipping sh ON sh.id = o.shipping_id
            JOIN    users u ON o.user_id = u.id
            JOIN    branches b ON b.id = o.branch_id
            WHERE   1=1
        ";

        $params = ['isDeleted' => $isDeleted];
        $sql .= " AND o.isDeleted = :isDeleted";

        if ($statusId !== null) {
            $sql .= " AND o.status_id = :status_id";
            $params['status_id'] = $statusId;
        }

        if ($keyword !== '') {
            $sql .= " AND o.code LIKE :kw";
            $params['kw'] = '%' . $keyword . '%';
        }

        if (!$isAdmin) {
            if ($branch_id !== null) {
                $sql .= " AND branch_id = :branch_id";
                $params['branch_id'] = $branch_id;
            }

            if ($employeeId !== null && $statusId !== 1) {
                $sql .= " AND employee_id = :employee_id";
                $params['employee_id'] = $employeeId;
            }
        }

        $sql .= " ORDER BY o.id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countOrderWithStatus(
        ?int $statusId = null,
        $keyword = '',
        ?int $branch_id = null,
        ?int $employeeId = null,
        bool $isAdmin = false,
        $isDeleted = 0
    ): int {
        $sql = "SELECT COUNT(*) FROM orders WHERE isDeleted = 0";

        $params = ['isDeleted' => $isDeleted];
        $sql .= " AND isDeleted = :isDeleted";
        if ($statusId !== null) {
            $sql .= " AND status_id = :sid";
            $params['sid'] = $statusId;
        }
        if ($keyword !== '') {
            $sql .= " AND code LIKE :kw";
            $params['kw'] = '%' . $keyword . '%';
        }

        if (!$isAdmin) {
            if ($branch_id !== null) {
                $sql .= " AND branch_id = :branch_id";
                $params['branch_id'] = $branch_id;
            }

            if ($employeeId !== null && $statusId !== 1) {
                $sql .= " AND employee_id = :employee_id";
                $params['employee_id'] = $employeeId;
            }
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function findAllOrders(
        string $keyword    = '',
        int    $limit      = 10,
        int    $offset     = 0
    ) {
        $sql = "
            SELECT  o.*, u.* ,s.name AS status_name, o.id AS order_id, sp.address AS shipping_address, sp.status AS shipping_status
            FROM    orders o
            JOIN    status s   ON o.status_id = s.id
            JOIN    users u ON o.user_id = u.id
            JOIN    shipping sp ON sp.id = o.shipping_id
            WHERE   o.isDeleted = 0
        ";
        $params = [];

        if ($keyword !== '') {
            $sql .= " AND o.code LIKE :kw";
            $params['kw'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY o.id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllOrders($keyword = ""): int
    {
        $sql = "SELECT COUNT(*) FROM orders WHERE isDeleted = 0";
        $params = [];

        if ($keyword !== '') {
            $sql .= " AND code LIKE :kw";
            $params['kw'] = '%' . $keyword . '%';
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function getUserAddressByShippingId($shippingId)
    {
        $sql = "
        SELECT u.Address AS address, o.id AS order_id
        FROM orders o
        JOIN users u ON o.user_id = u.id
        WHERE o.shipping_id = :shippingId
          AND o.isDeleted = 0
        LIMIT 1
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['shippingId' => $shippingId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
