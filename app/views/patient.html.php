<?php
// connect to the database
require_once('_config.php');

// get username from session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// Get information from the database
$query = "SELECT name FROM emergency_waitlist.Patient WHERE username = '$username'";
$result = pg_query($GLOBALS['db_conn'], $query);

// Fetch the row
if ($result) {
    $row = pg_fetch_row($result);
    if ($row) {
        $name = strtoupper(htmlspecialchars($row[0])); // get name of user
        $GLOBALS["viewables"]["h3"] = \emergency_waitlist\Message::getPatientWelcomeMessage($name); // get welcome message
    }
}
?>

<!DOCTYPE html>
<div id="header">
    <h1><?php echo g("h3") ?></h1>
    <button id="signout-btn">SIGN OUT</button>
</div>

<!-- Patient Information appears at the bottom of the page -->
<div id="patient-info">
    <h2>PATIENT INFORMATION</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Login Code</th>
            <th>Severity</th>
            <th>Arrival Time (EST)</th>
        </tr>
        <!-- Patient information will be displayed here -->
        <?php
        $query = "SELECT name, username, login_code, severity, arrival_time FROM emergency_waitlist.Patient WHERE username = '$username'";
        $result = pg_query($GLOBALS['db_conn'], $query);
        if ($result) {
            while ($row = pg_fetch_row($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row[0]) . "</td>";
                echo "<td>" . htmlspecialchars($row[1]) . "</td>";
                echo "<td>" . htmlspecialchars($row[2]) . "</td>";
                echo "<td>" . htmlspecialchars($row[3]) . "</td>";
                // convert the timestamp to a human-readable format
                $dateTime = new DateTime($row[4]);
                $estTimezone = new DateTimeZone('America/New_York'); // Set the timezone to Eastern Time (ET)
                $dateTime->setTimezone($estTimezone);
                $formattedDate = $dateTime->format('d/m/Y H:i:s'); // Format the date and time
                echo "<td>" . htmlspecialchars($formattedDate) . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
</div>

<!-- Queue List appears at the top of the page -->
 <div id="waiting-list">
    <h2>CURRENT WAITING LIST</h2>
    <table>
        <tr>
            <th>Number in Queue</th>
            <th>Wait Time (mins)</th>
        </tr>
        <!-- Queue information will be displayed here -->
        <?php
        // Get the queue list
        $query = "SELECT Patient.username, Queue.wait_time
        FROM emergency_waitlist.Patient
        INNER JOIN emergency_waitlist.Queue ON Patient.username= Queue.username";

        $result = pg_query($GLOBALS['db_conn'], $query);
        if ($result) {
            $i = 1;
            while ($row = pg_fetch_row($result)) {
                if (htmlspecialchars($row[0]) == $username){
                    echo "<tr>";
                    echo "<td>" . $i . "</td>";
                    echo "<td>" . htmlspecialchars($row[1]) . "</td>";
                }
                $i++;
            }
        }
        ?>
    </table>
</div>

<!-- Leave Queue Button -->
<div id="leave-queue">
    <form id="remove-patient-form" method="POST">
        <button type="submit" name="leave-btn">Leave Queue</button>
    </form>
</div>

