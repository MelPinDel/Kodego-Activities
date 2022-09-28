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

if (isset($_POST['submit'])) {
    
    $apptDate = $_POST['appt_date'];
    $apptTime = $_POST['appt_time'];
    $apptType = $_POST['appt_type_id'];
    $concerns = $_POST['patient_concerns'];

    $sql_update = "UPDATE `appt_details`
                    SET `appt_date` = '$apptDate',
                        `appt_time` = '$apptTime',
                        `appt_type_id` = '$apptType',
                        `patient_concerns` = '$concerns'

                    WHERE `appt_details`.`appt_id` = '$id';";

    $update = mysqli_query($con, $sql_update);

    if ($update) {

        echo "<script>alert('Appointment details successfully updated!')</script>";
        echo "<script>document.location="."\"details.php?ID=\"".$id."</script>";
        // echo header ('Location: details.php?ID='.$id);

    } else {

        echo "<script>alert('Submission failed. Please try again.')</script>";

    }

    };

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

$appt = $con->query($sql) or die ($con->error);

$row = $appt->fetch_assoc();

// Get all appt type data
$sql_appt_type = 'SELECT * FROM `appt_type` ORDER BY `appt_type` ASC;';

$appt_type = $con->query($sql_appt_type) or die($con->error);

$row_appt_type = $appt_type->fetch_assoc();


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

<body class='m-3'>
    
    <h1>Edit Appointment Details</h1>
    <a href='logout.php'>Logout</a>
    <br><br>
    <a href='insert.php'>Create New Appointment</a>
    <br><br>
    <a href='index.php'>Back to Main</a>
    <br><br>

    <form action='' method='POST'>

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
              
                <tr>
                    <td>
                        <?php echo $row['appt_id']; ?>
                    </td>
                    <td>
                        <input type='text' name='appt_date' id='appt_date' size=10 value='<?php echo $row['appt_date']; ?>'/>
                    </td>
                    <td>
                        <input type='text' name='appt_time' id='appt_time' size=10 value='<?php echo $row['appt_time']; ?>'>
                    </td>
                    <td>
                        <!-- <label>Appt Type</label> -->
                        <select name='appt_type_id' id='appt_type_id'>

                            <?php do{ ?>
                                <option value= <?php echo $row_appt_type['appt_type_id'];?>
                                               <?php echo ($row_appt_type['appt_type_id'] == $row['appt_type_id'] ? 'selected' : ''); ?> >
                                    <?php echo $row_appt_type['appt_type']; ?>
                                </option>
                            <?php } while ($row_appt_type = $appt_type->fetch_assoc()) ?>
                            
                        </select>
                    </td>
                    <td>
                        <?php echo $row['dr_specialty']; ?>
                    </td>
                    <td>
                        <?php echo $row['dr_first_name']." ".$row['dr_last_name']; ?>
                    </td>
                    <td>
                        <?php echo $row['patient_id']; ?>
                    </td>
                    <td>
                        <?php echo $row['pt_first_name']." ".$row['pt_last_name']; ?>
                    </td>
                    <td>
                        <input type='text' name='patient_concerns' id='patient_concerns' value='<?php echo $row['patient_concerns']; ?>'>
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