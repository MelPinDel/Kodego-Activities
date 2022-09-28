<?php

if(!isset($_SESSION)) {
    session_start();
}

include_once('connections/connections.php');

$con = connection(); 

if (isset($_POST['login'])) {

    $uname = $_POST['username'];
    $pword = $_POST['password'];

    $sql = "SELECT * FROM `user_access` WHERE `username` = '$uname' AND `password` = '$pword'";

    $user = $con->query($sql) or die($con->error);
    $row = $user->fetch_assoc();
    $total = $user->num_rows;

    if ($total > 0) {

        $_SESSION['userlogin'] = $row['username'];
        $_SESSION['access'] = $row['access'];


        echo "<script>alert('Welcome!')</script>";
        echo "<script>document.location='index.php';</script>";

    } else {

        echo "<script>alert('Invalid Username or Password')</script>";

    }

    };

?>



<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


</head>

<body>

    <div class='d-block my-5'>
        <h1>Login</h1>
    </div>
    <div class='d-flex align-items-center justify-content-center'>
    <form action='' method='POST'>

        <label>Username</label>
        <input type='text' name='username' id='username'/>
        
        <label>Password</label>
        <input type='password' name='password' id='password'/>

        <button type='submit' name='login'>Login</button>

    </form>
    </div>


</body>
</html>