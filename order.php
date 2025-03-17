<?php
require_once('auth.php');
session_start();
include('connection.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Wings Cafe</title>

<meta name="keywords" content="" />

<meta name="description" content="" />

<link href="style.css" rel="stylesheet" type="text/css" />
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />

<!-- jQuery and Facebox -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/facebox/1.3/facebox.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('a[rel*=facebox]').facebox({
            loadingImage: 'src/loading.gif',
            closeImage: 'src/closelabel.png'
        });
    });

    function ShowTime() {
        var time = new Date();
        var h = time.getHours();
        var m = time.getMinutes();
        var s = time.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('txt').value = h + " : " + m + " : " + s;
        setTimeout(ShowTime, 1000);
    }

    function checkTime(i) {
        return i < 10 ? "0" + i : i;
    }

    function validateForm() {
        var num = document.forms["abcd"]["num"].value;
        if (num == null || num == "") {
            alert("You must enter your student number");
            return false;
        }
        if (!document.abcd.checkbox.checked) {
            alert("Please agree to the terms and conditions");
            return false;
        }
        return true;
    }
</script>

</head>
<body onload="ShowTime()">

<div id="container">
    <div id="header_section">
        <div style="float:right; margin-right:30px;">
            <?php 
            $id = $_SESSION['SESS_MEMBER_ID'];
            $resulta = mysqli_query($conn, "SELECT * FROM members WHERE id = '$id'");

            if ($resulta) {
                while ($row = mysqli_fetch_assoc($resulta)) {
                    echo $row['name'] . ' ' . $row['surname'];
                }
            }
            ?>
            &nbsp;<a href="logout.php" id="logout-button">Logout</a>
        </div> 
    </div>

    <div id="menu_bg">
        <div id="menu">
            <div style="float:left">
                <input name="time" type="text" id="txt" readonly 
                    style="border: none; font-size: 25px; margin-top: -5px; 
                    height: 23px; width: 130px; background-color:#000000; color:#FF0000;" />
            </div> 
        </div>
    </div>

    <div id="content">
        <div id="content_left">
            <div class="text">Select From Menu Below</div>
            <div class="view1">
                <?php
                $result2 = mysqli_query($conn, "SELECT * FROM products");

                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $id = $row2['id'];
                    $result3 = mysqli_query($conn, "SELECT * FROM products WHERE product_id='$id'");
                    $row3 = mysqli_fetch_assoc($result3);
                    echo '<div class="box"> 
                            <a rel="facebox" href="portal.php?id=' . $row3["product_id"] . '">
                                <img src="images/bgr/' . $row3['product_photo'] . '" width="75px" height="75px" />
                            </a>';
                    echo '<div class="textbox"> ' . $row3['name'] . ' </div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <div id="content_right">
            <form method="post" action="confirm.php" name="abcd" onsubmit="return validateForm()">
                <input name="id" type="hidden" value="<?php echo $_SESSION['SESS_MEMBER_ID']; ?>" />
                <input name="transactioncode" type="hidden" value="<?php echo $_SESSION['SESS_FIRST_NAME']; ?>" />

                <h2>Order Details</h2>
                <table width="335" border="1" style="border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #ccc; text-align: center; font-weight: bold;">
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('connection.php'); // Ensure connection is included
                        $memid = $_SESSION['SESS_FIRST_NAME'];
                        $resulta = mysqli_query($conn, "SELECT * FROM orderditems WHERE transactioncode = '$memid'");

                        while ($row = mysqli_fetch_assoc($resulta)) {
                            echo '<tr style="color: black;">
                                    <td>' . $row['name'] . '</td>
                                    <td>' . $row['quantity'] . '</td>
                                    <td>' . $row['price'] . '</td>
                                    <td>' . $row['total'] . '</td>
                                    <td><a href="deleteorder.php?id=' . $row["id"] . '">Cancel</a></td>
                                </tr>';
                        }
                        ?>
                        <tr style="font-weight: bold; color: black;">
                            <td colspan="3" style="text-align: right;">Grand Total:</td>
                            <td colspan="2">
                                <?php
                                $result = mysqli_query($conn, "SELECT SUM(total) AS total FROM orderditems WHERE transactioncode = '$memid'");
                                $rows = mysqli_fetch_assoc($result);
                                echo '<input name="total" type="text" size="10" value="' . ($rows['total'] ?? '0') . '" readonly />';
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <br>
                <table width="273" border="0">
                    <tr>
                        <td><strong><h3 style="color: black;">Student Num: </h3></strong></td>
                        <td><input type="text" name="num"></td>
                    </tr>        
                    <tr>
                        <td colspan="2">
                            <label>
                                <input type="checkbox" name="checkbox" value="checkbox" />
                                I Agree To The <a rel="facebox" href="terms.php">Terms and Conditions</a>
                            </label>
                        </td>
                    </tr>
                </table>

                <br>
                <input type="submit" value="Confirm Order" />
            </form>
        </div>
    </div>

    <div id="footer">
        <div class="middle">Copyright © Wings Cafe 2023</div>
    </div>
</div>

</body>
</html>