<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'staff') {
    header("location: login.php");
}
$username = $_SESSION["username"];

require_once "dbConnect.php";

$error = $password_error = "";

// Fetch current staff details from the database
$sql = "SELECT * FROM staff WHERE username = ?";
$stmt = mysqli_prepare($dbCon, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$staff = mysqli_fetch_assoc($result);

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($dbCon, $_POST['name']);
    $email = mysqli_real_escape_string($dbCon, $_POST['email']);
    $phone_no = mysqli_real_escape_string($dbCon, $_POST['phone_no']);
    $address = mysqli_real_escape_string($dbCon, $_POST['address']);

    $update_sql = "UPDATE staff SET name = ?, email = ?, phone_no = ?, address = ? WHERE username = ?";

    if ($stmt = mysqli_prepare($dbCon, $update_sql)) {
        mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone_no, $address, $username);

        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Staff information updated successfully!";
            // Refresh staff data
            $staff['name'] = $name;
            $staff['email'] = $email;
            $staff['phone_no'] = $phone_no;
            $staff['address'] = $address;
        } else {
            $error = "Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
}

// Handle password change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    
    if (strlen($new_password) < 6) {
        $password_error = "Password must have at least 6 characters.";
    } elseif ($new_password !== $confirm_password) {
        $password_error = "Password confirmation does not match.";
    } else {
        $hashed_password = md5($new_password);
        
        $sql = "UPDATE staff SET password = ? WHERE username = ?";
        
        if ($stmt = mysqli_prepare($dbCon, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $username);
            
            if (mysqli_stmt_execute($stmt)) {
                $password_success = "Password changed successfully!";
            } else {
                $password_error = "Oops! Something went wrong. Please try again later.";
            }
            
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Account Setting</title>
    <link rel="stylesheet" href="css/staffAccountSetting.css">
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
        <div class="profile-container">
            <h2>My Profile</h2>
            <?php 
            if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; }
            if (!empty($success_message)) { echo "<p style='color: green;'>$success_message</p>"; }
            ?>
            <form method="post" action="">
                <table class="profile-details">
                    <tr>
                        <td class="label-column"><strong>Name</strong>:</td>
                        <td class="value-column"><input type="text" id="name" name="name" value="<?php echo htmlspecialchars($staff['name']); ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Username</strong>:</td>
                        <td class="value-column"><input type="text" id="username" name="username" value="<?php echo htmlspecialchars($staff['username']); ?>" readonly></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Email</strong>:</td>
                        <td class="value-column"><input type="email" id="email" name="email" value="<?php echo htmlspecialchars($staff['email']); ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Phone Number</strong>:</td>
                        <td class="value-column"><input type="text" id="phone_no" name="phone_no" value="<?php echo htmlspecialchars($staff['phone_no']); ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Address</strong>:</td>
                        <td class="value-column"><input type="text" id="address" name="address" value="<?php echo htmlspecialchars($staff['address']); ?>" required></td>
                    </tr>
                </table>
                <button type="submit" name="update_profile" class="save-btn">Save</button>
            </form>
            <h3>Change Password</h3>
            <?php 
            if (!empty($password_error)) { echo "<p style='color: red;'>$password_error</p>"; }
            if (!empty($password_success)) { echo "<p style='color: green;'>$password_success</p>"; }
            ?>
            <form method="post" action="">
                <table class="password-details">
                    <tr>
                        <td class="label-column"><strong>New Password:</strong></td>
                        <td class="value-column"><input type="password" id="new_password" name="new_password" placeholder="New Password" required></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Confirm New Password:</strong></td>
                        <td class="value-column"><input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" required></td>
                    </tr>
                </table>
                <button type="submit" name="change_password" class="confirm-btn">Confirm</button>
            </form>
        </div>
    </main>
</body>
</html>