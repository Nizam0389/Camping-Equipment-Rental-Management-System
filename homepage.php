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
    <title>SYAKIRI CAMPING</title>
    <link rel="stylesheet" type="text/css" href="css/homepage.css">
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
            <li><a href="category.php">RENTAL</a></li>
            <li><a href="contactUs.php">CONTACT US</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><span class="username"><?php echo $username; ?></span></li>
            <li class="right"><a href="javascript:void(0);" onclick="confirmLogout()"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="info-box">
            <h1>SYAKIRI CAMPING</h1>
            <p>"SYAKIRI CAMPING" is your one stop destination for all your
                Camping equipment rental needs. We offer a wide range of high
                quality camping gear, including tents, sleeping bags, cooking
                equipment, hiking gear, and more. Whether you're planning a
                weekend getaway or a longer outdoor adventure, our company
                ensures that you have everything you need to make your
                camping experience comfortable and enjoyable. With affordable
                rental rates and convenient pickup/delivery options, "SYAKIRI
                CAMPING" is committed to helping you make the most of your 
                outdoor adventures without the hassle of buying and storing equipment.
            </p>
        </div>
        <div class="biglogo">
            <img src="image/logo.png" alt="Big Logo">
        </div>
    </div>
</body>
</html>
