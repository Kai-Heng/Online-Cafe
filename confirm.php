<?php 
 require_once('auth.php');
 include('connection.php');

 // Get POST values safely
 $total = mysqli_real_escape_string($conn, $_POST['total']);
 $transactioncode = mysqli_real_escape_string($conn, $_POST['transactioncode']);
 $transactiondate = date("Y-m-d"); // Use correct date format for SQL
 $student = mysqli_real_escape_string($conn, $_POST['num']);
 
 ?>
 
 <form method="post" action="">
     <input name="transactioncode" type="hidden" value="<?php echo $transactioncode; ?>" />
     <input name="total" type="hidden" value="<?php echo $total; ?>" />
 </form>
 
 <?php
 // Fetch student details
 $result = mysqli_query($conn, "SELECT studentnum FROM members WHERE studentnum = '$student'");
 
 if (!$result) {
     die("Query Failed: " . mysqli_error($conn));
 }
 
 if (mysqli_num_rows($result) == 0) {
     echo "Wrong Student Number";
     exit(0);
 }
 
 // Insert into `wings_orders`
 $sql = "INSERT INTO wings_orders (cusid, total, transactiondate, transactioncode) 
         VALUES ('$student', '$total', '$transactiondate', '$transactioncode')";
 
 if (!mysqli_query($conn, $sql)) {
     die("Order Insertion Failed: " . mysqli_error($conn));
 }
 
 // Close connection
 mysqli_close($conn);
 ?>
 
 <a rel="facebox" href="order.php">
     <img src="images/28.png" width="75px" height="75px" />
 </a>

