<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'staff') {
    header("location: login.php");
    exit;
}
$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Item</title>
    <link rel="stylesheet" type="text/css" href="css/addItem.css">
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
                    <a href="staffDetail.php">Profile</a>
                    <a href="javascript:void(0);" onclick="confirmLogout()">Logout</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <h2 class="title-page">- UPDATE ITEM -</h2>
        <div class="container">
            <?php
            include 'dbConnect.php';

            if (isset($_GET['item_id'])) {
                $itemId = $_GET['item_id'];
                $sql = "SELECT * FROM Item WHERE item_id = ?";
                
                if ($stmt = mysqli_prepare($dbCon, $sql)) {
                    mysqli_stmt_bind_param($stmt, "i", $itemId);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                    } else {
                        echo "Item not found.";
                        exit();
                    }
                    mysqli_stmt_close($stmt);
                }
            } else {
                echo "Invalid item ID.";
                exit();
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $itemName = $_POST['itemName'];
                $itemType = $_POST['itemType'];
                $itemFee = $_POST['itemFee'];
                $itemQuantity = $_POST['itemQuantity'];
                $itemImageUrl = $row['item_image_url'];

                // Handling the image upload
                if ($_FILES["itemImage"]["name"]) {
                    $target_dir = "upload/";
                    $target_file = $target_dir . basename($_FILES["itemImage"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // Check if image file is a actual image or fake image
                    $check = getimagesize($_FILES["itemImage"]["tmp_name"]);
                    if ($check !== false) {
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }

                    // Check if file already exists
                    if (file_exists($target_file)) {
                        echo "Sorry, file already exists.";
                        $uploadOk = 0;
                    }

                    // Check file size
                    if ($_FILES["itemImage"]["size"] > 500000) { // 500KB limit
                        echo "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    // If everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["itemImage"]["tmp_name"], $target_file)) {
                            $itemImageUrl = $target_file;
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }
                }

                // Update data in the database
                $sql = "UPDATE Item SET item_name = ?, item_type = ?, item_fee = ?, item_quantity = ?, item_image_url = ? WHERE item_id = ?";

                if ($stmt = mysqli_prepare($dbCon, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssdisi", $itemName, $itemType, $itemFee, $itemQuantity, $itemImageUrl, $itemId);
                    if (mysqli_stmt_execute($stmt)) {
                        echo "Item updated successfully.";
                        header("location: itemList.php"); // Redirect to item list page
                        exit();
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }
                mysqli_stmt_close($stmt);
            }

            mysqli_close($dbCon);
            ?>
            <div class="form-container">
                <form action="updItem.php?item_id=<?php echo $itemId; ?>" method="post" enctype="multipart/form-data">
                    <label for="itemName">Item Name</label>
                    <input type="text" id="itemName" name="itemName" value="<?php echo $row['item_name']; ?>" required>

                    <label for="itemType">Item Type</label>
                    <select id="itemType" name="itemType" required>
                        <option value="tent" <?php if($row['item_type'] == 'tent') echo 'selected'; ?>>Tent</option>
                        <option value="accessory" <?php if($row['item_type'] == 'accessory') echo 'selected'; ?>>Accessory</option>
                        <option value="cooking set" <?php if($row['item_type'] == 'cooking set') echo 'selected'; ?>>Cooking Set</option>
                        <option value="bed" <?php if($row['item_type'] == 'bed') echo 'selected'; ?>>Bed</option>
                        <option value="table" <?php if($row['item_type'] == 'table') echo 'selected'; ?>>Table</option>
                    </select>

                    <label for="itemFee">Fee</label>
                    <input type="number" step="0.01" id="itemFee" name="itemFee" value="<?php echo $row['item_fee']; ?>" required>

                    <label for="itemQuantity">Quantity</label>
                    <input type="number" id="itemQuantity" name="itemQuantity" value="<?php echo $row['item_quantity']; ?>" required>

                    <label for="itemImage">Item Image</label>
                    <input type="file" id="itemImage" name="itemImage">

                    <button type="submit" class="save-button">Save</button>
                </form>
                <div class="image-preview">
                    <h3>Current Image</h3>
                    <img src="<?php echo $row['item_image_url']; ?>" alt="Item Image">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
