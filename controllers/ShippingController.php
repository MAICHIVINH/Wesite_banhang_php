<?php

require_once './models/Shipping.php';

class ShippingController
{
    private $shippingModel;

    public function __construct()
    {
        $this->shippingModel = new Shipping();
    }

    public function getById($id)
    {
        return $this->shippingModel->find($id);
    }

    public function add($data)
    {
        try {
            $shipping = $this->shippingModel->insert($data);
            return [
                'success' => true,
                'message' => 'Thêm địa chỉ thành công',
                'shipping' => $shipping
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ];
        }
    }

    public function update($id, $data)
    {
        try {
            $newShipping = $this->shippingModel->update($id, $data);
            return [
                'success' => true,
                'message' => 'Cập nhật địa chỉ thành công',
                'shipping' => $newShipping
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ];
        }
    }
}
