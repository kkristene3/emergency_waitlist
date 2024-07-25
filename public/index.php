<?php
// error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('_config.php');

// Start or resume a session
session_start();

/** set the global variables in the  $GLOBALS["viewables"] array, which stores data to be used in the view
 * head_title: Sets the title of the page.
 * route: Specifies which view file to include (in this case, homepage).
*/ 
$GLOBALS["viewables"]["head_title"] = "Homepage";
$GLOBALS["viewables"]["route"] = "homepage";
$GLOBALS["viewables"]["h1"] = \emergency_waitlist\Message::getWelcomeMessage();
$GLOBALS["viewables"]["stylesheet"] = "index";
$GLOBALS["viewables"]["javascript"] = "index";

// get the POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['sign-in-form'])) {
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

    // Check if the form was submitted to add a patient
    else if (isset($_POST["new-patient-form"])) {
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
            // do a partial refresh while keeping the current view
            
        } else {
            echo "<script>alert('Failed to add patient. Please try again.')</script>";
            //echo json_encode(['success' => false]);
        }
    }

    else if (isset($_POST['signOut'])) {
        // Perform sign out operations
        // TO DO: Unset all session variables
        $_SESSION = array();
    
        // If it's desired to kill the session, also delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    
        // Finally, destroy the session.
        session_destroy();
    } else {
        // Handle the case where signOut wasn't set in the POST request
        http_response_code(400); // Bad Request
        echo "Invalid request.";
    }
}

// render the layout for the page
require_view('layout/layout');
?>
