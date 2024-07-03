<?php
session_start();
$loggedin = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$username = $loggedin ? $_SESSION["username"] : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function checkLogin(event) {
            <?php if (!$loggedin): ?>
            event.preventDefault();
            $('#loginModal').modal('show');
            <?php else: ?>
            return true;
            <?php endif; ?>
        }
    </script>
</head>
<body>
    <div class="navbar">
        <ul class="navbar-links">
            <li><a href="category.php" onclick="checkLogin(event);">RENTAL</a></li>
            <li><a href="contactUsGuest.php">CONTACT US</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><span class="username"><?php echo htmlspecialchars($username); ?></span></li>
            <li class="right"><a href="login.php"><img src="image/profilebg.png" alt="Profile" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                You need to login first to access this section.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="login.php" class="btn btn-primary">Login</a>
            </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="info-box">
            <h1>SYAKIRI CAMPING</h1>
            <p>"SYAKIRI CAMPING" is your one-stop destination for all your camping equipment rental needs. 
                We offer a wide range of high-quality camping gear, including tents, sleeping bags, cooking 
                equipment, hiking gear, and more. Whether you're planning a weekend getaway or a longer outdoor 
                adventure, our company ensures that you have everything you need to make your camping experience 
                comfortable and enjoyable. With affordable rental rates and convenient pickup/delivery options, 
                "SYAKIRI CAMPING" is committed to helping you make the most of your outdoor adventures without the hassle of buying and storing equipment.</p>
        </div>
        <div class="biglogo">
            <img src="image/logo.png" alt="Big Logo">
        </div>
    </div>
</body>
</html>