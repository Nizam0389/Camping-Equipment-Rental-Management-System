<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm rental</title>
    <link rel="stylesheet" type="text/css" href="css/confirmation.css">
    <script src="js/confirmation.js" defer></script>
    <script src="js/rental-calculator.js" defer></script>
    <style>
        .confirm-rent-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #4CAF50; /* Green background */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .confirm-rent-button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="main-content">
        <h2 class="title-page">- CONFIRM RENTAL -</h2>
        <div class="cart-container">
            <div class="cart-details">
                <h3>Rental Details</h3>
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
                <button type="button" class="pay-button" style="background-color:#34A853;" onclick="confirmAndProceed()">Confirm and Proceed to Payment</button>
            </div>
        </div>
    </div>
</body>
</html>