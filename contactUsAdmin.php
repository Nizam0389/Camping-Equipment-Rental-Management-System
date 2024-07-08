<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'staff') {
    header("location: login.php");
    exit;
}
$username = $_SESSION["username"];
?>

<?php
require_once 'dbConnect.php';

// Fetch current contact information from the database
$sql = "SELECT comp_phoneNo, comp_email, comp_address, comp_webAdd FROM contactUS";
$result = mysqli_query($dbCon, $sql);
$contact = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = mysqli_real_escape_string($dbCon, $_POST['phone']);
    $email = mysqli_real_escape_string($dbCon, $_POST['email']);
    $address = mysqli_real_escape_string($dbCon, $_POST['address']);
    $website = mysqli_real_escape_string($dbCon, $_POST['website']);

    $update_sql = "UPDATE contactUS SET comp_phoneNo = ?, comp_email = ?, comp_address = ?, comp_webAdd = ?";

    if ($stmt = mysqli_prepare($dbCon, $update_sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $phone, $email, $address, $website);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                    alert('Contact information updated successfully!');
                    window.location.href = 'contactUsAdmin.php?success=true';
                  </script>";
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($dbCon);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us Admin</title>
    <link rel="stylesheet" type="text/css" href="css/contactUsAdmin.css">
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
    <header>
    <div class="navbar">
        <ul>
            <li><a href="adminDashboard.php">HOME</a></li>
            <li><a href="customerList.php">CUSTOMER</a></li>
            <li><a href="itemList.php">ITEM</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="contactUsAdmin.php">CONTACT US</a></li>
            <li class="right">
                <?php if ($username == 'S001') : ?>
                    <a href="addStaff.php" class="add-staff-link">
                        <i aria-hidden="true"></i>
                        ADD STAFF
                    </a>
                <?php endif; ?>
            </li>
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
    </header>
    <main>
        <div class="contact-section">
            <h2>- GET IN TOUCH WITH US -</h2>
            <div class="contact-container">
                <div class="contact-image">
                    <img src="image/contactUs.jpg" alt="Tent">
                </div>
                <form action="contactUsAdmin.php" method="post">
                    <div class="contact-info">
                        <div class="contact-item">
                            <img src="image/phone.png" alt="phone">
                            <input type="text" name="phone" value="<?php echo htmlspecialchars($contact['comp_phoneNo']); ?>">
                        </div>
                        <div class="contact-item">
                            <img src="image/email.png" alt="email">
                            <input type="text" name="email" value="<?php echo htmlspecialchars($contact['comp_email']); ?>">
                        </div>
                        <div class="contact-item">
                            <img src="image/location.png" alt="location">
                            <textarea name="address" rows="3"><?php echo htmlspecialchars($contact['comp_address']); ?></textarea>
                        </div>
                        <div class="contact-item">
                            <img src="image/website.png" alt="website">
                            <input type="text" name="website" value="<?php echo htmlspecialchars($contact['comp_webAdd']); ?>">
                        </div>
                        <div class="confirm-button">
                            <button type="submit">Confirm Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
