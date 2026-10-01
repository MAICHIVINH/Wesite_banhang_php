<?php

use Dotenv\Dotenv;

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $envFile = __DIR__ . '/.env';
        if (file_exists($envFile)) {
            $vendorAutoload = __DIR__ . '/../vendor/autoload.php';
            if (file_exists($vendorAutoload)) {
                require_once $vendorAutoload;
            }
            if (class_exists('Dotenv\Dotenv')) {
                $dotenv = Dotenv::createImmutable(__DIR__);
                $dotenv->safeLoad();
            }
        }

        $host    = $_ENV['DB_HOST'];
        $port    = $_ENV['DB_PORT'];
        $db      = $_ENV['DB_NAME'];
        $user    = $_ENV['DB_USER'];
        $pass    = $_ENV['DB_PASS'];
        $charset = $_ENV['DB_CHARSET'];

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        $this->pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
