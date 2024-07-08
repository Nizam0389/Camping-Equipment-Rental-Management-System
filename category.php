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
    <link rel="stylesheet" type="text/css" href="css/category.css">
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
<body>
    <?php include 'navbar.php'; ?>
    <div class="main-content">
        <div class="category-container">
            <h2>- CATEGORY -</h2>
            <div class="category-items">
                <a href="ListTent.php" class="category-item">
                    <img src="image/tent icon.jpeg" alt="Tent">
                    <p>tent</p>
                </a>
                <a href="ListAccessory.php" class="category-item">
                    <img src="image/accessoryIcon.jpeg" alt="Accessory">
                    <p>accessory</p>
                </a>
                <a href="ListCooking.php" class="category-item">
                    <img src="image/CookingSetIcon.jpeg" alt="Cooking Set">
                    <p>cooking set</p>
                </a>
                <a href="ListBed.php" class="category-item">
                    <img src="image/bedIcon.png" alt="Bed">
                    <p>bed</p>
                </a>
                <a href="ListTable.php" class="category-item">
                    <img src="image/tableIcon.png" alt="Table">
                    <p>table</p>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
