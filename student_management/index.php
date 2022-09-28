<?php

if(!isset($_SESSION)) {
    session_start();
}

// if(isset($_SESSION['userlogin'])) {
//     echo 'Welcome '.$_SESSION['userlogin'].'!'.'<br>';
// } else {
//     echo 'Welcome Guest'.'<br>';
// }

if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $_COOKIE['userID']) {
    echo 'Welcome '.$_SESSION['userlogin'].'!'.'<br>';
} else {
    echo header ("Location: login.php");
}

include_once('connections/connection.php');

$con = connection(); 

if (isset($_GET['search'])) {

    $search = $_GET['search'];

} else {
    $search = '%';
};
    
// Show filtered rows
$sql = "SELECT * FROM student_list WHERE firstName LIKE '%$search%' OR lastName LIKE '%$search%' ORDER BY ID ASC";

$students = $con->query($sql) or die($con->error);

$row = $students->fetch_assoc();

if ($row == null) {
    $row['ID'] = null;
    $row['firstName'] = 'No record found.';
    $row['lastName'] = 'No record found.';
};
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Database</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"rel="stylesheet"integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"crossorigin="anonymous">



</head>

<body class='container'>
    
    <h1>Students Information</h1>
    <!-- <a href='login.php'>Login</a>
    <br><br>
    <a href='insert.php'>Insert New</a>
    <br><br> -->

    <form action='index.php' method='GET'>

        <input type='text' name='search' id='search'>
        <button type='submit'>Search</button>
        <br><br>

    </form>

    <!-- Log display depending on login status -->
    <?php
        if(isset($_SESSION['userlogin'])) {
    ?>
        <a href='logout.php'>Logout</a>
        <br>
        <a href='index.php'>View All</a>
        <br>
    <?php
        } else {
    ?>
        <a href='login.php'>Login</a>
    <?php
        }
    ?>
    <br>

    <?php
        if(isset($_SESSION['access']) && $_SESSION['access']=='admin') {

            echo "<a href='insert.php'>Insert New</a>";
        };
    ?>

    <!-- <a href='insert.php'>Insert New</a> -->
    <br><br>

    <table>
        <thead>
            <tr>
                <th></th>
                <th>First Name</th>
                <th>Last Name</th>
            <tr>
        </thead>

        <tbody>
            <?php do{ ?> 
            <tr>
                <td>
                    <a  href="details.php?ID=<?php echo $row['ID']?>"
                        class='<?php if ($row['ID']==null) {
                            echo 'd-none';
                        };?>'>
                        View
                    </a>
                </td>
                <td><?php echo $row['firstName']; ?></td>
                <td><?php echo $row['lastName']; ?></td>
            </tr>
            <?php }while($row = $students->fetch_assoc()) ?>
        </tbody>
    </table>

    <?php
    if (isset($_GET['search'])) {
        echo '<h4>Search Results for '."\"".$search."\"".'</h4>'; 
    };?>


</body>
</html>