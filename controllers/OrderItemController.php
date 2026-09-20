<?php

require_once './models/OrderItem.php';
class OrderItemController
{
    private $orderItemModel;

    public function __construct()
    {
        $this->orderItemModel = new OrderItem();
    }

    public function add($data)
    {
        $orderItem = $this->orderItemModel->insert($data);
        return [
            'success' => true,
            'message' => 'Thêm chi tiết đơn hàng thành công',
            'category' => $orderItem
        ];
    }

    public function countProductThisWeek()
    {
        return $this->orderItemModel->countProductsSoldThisWeek();
    }

    public function getOrderItemById($orderId)
    {
        return $this->orderItemModel->getOrderItemByOrderId($orderId);
    }
}
