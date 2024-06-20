<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "campingrentaldb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$username = $password = $email = $phone_no = "";
$error = $success = "";

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Encrypt the password
    $email = $_POST["email"];
    $phone_no = $_POST["phone_no"];

    // Insert into database
    $sql = "INSERT INTO customer (username, password, email, phone_no) VALUES ('$username', '$password', '$email', '$phone_no')";
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
            <form>
                <input type="text" placeholder="Username" required>
                <input type="password" placeholder="Password" required>
                <input type="email" placeholder="Email" required>
                <input type="tel" placeholder="Phone No." required>
                <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="#">privacy policy</a>.</p>
            </form>
            <button type="submit" class="register-btn">REGISTER</button>
            <br>
            <button class="login-btn">LOG IN</button>
        </div>
    </main>

</body>
</html>
