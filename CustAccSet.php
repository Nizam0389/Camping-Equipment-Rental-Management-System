<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "campingrentaldb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$name = "";
$username = "";
$email = "";
$phone_no = "";
$address = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["cust_id"])) {
    $cust_id = $_GET["cust_id"];
    $sql = "SELECT name, username, email, phone_no, address FROM customer WHERE cust_id='$cust_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $username = $row['username'];
        $email = $row['email'];
        $phone_no = $row['phone_no'];
        $address = $row['address'];
    } else {
        $error = "No results found";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cust_id"])) {
    $cust_id = $_POST["cust_id"];
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone_no = $_POST["phone_no"];
    $address = $_POST["address"];
    
    $sql = "UPDATE customer SET name='$name', username='$username', email='$email', phone_no='$phone_no', address='$address' WHERE cust_id='$cust_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Update complete'); window.location.href='index.php?cust_id=$cust_id';</script>";
        exit();
    } else {
        $error = "Error updating record: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Account Setting</title>
    <link rel="stylesheet" href="css/CustAccSet.css">
</head>
<body>
    <header>
        <div class="navbar">
            <ul>
                <li><a href="index.html">HOMEPAGE</a></li>
                <li><a href="category.html">RENTAL</a></li>
                <li class="logo"><img src="image/logo.png" alt="logo"></li>
                <li class="right"><a href="contactus.html">CONTACT US</a></li>
                <li class="cart"><a href="#"><img src="image/cart1.png" alt="Cart"></a></li>
                <li class="right"><a href="login.php"><img src="image/profilebg.png" alt="Login"></a></li>
            </ul>
        </div>
    </header>
    <main>
        <div class="profile-container">
            <h2>My Profile</h2>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <form method="post" action="">
                <input type="hidden" name="cust_id" value="<?php echo htmlspecialchars($cust_id); ?>">
                <table class="profile-details">
                    <tr>
                        <td class="label-column"><strong>Name</strong>:</td>
                        <td class="value-column"><input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Username</strong>:</td>
                        <td class="value-column"><input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Email</strong>:</td>
                        <td class="value-column"><input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Phone Number</strong>:</td>
                        <td class="value-column"><input type="text" id="phone_no" name="phone_no" value="<?php echo htmlspecialchars($phone_no); ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-column"><strong>Address</strong>:</td>
                        <td class="value-column"><input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required></td>
                    </tr>
                </table>
                <button type="submit" class="save-btn">Save</button>
            </form>
            <h3>Change Password</h3>
            <form method="post" action="change_password.php">
                <input type="hidden" name="cust_id" value="<?php echo htmlspecialchars($cust_id); ?>">
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
