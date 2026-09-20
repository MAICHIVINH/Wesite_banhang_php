<?php

require_once './models/ReportReasons.php';

class ReportController
{
    private $reportModel;

    public function __construct()
    {
        $this->reportModel = new ReportReasons();
    }

    public function getById($id)
    {
        return $this->reportModel->find($id);
    }

    public function getAll()
    {
        return $this->reportModel->all();
    }
}
