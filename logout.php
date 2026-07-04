<?php
require_once 'includes/security.php';
session_start();
require_once 'config.php';
require_once 'includes/audit.php';

logAction($conn, 'LOGOUT', 'User logged out');

session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
