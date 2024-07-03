<?php
require_once 'dbConnect.php';

// Fetch current contact information from the database
$sql = "SELECT comp_phoneNo, comp_email, comp_address, comp_webAdd FROM contactUS";
$result = mysqli_query($dbCon, $sql);
$contact = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" type="text/css" href="css/contactUs.css">
</head>
<body>
    <header>
        <div class="navbar">
            <ul>
                <li><a href="index.php">HOMEPAGE</a></li>
                <li class="logo"><img src="image/logo.png" alt="logo"></li>
                <li class="right"><a href="contactUsGuest.php">CONTACT US</a></li>
                <li class="right"><a href="login.php"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
                </ul>
        </div>
    </header>
    <main>
        <div class="contact-section">
            <h2>- GET IN TOUCH WITH US -</h2>
            <div class="contact-container">
                <div class="contact-image">
                    <img src="image/contactUs.jpg" alt="Tent">
                </div>
                <div class="contact-info">
                    <p><img src="image/phone.png" alt="phone"><?php echo htmlspecialchars($contact['comp_phoneNo']); ?></p>
                    <p><img src="image/email.png" alt="email"><?php echo htmlspecialchars($contact['comp_email']); ?></p>
                    <p><img src="image/location.png" alt="location"><?php echo htmlspecialchars($contact['comp_address']); ?></p>
                    <p><img src="image/website.png" alt="website"><?php echo htmlspecialchars($contact['comp_webAdd']); ?></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
