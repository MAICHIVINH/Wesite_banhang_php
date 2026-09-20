<?php

require_once './models/Review.php';

class ReviewController
{
    private $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new Review();
    }

    public function getAllReviewUser($id)
    {
        return $this->reviewModel->getAllOfProduct($id);
    }

    public function add($data)
    {
        $result = $this->reviewModel->insert($data);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Đánh giá đơn hàng thành công!',
                'review' => $result
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Đánh giá đơn hàng thất bại',
            ];
        }
    }
}
