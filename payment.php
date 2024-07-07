<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="css/payment.css">
    <script src="js/cart.js" defer></script>
    <script src="js/rental-calculator.js" defer></script>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="index.php">HOMEPAGE</a></li>
            <li><a href="category.php">RENTAL</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="contactus.php">CONTACT US</a></li>
            <li class="right"><a href="login.php"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2 class="title-page">- CART -</h2>
        <div class="cart-container">
            <div class="cart-details">
                <h3>Payment</h3>
                <div class="rental-dates">
                    <label for="start-date">Start Date:</label>
                    <input type="date" id="start-date" name="start-date" required>
                    
                    <label for="end-date">Return Date:</label>
                    <input type="date" id="end-date" name="end-date" required>
                </div>
                <div class="rental-summary">
                    <p>Number of days: <span id="num-days">0</span></p>
                </div>
                <table class="cart-table">
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
            </div>
            <div class="payment-details">
                <h3>Payment</h3>
                <div class="total">
                    <span>Total</span>
                    <span id="total-price">RM 0.00</span>
                </div>
                <h4>Online Banking</h4>
                <form action="process-payment.php" method="post">
                    <label class="radio-container"><input type="radio" name="bank" value="maybank" required><img src="image/bank/maybank.png" alt="Maybank"></label><br>
                    <label class="radio-container"><input type="radio" name="bank" value="bank-islam" required><img src="image/bank/bank-islam.png" alt="Bank Islam"></label><br>
                    <label class="radio-container"><input type="radio" name="bank" value="cimb" required><img src="image/bank/cimb.png" alt="CIMB"></label><br>
                    <label class="radio-container"><input type="radio" name="bank" value="rhb" required><img src="image/bank/rhb.png" alt="RHB"></label><br>
                    <label class="radio-container"><input type="radio" name="bank" value="public-bank" required><img src="image/bank/public-bank.png" alt="Public Bank"></label><br>
                    <label class="radio-container"><input type="radio" name="bank" value="ambank" required><img src="image/bank/ambank.png" alt="AmBank"></label><br>
                    <button type="submit" class="pay-button">Pay Now</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
