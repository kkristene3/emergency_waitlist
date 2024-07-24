<?php
// /**
//  * This file will handle the form submission on the homepage
//  */

// require_once('_config.php');

// /** set the global variables in the  $GLOBALS["viewables"] array, which stores data to be used in the view
//  * head_title: Sets the title of the page.
//  * route: Specifies which view file to include (in this case, homepage).
// */ 
// $GLOBALS["viewables"]["head_title"] = "Homepage";
// $GLOBALS["viewables"]["route"] = "homepage";

// // Get the username from the form
// $username = $_POST["username"] ?? null;
// $code = $_POST["3-letter code"] ?? null;

// // h1: Uses the Message::getHomepageWelcomeMessage() method to generate a greeting message based on the username input.
// $GLOBALS["viewables"]["h1"] = \emergency_waitlist\Message::getHomepageWelcomeMessage();

// // render the layout for the page
// require_view('layout/layout');

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('_config.php');

$GLOBALS["viewables"]["head_title"] = "Homepage";
$GLOBALS["viewables"]["route"] = "homepage";

try {
    $GLOBALS["viewables"]["h1"] = \emergency_waitlist\Message::getWelcomeMessage();
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

require_view('layout/layout');
?>