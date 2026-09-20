<?php

require_once  './core/Models.php';

class ChatMessage extends Model
{
    protected $table = "chat_messages";

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'user_id' => 'INT',
        'sender_id' => 'INT',
        'sender_role' => 'VARCHAR(50) NOT NULL',
        'message' => 'TEXT',
        'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
        'isDeleted' => 'TINYINT(1)'
    ];

    protected $foreignKeys = [
        'user_id' => 'users(id)'
    ];

    public function hasUserMessage($userId)
    {
        if ($userId === null) {
            return false;
        }

        $sql = "SELECT EXISTS(
                SELECT 1 
                FROM {$this->table} 
                WHERE user_id = :user_id 
            ) AS found";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return (bool) $stmt->fetchColumn();
    }
}
