<?php

require_once './models/User.php';
require_once './models/Order.php';
require_once './models/OrderItem.php';
require_once './models/ChatMessage.php';
require_once './models/UserReports.php';
require_once './models/Review.php';
require_once './models/PasswordResetToken.php';
require_once './controllers/BaseController.php';


use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Respect\Validation\Validator as v;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require 'vendor/autoload.php';

class UserController extends BaseController
{
    private $userModel;
    private $userReportModel;
    private $jwtConfig;

    private $resetTokenModel;

    private $orderModel;
    private $orderItemModel;
    private $chatModel;
    private $reportModel;
    private $reviewModel;


    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->userReportModel = new UserReports();
        $this->resetTokenModel = new PasswordResetToken();
        $this->orderModel = new Order();
        $this->orderItemModel = new OrderItem();
        $this->chatModel = new ChatMessage();
        $this->reportModel = new UserReports();
        $this->reviewModel = new Review();
        $this->jwtConfig = include './config/jwt.php';
    }

    public function getById($id)
    {
        return $this->userModel->find($id);
    }

    public function register($data)
    {

        $rules = [
            'FullName' => v::stringType()->length(3, 50)
                ->setTemplate("Họ tên phải từ 3 đến 50 ký tự"),

            'Email' => v::email()->notEmpty()
                ->setTemplate("Email không hợp lệ hoặc để trống"),

            'Phone' => v::phone()->notEmpty()
                ->setTemplate("Số điện thoại không hợp lệ"),

            'Address' => v::stringType()->length(5, 255)
                ->setTemplate("Địa chỉ phải từ 5 đến 255 ký tự"),

            'password' => v::stringType()->length(6, 32)
                ->setTemplate("Mật khẩu phải từ 6 đến 32 ký tự"),
        ];
        if (!$this->validator->validate($data, $rules)) {
            return [
                'success' => false,
                'message' => $this->validator->error()
            ];
        }


        // if ($this->userModel->existsByName($data['Email'])) {
        //     return ['success' => false, 'message' => 'Email đã tồn tại'];
        // }

        $data['PasswordHash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['CreatedAt'] = date('Y-m-d H:i:s');
        unset($data['password']);
        $id = $this->userModel->insert($data);
        return ['success' => true, 'id' => $id];
    }

    public function login($email, $password)
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['PasswordHash'])) {
            return ['success' => false, 'message' => 'Email hoặc mật khẩu không đúng'];
        }

        $checkReportUser = $this->userReportModel->getLatestByUserId($user['id']);
        if ($checkReportUser) {
            if ($checkReportUser['banned_until'] > date('Y-m-d H:i:s')) {
                return [
                    'success' => false,
                    'message' => 'Tài khoản của bạn đã bị khóa',
                    'report' => $checkReportUser
                ];
            }
        }

        $now = time();
        $token = [
            'iss' => $this->jwtConfig['issuer'],
            'aud' => $this->jwtConfig['audience'],
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + 3600,
            'data' => [
                'id' => $user['id'],
                'email' => $user['Email'],
                'name' => $user['FullName'],
                'phone' => $user['Phone'],
                'address' => $user['Address']
            ]
        ];
        $jwt = JWT::encode($token, $this->jwtConfig['secret_key'], 'HS256');
        return ['success' => true, 'token' => $jwt];
    }

    public function getCurrentUser()
    {
        if (!isset($_SESSION['jwt'])) {
            return null;
        }
        try {
            $decoded = JWT::decode($_SESSION['jwt'], new Key($this->jwtConfig['secret_key'], 'HS256'));
            return $decoded->data;
        } catch (\Firebase\JWT\ExpiredException $e) {
            // Token hết hạn → xóa session, yêu cầu đăng nhập lại
            unset($_SESSION['jwt']);
            return null;
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            unset($_SESSION['jwt']);
            return null;
        } catch (\UnexpectedValueException $e) {
            unset($_SESSION['jwt']);
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
    public function validateToken($authHeader)
    {
        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return null;
        }
        $jwt = $matches[1];
        try {
            $decoded = JWT::decode($jwt, new Key($this->jwtConfig['secret_key'], 'HS256'));
            return $decoded->data;
        } catch (Exception $e) {
            return null;
        }
    }

    public function updateProfile($id, $data, $isUser)
    {
        $rules = [
            'FullName' => v::optional(v::stringType()->length(3, 50))
                ->setTemplate("Họ tên phải từ 3 đến 50 ký tự"),

            'Email' => v::optional(v::email())
                ->setTemplate("Email không hợp lệ"),

            'Phone' => v::optional(v::phone())
                ->setTemplate("Số điện thoại không hợp lệ"),

            'Address' => v::optional(v::stringType()->length(5, 255))
                ->setTemplate("Địa chỉ phải từ 5 đến 255 ký tự"),
        ];

        if (!$this->validator->validate($data, $rules)) {
            return [
                'success' => false,
                'message' => $this->validator->error()
            ];
        }

        if (!empty($data['password'])) {
            if (!v::stringType()->length(6, 32)->validate($data['password'])) {
                return ['success' => false, 'message' => 'Mật khẩu phải từ 6 đến 32 ký tự'];
            }
            $data['PasswordHash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        }

        $data['UpdateAt'] = date('Y-m-d H:i:s');

        $result = $this->userModel->update($id, $data);
        if ($isUser) {
            if ($result) {
                $userById = $this->userModel->find($id);
                $now = time();
                $token = [
                    'iss' => $this->jwtConfig['issuer'],
                    'aud' => $this->jwtConfig['audience'],
                    'iat' => $now,
                    'nbf' => $now,
                    'exp' => $now + 3600,
                    'data' => [
                        'id' => $userById['id'],
                        'email' => $userById['Email'],
                        'name' => $userById['FullName'],
                        'phone' => $userById['Phone'],
                        'address' => $userById['Address']
                    ]
                ];
                $jwt = JWT::encode($token, $this->jwtConfig['secret_key'], 'HS256');
                return ['success' => true, 'token' => $jwt];
            } else {
                return ['success' => false, 'message' => "Lỗi cập nhật"];
            }
        }

        if ($result) {
            return ['success' => true, 'message' => "Cập nhật thông tin người dùng thành công!"];
        } else {
            return ['success' => false, 'message' => "Lỗi cập nhật"];
        }
    }


    public function getPagination($limit, $offset, $keyword, $isDeleted = 0)
    {
        return $this->userModel->getFilteredUsers($limit, $offset, $keyword, $isDeleted);
    }

    public function countUser($keyword, $isDeleted = 0)
    {
        return $this->userModel->countUser($keyword, $isDeleted);
    }

    public function updatePasswordByAdmin($userId, $password)
    {
        try {
            if (!v::stringType()->length(6, 32)->validate($password)) {
                return ['success' => false, 'message' => 'Mật khẩu phải từ 6 đến 32 ký tự'];
            }
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $data = [
                'PasswordHash' => $passwordHash,
                'UpdateAt' => date('Y-m-d H:i:s')
            ];

            $result = $this->userModel->update($userId, $data);

            if ($result) {
                return ['success' => true, 'message' => 'Cập nhật mật khẩu thành công'];
            } else {
                return ['success' => false, 'message' => 'Cập nhật thất bại'];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => "Lỗi: " . $e->getMessage()
            ];
        }
    }


    public function sendResetToken($email)
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            return ['success' => false, 'message' => 'Email không tồn tại'];
        }

        $token = rand(100000, 999999); // Mã OTP 6 số
        $expiresAt = date('Y-m-d H:i:s', time() + 300); // Hết hạn sau 5 phút

        $this->resetTokenModel->insert([
            'user_id' => $user['id'],
            'token' => $token,
            'expires_at' => $expiresAt
        ]);


        $this->sendVerificationCode($user['Email'], $token);

        return ['success' => true, 'message' => 'Đã gửi mã xác nhận qua email'];
    }

    function sendVerificationCode($toEmail, $code)
    {
        $mail = new PHPMailer(true);

        try {
            // Charset & Encoding for UTF-8 support (fixes broken Vietnamese characters)
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'vinh23861@gmail.com';
            $mail->Password = 'qrkssypizvrenvgn';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('vinh23861@gmail.com', 'MCV Shop');
            $mail->addAddress($toEmail);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Mã xác nhận đặt lại mật khẩu - MCV Shop';

            $currentYear = date('Y');
            $mail->Body = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            </head>
            <body style='font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px;'>
                <div style='max-width: 520px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #e2e8f0;'>
                    <div style='background: linear-gradient(135deg, #d70018 0%, #ff4757 100%); padding: 24px 20px; text-align: center; color: #ffffff;'>
                        <h2 style='margin: 0; font-size: 22px; font-weight: bold; letter-spacing: 0.5px;'>MCV SHOP</h2>
                        <p style='margin: 6px 0 0; font-size: 13px; opacity: 0.9;'>Xác nhận yêu cầu đặt lại mật khẩu</p>
                    </div>
                    <div style='padding: 28px 24px; text-align: center; color: #334155;'>
                        <p style='font-size: 15px; margin-bottom: 8px; font-weight: 600;'>Xin chào,</p>
                        <p style='font-size: 14px; color: #64748b; margin-top: 0; line-height: 1.5;'>Bạn vừa yêu cầu lấy lại mật khẩu cho tài khoản tại MCV Shop. Vui lòng sử dụng mã OTP bên dưới để hoàn tất:</p>
                        
                        <div style='background: #f8fafc; border: 2px dashed #d70018; border-radius: 10px; padding: 16px 20px; display: inline-block; margin: 20px 0;'>
                            <span style='font-size: 34px; font-weight: 800; letter-spacing: 6px; color: #d70018; font-family: monospace;'>{$code}</span>
                        </div>

                        <p style='font-size: 13px; color: #64748b; margin-top: 10px; line-height: 1.5;'>
                            ⏱️ Mã này có hiệu lực trong <strong>5 phút</strong>.<br>
                            🔒 Vì lý do bảo mật, tuyệt đối <strong>không chia sẻ mã này</strong> cho bất kỳ ai.
                        </p>
                    </div>
                    <div style='background: #f8fafc; padding: 14px 20px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #f1f5f9;'>
                        <p style='margin: 0;'>© {$currentYear} MCV Shop Electronics. Trân trọng cảm ơn!</p>
                    </div>
                </div>
            </body>
            </html>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Lỗi gửi email: {$mail->ErrorInfo}");
            return false;
        }
    }

    public function verifyResetToken($email, $token)
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            return ['success' => false, 'message' => 'Email không tồn tại'];
        }

        $result = $this->resetTokenModel->verifyResetToken($user['id'], $token);

        if (!$result['success']) {
            return $result;
        }

        return $result;
    }

    public function resetPassword($userId, $newPassword)
    {
        if (!v::stringType()->length(6, 32)->validate($newPassword)) {
            return ['success' => false, 'message' => 'Mật khẩu phải từ 6 đến 32 ký tự'];
        }

        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->userModel->update($userId, [
            'PasswordHash' => $hash,
            'UpdateAt' => date('Y-m-d H:i:s')
        ]);

        return ['success' => true, 'message' => 'Đặt lại mật khẩu thành công'];
    }

    public function countUserAll()
    {
        return $this->userModel->countUserAll();
    }

    public function exportUserExcel()
    {
        $users = $this->userModel->all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Tên Người dùng');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Số điện thoại');
        $sheet->setCellValue('E1', 'Địa chỉ');
        $sheet->setCellValue('F1', 'Ngày tham gia');


        $row = 2;

        foreach ($users as $user) {

            $sheet->setCellValue('A' . $row, $user['id']);
            $sheet->setCellValue('B' . $row, $user['FullName']);
            $sheet->setCellValue('C' . $row, $user['Email']);
            $sheet->setCellValue('D' . $row, $user['Phone']);
            $sheet->setCellValue('E' . $row, $user['Address']);
            $sheet->setCellValue('F' . $row, $user['CreatedAt']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'products_' . date('Y-m-d') . '.xlsx';

        if (ob_get_length())
            ob_end_clean();

        $filepath = 'exports/' . $filename;
        $writer->save($filepath);
        echo "<script>
        window.location.href='$filepath'; 
setTimeout(function() {
        window.location.href = 'Admin.php?page=modules/Admin/Dashboard/Dashboard.php';
    }, 1000);</script>";
    }



    public function countIsDeleted()
    {
        return $this->userModel->countDeleted();
    }

    public function countUsersByMonthInYear($year = null)
    {
        return $this->userModel->countUsersByMonthInYear($year);
    }

    public function delete($id)
    {
        try {
            $existingUser = $this->userModel->findIsDeled($id);

            if ($existingUser == null) {
                return [
                    'success' => false,
                    'message' => 'Người dùng không tồn tại!'
                ];
            }

            if ($this->reportModel->hasReportOfUser($id)) {
                $this->reportModel->deleteByColumn('reported_user_id', $id);
            }

            if ($this->chatModel->hasUserMessage($id)) {
                $this->chatModel->deleteByColumn('user_id', $id);
            }

            $orderId = $this->orderModel->getOrderIdsByUser($id);
            if (is_array($orderId) && count($orderId) > 0) {
                foreach ($orderId as $item) {
                    $this->orderItemModel->deleteByColumn('order_id', $item);
                    $this->orderModel->delete($item);
                }
            }

            $review = $this->reviewModel->getByColumn('user_id', $id);
            if (is_array($review) && count($review) > 0) {
                $this->reviewModel->deleteByColumn('user_id', $id);
            }

            $result = $this->userModel->delete($id);

            if ($result) {
                return ['success' => true, 'message' => 'Đã xóa Vĩnh viễn người dùng này!'];
            } else {
                return ['success' => false, 'message' => 'Lỗi xóa người dùng'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi ' . $e->getMessage()];
        }
    }

    public function restore($id)
    {
        try {
            $existingUser = $this->userModel->findIsDeled($id);

            if ($existingUser == null) {
                return [
                    'success' => false,
                    'message' => 'Người dùng không tồn tại!'
                ];
            }

            if ($this->reportModel->hasReportOfUser($id)) {
                $this->reportModel->deleteByColumn('reported_user_id', $id);
            }

            if ($this->chatModel->hasUserMessage($id)) {
                $this->chatModel->deleteByColumn('user_id', $id);
            }

            $orderId = $this->orderModel->getOrderIdsByUser($id);

            if (is_array($orderId) && count($orderId) > 0) {
                foreach ($orderId as $item) {
                    $this->orderItemModel->deleteByColumn('order_id', $item);
                    $this->orderModel->delete($item);
                }
            }

            $result = $this->userModel->updateIsDeleted($id, ['isDeleted' => 0]);

            if ($result) {
                return ['success' => true, 'message' => 'Đã khôi phục người dùng này!'];
            } else {
                return ['success' => false, 'message' => 'Lỗi khôi phục người dùng'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi ' . $e->getMessage()];
        }
    }
}
