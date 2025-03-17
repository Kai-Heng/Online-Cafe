<?php
// Start session
session_start();

// Include database connection
include('connection.php');

// Function to sanitize values received from the form
function clean($conn, $str) {
    return mysqli_real_escape_string($conn, trim($str));
}

// Get and sanitize input
$email = clean($conn, $_POST['user']);
$password = clean($conn, $_POST['password']);

// Query to find the user by email
$qry = "SELECT * FROM members WHERE email='$email'";
$result = mysqli_query($conn, $qry);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $member = mysqli_fetch_assoc($result);
        
        // Debugging: Print stored and entered passwords
        echo "Stored: " . $member['password'] . "<br>";
        echo "Entered: " . $password . "<br>";

        // Check if passwords match
        if ($password === $member['password']) {  // Use password_verify() if passwords are hashed
            session_regenerate_id();
            $_SESSION['SESS_MEMBER_ID'] = $member['id'];
            $_SESSION['SESS_FIRST_NAME'] = $member['name'];  // Store actual name instead of random
            session_write_close();
            header("Location: order.php");
            exit();
        } else {
            echo "<h4 style='color:red;'>Invalid Email or Password</h4>";
            exit();
        }
    } else {
        echo "<h4 style='color:red;'>Invalid Email or Password</h4>";
        exit();
    }
} else {
    die("Query failed: " . mysqli_error($conn));
}

// Close connection
mysqli_close($conn);
?>
