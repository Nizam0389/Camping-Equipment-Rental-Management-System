<?php
require_once("dbConnect.php");

$username = $password = $email = $phone_no = $name = $address = "";
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = md5($_POST["password"], PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $phone_no = $_POST["phone_no"];
    $name = $_POST["name"];
    $address = $_POST["address"];

    $sql = "INSERT INTO staff (username, password, email, phone_no, name, address) VALUES ('$username', '$password', '$email', '$phone_no', '$name', '$address')";
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
    <title>Add Staff</title>
    <link rel="stylesheet" href="css/register.css">
    <script>
        function confirmLogout() {
            var result = confirm("Do you want to log out?");
            if (result) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</head>
<body>
    <header>
        <div class="navbar">
            <ul>
                <li><a href="adminDashboard.html">Back</a></li>
                <li class="logo"><img src="image/logo.png" alt="logo"></li>
                <li class="right"><a href="javascript:void(0);" onclick="confirmLogout()"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
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
                <button type="submit" class="register-btn">Add Staff</button>
            </form>
        </div>
    </main>
</body>
</html>
