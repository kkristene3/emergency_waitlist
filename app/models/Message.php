<?php
/**
 * This class will be used to display the Welcome message when a user logs in
 * It displays their name and a welcome message
 */

namespace emergency_waitlist;

class Message
{
    public static function getWelcomeMessage()
    {
        return "Sign in to view the waitlist";
    }
}
?>