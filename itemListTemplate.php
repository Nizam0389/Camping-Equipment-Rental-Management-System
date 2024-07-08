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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will be logged out',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Logging Out!',
                        text: 'You are being logged out.',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    setTimeout(() => {
                        window.location.href = 'logout.php';
                    }, 1000);
                }
            });
        }
    </script>
</head>
<body class="">

<?php include 'navbar.php'; ?>

<div class="container">
    <header>
        <div class="title"><?php echo ucfirst($itemType); ?> List</div>
        
        <div class="dropdown">
            <a class="icon" style="display: flex">Category
                <svg style="margin-top: 10px" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-square-fill" viewBox="0 0 16 16">
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
        <button class="close" style="color: black">Close</button>
        <button style="color: black">
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