<?php
session_start();

include('connection.php');
	
// Get form data safely
$studentnum = mysqli_real_escape_string($conn, $_POST['studentnum']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$surname = mysqli_real_escape_string($conn, $_POST['surname']);
$contacts = mysqli_real_escape_string($conn, $_POST['contacts']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$email = mysqli_real_escape_string($conn, $_POST['email']);


// SQL query
$sql = "INSERT INTO members (studentnum, name, surname, contacts, password, email) 
        VALUES ('$studentnum', '$name', '$surname', '$contacts', '$password', '$email')";

// Execute query
if (mysqli_query($conn, $sql)) {
    header("Location: loginindex.php");
    exit();
} else {
    die("Could not connect: " . mysqli_error($conn));
}

// Close connection
mysqli_close($conn);
?> 