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
        return "Sign in to view the waitlist";
    }

    /**
     * This function will return the welcome message on the staff page
     */
    public static function getStaffWelcomeMessage($name)
    {
        return "Welcome to the staff page $name!";
    }

    /**
     * This function will return the welcome message on the patient page
     */
    public static function getPatientWelcomeMessage($name)
    {
        return "Welcome to the patient page $name!";
    }
}
?>