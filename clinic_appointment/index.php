<?php

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['userlogin'])) {
    echo 'Welcome '.$_SESSION['userlogin'].'!';
} else {
    echo 'Welcome Guest';
}

include_once('connections/connections.php');

$con = connection(); 

// START SEARCH
if (isset($_GET['search'])) {

    $search = $_GET['search'];

} else {
    $search = '%';
};
    
// Show filtered rows
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
        WHERE
        `doctors_details`.`dr_first_name` LIKE '%$search%' OR
        `doctors_details`.`dr_last_name` LIKE '%$search%' OR
        `patients_details`.`first_name` LIKE '%$search%' OR
        `patients_details`.`last_name` LIKE '%$search%'
        ORDER BY `appt_details`.`appt_id` DESC;";

$appt = $con->query($sql) or die($con->error);

$row = $appt->fetch_assoc();

if ($row == null) {
    $row['appt_id'] = null;
    $row['appt_date'] = 'No records found.';
    $row['appt_time'] = '';
    $row['appt_type'] = '';
    $row['dr_specialty'] = '';
    $row['dr_first_name'] = '';
    $row['dr_last_name'] = '';
    $row['patient_id'] = '';
    $row['pt_first_name'] = '';
    $row['pt_last_name'] = '';
    $row['patient_concerns'] = '';
};
// END SEARCH


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Schedule</title>
    <link rel='stylesheet' href='css/style.css'/>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"rel="stylesheet"integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"crossorigin="anonymous">

</head>

<body class='m-3'>
    
    <h1>Appointments Information</h1>
    <br/>
    <br/>

    <form action='' method='GET'>

        <input type='text' name='search' id='search'>
        <button type='submit'>Search</button>
    </form>

    <br><br>

        <!-- Display depending on session status -->

        <?php
            if(isset($_SESSION['userlogin'])) {
        ?>
            <a href='logout.php'>Logout</a>
            <br>
            <a href='insert.php'>Create New Appointment</a>
            <br><br>
                   
        <?php
                } else {
        ?>
            <a href='login.php'>Login</a>
        <?php
            };
        ?>

        <?php
            if(isset($_SESSION['userlogin']) && $_SESSION['access']=='admin') {
        ?>
        <a href='index.php'>View All</a>
        <br><br>

        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Appt Date</th>
                    <th>Appt Time</th>
                    <th>Appt Type</th>
                    <th>Department</th>
                    <th>Doctor</th>
                    <th>Patient ID</th>
                    <th>Patient</th>
                    <th>Concerns</th>
                <tr>
            </thead>

            <tbody>
                <?php do{ ?> 
                <tr>
                    <td>
                        <a  href="details.php?ID=<?php echo $row['appt_id']?>"
                            class='<?php if ($row['appt_id']==null) {
                                echo 'd-none';
                            };?>'>
                            View
                        </a>
                    </td>
                    <td><?php echo $row['appt_date']; ?></td>
                    <td><?php echo $row['appt_time']; ?></td>
                    <td><?php echo $row['appt_type']; ?></td>
                    <td><?php echo $row['dr_specialty']; ?></td>
                    <td><?php echo $row['dr_first_name']." ".$row['dr_last_name']; ?></td>
                    <td><?php echo $row['patient_id']; ?></td>
                    <td>
                        
                        <?php echo $row['pt_first_name']." ".$row['pt_last_name']; ?>
                    
                    </td>
                    <td><?php echo $row['patient_concerns']; ?></td>
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


</body>
</html>
