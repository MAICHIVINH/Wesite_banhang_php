<?php

require_once  './core/Models.php';


class Banner extends Model
{
    protected $table = 'banners';

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'title' => 'VARCHAR(255)',
        'image' => 'VARCHAR(255)',
        'link' => 'VARCHAR(255)',
        'position' => "VARCHAR(50) DEFAULT 'slider_main'",
        'status' => 'BIT DEFAULT 1',
        'isDeleted' => 'TINYINT(1) DEFAULT 0',
    ];

    public function __construct()
    {
        parent::__construct();
        try {
            $this->createTable();
        } catch (Throwable $e) {
            // Table/Columns up to date
        }
    }
}
