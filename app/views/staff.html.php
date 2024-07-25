<?php
// connect to the database
require_once('_config.php');

// Get the username from the viewables
$username = isset($GLOBALS["viewables"]["username"]) ? htmlspecialchars($GLOBALS["viewables"]["username"]) : '';

// Get information from the database
$query = "SELECT name FROM emergency_waitlist.Staff WHERE username = '$username'";
$result = pg_query($GLOBALS['db_conn'], $query);

// Fetch the row
if ($result) {
    $row = pg_fetch_row($result);
    if ($row) {
        $name = strtoupper(htmlspecialchars($row[0])); // Escape the output for safety
        $GLOBALS["viewables"]["h2"] = \emergency_waitlist\Message::getStaffWelcomeMessage($name);
    }
}

// Get the patient list
$query = "SELECT * FROM emergency_waitlist.Patient";
$result = pg_query($GLOBALS['db_conn'], $query);
?>

<!-- ---------------- The HTML content for the staff page ---------------- -->
<!DOCTYPE html>
<div id="header">
    <h1><?php echo g("h2") ?></h1>
    <button id="signout-btn">SIGN OUT</button>
</div>

<!-- Patient List appears at the top of the page -->
<div id="patient-list">
    <h2>Patient List</h2>
    <table>
        <tr>
            <th>Patient ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Severity</th>
            <th>Arrival Time (EST)</th>
        </tr>
        <!-- Patient information will be displayed here -->
        <?php
        if ($result) {
            while ($row = pg_fetch_row($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row[0]) . "</td>";
                echo "<td>" . htmlspecialchars($row[1]) . "</td>";
                echo "<td>" . htmlspecialchars($row[2]) . "</td>";
                echo "<td>" . htmlspecialchars($row[4]) . "</td>";
                // convert the timestamp to a human-readable format
                $dateTime = new DateTime($row[5]);
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

<!-- Action Content appears afterwards -->
<div class="action-content">
    <h2 id="subtitle">TRIAGE STAFF ACTIONS</h2>
    <p>Choose an action to perform.</p>
    <div id="action-btns">
        <button id="add-patient-btn">Add Patient</button>
        <button id="remove-patient-btn">Remove Patient</button>
    </div>
</div>

<!-- Divs that will appear depending on which action button was clicked -->
<div id="add-patient" class="action-form">
    <h2>Add Patient</h2>
    <p>Enter the patient's name, username, and login code to add them to the waitlist.</p>
    <form id="add-patient-form">
        <div class="form-row">
            <label for="patient-name">Patient Name:</label>
            <input type="text" id="patient-name" name="patient-name" required>
        </div>
        <div class="form-row">
            <label for="patient-username">Patient Username:</label>
            <input type="text" id="patient-username" name="patient-username" required>
        </div>
        <div class="form-row">
            <label for="patient-login-code">Patient Login Code:</label>
            <input type="text" id="patient-login-code" name="patient-login-code" required>
        </div>
        <div class="form-row">
            <label for="patient-severity">Patient Severity:</label>
            <input type="number" id="patient-severity" name="patient-severity" required min="0" max="5">
        </div>
        <button type="submit">Add Patient</button>
    </form>
</div>


<div id="remove-patient" class="action-form">
    <h2>Remove Patient</h2>
    <p>Enter the Patient ID of the patient you would like to remove.</p>
    <form id="remove-patient-form">
        <label for="patient-id">Patient ID:</label>
        <input type="text" id="patient-id" name="patient-id" required>
        <button type="submit">Remove Patient</button>
    </form>
</div>