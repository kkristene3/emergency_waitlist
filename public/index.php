<?php
// error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('_config.php');

$query = "SELECT * FROM emergency_waitlist.Staff";
$result = pg_query($GLOBALS['db_conn'], $query);
if (!$result) {
    die("An error occurred.\n");
}

while ($row = pg_fetch_assoc($result)) {
    echo $row['staff_id'] . " " . $row['name'] . " " . $row['username'] . " " . $row['login_code'] . "<br>";
}


/** set the global variables in the  $GLOBALS["viewables"] array, which stores data to be used in the view
 * head_title: Sets the title of the page.
 * route: Specifies which view file to include (in this case, homepage).
*/ 
$GLOBALS["viewables"]["head_title"] = "Homepage";
$GLOBALS["viewables"]["route"] = "homepage";

//Get the username from the form
$username = $_POST["username"] ?? null;
$code = $_POST["3-letter code"] ?? null;

try {
    $GLOBALS["viewables"]["h1"] = \emergency_waitlist\Message::getWelcomeMessage();
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// render the layout for the page
require_view('layout/layout');
?>