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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYAKIRI CAMPING</title>
    <link rel="stylesheet" type="text/css" href="css/tentList.css">
    <script>
        function confirmLogout() {
            var result = confirm("Do you want to log out?");
            if (result) {
                window.location.href = 'logout.php';
            }
        }

        function addToCart(tentId, tentName, tentPrice) {
            var cartItems = document.querySelector('.listCart');
            var item = document.createElement('div');
            item.classList.add('item');
            item.innerHTML = `
                <img src="image/tent image/${tentId}.png" alt="${tentName}">
                <span>${tentName}</span>
                <span>RM${tentPrice}</span>
                <div class="quantity">
                    <span onclick="changeQuantity(this, 'decrease')">-</span>
                    <span>1</span>
                    <span onclick="changeQuantity(this, 'increase')">+</span>
                </div>
            `;
            cartItems.appendChild(item);
            document.querySelector('.cartTab').style.right = '0';
            updateTotal();
        }

        function updateTotal() {
            var total = 0;
            document.querySelectorAll('.listCart .item').forEach(function(item) {
                var price = parseFloat(item.children[2].innerText.replace('RM', ''));
                var quantity = parseInt(item.querySelector('.quantity span:nth-child(2)').innerText);
                total += price * quantity;
            });
            document.querySelector('.totalAmount').innerText = 'RM' + total.toFixed(2);
        }

        function changeQuantity(element, action) {
            var quantitySpan = element.parentElement.children[1];
            var quantity = parseInt(quantitySpan.innerText);
            if (action === 'increase') {
                quantity++;
            } else if (action === 'decrease' && quantity > 1) {
                quantity--;
            }
            quantitySpan.innerText = quantity;
            updateTotal();
        }

        function closeCart() {
            document.querySelector('.cartTab').style.right = '-400px';
        }
    </script>
    <style>
    body {
        margin: 0;
        font-family: Poppins, sans-serif;
    }

    .navbar1{
        height: 80px;
        background-color: #1A4D2E;
    }

    .navbar ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        display: flex;
        align-items: center;
    }

    .navbar li {
        float: left;
    }

    .navbar li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    .navbar li a:hover {
        background-color: #111;
    }

    .navbar .logo img {
        height: 40px;
        width: auto;
    }

    .navbar .logo {
        margin-left: auto;
        margin-right: auto;
    }

    .navbar .right {
        margin-left: auto;
        display: flex;
        align-items: center;
    }

    .main-content {
        padding: 20px;
    }

    .container {
        width: 900px;
        margin: auto;
        max-width: 90vw;
        text-align: center;
        padding-top: 10px;
        transition: transform .5s;
    }

    .item-card {
        display: inline-block;
        margin: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 10px;
        width: 200px;
    }

    .item-card img {
        width: 100%;
    }

    .item-card button {
        background-color: #353432;
        color: #eee;
        border: none;
        padding: 5px 10px;
        margin-top: 10px;
        border-radius: 20px;
        cursor: pointer;
    }

    .cartTab {
        width: 400px;
        background-color: #353432;
        color: #eee;
        position: fixed;
        top: 0;
        right: -400px;
        bottom: 0;
        display: grid;
        grid-template-rows: 70px 1fr 70px;
        transition: .5s;
    }

    .cartTab h1 {
        padding: 20px;
        margin: 0;
        font-weight: 300;
    }

    .cartTab .btn {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }

    .cartTab button {
        padding: 20px;
        background-color: #E8BC0E;
        border: none;
        font-family: Poppins, sans-serif;
        font-weight: 500;
        cursor: pointer;
    }

    .cartTab .close {
        background-color: #eee;
    }

    .listCart .item img {
        width: 100%;
    }

    .listCart .item {
        display: grid;
        grid-template-columns: 70px 150px 50px 1fr;
        gap: 10px;
        text-align: center;
        align-items: center;
    }

    .listCart .quantity span {
        display: inline-block;
        width: 25px;
        height: 25px;
        background-color: #eee;
        border-radius: 50%;
        color: #555;
        cursor: pointer;
    }

    .listCart .quantity span:nth-child(2) {
        background-color: transparent;
        color: #eee;
        cursor: auto;
    }

    .listCart .item:nth-child(even) {
        background-color: #eee1;
    }

    .listCart {
        overflow: auto;
    }

    .listCart::-webkit-scrollbar {
        width: 0;
    }

    @media only screen and (max-width: 992px) {
        .listProduct {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media only screen and (max-width: 768px) {
        .listProduct {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    </style>
</head>
<body>
    <div class="navbar1">
        <div class="navbar">
            <ul>
                <li><a href="homepage.php">HOMEPAGE</a></li>
                <li><a href="category.php">RENTAL</a></li>
                <li class="logo"><img src="image/logo.png" alt="logo"></li>
                <li class="cart right"><a href="javascript:void(0);" onclick="document.querySelector('.cartTab').style.right = '0';"><img src="image/cart1.png" alt="Cart"></a></li>
                <li class="right"><span class="username"><?php echo $username; ?></span></li>
                <li class="right"><a href="javascript:void(0);" onclick="confirmLogout()"><img src="image/profilebg.png" alt="Logout" style="height:20%; width:30px;"></a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <h2 class="title-page">- RENT TENT WITH US -</h2>
        <div class="container">
            <div class="item-card">
                <img src="image/tent image/2_person_pop_tent.png" alt="Compact 2 Person Popup Tent">
                <h3>Compact 2 Person Popup Tent</h3>
                <p>RM55 per day</p>
                <button onclick="addToCart('2_person_pop_tent', 'Compact 2 Person Popup Tent', 55)">Add to Cart</button>
            </div>
            <div class="item-card">
                <img src="image/tent image/single_person_tent-removebg-preview.png" alt="Single Person Tent">
                <h3>Single Person Tent</h3>
                <p>RM25 per day</p>
                <button onclick="addToCart('single_person_tent', 'Single Person Tent', 25)">Add to Cart</button>
            </div>
            <div class="item-card">
                <img src="image/tent image/5_person_tent.png" alt="3-5 Person Camping Tent">
                <h3>3-5 Person Camping Tent</h3>
                <p>RM180 per day</p>
                <button onclick="addToCart('5_person_tent', '3-5 Person Camping Tent', 180)">Add to Cart</button>
            </div>
        </div>
        <div class="container">
            <div class="item-card">
                <img src="image/tent image/5-8_person_tent.png" alt="5-8 Person Camping Tent">
                <h3>5-8 Person Camping Tent</h3>
                <p>RM200 per day</p>
                <button onclick="addToCart('5_8_person_tent', '5-8 Person Camping Tent', 200)">Add to Cart</button>
            </div>
            <div class="item-card">
                <img src="image/tent image/12_person_tent-removebg-preview.png" alt="12 Person Camping Tent">
                <h3>12 Person Camping Tent</h3>
                <p>RM350 per day</p>
                <button onclick="addToCart('12_person_tent', '12 Person Camping Tent', 350)">Add to Cart</button>
            </div>
        </div>
    </div>
    <div class="cartTab">
        <h1>Shopping Cart</h1>
        <div class="listCart"></div>
        <div class="totalAmount">RM0.00</div>
        <div class="btn">
            <button class="close" onclick="closeCart()">CLOSE</button>
            <button class="checkOut">Check Out</button>
        </div>
    </div>
</body>
</html>
