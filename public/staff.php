<?php
require_once('_config.php');

$GLOBALS["viewables"]["head_title"] = "Staff Page";
$GLOBALS["viewables"]["route"] = "staff";
$GLOBALS["viewables"]["stylesheet"] = "staff";
$GLOBALS["viewables"]["javascript"] = "staff";

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted to add a patient
    if (isset($_POST["patient-name"]) && isset($_POST["patient-username"]) && isset($_POST["patient-login-code"]) && isset($_POST["patient-severity"])) {
        // Get the form data
        $name = htmlspecialchars($_POST["patient-name"]);
        $username = htmlspecialchars($_POST["patient-username"]);
        $login_code = htmlspecialchars($_POST["patient-login-code"]);
        $severity = (int)$_POST["patient-severity"];
        $arrivalTime = date('Y-m-d H:i:s'); // Get the current date and time

        // Use the TableInsertion.php to insert the patient into the database
        $result = emergency_waitlist\TableInsertion::insertPatient($name, $username, $login_code, $severity, $arrivalTime);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit();
    }
}

require_view('layout/layout');
?>