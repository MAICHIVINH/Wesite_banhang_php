<?php
require_once  './core/Models.php';


class Status extends Model
{
    protected $table = "status";

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(255) NOT NULL',
        'isDeleted' => 'TINYINT(1)',
    ];
}
