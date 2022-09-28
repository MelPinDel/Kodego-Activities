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

if (isset($_POST['submit'])) {
    
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $bday = $_POST['b_day'];
    $gender = $_POST['gender'];
    $enrolledDate = $_POST['enrolled_date'];

    $sql_update = "UPDATE `student_list`
                    SET `firstName` = '$fname',
                        `lastName` = '$lname',
                        `b_day` = '$bday',
                        `gender` = '$gender',
                        `enrolled_date` = '$enrolledDate'

                    WHERE `student_list`.`ID` = '$id';";

    $update = mysqli_query($con, $sql_update);

    if ($update) {

        echo "<script>alert('Student details successfully updated!')</script>";
        // echo `<script>document.location='details.php?ID=$id</script>`;
        echo header ('Location: details.php?ID='.$id);

    } else {

        echo "<script>alert('Submission failed. Please try again.')</script>";

    }

    };

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
    
    <h1>Edit Student Records</h1>
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
                        <input type='text' name='firstName' id='firstName' value='<?php echo $row['firstName']; ?>'/>
                    </td>
                    <td>
                        <input type='text' name='lastName' id='lastName' value='<?php echo $row['lastName']; ?>'>
                    </td>
                    <td>
                        <input type='text' name='b_day' id='b_day' value='<?php echo $row['b_day']; ?>'>
                    </td>
                    <td>
                        <select name='gender' id='gender' value='<?php echo $row['gender']; ?>'>
                            <option value='Male' <?php echo ($row['gender']=='Male') ?'selected':''?> >Male</option>
                            <option value='Female' <?php echo ($row['gender']=='Female') ?'selected':''?> >Female</option>
                        </select>
                    </td>
                    <td>
                        <input type='text' name='enrolled_date' id='enrolled_date' value='<?php echo $row['enrolled_date']; ?>'>
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