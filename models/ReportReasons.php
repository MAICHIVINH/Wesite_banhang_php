<?php

require_once  './core/Models.php';

class ReportReasons extends Model
{
    protected $table = 'reports';

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'reason_text' => 'VARCHAR(255) NOT NULL',
        'ban_days' => 'INT DEFAULT 0',
        'isDeleted' => 'TINYINT(1)',

    ];
}
