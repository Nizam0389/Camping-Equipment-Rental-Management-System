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
        <h2 class="title-page">- RENT COOKING SET WITH US -</h2>
        <div class="container">
            <div class="item-card">
                <img src="image/cooking set image/portable mini stove.png">
                <h3>Portable Mini Stove</h3>
                <p>R2 per day</p>
                <a href="addToCart.html">add to cart</a>
            </div>
            <div class="item-card">
                <img src="image/cooking set image/cooking_set-removebg-preview.png">
                <h3>Camping Cook Set</h3>
                <p>RM10 per day</p>
                <a href="addToCart.html">add to cart</a>
            </div>
            <div class="item-card">
                <img src="image/cooking set image/Titanium_Pot-removebg-preview.png">
                <h3>Titanium Pot and Cup</h3>
                <p>RM3 per day</p>
                <a href="addToCart.html">add to cart</a>
            </div>
        </div>
        <div class="container">
            <div class="item-card">
                <img src="image/cooking set image/ceramic_2_pot-removebg-preview.png">
                <h3>Ceramic 2-Pot</h3>
                <p>RM5 per day</p>
                <a href="addToCart.html">add to cart</a>
            </div>
            <div class="item-card">
                <img src="image/cooking set image/camping_utensil-removebg-preview.png">
                <h3>Cooking Utensil</h3>
                <p>RM2 per day</p>
                <a href="addToCart.html">add to cart</a>
            </div>
        </div>
    </div>
</body>
</html>