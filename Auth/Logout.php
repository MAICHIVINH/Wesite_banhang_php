<?php
require_once __DIR__ . '/../core/Session.php';
Session::start('admin_session');
session_unset();
session_destroy();
header("Location: Login.php");
exit;
