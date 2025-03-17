<?php
if (isset($_GET['id'])) {
    include('connection.php');

    // Sanitize input
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Execute DELETE query
    $query = "DELETE FROM orderditems WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: order.php");
        exit();
    } else {
        die("Error deleting record: " . mysqli_error($conn));
    }
}
?>
			
			
