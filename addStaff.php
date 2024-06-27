<?php
require_once("dbConnect.php");

$username = $password = $confirm_password = $email = $phone_no = $name = $address = "";
$error = $success = "";
$username_err = $password_err = $confirm_password_err = $email_err = $phone_no_err = $name_err = $address_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Check if username exists in customer or staff table
        $sql = "SELECT username FROM customer WHERE username = ? UNION SELECT username FROM staff WHERE username = ?";
        if ($stmt = mysqli_prepare($dbCon, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_username);
            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = $param_username;
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = mysqli_real_escape_string($dbCon, trim($_POST["email"]));
    }

    // Validate phone number
    if (empty(trim($_POST["phone_no"]))) {
        $phone_no_err = "Please enter a phone number.";
    } else {
        $phone_no = mysqli_real_escape_string($dbCon, trim($_POST["phone_no"]));
    }

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = mysqli_real_escape_string($dbCon, trim($_POST["name"]));
    }

    // Validate address
    if (empty(trim($_POST["address"]))) {
        $address_err = "Please enter your address.";
    } else {
        $address = mysqli_real_escape_string($dbCon, trim($_POST["address"]));
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($phone_no_err) && empty($name_err) && empty($address_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO staff (username, password, email, phone_no, name, address) VALUES (?, ?, ?, ?, ?, ?)";
        
        if ($stmt = mysqli_prepare($dbCon, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_password, $param_email, $param_phone_no, $param_name, $param_address);
            
            // Set parameters
            $param_username = $username;
            $param_password = md5($password); // Encrypt the password using md5
            $param_email = $email;
            $param_phone_no = $phone_no;
            $param_name = $name;
            $param_address = $address;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo "<script> alert('Registration successful!'); </script>";
                echo "<script> location.href='adminDashboard.php'; </script>";
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt); // Close statement
    }
    mysqli_close($dbCon); // Close connection
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
                <li><a href="adminDashboard.php">Back</a></li>
                <li class="logo"><img src="image/logo.png" alt="logo"></li>
                <li class="right"><a href="javascript:void(0);" onclick="confirmLogout()"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
            </ul>
        </div>
    </header>
    <main>
        <div class="register-form">
            <h2>Add Staff</h2>
            <?php if (!empty($username_err)) echo "<p class='error'>$username_err</p>"; ?>
            <?php if (!empty($password_err)) echo "<p class='error'>$password_err</p>"; ?>
            <?php if (!empty($confirm_password_err)) echo "<p class='error'>$confirm_password_err</p>"; ?>
            <?php if (!empty($email_err)) echo "<p class='error'>$email_err</p>"; ?>
            <?php if (!empty($phone_no_err)) echo "<p class='error'>$phone_no_err</p>"; ?>
            <?php if (!empty($name_err)) echo "<p class='error'>$name_err</p>"; ?>
            <?php if (!empty($address_err)) echo "<p class='error'>$address_err</p>"; ?>
            <form action="addStaff.php" method="post">
                <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                <input type="tel" name="phone_no" placeholder="Phone No." value="<?php echo $phone_no; ?>" required>
                <input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>" required>
                <input type="text" name="address" placeholder="Address" value="<?php echo $address; ?>" required>
                <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="#">privacy policy</a>.</p>
                <button type="submit" class="register-btn">REGISTER</button>
            </form>
        </div>
    </main>
</body>
</html>
