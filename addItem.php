<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'staff') {
    header("location: login.php");
    exit;
}
$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
    <link rel="stylesheet" type="text/css" href="css/addItem.css">
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="index.php">CUSTOMER</a></li>
            <li><a href="itemList.php">ITEM</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="contactus.php">CONTACT US</a></li>
            <li class="right"><a href="login.php"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2 class="title-page">- ADD ITEM -</h2>
        <div class="container">
            <form action="process-add-item.php" method="post" enctype="multipart/form-data">
                <label for="itemName">Item Name</label>
                <input type="text" id="itemName" name="itemName" required>

                <label for="itemType">Item Type</label>
                <select id="itemType" name="itemType" required>
                    <option value="tent">Tent</option>
                    <option value="accessory">Accessory</option>
                    <option value="cooking set">Cooking Set</option>
                    <option value="bed">Bed</option>
                    <option value="table">Table</option>
                </select>

                <label for="itemFee">Fee</label>
                <input type="number" step="0.01" id="itemFee" name="itemFee" required>

                <label for="itemQuantity">Quantity</label>
                <input type="number" id="itemQuantity" name="itemQuantity" required>

                <label for="itemImage">Item Image</label>
                <input type="file" id="itemImage" name="itemImage" required>

                <button type="submit" class="save-button">Save</button>
            </form>
        </div>
    </div>
</body>
</html>
