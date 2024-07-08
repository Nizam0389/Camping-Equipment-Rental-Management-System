<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'customer') {
    header("location: login.php");
    exit;
}
$username = $_SESSION["username"];

require_once "dbConnect.php";

$error = $password_error = "";
$success_message = $password_success = "";

// Fetch current customer details from the database
$sql = "SELECT * FROM customer WHERE username = ?";
$stmt = mysqli_prepare($dbCon, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$customer = mysqli_fetch_assoc($result);

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($dbCon, $_POST['name']);
    $email = mysqli_real_escape_string($dbCon, $_POST['email']);
    $phone_no = mysqli_real_escape_string($dbCon, $_POST['phone_no']);
    $address = mysqli_real_escape_string($dbCon, $_POST['address']);

    $update_sql = "UPDATE customer SET name = ?, email = ?, phone_no = ?, address = ? WHERE username = ?";

    if ($stmt = mysqli_prepare($dbCon, $update_sql)) {
        mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone_no, $address, $username);

        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Customer information updated successfully!";
            // Refresh customer data
            $customer['name'] = $name;
            $customer['email'] = $email;
            $customer['phone_no'] = $phone_no;
            $customer['address'] = $address;
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
        
        $sql = "UPDATE customer SET password = ? WHERE username = ?";
        
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
    <title>Customer Account Setting</title>
    <link rel="stylesheet" href="css/customerAccountSetting.css">
</head>
<body>
    <header>
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
    </header>
    <main>
        <div class="profile-container">
            <h2>My Profile</h2>
            <?php 
            if (!empty($error)) { 
                echo "<p style='color: red;'>$error</p>"; 
            }
            if (!empty($success_message)) {
                echo "<p style='color: green;'>$success_message</p>";
            }
            ?>
            <form method="post" action="">
                <input type="hidden" name="update_profile" value="1">
                <table class="profile-details">
                    <tr>
                        <td class="label-column"><strong>Name</strong>:</td>
                        <td class="value-column"><input type="text" id="name" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Username</strong>:</td>
                        <td class="value-column"><input type="text" id="username" name="username" value="<?php echo htmlspecialchars($customer['username']); ?>" readonly></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Email</strong>:</td>
                        <td class="value-column"><input type="email" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Phone Number</strong>:</td>
                        <td class="value-column"><input type="text" id="phone_no" name="phone_no" value="<?php echo htmlspecialchars($customer['phone_no']); ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Address</strong>:</td>
                        <td class="value-column"><input type="text" id="address" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>" required></td>
                    </tr>
                </table>
                <button type="submit" class="save-btn">Save</button>
            </form>
            <h3>Change Password</h3>
            <?php 
            if (!empty($password_error)) { 
                echo "<p style='color: red;'>$password_error</p>"; 
            }
            if (!empty($password_success)) {
                echo "<p style='color: green;'>$password_success</p>";
            }
            ?>
            <form method="post" action="">
                <input type="hidden" name="change_password" value="1">
                <table class="password-details">
                    <tr>
                        <td class="label-column"><strong>Password:</strong></td>
                        <td class="value-column"><input type="password" id="new_password" name="new_password" placeholder="Password" required></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Password Confirmation:</strong></td>
                        <td class="value-column"><input type="password" id="confirm_password" name="confirm_password" placeholder="Password Confirmation" required></td>
                    </tr>
                </table>
                <button type="submit" class="confirm-btn">Confirm</button>
            </form>
        </div>
    </main>
</body>
</html>
