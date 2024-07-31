<?php
namespace emergency_waitlist;
require_once('_config.php');
/**
 * Class TableInsertion
 * This class is used to insert data into the database.
 */
class TableInsertion {
    /**
     * Insert a new patient into the database.
     * @param $patientID string The patient's ID.
     * @param $name string The patient's name.
     * @param $username string The patient's username.
     * @param $severity string The patient's severity.
     * @param $arrivalTime string The patient's arrival time.
     * @return bool True if the patient was successfully inserted, false otherwise.
     */
    public static function insertPatient($name, $username, $login_code, $severity, $arrivalTime) {
        
        // Insert the patient into the database
        $query = "INSERT INTO emergency_waitlist.Patient (name, username, login_code, severity, arrival_time) 
                    VALUES ('$name', '$username', '$login_code', '$severity', '$arrivalTime')";
        $result = pg_query($GLOBALS['db_conn'], $query);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * Insert a new patient into the waiting list.
     * @param $username string The patient's username.
     * @return bool True if the patient was successfully inserted, false otherwise.
     */
    public static function insertPatientIntoWaitingList ($username) {
        // calcualte the wait time based on patient's severity
        $query = "SELECT severity FROM emergency_waitlist.Patient WHERE username = '$username'";
        $result = pg_query($GLOBALS['db_conn'], $query);
        $row = pg_fetch_row($result);
        $severity = (int)$row[0];
        $waitTime = $severity * 10; // 10 minutes per severity level

        // add the patient to the waitlist
        $query = "INSERT INTO emergency_waitlist.Queue (username, wait_time) VALUES ('$username', '$waitTime')";
        $result = pg_query($GLOBALS['db_conn'], $query);
        if (!$result) {
            return false;
        }
        return true;
    }
}