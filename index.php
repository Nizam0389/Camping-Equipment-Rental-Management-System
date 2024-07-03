<?php
session_start();
$loggedin = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$username = $loggedin ? $_SESSION["username"] : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="css/index.css">
    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = 'login.php';
            }
        }

        function checkLogin() {
            <?php if (!$loggedin): ?>
            alert("You need to login first.");
            return false;
            <?php endif; ?>
        }
    </script>
</head>
<body>
    <div class="navbar">
        <ul class="navbar-links">
            <li><a href="category.php" onclick="return checkLogin();">RENTAL</a></li>
            <li><a href="contactUs.php">CONTACT US</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><span class="username"><?php echo htmlspecialchars($username); ?></span></li>
            <li class="right"><a href="javascript:void(0);" onclick="confirmLogout()"><img src="image/profilebg.png" alt="Profile" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="info-box">
            <h1>SYAKIRI CAMPING</h1>
            <p>"SYAKIRI CAMPING" is your one-stop destination for all your camping equipment rental needs. We offer a wide range of high-quality camping gear, including tents, sleeping bags, cooking equipment, hiking gear, and more. Whether you're planning a weekend getaway or a longer outdoor adventure, our company ensures that you have everything you need to make your camping experience comfortable and enjoyable. With affordable rental rates and convenient pickup/delivery options, "SYAKIRI CAMPING" is committed to helping you make the most of your outdoor adventures without the hassle of buying and storing equipment.</p>
        </div>
        <div class="biglogo">
            <img src="image/logo.png" alt="Big Logo">
        </div>
    </div>
</body>
</html>
