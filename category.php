<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>SYAKIRI CAMPING</title>
    <link rel="stylesheet" type="text/css" href="css/category.css">
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
            <li><a href="homepage.php">HOMEPAGE</a></li>
            <li><a href="contactus.php">CONTACT US</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="cart"><a href="#"><img src="image/cart1.png" alt="Cart"></a></li>
            <li class="right"><span class="username"><?php echo $username; ?></span></li>
            <li class="right"><a href="javascript:void(0);" onclick="confirmLogout()"><img src="image/profilebg.png" alt="Logout" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="category-container">
            <h2>- CATEGORY -</h2>
            <div class="category-items">
                <a href="tentList.php" class="category-item">
                    <img src="image/tent icon.jpeg" alt="Tent">
                    <p>tent</p>
                </a>
                <a href="accessoryList.php" class="category-item">
                    <img src="image/accessoryIcon.jpeg" alt="Accessory">
                    <p>accessory</p>
                </a>
                <a href="cookingList.php" class="category-item">
                    <img src="image/CookingSetIcon.jpeg" alt="Cooking Set">
                    <p>cooking set</p>
                </a>
                <a href="bedList.php" class="category-item">
                    <img src="image/bedIcon.png" alt="Bed">
                    <p>bed</p>
                </a>
                <a href="tableList.php" class="category-item">
                    <img src="image/tableIcon.png" alt="Table">
                    <p>table</p>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
