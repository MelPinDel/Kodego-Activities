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

$sql = "SELECT 
        `appt_details`.*,
        `appt_type`.*,
        `doctors_details`.`dr_first_name`,
        `doctors_details`.`dr_last_name`,
        `doctors_details`.`dr_specialty`,
        `patients_details`.`first_name` AS `pt_first_name`, `patients_details`.`last_name` AS `pt_last_name`
        FROM `appt_details`
        LEFT JOIN `appt_type`
            ON `appt_details`.`appt_type_id` = `appt_type`.`appt_type_id`
        LEFT JOIN `doctors_details`
            ON `appt_details`.`dr_id` = `doctors_details`.`dr_id`
        LEFT JOIN `patients_details`
            ON `appt_details`.`patient_id` = `patients_details`.`patient_id`
        WHERE `appt_id` = '$id'
        ORDER BY `appt_details`.`appt_id` DESC;";

$appt = $con->query($sql) or die($con->error);

$row = $appt->fetch_assoc();


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

<body class='m-4'>
    
    <h1>Appointment Details</h1>
    <a href='logout.php'>Logout</a>
    <br><br>
    <a href='insert.php'>Create New Appointment</a>
    <br><br>
    <a href='index.php'>Back to Main</a>
    <br><br>

    <form action='' method='POST'>
    <?php
            if(isset($_SESSION['userlogin']) && $_SESSION['access']=='admin') {
        ?>

        <table>
            <thead>
                <tr>
                    <th>Appt ID</th>
                    <th>Appt Date</th>
                    <th>Appt Time</th>
                    <th>Appt Type</th>
                    <th>Department</th>
                    <th>Doctor</th>
                    <th>Patient ID</th>
                    <th>Patient</th>
                    <th>Concerns</th>
                    <th></th>
                <tr>
            </thead>

            <tbody>
                <?php do{ ?> 
                <tr>
                    <td><?php echo $row['appt_id']; ?></td>
                    <td><?php echo $row['appt_date']; ?></td>
                    <td><?php echo $row['appt_time']; ?></td>
                    <td><?php echo $row['appt_type']; ?></td>
                    <td><?php echo $row['dr_specialty']; ?></td>
                    <td><?php echo $row['dr_first_name']." ".$row['dr_last_name']; ?></td>
                    <td><?php echo $row['patient_id']; ?></td>
                    <td><?php echo $row['pt_first_name']." ".$row['pt_last_name']; ?></td>
                    <td><?php echo $row['patient_concerns']; ?></td>
                    <td>    
                        <a href="update.php?ID=<?php echo $row['appt_id']?>" class='btn btn-primary me-2'>Edit</a>
                        <a href="delete.php?ID=<?php echo $row['appt_id']?>" class='btn btn-danger'>Delete</a>
                    </td>
                </tr>
                <?php }while($row = $appt->fetch_assoc()) ?>
            </tbody>
        </table>

        <?php
            } else {
        ?>
            <h3>Schedule an appointment today!</h3>
        <?php
            };
        ?>

    </form>

</body>


</html>