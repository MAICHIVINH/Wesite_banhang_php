<?php

require_once  './core/Models.php';

class UserReports extends Model
{
    protected $table = 'user_reports';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'reported_user_id' => 'INT NOT NULL',
        'reason_id' => 'INT NOT NULL',
        'banned_by_user_id' => 'INT NULL',
        'banned_by_role' => 'VARCHAR(50)',
        'banned_from' => "DATETIME",
        'banned_until' => 'DATETIME',
        'isDeleted' => 'TINYINT(1)',
        'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
    ];

    protected $foreignKeys = [
        'reported_user_id' => 'users(id)',
        'reason_id' => 'reports(id)'
    ];

    public function hasReportOfUser($userId)
    {
        if ($userId === null) {
            return false;
        }

        $sql = "SELECT EXISTS(
                SELECT 1
                FROM {$this->table}
                WHERE reported_user_id = :user_id
            ) AS found";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return (bool) $stmt->fetchColumn();
    }


    public function getLatestByUserId($userId)
    {
        $sql = "SELECT * FROM {$this->table}
            WHERE reported_user_id = :user_id AND isDeleted = 0
            ORDER BY banned_until DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function DeleteReportUser($id)
    {
        $sql = "UPDATE {$this->table} SET isDeleted = 1 WHERE reported_user_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
