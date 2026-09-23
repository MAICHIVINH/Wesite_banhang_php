<?php
require_once __DIR__ . '/../core/Models.php';

class AiLog extends Model
{
    protected $table = "ai_chat_logs";

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'user_query' => 'TEXT',
        'ai_response' => 'TEXT',
        'rating' => 'TINYINT DEFAULT 0',
        'is_resolved' => 'TINYINT DEFAULT 1',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    public function logQuery($userQuery, $aiResponse, $isResolved = 1)
    {
        $sql = "INSERT INTO {$this->table} (user_query, ai_response, is_resolved) VALUES (:user_query, :ai_response, :is_resolved)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_query' => $userQuery,
            'ai_response' => $aiResponse,
            'is_resolved' => $isResolved
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateRating($id, $rating)
    {
        $sql = "UPDATE {$this->table} SET rating = :rating WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'rating' => $rating,
            'id' => $id
        ]);
    }

    public function getUnresolvedQueries($limit = 50)
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_resolved = 0 OR rating = -1 ORDER BY id DESC LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
