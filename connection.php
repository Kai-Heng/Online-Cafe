<?php
// $mysql_hostname = "";
// $mysql_user = "";
// $mysql_password = "";
// $mysql_database = "";
// Include AWS Parameter Store values
include('get-parameters.php');

// Connect using MySQLi
$conn = mysqli_connect($ep, $un, $pw, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>