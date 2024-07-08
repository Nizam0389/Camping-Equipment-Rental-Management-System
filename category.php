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
    <div class="navbar">
        <ul>
            <li><a href="homepage.php">HOMEPAGE</a></li>
            <li><a href="contactus.php">CONTACT US</a></li>
            <li class="logo" style="margin-right: 150px;" ><img src="image/logo.png" alt="logo"></li>
            <li class="right"><span class="username"><?php echo $username; ?></span></li>
            <li class="right profile-dropdown">
                <a href="javascript:void(0);">
                    <img src="image/profilebg.png" alt="Profile" style="height:20%; width:30px;">
                </a>
                <div class="dropdown-content">
                    <a href="staffAccountSetting.php">Profile</a>
                    <a href="javascript:void(0);" onclick="confirmLogout()">Logout</a>
                </div>
            </li>
        </ul>
    </div>
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
