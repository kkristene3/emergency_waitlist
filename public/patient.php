<?php
require_once('_config.php');

// resume the session
session_start();

$GLOBALS["viewables"]["head_title"] = "Patient Page";
$GLOBALS["viewables"]["route"] = "patient";
$GLOBALS["viewables"]["stylesheet"] = "patient";
$GLOBALS["viewables"]["javascript"] = "patient";

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// handle post for when user leaves queue before their turn
if (isset ($_POST['leave-btn'])){
    $result = emergency_waitlist\TableDeletion::removePatientWithUsername($username);

    if ($result){
        echo "<script>alert('You have successfully been removed from the waitlist');</script>";
    }
    else{
        $_SESSION['alert'] = 'Failed to remove you from the waitlist. Please try again.';
    }

    header("Location: index.php");
}

// Check for alert messages in the session and display them
if (isset($_SESSION['alert'])) {
    echo "<script>alert('" . $_SESSION['alert'] . "');</script>";
    unset($_SESSION['alert']); // Clear the alert message from the session
}

require_view('layout/layout');
?>