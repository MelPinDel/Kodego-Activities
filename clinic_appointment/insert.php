<?php

include_once('connections/connections.php');

$con = connection();



// Add patient details
if (isset($_POST['add_pt'])) {
    
    $pt_fname = $_POST['pt_first_name'];
    $pt_lname = $_POST['pt_last_name'];
    $bday = $_POST['b_day'];
    $phone = $_POST['phone'];


    $sql_pt = "INSERT INTO `patient_details` (`first_name`, `last_name`, `b_day`, `phone`)
            VALUES ('$fname', '$lname', '$bday', '$phone')";

    $insert_pt = mysqli_query($con, $sql_pt);

    if ($insert_pt) {

        echo "<script>alert('New patient successfully added!')</script>";
        echo "<script>document.location='index.php';</script>";

    } else {

        echo "<script>alert('Submission failed. Please try again.')</script>";

    }

    };



// Add Doctors' details
if (isset($_POST['add_dr'])) {
    
    $dr_fname = $_POST['dr_first_name'];
    $dr_lname = $_POST['dr_last_name'];
    $dept = $_POST['dept'];
    $contact = $_POST['contact'];


    $sql_dr = "INSERT INTO `doctors_details` (`dr_first_name`, `dr_last_name`, `dr_specialty`, `contact`)
            VALUES ('$dr_fname', '$dr_lname', '$dept', '$contact')";

    $insert_dr = mysqli_query($con, $sql_dr);

    if ($insert_dr) {

        echo "<script>alert('New Doctor successfully added!')</script>";
        echo "<script>document.location='index.php';</script>";
    } else {

        echo "<script>alert('Submission failed. Please try again.')</script>";

    }

    };



// Add appointment details
if (isset($_POST['add_appt'])) {
    
    $appt_date = $_POST['appt_date'];
    $appt_time = $_POST['appt_time'];
    $appt_type_id = $_POST['appt_type_id'];
    $pt_id = $_POST['patient_id'];
    $dr_id = $_POST['dr_id'];
    $concerns = $_POST['patient_concerns'];


    $sql_appt = "INSERT INTO `appt_details` (`appt_date`, `appt_time`, `appt_type_id`, `patient_id`, `dr_id`, `patient_concerns`)
            VALUES ('$appt_date', '$appt_time', '$appt_type_id', '$pt_id', '$dr_id', '$concerns')";

    $insert_appt = mysqli_query($con, $sql_appt);

    if ($insert_appt) {

        echo "<script>alert('New Appointment successfully scheduled!')</script>";
        echo "<script>document.location='index.php';</script>";
    } else {

        echo "<script>alert('Submission failed. Please try again.')</script>";

    }

    };

// Get all appt type data
$sql_appt_type = 'SELECT * FROM `appt_type` ORDER BY `appt_type` ASC;';

$appt_type = $con->query($sql_appt_type) or die($con->error);

$row_appt_type = $appt_type->fetch_assoc();



// Get all patient data

// $pt_id = 

// $sql_pt = 'SELECT `first_name`, `last_name` FROM `patients_details` WHERE `patient_id` = ';

// $appt_type = $con->query($sql_appt_type) or die($con->error);

// $row_appt_type = $appt_type->fetch_assoc();

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

<body class='container-fluid p-3'>
    
<div>
    <h1>Schedule an Appointment</h1>
    <br>
    <a href='logout.php'>Logout</a>
    <br>
    <a href='insert.php'>Create New Appointment</a>
    <br>
    <a href='index.php'>Back to Main</a>
    <br><br>
</div>

<div>

    <form action='' method='POST'>
        <table>
            <thead>
                <tr>
                    <th>Appt Date</th>
                    <th>Appt Time</th>
                    <th>Appt Type</th>
                    <th>Patient ID</th>
                    <th>Doctor ID</th>
                    <th>Concerns</th>
                <tr>
            </thead>

            <tbody>
                <tr>
                    <td>
                        <!-- <label>Appt Date</label> -->
                        <input type='text' name='appt_date' id='appt_date' size='10px'/>
                    </td>

                    <td>
                        <!-- <label>Appt Time</label> -->
                        <input type='text' name='appt_time' id='appt_time' size='10px'/>
                    </td>

                    <td>
                        <!-- <label>Appt Type</label> -->
                        <select name='appt_type_id' id='appt_type_id'>

                            <?php do{ ?>
                                <option value= <?php echo $row_appt_type['appt_type_id']; ?> >
                                    <?php echo $row_appt_type['appt_type']; ?>
                                </option>
                            <?php } while ($row_appt_type = $appt_type->fetch_assoc()) ?>
                            
                        </select>
                    </td>

                    <td>
                        <!-- <label>Patient ID</label> -->
                        <input type='text' name='patient_id' id='patient_id'size='5px'/>
                    </td>

                    <!-- <td>
                        <label>Patient Name</label>
                        <h6></h6>
                    </td> -->

                    <td>
                        <!-- <label>Doctor's ID</label> -->
                        <input type='text' name='dr_id' id='dr_id' size='5px'/>
                    </td>

                    <td>
                        <!-- <label>Patient's Concerns</label> -->
                        <input type='text' name='patient_concerns' id='patient_concerns' size='80px'/>
                    </td>

                </tr>
            </tbody>

        </table>

        <br/><br/>
        <input type='submit' name='add_appt' value='Submit'/>

    </form>
</div>


</body>
</html>
