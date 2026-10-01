<?php
require_once __DIR__ . '/core/Session.php';
Session::start('user_session');
unset($_SESSION['jwt']);
session_destroy();
header("Location: index.php");
exit;
