<?php
session_start();
require_once 'dbConnect.php';

$username = $password = "";
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($dbCon, $_POST['username']);
    $password = md5(mysqli_real_escape_string($dbCon, $_POST['password']));

    // Debugging statements
    echo "Username: $username<br>";
    echo "Password (hashed): $password<br>";

    // Query for staff
    $sql_staff = "SELECT username, password FROM staff WHERE username = '$username'";
    $result_staff = mysqli_query($dbCon, $sql_staff);
    if (!$result_staff) {
        echo "Staff query failed: " . mysqli_error($dbCon) . "<br>";
    } else {
        echo "Staff query succeeded.<br>";
    }

    // Query for customer
    $sql_customer = "SELECT username, password FROM customer WHERE username = '$username'";
    $result_customer = mysqli_query($dbCon, $sql_customer);
    if (!$result_customer) {
        echo "Customer query failed: " . mysqli_error($dbCon) . "<br>";
    } else {
        echo "Customer query succeeded.<br>";
    }

    if ($result_staff && mysqli_num_rows($result_staff) == 1) {
        $row = mysqli_fetch_assoc($result_staff);
        echo "Found staff user<br>";
        if ($password === $row['password']) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['loggedin'] = true;
            $_SESSION['user_type'] = 'staff';
            echo "Redirecting to adminDashboard.php<br>";
            header("Location: adminDashboard.php");
            exit();
        } else {
            $message = "Invalid password.";
        }
    } elseif ($result_customer && mysqli_num_rows($result_customer) == 1) {
        $row = mysqli_fetch_assoc($result_customer);
        echo "Found customer user<br>";
        if ($password === $row['password']) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['loggedin'] = true;
            $_SESSION['user_type'] = 'customer';
            echo "Redirecting to homepage.php<br>";
            header("Location: homepage.php");
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "No account found with that username.";
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
            <?php if (!empty($message)): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
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
