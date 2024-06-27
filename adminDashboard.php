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
            <li><a href="index.php">CUSTOMER</a></li>
            <li><a href="itemList.php">ITEM</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="contactus.php">CONTACT US</a></li>
            <li class="right">
                <?php if ($username == 'S001') : ?>
                    <button name="addStaff" onclick="window.location.href='addStaff.php'">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Add Staff
                    </button>
                <?php endif; ?>
            </li>
            <li class="right"><a href="javascript:void(0);" onclick="confirmLogout()"><img src="image/profilebg.png" alt="Logout" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="statistic-container">
            <h2 class="title-page">STATISTIC</h2>
            <div class="statistics">
                <?php
                $total_customers = 45;
                $active_customers = 37;
                $available_equipment = 124;
                $rented_equipment = 80;
                ?>
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
