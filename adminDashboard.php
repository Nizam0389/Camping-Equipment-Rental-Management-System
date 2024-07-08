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
$active_customers = $dbCon->query("SELECT COUNT(DISTINCT c.cust_id) FROM customer c JOIN rent r ON c.cust_id = r.cust_id WHERE r.rent_status = 1")->fetch_row()[0];
$available_equipment = $dbCon->query("SELECT SUM(item_quantity) FROM Item")->fetch_row()[0];
$rented_equipment = $dbCon->query("SELECT SUM(rd.RD_quantity) FROM rentaldetail rd JOIN rent r ON rd.rent_id = r.rent_id WHERE r.rent_status = 1")->fetch_row()[0];

$dbCon->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/adminDashboard.css">
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
                    <a href="staffAccountSetting.php">Profile</a>
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
                    <div class="stat-title">rentED EQUIPMENT</div>
                    <div class="stat-value"><?php echo $rented_equipment; ?></div>
                </div>
            </div>
        </div>
        <div class="action-container">
            <h2 class="title-page">ACTION</h2>
            <div class="actions">
                <a href="customerList.php" class="action-link">
                    <div class="action">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                        </svg>
                        <div class="action-title">CUSTOMER</div>
                    </div>
                </a>
                <a href="itemList.php" class="action-link">
                    <div class="action">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-box2-fill" viewBox="0 0 16 16">
                            <path d="M3.75 0a1 1 0 0 0-.8.4L.1 4.2a.5.5 0 0 0-.1.3V15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4.5a.5.5 0 0 0-.1-.3L13.05.4a1 1 0 0 0-.8-.4zM15 4.667V5H1v-.333L1.5 4h6V1h1v3h6z"/>
                        </svg>
                        <div class="action-title">ITEM</div>
                    </div>
                </a>
                <a href="report.php" class="action-link">
                    <div class="action">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-bar-graph-fill" viewBox="0 0 16 16">
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m.5 10v-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5m-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5z"/>
                        </svg>
                        <div class="action-title">REPORT</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
