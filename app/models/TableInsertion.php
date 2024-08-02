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
        // calcualte the wait time based on the previous patient's time and severity
        $waitTime = 0;
        
        //check if this patient is the first in the queue
        $query = "SELECT count(*) FROM emergency_waitlist.Queue";
        $result = pg_query($GLOBALS['db_conn'], $query);
        $row = pg_fetch_row($result);

        if ($row[0] == 0){
            $query = "INSERT INTO emergency_waitlist.Queue (username, wait_time) VALUES ('$username', '$waitTime')";
            $result = pg_query($GLOBALS['db_conn'], $query);
            if (!$result) {
                return false;
            }
        }
        else{
            //grab the last patient in the wait queue
            $query = "SELECT username, wait_time FROM emergency_waitlist.Queue WHERE wait_time IN (SELECT max(wait_time) FROM emergency_waitlist.QUEUE)";
            $result = pg_query($GLOBALS['db_conn'], $query);
            $row = pg_fetch_row($result);

            $prevUsername = htmlspecialchars($row[0]);
            $prevWaitTime = (int)$row[1];

            //grab the severity from that last patient
            $query = "SELECT severity FROM emergency_waitlist.Patient WHERE username = '$prevUsername'";
            $result = pg_query($GLOBALS['db_conn'], $query);
            $row = pg_fetch_row($result);

            $prevSeverity = (int)$row[0];

            $waitTime = $prevWaitTime + ($prevSeverity*5);

            if ($prevSeverity == 0){
                $waitTime = $prevWaitTime + 2;
            }
            
            // add the patient to the waitlist
            $query = "INSERT INTO emergency_waitlist.Queue (username, wait_time) VALUES ('$username', '$waitTime')";
            $result = pg_query($GLOBALS['db_conn'], $query);
            if (!$result) {
                return false;
            }
        }

        return true;
    }
}