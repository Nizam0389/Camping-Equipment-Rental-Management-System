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
    <link rel="stylesheet" type="text/css" href="css/ItemList.css">
    <script>
        function confirmLogout() {
            var result = confirm("Do you want to log out?");
            if (result) {
                window.location.href = 'logout.php';
            }
        }

        function addToCart(itemId, itemName, itemPrice) {
            var cartItems = document.querySelector('.listCart');
            var item = document.createElement('div');
            item.classList.add('item');
            item.innerHTML = `
                <img src="image/cooking set image/${itemId}.png" alt="${itemName}">
                <span>${itemName}</span>
                <span>RM${itemPrice}</span>
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
            border-radius: 10%;
        }

        .cartTab .close {
            background-color: #eee;
            color: black;
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

        .totalAmount {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn {
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 10px;
            border: none;
            background-color: #DBFFBF;
            cursor: pointer;
            border-radius: 10%;
        }

        button:hover {
            background-color: #45a049;
        }
    </s

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
        <h2 class="title-page">- RENT COOKING SET WITH US -</h2>
        <div class="container">
            <div class="item-card">
                <img src="image/cooking set image/portable_mini_stove.png" alt="Portable Mini Stove">
                <h3>Portable Mini Stove</h3>
                <p>RM2 per day</p>
                <button onclick="addToCart('portable_mini_stove', 'Portable Mini Stove', 2)">Add to Cart</button>
            </div>
            <div class="item-card">
                <img src="image/cooking set image/cooking_set.png" alt="Camping Cook Set">
                <h3>Camping Cook Set</h3>
                <p>RM10 per day</p>
                <button onclick="addToCart('cooking_set', 'Camping Cook Set', 10)">Add to Cart</button>
            </div>
            <div class="item-card">
                <img src="image/cooking set image/Titanium_Pot.png" alt="Titanium Pot and Cup">
                <h3>Titanium Pot and Cup</h3>
                <p>RM3 per day</p>
                <button onclick="addToCart('Titanium_Pot', 'Titanium Pot and Cup', 3)">Add to Cart</button>
            </div>
        </div>
        <div class="container">
            <div class="item-card">
                <img src="image/cooking set image/ceramic_2_pot.png" alt="Ceramic 2-Pot">
                <h3>Ceramic 2-Pot</h3>
                <p>RM5 per day</p>
                <button onclick="addToCart('ceramic_2_pot', 'Ceramic 2-Pot', 5)">Add to Cart</button>
            </div>
            <div class="item-card">
                <img src="image/cooking set image/camping_utensil.png" alt="Cooking Utensil">
                <h3>Cooking Utensil</h3>
                <p>RM2 per day</p>
                <button onclick="addToCart('camping_utensil', 'Cooking Utensil', 2)">Add to Cart</button>
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
