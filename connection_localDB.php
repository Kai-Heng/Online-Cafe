<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "root";
$mysql_database = "wings";

// Connect using MySQLi
$conn = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>