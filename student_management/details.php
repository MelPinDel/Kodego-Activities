<?php

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['access']) && $_SESSION['access'] == 'admin') {
    echo 'Welcome '.$_SESSION['userlogin'].'!'.'<br><br>';
} else {
    echo header ('Location: index.php');
}

include_once('connections/connection.php');

$con = connection(); 

$id = $_GET['ID'];

$sql = "SELECT * FROM `student_list` WHERE `ID` = '$id'";

$students = $con->query($sql) or die ($con->error);

$row = $students->fetch_assoc();

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
    <a href='logout.php'>Logout</a>
    <br><br>
    <a href='insert.php'>Insert New</a>
    <br><br>
    <a href='index.php'>Back to Main</a>
    <br><br>
    
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Birthday</th>
                <th>Gender</th>
                <th>Date Enrolled</th>
                <th></th>
            <tr>
        </thead>

        <tbody>
            <?php do{ ?> 
            <tr>
                <td><?php echo $row['firstName']; ?></td>
                <td><?php echo $row['lastName']; ?></td>
                <td><?php echo $row['b_day']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['enrolled_date']; ?></td>
                <td>    
                
                    <a href="update.php?ID=<?php echo $row['ID']?>" class='btn btn-primary me-2'>Edit</a>

                    <a href="delete.php?ID=<?php echo $row['ID']?>" class='btn btn-danger'>Delete</a>
                    
                </td>
            </tr>
            <?php }while($row = $students->fetch_assoc()) ?>
        </tbody>
    </table>

</body>
</html>