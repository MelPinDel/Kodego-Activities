<?php

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['access']) && $_SESSION['access'] == 'admin') {
    echo 'Welcome '.$_SESSION['userlogin'].'!'.'<br><br>';
} else {
    echo header ('Location: index.php');
}

include_once('connections/connections.php');

$con = connection(); 

$id = $_GET['ID'];

$sql = "DELETE FROM `appt_details` WHERE `appt_id` = '$id'";

$delete = mysqli_query($con, $sql);

if ($delete) {

    echo "<script>alert('Appointment details successfully removed!')</script>";
    echo "<script>document.location='index.php';</script>";
    
} else {

    echo "<script>alert('Submission failed. Please try again.')</script>";

};

