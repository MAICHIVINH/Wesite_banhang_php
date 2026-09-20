<?php
session_name('user_session');
session_start();
unset($_SESSION['jwt']);
session_destroy();
header("Location: index.php");
exit;
