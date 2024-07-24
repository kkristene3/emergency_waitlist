<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * DATABASE CONFIGURATION
 */
$dbHost = 'localhost'; // Use 'localhost' if Docker is running on the same host
$dbPort = '5432'; // Default PostgreSQL port
$dbName = 'postgres';
$dbUser = 'postgres';
$dbPassword = 'Soobin1!';

// Create a connection string
$connString = "host=$dbHost port=$dbPort dbname=$dbName user=$dbUser password=$dbPassword";

// Establish a connection to the database
$conn = pg_connect($connString);
if (!$conn) {
  die("Connection failed: " . pg_last_error());
}

// Global variables
$GLOBALS['db_conn'] = $conn;
$GLOBALS["appDir"] = resolve_path("app");
$GLOBALS["viewables"] = array();

function resolve_path($name)
{
    if ($name == ".")
    {
        $publicRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
        $appRoot = $_SERVER["DOCUMENT_ROOT"];
    }
    else if ($_SERVER["DOCUMENT_ROOT"] != "")
    {
        $publicRoot = $_SERVER["DOCUMENT_ROOT"] . "/../$name";
        $appRoot = $_SERVER["DOCUMENT_ROOT"] . "/$name";
    }
    else
    {
        return "../{$name}";
    }

    return file_exists($publicRoot) ? realpath($publicRoot) : realpath($appRoot);
}

spl_autoload_register(function ($fullName) {
    $parts = explode("\\", $fullName);
    $len = count($parts);
    $className = $parts[$len - 1];
    if (file_exists($GLOBALS["appDir"] . "/models/{$className}.php"))
    {
      require_once $GLOBALS["appDir"] . "/models/{$className}.php";
    }
});

function l($lookup,$default = "")
{
  $locals = g("locals",array());
  if (isset($locals[$lookup]))
  {
    return $locals[$lookup];
  }
  else
  {
    return $default;
  }
}

function g($lookup,$default = "")
{
  if (isset($GLOBALS["viewables"][$lookup]))
  {
    return $GLOBALS["viewables"][$lookup];
  }
  else
  {
    return $default;
  }
}

function require_view($viewName, $locals = array())
{
  $GLOBALS["viewables"]["locals"] = $locals;
  require $GLOBALS["appDir"] . "/views/{$viewName}.html.php";
}
