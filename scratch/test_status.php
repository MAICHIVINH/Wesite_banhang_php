<?php
require_once './config/database.php';
$pdo = Database::getInstance();
$stmt = $pdo->query("SELECT * FROM status");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
