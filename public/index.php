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

$role = '';

// get the POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['sign-in-form'])) {
        $role = isset($_POST['role']) ? $_POST['role'] : null;
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $login_code = isset($_POST['3-letter-code']) ? $_POST['3-letter-code'] : null;

        // change the route to the appropriate view file when button is pressed
        if ($role == "Staff") {
            $query = "SELECT * FROM emergency_waitlist.Staff WHERE username = '$username' AND login_code = '$login_code'";
            $result = pg_query($GLOBALS['db_conn'], $query);

            $row = pg_fetch_row($result);
            if (!empty($row)){
                // Store username in the session
                $_SESSION['username'] = $username;

                $GLOBALS["viewables"]["head_title"] = "Staff Page";
                $GLOBALS["viewables"]["route"] = "staff";
                $GLOBALS["viewables"]["stylesheet"] = "staff";
                $GLOBALS["viewables"]["javascript"] = "staff";
                header("Location: staff.php");
            } else{
                echo "<script>alert('Username or password is incorrect. Please try again.')</script>";
            }         
        } else if ($role == "Patient") {
            $query = "SELECT * FROM emergency_waitlist.Patient WHERE username = '$username' AND login_code = '$login_code'";
            $result = pg_query($GLOBALS['db_conn'], $query);

            $row = pg_fetch_row($result);
            if (!empty($row)){
                // Store username in the session
                $_SESSION['username'] = $username;

                $GLOBALS["viewables"]["head_title"] = "Patient Page";
                $GLOBALS["viewables"]["route"] = "patient";
                $GLOBALS["viewables"]["stylesheet"] = "patient";
                $GLOBALS["viewables"]["javascript"] = "patient";
                header("Location: patient.php");
            } else{
                echo "<script>alert('Username or password is incorrect. Please try again.')</script>";
            }
            
        }
        else{
            echo "<script>alert('Please indicate whether you are a patient or a staff member')</script>";
        }
    }

    else if (isset($_POST['signOut'])) {
        // Unset all session variables
        $_SESSION = array();    
    
        //  delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    
        // destroy the session.
        session_destroy();
        // Respond with a success message
        http_response_code(200);
        echo "Signed out successfully";
    }
}

// render the layout for the page
require_view('layout/layout');
?>
