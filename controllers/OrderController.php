<?php

require_once './models/Order.php';
require_once './models/Shipping.php';
require_once './models/OrderItem.php';

require_once './models/Employee.php';

require_once './models/User.php';

require_once './models/Branch.php';

require_once './models/Status.php';



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class OrderController
{
    private $orderModel;
    private $shippingModel;
    private $orderItemModel;
    private $employeeModel;
    private $userModel;
    private $branchModel;
    private $statusModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->shippingModel = new Shipping();
        $this->orderItemModel = new OrderItem();
        $this->employeeModel = new Employee();
        $this->userModel = new User();
        $this->branchModel = new Branch();
        $this->statusModel = new Status();
    }

    public function add($data)
    {
        $order = $this->orderModel->insert($data);
        return [
            'success' => true,
            'message' => 'Thêm đơn hàng thành công',
            'order_id' => $order
        ];
    }

    public function getById($id)
    {
        return $this->orderModel->find($id);
    }

    public function getByCode($code)
    {
        return $this->orderModel->findByCode($code);
    }

    public function countIsDeleted()
    {
        return $this->orderModel->countDeleted();
    }

    public function getOrderPagination(int $userId, ?int $statusId, int $limit, int $offset, $keyword)
    {
        return $this->orderModel->findOrders($userId, $statusId, $keyword, $limit, $offset);
    }

    public function getOrderWithStatusPagination(?int $statusId, int $limit, int $offset, string $keyword, $branch_id = null, ?int $employeeId = null, bool $isAdmin = false, $isDeleted = 0)
    {
        return $this->orderModel->findOrderWithStatus($statusId, $keyword, $limit, $offset, $branch_id, $employeeId, $isAdmin, $isDeleted);
    }

    public function getCountOrder(int $userId, ?int $statusId, $keyword): int
    {
        return $this->orderModel->countOrders($userId, $statusId, $keyword);
    }

    public function getCountOrderWithStatus(?int $statusId, string $keyword, $branch_id = null, ?int $employeeId = null, bool $isAdmin = false, $isDeleted = 0): int
    {
        return $this->orderModel->countOrderWithStatus($statusId, $keyword, $branch_id,  $employeeId, $isAdmin, $isDeleted);
    }

    public function getAllOrdersPagination(string $keyword, int $limit, int $offset)
    {
        return $this->orderModel->findAllOrders($keyword, $limit, $offset);
    }


    public function getAllCountOrder(string $keyword)
    {
        return $this->orderModel->countAllOrders($keyword);
    }

    public function getUserAddressByShippingId($shippingId)
    {
        return $this->orderModel->getUserAddressByShippingId($shippingId);
    }

    public function edit($id, $data)
    {
        try {
            $orderEdit = $this->orderModel->update($id, $data);
            return [
                "success" => true,
                "message" => 'Cập nhật đơn hàng thành công',
                'order' => $orderEdit
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => 'Lỗi" ' . $e->getMessage(),
            ];
        }
    }

    public function delete($id)
    {
        $existing = $this->orderModel->find($id);
        if ($existing === null) {
            return [
                'success' => false,
                'message' => 'Đơn hàng không tồn tại!'
            ];
        }

        $this->shippingModel->updateDeleted($existing['shipping_id']);

        $orderDelete = $this->orderModel->updateDeleted($id);
        return [
            "success" => true,
            "message" => 'Xóa đơn hàng thành công',
        ];
    }

    public function countOrderThisWeek()
    {
        return $this->orderModel->countOrdersThisWeek();
    }

    public function exportOrderThisWeekExcel()
    {
        $orders = $this->orderModel->all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Mã đơn hàng');
        $sheet->setCellValue('C1', 'Tổng tiền đơn hàng');
        $sheet->setCellValue('D1', 'Trạng thái đơn hàng');
        $sheet->setCellValue('E1', 'Trạng thái giao hàng');
        $sheet->setCellValue('F1', 'Khách hàng');
        $sheet->setCellValue('G1', 'Chi nhánh');
        $sheet->setCellValue('H1', 'Nhân viên');
        $sheet->setCellValue('I1', 'Ghi chú');
        $sheet->setCellValue('J1', 'Ngày đặt');

        $row = 2;

        foreach ($orders as $order) {

            $status = $this->statusModel->find($order['status_id']);
            $shipping = $this->shippingModel->find($order['shipping_id']);
            $user = $this->userModel->find($order['user_id']);
            $branch = $this->branchModel->find($order['branch_id']);
            $employee = $this->employeeModel->find($order['employee_id']) ?? 'Chưa có người nhận';
            $sheet->setCellValue('A' . $row, $order['id']);
            $sheet->setCellValue('B' . $row, $order['code']);
            $sheet->setCellValue('C' . $row, $order['total_amount']);
            $sheet->setCellValue('D' . $row, $status['name']);
            $sheet->setCellValue('E' . $row, $shipping['status']);
            $sheet->setCellValue('F' . $row, $user['FullName']);
            $sheet->setCellValue('G' . $row, $branch['name']);
            $sheet->setCellValue('H' . $row, $employee['name']);
            $sheet->setCellValue('I' . $row, $order['note']);
            $sheet->setCellValue('J' . $row, $order['create_at']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'products_' . date('Y-m-d') . '.xlsx';

        if (ob_get_length()) ob_end_clean();

        $filepath = 'exports/' . $filename;
        $writer->save($filepath);
        echo "<script>
        window.location.href='$filepath'; 
setTimeout(function() {
        window.location.href = 'Admin.php?page=modules/Admin/Dashboard/Dashboard.php';
    }, 1000);</script>";
    }


    public function countOrdersByStatusThisWeek($statusId)
    {
        return $this->orderModel->countOrdersByStatusThisWeek($statusId);
    }

    public function hasUserOrder($id)
    {
        try {
            if ($this->orderModel->hasUserOrder($id)) {
                return [
                    "success" => false,
                    "message" => 'Người dùng này đang có đơn hàng xử lý bạn không được xóa!',
                ];
            }
            return [
                "success" => true,
                "message" => 'Người dùng này không có đơn hàng đặt',
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => 'Lỗi" ' . $e->getMessage(),
            ];
        }
    }

    public function deleteIsDeleted($id)
    {
        try {
            $existing = $this->orderModel->findIsDeled($id);
            if ($existing === null) {
                return [
                    'success' => false,
                    'message' => 'Đơn hàng không tồn tại!'
                ];
            }



            $resultOrderItem = $this->orderItemModel->deleteByColumn('order_id', $id);
            if (!$resultOrderItem) {
                return [
                    'success' => false,
                    'message' => 'Lỗi xóa chi tiết đơn hàng'
                ];
            }

            $result = $this->orderModel->delete($id);

            $resultShipping = $this->shippingModel->delete($existing['shipping_id']);

            if (!$resultShipping) {
                return [
                    'success' => false,
                    'message' => 'Lỗi xóa giao hàng'
                ];
            }
            if ($result) {
                return ['success' => true, 'message' => 'Đã xóa Vĩnh viễn đơn hàng này!'];
            } else {
                return ['success' => false, 'message' => 'Lỗi xóa đơn hàng'];
            }
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => 'Lỗi" ' . $e->getMessage(),
            ];
        }
    }

    public function restore($id)
    {
        try {
            $existing = $this->orderModel->findIsDeled($id);

            if ($existing === null) {
                return [
                    'success' => false,
                    'message' => 'Đơn hàng không tồn tại!'
                ];
            }



            $this->shippingModel->updateIsDeleted($existing['shipping_id'], ['isDeleted' => 0]);
            $result = $this->orderModel->updateIsDeleted($id, ['isDeleted' => 0]);
            if ($result) {
                return ['success' => true, 'message' => 'Đã khôi phục đơn hàng này!'];
            } else {
                return ['success' => false, 'message' => 'Lỗi khôi phục hàng'];
            }
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => 'Lỗi" ' . $e->getMessage(),
            ];
        }
    }
}
