<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'staff') {
    header("location: login.php");
    exit;
}
$username = $_SESSION["username"];

include 'dbConnect.php';

// Fetch statistics from the database
$total_customers = $dbCon->query("SELECT COUNT(*) FROM customer")->fetch_row()[0];
$active_customers = $dbCon->query("SELECT COUNT(DISTINCT c.cust_id) FROM customer c JOIN Rent r ON c.cust_id = r.cust_id WHERE r.rent_status = 1")->fetch_row()[0];
$available_equipment = $dbCon->query("SELECT SUM(item_quantity) FROM Item")->fetch_row()[0];
$rented_equipment = $dbCon->query("SELECT SUM(rd.RD_quantity) FROM RentalDetail rd JOIN Rent r ON rd.rent_id = r.rent_id WHERE r.rent_status = 1")->fetch_row()[0];

$dbCon->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/adminDashboard.css">
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
        <div class="statistic-container">
            <h2 class="title-page">STATISTIC</h2>
            <div class="statistics">
                <div class="stat">
                    <div class="stat-title">TOTAL CUSTOMER</div>
                    <div class="stat-value"><?php echo $total_customers; ?></div>
                </div>
                <div class="stat">
                    <div class="stat-title">ACTIVE CUSTOMER</div>
                    <div class="stat-value"><?php echo $active_customers; ?></div>
                </div>
                <div class="stat">
                    <div class="stat-title">AVAILABLE EQUIPMENT</div>
                    <div class="stat-value"><?php echo $available_equipment; ?></div>
                </div>
                <div class="stat">
                    <div class="stat-title">RENTED EQUIPMENT</div>
                    <div class="stat-value"><?php echo $rented_equipment; ?></div>
                </div>
            </div>
        </div>
        <div class="action-container">
            <h2 class="title-page">ACTION</h2>
            <div class="actions">
                <div class="action">
                    <img src="image/customer-icon.png" alt="Customer">
                    <div class="action-title">CUSTOMER</div>
                </div>
                <div class="action">
                    <img src="image/inventory-icon.png" alt="Inventory">
                    <div class="action-title">INVENTORY</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
