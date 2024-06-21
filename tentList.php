<!DOCTYPE html>
<html>
<head>
    <title>SYAKIRI CAMPING</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .navbar {
            background-color: #4F6F52;
            overflow: hidden;
        }
        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
        }
        .navbar li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 18px;
            position: relative;
        }
        .navbar li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: transparent;
            transform: scaleX(0);
            transition: transform 0.3s ease-in-out;
        }
        .navbar li a:hover::after {
            background-color: white;
            transform: scaleX(1);
        }
        .navbar li.logo {
            flex-grow: 1;
            text-align: center;
        }
        .navbar li.logo img {
            border-radius: 50%;
            padding: 5px;
            background-color: #fff;
            height: 30px;
        }
        .navbar li.cart img, .navbar li.right img {
            border-radius: 50%;
            padding: 5px;
            height: 30px;
            width: auto;
        }
        .main-content {
            background-color: #F5EFE6;
            min-height: 100vh;
            margin-top: -2%;
        }
        .main-content h2 {
            padding-top: 2%;
        }
        .title-page {
            text-align: center;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }
        .item-card {
            background-color: #1A4D2E;
            color: #fff;
            padding: 20px;
            margin: 10px;
            text-align: center;
            border-radius: 10%;
            width: 20%;
        }
        .item-card img {
            max-width: 100%;
            height: auto;
        }
        .item-card a {
            color: white;
        }
        .shopping-cart {
            position: fixed;
            right: 0;
            top: 0;
            width: 300px;
            height: 100%;
            background: #8B5E3C;
            color: white;
            padding: 20px;
            display: none; /* Hidden by default */
            flex-direction: column;
            justify-content: space-between;
        }
        .shopping-cart h2 {
            margin-top: 0;
        }
        .shopping-cart .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .shopping-cart .cart-item img {
            width: 50px;
        }
        .shopping-cart .total {
            font-weight: bold;
        }
        .shopping-cart .buttons {
            display: flex;
            justify-content: space-between;
        }
        .shopping-cart .buttons button {
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        .shopping-cart .buttons button#rent-now {
            background-color: yellow;
            color: black;
        }
    </style>
    <script>
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
            <li><a href="index.php">HOMEPAGE</a></li>
            <li><a href="category.php">RENTAL</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="contactus.php">CONTACT US</a></li>
            <li class="cart"><a href="#"><img src="image/cart1.png" alt="Cart"></a></li>
            <li class="right"><a href="login.php"><img src="image/profilebg.png" alt="Login"></a></li>
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
