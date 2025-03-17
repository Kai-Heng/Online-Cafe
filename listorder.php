<style type="text/css">
    .style1 {color: #FFFFFF}
</style>

<table width="249" border="1" cellpadding="0" cellspacing="0">
    <tr>
        <td width="189"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;Products</div></td>
        <td width="65">Price</td>
        <td width="50">Qty</td>
    </tr>

<?php
if (isset($_GET['id'])) {
    include('connection.php');
    
    // Sanitize input
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Fetch order details
    $result3 = mysqli_query($conn, "SELECT * FROM orderditems WHERE transactioncode = '$id'");

    if ($result3) {
        while ($row3 = mysqli_fetch_assoc($result3)) {  
            echo '<tr>';
            echo '<td><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;'.$row3['name'].'</div></td>';
            echo '<td>M'.$row3['price'].'</td>';
            echo '<td>'.$row3['quantity'].'</td>';
            echo '</tr>';
        }
    } else {
        echo "<tr><td colspan='3'>Error retrieving order items: " . mysqli_error($conn) . "</td></tr>";
    }
}
?>
</table><br>

<?php
if (isset($_GET['id'])) {  
    include('connection.php');
    
    // Fetch order details
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $result3 = mysqli_query($conn, "SELECT * FROM orderditems WHERE transactioncode = '$id'");

    if ($result3 && mysqli_num_rows($result3) > 0) {
        $row3 = mysqli_fetch_assoc($result3);
        $var = mysqli_real_escape_string($conn, $row3['customer']);

        // Fetch customer details
        $result4 = mysqli_query($conn, "SELECT * FROM members WHERE id = '$var'");
        if ($result4 && mysqli_num_rows($result4) > 0) {
            $row4 = mysqli_fetch_assoc($result4);
        }
    }
}
?>
<br />
