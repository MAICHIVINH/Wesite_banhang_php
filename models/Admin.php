<?php
require_once  './core/Models.php';

class Admin extends Model
{
    protected $table = 'admin';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'username' => 'VARCHAR(100)',
        'password_hash' => 'VARCHAR(255)',
        'email' => 'VARCHAR(255)',
        'role' => 'VARCHAR(255)',
        'isDeleted' => 'TINYINT(1)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    public function ExistsLogin($email, $password)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email AND password_hash = :password";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["email" => $email, "password" => $password]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ExitEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["email" => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
