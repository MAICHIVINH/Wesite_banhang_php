<?php

require_once  './core/Models.php';

class Shipping extends Model
{
    protected $table = 'shipping';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'address' => 'TEXT',
        'method' => 'VARCHAR(50)',
        'status' => 'VARCHAR(50)',
        'isDeleted' => 'TINYINT(1)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        'updated_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
    ];
}
