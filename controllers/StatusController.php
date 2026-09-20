<?php

require_once './models/Status.php';

class StatusController
{
    private $statusModel;

    public function __construct()
    {
        $this->statusModel = new Status();
    }

    public function getAll()
    {
        return $this->statusModel->all();
    }

    public function getById($id)
    {
        return $this->statusModel->find($id);
    }
}
