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

function getUsername($db){
    $id = $_SESSION['credentials']['user_id'];
    $query = "SELECT name, surname FROM User WHERE `id` = '$id'";
    if ($result = mysqli_query($db,$query)){
        $count = mysqli_num_rows($result);
        // If count is 1, user exists.
        if ($count == 1) {
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            return $row['name'].' '.$row['surname'];
        }
    }
    return "Unknown User";
}
?>