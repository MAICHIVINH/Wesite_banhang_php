<?php
require_once  './core/Models.php';

class Payment extends Model
{
    protected $table = 'payments';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'method' => 'VARCHAR(50)',
        'status' => 'VARCHAR(50)',
        'paid_at' => 'DATETIME'
    ];
}
