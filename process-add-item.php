<?php
include 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemName = $_POST['itemName'];
    $itemType = $_POST['itemType'];
    $itemFee = $_POST['itemFee'];
    $itemQuantity = $_POST['itemQuantity'];

    // Handling the image upload
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
    if ($_FILES["itemImage"]["size"] > 5000000) { // 500KB limit
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

            // Insert data into the database
            $sql = "INSERT INTO Item (item_name, item_type, item_fee, item_quantity, item_image_url) VALUES (?, ?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($dbCon, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssdis", $itemName, $itemType, $itemFee, $itemQuantity, $itemImageUrl);
                if (mysqli_stmt_execute($stmt)) {
                    echo "Item added successfully.";
                    header("location: itemList.php"); // Redirect to item list page
                    exit();
                } else {
                    echo "Something went wrong. Please try again later.";
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

mysqli_close($dbCon);
?>
