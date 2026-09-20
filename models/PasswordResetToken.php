<?php
require_once './core/Models.php';

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'user_id' => 'INT NOT NULL',
        'token' => 'VARCHAR(255) NOT NULL',
        'expires_at' => 'DATETIME NOT NULL',
        'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP'
    ];

    public function verifyResetToken($userId, $token,)
    {


        $resetTokenModel = new PasswordResetToken();
        $sql = "SELECT * FROM password_reset_tokens 
            WHERE user_id = :uid AND token = :token 
            ORDER BY id DESC LIMIT 1";
        $stmt = $resetTokenModel->pdo->prepare($sql);
        $stmt->execute([
            'uid' => $userId,
            'token' => $token
        ]);
        $tokenRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$tokenRow) {
            return ['success' => false, 'message' => 'Mã xác thực không đúng'];
        }

        if (strtotime($tokenRow['expires_at']) < time()) {
            return ['success' => false, 'message' => 'Mã xác thực đã hết hạn'];
        }

        return ['success' => true, 'user_id' => $userId];
    }
}
