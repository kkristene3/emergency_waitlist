<?php
/**
 * This class will be used to display the Welcome message upon screen loading
 */

namespace emergency_waitlist;

class Message
{
    /**
     * This function will return the welcome message on the homepage
     */
    public static function getWelcomeMessage()
    {
        return "WELCOME TO THE EMERGENCY WAITLIST SYSTEM!";
    }

    /**
     * This function will return the welcome message on the staff page
     */
    public static function getStaffWelcomeMessage($name)
    {
        return "WELCOME TO THE STAFF PAGE $name!";
    }

    /**
     * This function will return the welcome message on the patient page
     */
    public static function getPatientWelcomeMessage($name)
    {
        return "WELCOME TO THE PATIENT PAGE $name!";
    }
}
?>