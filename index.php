<?php
session_start();
$loggedin = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$username = $loggedin ? htmlspecialchars($_SESSION["username"]) : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYAKIRI CAMPING</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="navbar">
        <ul class="navbar-links">
            <li><a href="<?php echo $loggedin ? 'category.php' : '#'; ?>" <?php if(!$loggedin) echo 'onclick="showLoginPopup(event)"'; ?>>rentAL</a></li>
            <li><a href="contactUsGuest.php">CONTACT US</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="<?php echo $loggedin ? 'profile.php' : 'login.php'; ?>"><img src="image/profilebg.png" alt="Profile" style="height:20px; width:30px;"></a></li>
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

    <div class="popup js_basic-popup">
        <div class="popup__background"></div>
        <div class="popup__content">
            <h3 class="popup__content__title">Login Required</h3>
            <p>You need to login first to access this section.</p>
            <p>
                <button class="button" onclick="closePopup()">Close</button>
                <a href="login.php" class="button">Login</a>
            </p>
        </div>
    </div>

    <script>
        function showLoginPopup(event) {
            event.preventDefault();
            document.querySelector('.js_basic-popup').classList.add('popup--visible');
        }

        function closePopup() {
            document.querySelector('.js_basic-popup').classList.remove('popup--visible');
        }

        $(document).ready(function() {
            $('.popup__background').click(closePopup);
        });
    </script>
</body>
</html>