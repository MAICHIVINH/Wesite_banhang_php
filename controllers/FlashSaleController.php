<?php
require_once './models/FlashSale.php';

class FlashSaleController
{
    private $flashSaleModel;

    public function __construct()
    {
        $this->flashSaleModel = new FlashSale();
    }

    public function getConfig()
    {
        return $this->flashSaleModel->getActiveConfig();
    }

    public function updateConfig($title, $endTime, $status)
    {
        return $this->flashSaleModel->updateConfig($title, $endTime, $status);
    }
}
