<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$itemType = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';

if (empty($itemType)) {
    echo "Invalid item type.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($itemType); ?> List</title>
    <link rel="stylesheet" href="css/list.css">
</head>
<body class="">

<div class="navbar1">
    <div class="navbar">
        <ul>
            <li><a href="homepage.php">HOMEPAGE</a></li>
            <li><a href="category.php">RENTAL</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><span class="username"><?php echo $username; ?></span></li>
            <li class="right"><a href="javascript:void(0);" onclick="confirmLogout()"><img src="image/profilebg.png" alt="Logout" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
</div>

<div class="container">
    <header>
        <div class="title"><?php echo ucfirst($itemType); ?> List</div>
        
        <div class="dropdown">
            <a class="icon">Category
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-square-fill" viewBox="0 0 16 16">
                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm4 4a.5.5 0 0 0-.374.832l4 4.5a.5.5 0 0 0 .748 0l4-4.5A.5.5 0 0 0 12 6z"/>
                </svg>
            </a>
            <div class="dropdown-content">
                <a href="ListTent.php">Tent</a>
                <a href="ListAccessory.php">Accessory</a>
                <a href="ListCooking.php">Cooking Set</a>
                <a href="ListBed.php">Bed</a>
                <a href="ListTable.php">Table</a>
            </div>
        </div>

        <div class="icon-cart">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
            </svg>
            <span>0</span>
        </div>
    </header>
    <div class="listProduct">
        <!-- Product list goes here -->
    </div>
</div>
<div class="cartTab">
    <h1>Shopping Cart</h1>
    <div class="listCart">
        
    </div>
    <div class="btn">
        <button class="close">CLOSE</button>
        <button>
            <a class="checkOut" href="confirmation.php">Check Out</a>
        </button>
    </div>
</div>

<div id="successModal" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Item successfully added to cart!</p>
        <button id="closeModal">Close</button>
    </div>
</div>

<script src="app.js?type=<?php echo urlencode($itemType); ?>"></script>
</body>
</html>
