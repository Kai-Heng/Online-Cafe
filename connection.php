<?php
// $mysql_hostname = "wings.cfmvtqab0vht.us-east-1.rds.amazonaws.com";
// $mysql_user = "admin";
// $mysql_password = "lpw3518739";
// $mysql_database = "wings";
// Include AWS Parameter Store values
include('get-parameters.php');

// Connect using MySQLi
$conn = mysqli_connect($ep, $un, $pw, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>