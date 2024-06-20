<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "campingretaldb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cust_id"])) {
    $cust_id = $_POST["cust_id"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    
    if ($new_password == $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE customer SET password='$hashed_password' WHERE cust_id='$cust_id'";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Password updated successfully'); window.location.href='index.php?cust_id=$cust_id';</script>";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "<script>alert('Passwords do not match'); window.history.back();</script>";
    }
}

// Close database connection
$conn->close();
?>
