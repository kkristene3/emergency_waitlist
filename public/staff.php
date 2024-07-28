<?php
require_once('_config.php');

// resume the session
session_start();

$GLOBALS["viewables"]["head_title"] = "Staff Page";
$GLOBALS["viewables"]["route"] = "staff";
$GLOBALS["viewables"]["stylesheet"] = "staff";
$GLOBALS["viewables"]["javascript"] = "staff";

// Check if the form was submitted to add a patient
if (isset($_POST["new-patient-form"])) {
    // Get the form data
    $name = htmlspecialchars($_POST["patient-name"]);
    $username = htmlspecialchars($_POST["patient-username"]);
    $login_code = htmlspecialchars($_POST["patient-login-code"]);
    $severity = (int)$_POST["patient-severity"];
    $arrivalTime = date('Y-m-d H:i:s'); // Get the current date and time
    
    // Use the TableInsertion.php to insert the patient into the database
    $result = emergency_waitlist\TableInsertion::insertPatient($name, $username, $login_code, $severity, $arrivalTime);

    if ($result) {
        echo "<script>alert('Patient added successfully!')</script>";
        
        // reset the POST data
        $_POST = array();

        // Add the patient to the waiting list
        $result = emergency_waitlist\TableInsertion::insertPatientIntoWaitingList($username);
        if ($result) {
            echo "<script>alert('Patient added to the waiting list.')</script>";

        } else {
            echo "<script>alert('Failed to add patient to the waiting list.')</script>";
        }
        
    } else {
        echo "<script>alert('Failed to add patient. Please try again.')</script>";
        //echo json_encode(['success' => false]);
    }
}

require_view('layout/layout');
?>