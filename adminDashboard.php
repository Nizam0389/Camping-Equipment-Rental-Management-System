<?php
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: index.php");
        exit;
    }
    $username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/adminDashboard.css">
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
            <li><a href="category.php">RENTAL</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="contactus.php">CONTACT US</a></li>
            <li class="right"><a href="login.php"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
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
