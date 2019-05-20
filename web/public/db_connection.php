<?php
// DEBUG PURPOSES.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

function isLoggedIn($userType){
    if(isset($_SESSION['credentials'])){
        $userID = $_SESSION['credentials']['user_id'];
        if ($_SESSION['credentials']['user_hash'] == hash_pass($userID, $userType)){
            return true;
        }
    }
    return false;
}
function hash_pass($str, $salt){
    return md5($salt.$str);
}

$servername = "mysql";
$username = "dev";
$password = "dev";
$dbname = "judiciary_db";

$db = mysqli_connect($servername, $username, $password, $dbname);
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
?>