<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "campingrentaldb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$username = $password = $email = $phone_no = $name = $address = "";
$error = $success = "";

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Encrypt the password
    $email = $_POST["email"];
    $phone_no = $_POST["phone_no"];
    $name = $_POST["name"];
    $address = $_POST["address"];

    // Insert into database
    $sql = "INSERT INTO customer (username, password, email, phone_no, name, address) VALUES ('$username', '$password', '$email', '$phone_no', '$name', '$address')";
    if ($conn->query($sql) === TRUE) {
        $success = "Registration successful!";
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <header>
        <div class="navbar">
            <ul>
                <li><a href="index.html">HOMEPAGE</a></li>
                <li><a href="category.html">RENTAL</a></li>
                <li class="logo"><img src="image/logo.png" alt="logo"></li>
                <li class="right"><a href="contactus.html">CONTACT US</a></li>
                <li class="right"><a href="login.php"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
            </ul>
        </div>
    </header>
    <main>
        <div class="register-form">
            <h2>Register</h2>
            <?php if ($success) { echo "<p class='success'>$success</p>"; } ?>
            <?php if ($error) { echo "<p class='error'>$error</p>"; } ?>
            <form action="register.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="tel" name="phone_no" placeholder="Phone No." required>
                <input type="text" name="name" placeholder="Name" required>
                <input type="text" name="address" placeholder="Address" required>
                <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="#">privacy policy</a>.</p>
                <button type="submit" class="register-btn">REGISTER</button>
            </form>
            <br>
            <button class="login-btn" onclick="window.location.href='login.php'">LOG IN</button>
        </div>
    </main>
</body>
</html>
