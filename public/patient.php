<?php
require_once('_config.php');

// resume the session
session_start();


$GLOBALS["viewables"]["head_title"] = "Patient Page";
$GLOBALS["viewables"]["route"] = "patient";
$GLOBALS["viewables"]["stylesheet"] = "patient";
$GLOBALS["viewables"]["javascript"] = "patient";

require_view('layout/layout');
?>