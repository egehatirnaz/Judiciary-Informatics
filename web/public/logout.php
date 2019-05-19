<?php
include 'db_connection.php';

session_destroy();
header("Location: index.php");
die();
?>