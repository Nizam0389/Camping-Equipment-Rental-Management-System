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
    <link rel="stylesheet" type="text/css" href="css/ItemList.css">
    <script>
        function confirmLogout() {
            var result = confirm("Do you want to log out?");
            if (result) {
                window.location.href = 'logout.php';
            }
        }

        function addToCart(tentId, tentName, tentPrice) {
            var cartItems = document.querySelector('.cart-items');
            var item = document.createElement('div');
            item.classList.add('cart-item');
            item.innerHTML = `
                <img src="image/tent image/${tentId}.png" alt="${tentName}">
                <span>${tentName}</span>
                <span>RM${tentPrice}</span>
                <input type="number" value="1" min="1" onchange="updateTotal()">
            `;
            cartItems.appendChild(item);
            document.querySelector('.shopping-cart').style.display = 'flex';
            updateTotal();
        }

        function updateTotal() {
            var total = 0;
            document.querySelectorAll('.cart-item').forEach(function(item) {
                var price = parseFloat(item.children[2].innerText.replace('RM', ''));
                var quantity = item.children[3].value;
                total += price * quantity;
            });
            document.getElementById('total').innerText = 'RM' + total.toFixed(2);
        }

        function closeCart() {
            document.querySelector('.shopping-cart').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="homepage.php">HOMEPAGE</a></li>
            <li><a href="category.php">RENTAL</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="contactus.php">CONTACT US</a></li>
            <li class="cart"><a href="#"><img src="image/cart1.png" alt="Cart"></a></li>
            <li class="right"><span class="username"><?php echo $username; ?></span></li>
            <li class="right"><a href="javascript:void(0);" onclick="confirmLogout()"><img src="image/profilebg.png" alt="Logout" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2 class="title-page">- RENT TENT WITH US -</h2>
        <div class="container">
            <div class="item-card">
                <img src="image/tent image/2 person pop tent.png" alt="Compact 2 Person Popup Tent">
                <h3>Compact 2 Person Popup Tent</h3>
                <p>RM55 per day</p>
                <button onclick="addToCart('2_person_pop_tent', 'Compact 2 Person Popup Tent', 55)">add to cart</button>
            </div>
            <div class="item-card">
                <img src="image/tent image/single_person_tent-removebg-preview.png" alt="Single Person Tent">
                <h3>Single Person Tent</h3>
                <p>RM25 per day</p>
                <button onclick="addToCart('single_person_tent', 'Single Person Tent', 25)">add to cart</button>
            </div>
            <div class="item-card">
                <img src="image/tent image/5 person tent.png" alt="3-5 Person Camping Tent">
                <h3>3-5 Person Camping Tent</h3>
                <p>RM180 per day</p>
                <button onclick="addToCart('5_person_tent', '3-5 Person Camping Tent', 180)">add to cart</button>
            </div>
        </div>
        <div class="container">
            <div class="item-card">
                <img src="image/tent image/5-8 person tent.png" alt="5-8 Person Camping Tent">
                <h3>5-8 Person Camping Tent</h3>
                <p>RM200 per day</p>
                <button onclick="addToCart('5_8_person_tent', '5-8 Person Camping Tent', 200)">add to cart</button>
            </div>
            <div class="item-card">
                <img src="image/tent image/12_person_tent-removebg-preview.png" alt="12 Person Camping Tent">
                <h3>12 Person Camping Tent</h3>
                <p>RM350 per day</p>
                <button onclick="addToCart('12_person_tent', '12 Person Camping Tent', 350)">add to cart</button>
            </div>
        </div>
    </div>
    <div class="shopping-cart" id="shopping-cart">
        <h2>Shopping Cart</h2>
        <div class="cart-items"></div>
        <div class="total">Total: <span id="total">RM0.00</span></div>
        <div class="buttons">
            <button onclick="closeCart()">CLOSE</button>
            <button id="rent-now">RENT NOW</button>
        </div>
    </div>
</body>
</html>