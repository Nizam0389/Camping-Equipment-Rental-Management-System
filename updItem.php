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
    <script>
        function confirmLogout() {
            var result = confirm("Do you want to log out?");
            if (result) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</head>
<body>
<div class="navbar">
        <ul>
            <li><a href="adminDashboard.php">HOME</a></li>
            <li><a href="customerList.php">CUSTOMER</a></li>
            <li><a href="itemList.php">ITEM</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="contactUsAdmin.php">CONTACT US</a></li>
            <li class="right">
                <?php if ($username == 'S001') : ?>
                    <a href="addStaff.php" class="add-staff-link">
                        <i aria-hidden="true"></i>
                        ADD STAFF
                    </a>
                <?php endif; ?>
            </li>
            <li class="right profile-dropdown">
                <a href="javascript:void(0);">
                    <img src="image/profilebg.png" alt="Profile" style="height:20%; width:30px;">
                </a>
                <div class="dropdown-content">
                    <a href="staffDetail.php">Profile</a>
                    <a href="javascript:void(0);" onclick="confirmLogout()">Logout</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <h2 class="title-page">- ADD ITEM -</h2>
        <div class="container">
            <form action="process-add-item.php" method="post" enctype="multipart/form-data" class="form-background">
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
