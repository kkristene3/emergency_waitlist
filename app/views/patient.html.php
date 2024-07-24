<?php
// connect to the database
require_once('_config.php');

// Get the username from the viewables
$username = isset($GLOBALS["viewables"]["username"]) ? htmlspecialchars($GLOBALS["viewables"]["username"]) : '';

// Get information from the database
$query = "SELECT name FROM emergency_waitlist.Patient WHERE username = '$username'";
$result = pg_query($GLOBALS['db_conn'], $query);

// Fetch the row
if ($result) {
    $row = pg_fetch_row($result);
    if ($row) {
        $name = htmlspecialchars($row[0]); // Escape the output for safety
        $GLOBALS["viewables"]["h3"] = \emergency_waitlist\Message::getPatientWelcomeMessage($name);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Page</title>
</head>
<body>
    <h1><?php echo g("h3") ?></h1>
    <button>Sign Out</button>
</body>
</html>
