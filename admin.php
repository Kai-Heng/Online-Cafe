<?php
session_start();

include("connection.php");

// Get and sanitize input
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Query the database
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Check if user exists
if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    
    // Verify password (if stored as a hash)
    if ($password === $user['password']) {
        session_regenerate_id();
        $_SESSION['SESS_MEMBER_ID'] = $user['id'];
        $_SESSION['SESS_FIRST_NAME'] = $user['username'];
        session_write_close();
        header("Location: home_admin.php");
        exit();
    } else {
        echo "<h4 style='color:red;'>Incorrect email or password!</h4>";
    }
} else {
    echo "<h4 style='color:red;'>User not found!</h4>";
}

// Close the connection
mysqli_close($conn);
?>

