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
}