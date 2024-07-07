<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'staff') {
    header("location: login.php");
    exit;
}
$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Dashboard</title>
    <link rel="stylesheet" href="css/report.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <h2 class="title-page">Reports</h2>
        <div class="report-buttons">
            <a href="reportCustomerList.php" class="report-button">Customer List</a>
            <a href="reportStaffList.php" class="report-button">Staff List</a>
            <a href="reportMonthlyRent.php" class="report-button">Monthly Rent Report</a>
            <a href="reportItem.php" class="report-button">Item Report</a>
        </div>
    </div>
</body>
</html>
