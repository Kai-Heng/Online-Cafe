<?php
	require_once('auth.php');
  include('connection.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Wings Cafe</title>
<link href="css/ble.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<!--sa poip up-->
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
 
<!-- jQuery and Facebox -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/facebox/1.3/facebox.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('a[rel*=facebox]').facebox({
            loadingImage : 'src/loading.gif',
            closeImage   : 'src/closelabel.png'
        });
    });
</script>

<!-- Filtering & Table Scripts -->
<link rel="stylesheet" href="./febe/style.css" type="text/css" media="screen">
<script src="argiepolicarpio.js" type="text/javascript"></script>
<script src="./js/application.js" type="text/javascript"></script>

<style type="text/css">
    a { text-decoration: none; }
    .style1 { font-size: 16px; }
</style>

</head>

<body>
<div style="width:900px; margin:0 auto; position:relative; border:3px solid rgba(0,0,0,0); 
    border-radius:5px; box-shadow:0 0 18px rgba(0,0,0,0.4); margin-top:10%;">
    
    <div style="background-color:#ff3300; height:40px; margin-bottom:10px;">
        <div style="float:right; width:50px; margin-right:20px; background-color:#cccccc; text-align:center;">
            <a href="home_admin.php">Back</a>
        </div>
        <div style="float:left; margin-left:10px; margin-top:10px;">
            <strong>Welcome</strong> <?php echo $_SESSION['SESS_FIRST_NAME']; ?>
        </div>
    </div>

    <br />
    <label style="margin-left:12px;">Filter</label>
    <input type="text" name="filter" value="" id="filter" />
    <br /><br />

    <table cellpadding="1" cellspacing="1" id="resultTable" border="1">
        <thead>
            <tr bgcolor="#cccccc">
                <th>Student Num</th>
                <th>Amount Paid</th>
                <th>Code (click to view order)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result3 = mysqli_query($conn, "SELECT * FROM wings_orders");

        while ($row3 = mysqli_fetch_assoc($result3)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row3['cusid']) . '</td>';
            echo '<td>M' . htmlspecialchars($row3['total']) . '</td>';
            echo '<td><a rel="facebox" href="listorder.php?id=' . urlencode($row3["transactioncode"]) . '">' . htmlspecialchars($row3['transactioncode']) . '</a></td>';
            echo '<td>' . htmlspecialchars($row3['transactiondate']) . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>