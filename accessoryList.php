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

        function addToCart(itemId, itemName, itemPrice) {
            var cartItems = document.querySelector('.cart-items');
            var item = document.createElement('div');
            item.classList.add('cart-item');
            item.innerHTML = `
                <img src="image/tent image/${itemId}.png" alt="${itemName}">
                <span>${itemName}</span>
                <span>RM${itemPrice}</span>
                <input type="number" value="1" min="1" onchange="updateTotal()">
            `;
            cartItems.appendChild(item);
            document.querySelector('.shopping-cart').style.display = 'block';
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
        <h2 class="title-page">- RENT ACCESSORIES WITH US -</h2>
        <div class="container">
            <div class="item-card">
                <img src="image/accessory image/ground sheet.png" alt="Groundsheet">
                <h3>Groundsheet</h3>
                <p>RM10 per day</p>
                <button onclick="addToCart('ground_sheet', 'Groundsheet', 10)">add to cart</button>
            </div>
            <div class="item-card">
                <img src="image/accessory image/low-folding-camping-chair-removebg-preview.png" alt="Low Folding Camping Chair">
                <h3>Low Folding Camping Chair</h3>
                <p>RM10 per day</p>
                <button onclick="addToCart('low_folding_camping_chair', 'Low Folding Camping Chair', 10)">add to cart</button>
            </div>
            <div class="item-card">
                <img src="image/accessory image/large-folding-camping-chair-basic-xl-quechua-8575772-removebg-preview.png" alt="Large Folding Camping Chair">
                <h3>Large Folding Camping Chair</h3>
                <p>RM15 per day</p>
                <button onclick="addToCart('large_folding_camping_chair', 'Large Folding Camping Chair', 15)">add to cart</button>
            </div>
        </div>
        <div class="container">
            <div class="item-card">
                <img src="image/accessory image/camping lamp.png" alt="Camping Lamp rechargeable">
                <h3>Camping Lamp rechargeable</h3>
                <p>RM5 per day</p>
                <button onclick="addToCart('camping_lamp', 'Camping Lamp rechargeable', 5)">add to cart</button>
            </div>
            <div class="item-card">
                <img src="image/accessory image/Torch.png" alt="Torch Light">
                <h3>Torch Light</h3>
                <p>RM1 per day</p>
                <button onclick="addToCart('torch_light', 'Torch Light', 1)">add to cart</button>
            </div>
            <div class="item-card">
                <img src="image/accessory image/rope.png" alt="Multipurpose Rope (10m)">
                <h3>Multipurpose Rope (10m)</h3>
                <p>RM2 per day</p>
                <button onclick="addToCart('rope', 'Multipurpose Rope (10m)', 2)">add to cart</button>
            </div>
        </div>
    </div>
</body>
</html>
