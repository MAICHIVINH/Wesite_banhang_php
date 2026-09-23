<?php
require_once './core/Models.php';

class FlashSale extends Model
{
    protected $table = 'flash_sales';

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'title' => 'VARCHAR(255) DEFAULT "HOT SALE GIÁ SỐC"',
        'end_time' => 'DATETIME',
        'status' => 'TINYINT(1) DEFAULT 1',
        'updated_at' => 'DATETIME'
    ];

    public function __construct()
    {
        parent::__construct();
        try {
            $this->createTable();
            $this->seedInitial();
        } catch (Throwable $e) {
            // Table / columns ready
        }
    }

    private function seedInitial()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->table}");
        if ($stmt->fetchColumn() == 0) {
            $sql = "INSERT INTO {$this->table} (title, end_time, status, updated_at) VALUES (:title, :end_time, 1, NOW())";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'title' => 'HOT SALE GIÁ SỐC',
                'end_time' => date('Y-m-d H:i:s', strtotime('+3 days'))
            ]);
        }
    }

    public function getActiveConfig()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT 1";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            $this->seedInitial();
            $stmt = $this->pdo->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }

    public function updateConfig($title, $endTime, $status)
    {
        $current = $this->getActiveConfig();
        // Convert datetime-local format (Y-m-d\TH:i) to MySQL DATETIME (Y-m-d H:i:s)
        $formattedEndTime = date('Y-m-d H:i:s', strtotime($endTime));

        if ($current && isset($current['id'])) {
            $sql = "UPDATE {$this->table} SET title = :title, end_time = :end_time, status = :status, updated_at = NOW() WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'title' => $title,
                'end_time' => $formattedEndTime,
                'status' => (int)$status,
                'id' => $current['id']
            ]);
        } else {
            $sql = "INSERT INTO {$this->table} (title, end_time, status, updated_at) VALUES (:title, :end_time, :status, NOW())";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'title' => $title,
                'end_time' => $formattedEndTime,
                'status' => (int)$status
            ]);
        }
    }
}
