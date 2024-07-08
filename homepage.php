<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'customer') {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYAKIRI CAMPING</title>
    <link rel="stylesheet" href="css/homepage.css">
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
        <div class="info-box">
            <p>"SYAKIRI CAMPING" is your one stop destination for all your
                Camping equipment rental needs. We offer a wide range of high
                quality camping gear, including tents, sleeping bags, cooking
                equipment, hiking gear, and more. Whether you're planning a
                weekend getaway or a longer outdoor adventure, our company
                ensures that you have everything you need to make your
                camping experience comfortable and enjoyable. With affordable
                rental rates and convenient pickup/delivery options, "SYAKIRI
                CAMPING" is committed to helping you make the most of your
                outdoor adventures without the hassle of buying and storing equipment.
            </p>
        </div>
        <div class="biglogo">
            <img src="image/logo.png" alt="Big Logo">
        </div>
    </div>
</body>
</html>
