<?php
// error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('_config.php');

/** set the global variables in the  $GLOBALS["viewables"] array, which stores data to be used in the view
 * head_title: Sets the title of the page.
 * route: Specifies which view file to include (in this case, homepage).
*/ 
$GLOBALS["viewables"]["head_title"] = "Homepage";
$GLOBALS["viewables"]["route"] = "homepage";
$GLOBALS["viewables"]["h1"] = \emergency_waitlist\Message::getWelcomeMessage();

// get the POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = isset($_POST['role']) ? $_POST['role'] : null;
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $login_code = isset($_POST['3-letter code']) ? $_POST['3-letter code'] : null;

    // Store username in viewables to be used in another view
    $GLOBALS["viewables"]["username"] = $username;

    // change the route to the appropriate view file when button is pressed
    if ($role == "Staff") {
        $GLOBALS["viewables"]["head_title"] = "Staff Page";
        $GLOBALS["viewables"]["route"] = "staff";
        $GLOBALS["viewables"]["stylesheet"] = "staff";
        $GLOBALS["viewables"]["javascript"] = "staff";
    } else if ($role == "Patient") {
        $GLOBALS["viewables"]["head_title"] = "Patient Page";
        $GLOBALS["viewables"]["route"] = "patient";
        $GLOBALS["viewables"]["stylesheet"] = "patient";
        $GLOBALS["viewables"]["javascript"] = "patient";
    }
}

// render the layout for the page
require_view('layout/layout');
?>
