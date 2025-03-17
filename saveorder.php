<?php
session_start();
include('connection.php');

// Retrieve and sanitize user inputs
$memid = mysqli_real_escape_string($conn, $_POST['id']);
$qty = (int) $_POST['quantity']; // Ensure quantity is an integer
$name = mysqli_real_escape_string($conn, $_POST['name']);
$transcode = mysqli_real_escape_string($conn, $_POST['transcode']);
$id = mysqli_real_escape_string($conn, $_POST['butadd']);
$pprice = (float) $_POST['price']; // Ensure price is an integer
$total = round($pprice * $qty, 2);

// Insert order details into database
$query = "INSERT INTO orderditems (customer, quantity, price, total, name, transactioncode) 
          VALUES ('$memid', '$qty', '$pprice', '$total', '$name', '$transcode')";

if (mysqli_query($conn, $query)) {
    header("Location: order.php");
    exit();
} else {
    die("Error: " . mysqli_error($conn)); // Debugging in case of errors
}
?>












?> 