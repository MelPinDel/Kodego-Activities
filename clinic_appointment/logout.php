<?php
session_start();
unset($_SESSION['userlogin']);
unset($_SESSION['access']);
echo header ('Location: index.php');
?>