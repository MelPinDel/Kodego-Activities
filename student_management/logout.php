<?php
session_start();
unset($_SESSION['userlogin']);
unset($_SESSION['access']);
unset($_SESSION['user_id']);
echo header ('Location: index.php');
?>