    <?php

    require_once './core/RedisCache.php';
    require_once './models/ChatMessage.php';

    class ChatController
    {

        private $chatMessageModel;

        public function __construct()
        {
            $this->chatMessageModel = new ChatMessage();
        }

        public function getAllChatUserIdsFromRedis()
        {
            $keys = RedisCache::getClient()->keys("chat:user:*");
            $userIds = [];

            foreach ($keys as $key) {
                if (preg_match('/^chat:user:(\d+)$/', $key, $matches)) {
                    $userIds[] = (int)$matches[1];
                }
            }

            return $userIds;
        }


        public function sendMessage($userId, $from, $message)
        {
            $chatKey = "chat:user:$userId";
            $senderRole = $from['sender_role'];

            $entry = json_encode([
                'from' => $senderRole,
                'message' => $message,
                'time' => date('H:i d/m/Y'),
            ]);

            RedisCache::getClient()->rpush($chatKey, [$entry]);

            $senderId = $from['sender_id'] ?? null;

            $this->chatMessageModel->insert([
                'user_id' => $userId,
                'sender_id' => $senderId,
                'sender_role' => $senderRole,
                'message' => $message,
                'isDeleted' => 0
            ]);
            
            return [
                'success' => true
            ];
        }

        public function getChatHistory($userId)
        {
            $chatKey = "chat:user:$userId";

            $messages = RedisCache::getClient()->lrange($chatKey, 0, -1);
            return array_map('json_decode', $messages);
        }

        public function clearChat($userId)
        {
            $chatKey = "chat:user:$userId";
            RedisCache::delete($chatKey);
        }
    }
