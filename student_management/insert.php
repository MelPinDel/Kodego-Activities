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

if (isset($_POST['submit'])) {
    
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $bday = $_POST['b_day'];
    $gender = $_POST['gender'];
    $e_date = $_POST['enrolled_date'];


    $sql = "INSERT INTO `student_list` (`firstName`, `lastName`, `b_day`,`gender`, `enrolled_date`)
            VALUES ('$fname', '$lname', '$bday', '$gender', '$e_date')";

    $insert = mysqli_query($con, $sql);

    if ($insert) {

        echo "<script>alert('New student successfully added!')</script>";
        echo "<script>document.location='index.php';</script>";
    } else {

        echo "<script>alert('Submission failed. Please try again.')</script>";

    }

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
    
    <h1>Add New Student</h1>
    <a href='logout.php'>Logout</a>
    <br><br>
    <a href='insert.php'>Insert New</a>
    <br><br>
    <a href='index.php'>Back to Main</a>
    <br><br>

    <form action='' method='POST'>
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
                <tr>
                    <td>
                        <input type='text' name='firstName' id='firstName'/>
                    </td>
                    <td>
                        <input type='text' name='lastName' id='lastName'/>
                    </td>
                    <td>
                        <input type='text' name='b_day' id='bday'/>
                    </td>
                    <td>
                        <select name='gender' id='gender'>
                            <option value='Male'>Male</option>
                            <option value='Female'>Female</option>
                        </select>
                    </td>
                    <td>
                        <input type='text' name='enrolled_date' id='e_date'/>
                    </td>

                    <td>    
                        <input type='submit' name='submit' value='Submit' class='btn btn-primary'/>
                    </td>

                </tr>

            </tbody>
        </table>

    </form>

</body>


</html>