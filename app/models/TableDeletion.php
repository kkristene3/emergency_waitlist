<?php
namespace emergency_waitlist;
require_once('_config.php');

/**
 * Class TableDeletion
 * This class is used to delete data from the database
 */
class TableDeletion{

    /**
     * Remove a patient from the database.
     * @param $id String of the patient id.
     */
    public static function deletePatient($id){

        $username = '';

        //Check if the user exists
        $query = "SELECT username, severity FROM emergency_waitlist.Patient WHERE patient_id = '$id'";
        $result = pg_query($GLOBALS['db_conn'], $query);
        $row = pg_fetch_row($result);

        if (empty($row)){
            return false;
        }
        else{
            $username = htmlspecialchars($row[0]);
            $severity = (int)$row[1];
        }

        if ($username){
            //grab the wait-time of that user
            $query = "SELECT wait_time FROM emergency_waitlist.Queue WHERE username = '$username'";
            $result = pg_query($GLOBALS['db_conn'], $query);
            $row = pg_fetch_row($result);
            $wait_time = (int)$row[0];

            //delete the user from the queue
            $query1 = "DELETE FROM emergency_waitlist.Queue WHERE username = '$username'";

            $result1 = pg_query($GLOBALS['db_conn'], $query1);

            if ($result1){

                 //change the wait-time of everything that comes after it
                 $query = "SELECT username, wait_time FROM emergency_waitlist.Queue WHERE wait_time >= '$wait_time'";
                 $result = pg_query($GLOBALS['db_conn'], $query);
 
                 while($row = pg_fetch_row($result)){
                     $username = htmlspecialchars($row[0]);
                     $wait_time = (int)$row[1];
 
                     $newWaitTime = $wait_time - $severity*5;
                     $query1 = "UPDATE emergency_waitlist.Queue SET wait_time = '$newWaitTime' WHERE username='$username'";
                     $result1 = pg_query($GLOBALS['db_conn'], $query1);
                 }

                //delete the user from the patient list
                $query = "DELETE FROM emergency_waitlist.Patient WHERE patient_id = '$id'";
                $result = pg_query($GLOBALS['db_conn'], $query);

                if($result){
                    return true;
                }
            }
            return false;
        }

    }
    public static function removePatientWithUsername($username){
        $query = "SELECT DISTINCT p.severity, q.wait_time from emergency_waitlist.Patient as p, emergency_waitlist.Queue as q WHERE p.username = '$username'";
        $result = pg_query($GLOBALS['db_conn'], $query);
        $row = pg_fetch_row($result);

        if (empty($row)){
            return false;
        }
        else{
            $severity = (int)$row[0];
            $wait_time = (int)$row[1];
            //delete the user from the queue
            $query1 = "DELETE FROM emergency_waitlist.Queue WHERE username = '$username'";

            $result1 = pg_query($GLOBALS['db_conn'], $query1);

            if ($result1){
                //change the wait-time of everything that comes after it
                $query = "SELECT username, wait_time FROM emergency_waitlist.Queue WHERE wait_time > '$wait_time'";
                $result = pg_query($GLOBALS['db_conn'], $query);

                while($row = pg_fetch_row($result)){
                    $otherUsername = htmlspecialchars($row[0]);
                    $wait_time = (int)$row[1];

                    $newWaitTime = $wait_time - $severity*5;
                    $query1 = "UPDATE emergency_waitlist.Queue SET wait_time = '$newWaitTime' WHERE username='$otherUsername'";
                    $result1 = pg_query($GLOBALS['db_conn'], $query1);
                }

                //delete the user from the patient list
                $query = "DELETE FROM emergency_waitlist.Patient WHERE username = '$username'";
                $result = pg_query($GLOBALS['db_conn'], $query);

                if($result){
                    return true;
                }
            }
            return false;
        }
    }

}