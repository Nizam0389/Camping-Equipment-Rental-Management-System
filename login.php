<?php
session_start();
require_once 'dbConnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($dbCon, $_POST['username']);
    $password = mysqli_real_escape_string($dbCon, $_POST['password']);

    $sql_staff = "SELECT username, password, 'staff' AS role FROM staff WHERE username = '$username'";
    $result_staff = mysqli_query($dbCon, $sql_staff);

    $sql_customer = "SELECT username, password, 'customer' AS role FROM customer WHERE username = '$username'";
    $result_customer = mysqli_query($dbCon, $sql_customer);

    if ($result_staff && mysqli_num_rows($result_staff) == 1) {
        $row = mysqli_fetch_assoc($result_staff);
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            header("Location: adminDashboard.php");
            exit();
        } else {
            $login_error = "Invalid password.";
        }
    } elseif ($result_customer && mysqli_num_rows($result_customer) == 1) {
        $row = mysqli_fetch_assoc($result_customer);
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            header("Location: homepage.php");
            exit();
        } else {
            $login_error = "Invalid password.";
        }
    } else {
        $login_error = "No account found with that username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
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
        <div class="login-container">
            <h2>LOGIN</h2>
            <form action="login.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="toggle-password"></button>
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit" class="login-btn">LOG IN</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </main>
    <script>
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordField = document.querySelector('#password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('clicked');
        });

        document.querySelector('.search-container').addEventListener('click', function () {
            alert('Search button clicked!');
        });
    </script>
</body>
</html>