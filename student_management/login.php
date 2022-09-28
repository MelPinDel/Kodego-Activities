<?php


if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $_COOKIE['userID']) {
    // echo header ("Location: index.php");
    echo $_SESSION['user_id'];
    echo $_SESSION['userlogin'];
    echo $_SESSION['access'];
};

include_once('connections/connection.php');

$con = connection(); 

if (isset($_POST['login'])) {

    $uname = $_POST['username'];
    $pword = $_POST['password'];

    $sql = "SELECT * FROM `student_user` WHERE `username` = '$uname' AND `password` = '$pword'";

    $user = $con->query($sql) or die($con->error);
    $row = $user->fetch_assoc();
    $total = $user->num_rows;

    if ($total > 0) {

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['userlogin'] = $row['username'];
        $_SESSION['access'] = $row['access'];

        $cookie_name = 'userID';
        $cookie_value = $row['user_id'];
        $current_user = $row['username'];
        setcookie($cookie_name, $cookie_value);

        echo "<script>alert('Welcome Back $current_user!')</script>";
        echo "<script>document.location='index.php';</script>";
        echo header ("Set-Cookie: userID=$cookie_value");

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

    <div class='d-block mb-5'>
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