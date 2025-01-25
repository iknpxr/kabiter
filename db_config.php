<?php
// Database configuration
$host = 'localhost';            // Database host
$db_user = 'wildrift';          // Username
$db_pass = 'xcix456$$';     // Password
$db_name = 'wildrift_cr';     // Database name

// Create connection
$mysqli = new mysqli($host, $db_user, $db_pass, $db_name);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
