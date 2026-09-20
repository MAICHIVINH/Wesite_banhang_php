<?php

require_once './models/Image.php';

class ImageController
{
    private $imageModel;

    public function __construct()
    {
        $this->imageModel = new Image();
    }

    public function getAll()
    {
        return $this->imageModel->all();
    }

    public function getById($id)
    {
        return $this->imageModel->find($id);
    }

    public function getImageById($id)
    {
        return $this->imageModel->getImagesByProductId($id);
    }

    public function add($data)
    {
        $product = $this->imageModel->insert($data);
        return [
            'success' => true,
            'message' => 'Thêm sản phẩm thành công',
            'product' => $product
        ];
    }

    public function delete($id)
    {
        return $this->imageModel->updateDeleted($id);
    }

    public function deleteProductId($id)
    {
        return $this->imageModel->deleteByProductId($id);
    }
}
