<?php
// DEBUG PURPOSES.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "mysql";
$username = "dev";
$password = "dev";
$dbname = "judiciary_db";

$db = mysqli_connect($servername, $username, $password, $dbname);
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
?>