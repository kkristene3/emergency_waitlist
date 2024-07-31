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
        $_SESSION['alert'] = 'Patient added successfully!';
        // Use the TableInsertion.php to add the patient to the waiting list
        $result = emergency_waitlist\TableInsertion::insertPatientIntoWaitingList($username);
    } else {
        $_SESSION['alert'] = 'Failed to add patient. Please try again.';
    }
    // Redirect to the same page to clear the form data
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

//check if the form was submitted to remove a patient
if (isset($_POST["remove-patient"])){
    //Get the form data
    $id = htmlspecialchars($_POST['patient-id']);

    $result = emergency_waitlist\TableDeletion::deletePatient($id);

    /*$query = "SELECT username FROM emergency_waitlist.Patient WHERE patient_id = '$id'";
    $result = pg_query($GLOBALS['db_conn'], $query);
    $row = pg_fetch_row($result);*/

    if ($result){
        //$_SESSION['alert'] = htmlspecialchars($row[0]);
        $_SESSION['alert'] = 'Patient removed successfully';
        
    }
    else{
        $_SESSION['alert'] = 'Failed to remove patient. Please try again.';
    }
    // Redirect to the same page to clear the form data
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;

}
// Check for alert messages in the session and display them
if (isset($_SESSION['alert'])) {
    echo "<script>alert('" . $_SESSION['alert'] . "');</script>";
    unset($_SESSION['alert']); // Clear the alert message from the session
}

require_view('layout/layout');
?>