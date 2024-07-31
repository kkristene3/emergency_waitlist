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
        $query = "SELECT username FROM emergency_waitlist.Patient WHERE patient_id = '$id'";
        $result = pg_query($GLOBALS['db_conn'], $query);
        $row = pg_fetch_row($result);

        if (empty($row)){
            return false;
        }
        else{
            $username = htmlspecialchars($row[0]);
        }

        if ($username){
            //delete the user from the queue
            $query1 = "DELETE FROM emergency_waitlist.Queue WHERE username = '$username'";

            $result1 = pg_query($GLOBALS['db_conn'], $query1);

            if ($result1){
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

    public static function removePatientFromWaitingList($id){

    }

}