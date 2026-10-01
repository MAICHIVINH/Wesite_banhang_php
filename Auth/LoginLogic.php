<?php

require_once __DIR__ . '/../core/Csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if (!Csrf::verifyToken($_POST['csrf_token'] ?? null)) {
        echo "<script>
            alert('Yêu cầu không hợp lệ (CSRF Token mismatch)');
            window.location.href = 'Auth/Login.php';
        </script>";
        exit;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $isAdmin = $_POST['isAdmin'] ?? null;
    if ($isAdmin === null) {
        $data = [
            'email' => $email,
            'password' => $password
        ];
        $res = $employeeController->login($data);
        if ($res['success']) {
            session_regenerate_id(true);
            $_SESSION['jwt_employee'] = $res['token'];
            $_SESSION['user_type'] = 'employee';
            $employeeData = $employeeController->getCurrentEmployee();
            $_SESSION['menu'] = $employeeController->getMenuByUserId($employeeData->id);
        } else {
            echo "<script>
                alert('Sai tài khoản hoặc mặt khẩu');
                window.location.href = 'Auth/Login.php';
            </script>";
            exit;
        }
    } else {
        $res = $adminController->Login($email, $password);
        if ($res) {
            session_regenerate_id(true);
            $_SESSION['user_type'] = 'admin';
            $_SESSION['admin'] = $res;
        } else {
            echo "<script>
                alert('Sai tài khoản hoặc mặt khẩu');
                window.location.href = 'Auth/Login.php';
            </script>";
            exit;
        }
    }
}



function hasPermission($url)
{
    if ($_SESSION['user_type'] === 'admin')
        return true;
    else {
        foreach ($_SESSION['menu'] as $menu) {
            if ($menu['menu_url'] === $url) {
                return true;
            }
        }
        return false;
    }
}
