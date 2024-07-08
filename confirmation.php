<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm rental</title>
    <link rel="stylesheet" type="text/css" href="css/payment.css">
    <script src="js/confirmation.js" defer></script>
    <script src="js/rental-calculator.js" defer></script>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="homepage.php">HOMEPAGE</a></li>
            <li><a href="category.php">rentAL</a></li>
            <li class="logo"><a href="logout.php"><img src="image/logo.png" alt="logo"></a></li>
            <li class="right"><a href="contactus.php">CONTACT US</a></li>
            <li class="right"><a href="login.php"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2 class="title-page">- CONFIRM rentAL -</h2>
        <div class="cart-container">
            <div class="cart-details">
                <h3>rental Details</h3>
                <div class="rental-dates">
                    <label for="start-date">Start Date:</label>
                    <input type="date" id="start-date" name="start-date" required>
                    
                    <label for="end-date">Return Date:</label>
                    <input type="date" id="end-date" name="end-date" required>
                </div>
                <table class="cart-table" id="cart-items-container">
                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th>PRICE PER DAY</th>
                            <th>QUANTITY</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        <!-- Cart items will be populated here -->
                    </tbody>
                </table>
                <div class="rental-summary">
                    <p>Number of days: <span id="num-days">0</span></p>
                    <p>Total Price: <span id="total-price">RM 0.00</span></p> <!-- Added total price display -->
                </div>
                <button type="button" class="confirm-rent-button" onclick="confirmAndProceed()">Confirm and Proceed to Payment</button>
            </div>
        </div>
    </div>
</body>
</html>