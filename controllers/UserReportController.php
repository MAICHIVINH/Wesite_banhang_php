<?php

require_once './models/UserReports.php';

class UserReportController
{
    private $userReportModel;

    public function __construct()
    {
        $this->userReportModel = new UserReports();
    }

    public function getById($id)
    {
        return $this->userReportModel->find($id);
    }

    public function getByUserId($userId)
    {
        return $this->userReportModel->getLatestByUserId($userId);
    }

    public function add($data)
    {
        try {
            $report = $this->userReportModel->insert($data);
            return [
                'success' => true,
                'message' => 'Báo cáo người dùng thành công!',
                'report' => $report
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $this->userReportModel->DeleteReportUser($id);
            return [
                'success' => true,
                'message' => 'Xóa báo cáo thành công!'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
