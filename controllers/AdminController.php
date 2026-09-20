<?php

require_once './models/Admin.php';

class AdminController
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new Admin();
    }

    public function Login($email, $password)
    {
        return $this->adminModel->ExistsLogin($email, $password);
    }

    public function getById($id)
    {
        return $this->adminModel->find($id);
    }

    public function ChangePassword($email, $passwordOld, $passwordNew)
    {
        $existing = $this->adminModel->ExitEmail($email);
        if ($existing) {
            if ($passwordOld === $existing['password_hash']) {
                $result = $this->adminModel->update($existing['id'], ["password_hash" => $passwordNew]);
                if ($result) {
                    return [
                        'success' => true,
                        'message' => "Cập nhật mật khẩu thành công"
                    ];
                }
                return [
                    'success' => false,
                    'message' => "Cập nhật mật khẩu không thành công"
                ];
            } else {
                return [
                    'success' => false,
                    'message' => "Mặt khẩu không trùng khớp"
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => "Tài khoản không hợp lệ"
            ];
        }
    }

    public function update($id, $data)
    {
        $result = $this->adminModel->update($id, $data);
        if ($result) {
            return [
                'success' => true,
                'message' => "Cập nhật thành công!"
            ];
        } else {
            return [
                'success' => false,
                'message' => "Cập nhật không thành công"
            ];
        }
    }
}
