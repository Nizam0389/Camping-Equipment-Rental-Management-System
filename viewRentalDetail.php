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
    <title>Rental Details</title>
    <link rel="stylesheet" type="text/css" href="css/viewrentaldetail.css">
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
        <h2 class="title-page">- RENTAL DETAILS -</h2>
        <div class="header-info">
            <?php
            include 'dbConnect.php';

            if (isset($_GET['rent_id']) && isset($_GET['status'])) {
                $rentId = $_GET['rent_id'];
                $rentStatus = $_GET['status'];
                $sql = "SELECT r.rent_id, c.cust_id, c.name, r.rent_date, r.return_date
                        FROM rent r
                        JOIN customer c ON r.cust_id = c.cust_id
                        WHERE r.rent_id = ?";
                
                if ($stmt = mysqli_prepare($dbCon, $sql)) {
                    mysqli_stmt_bind_param($stmt, "i", $rentId);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $rentId, $custId, $custName, $rentDate, $returnDate);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);
                }
            } else {
                echo "Invalid rent ID.";
                exit();
            }
            ?>
            <div class="left-info">
                <p>Rent ID: <?php echo $rentId; ?></p>
                <p>Customer ID: <?php echo $custId; ?></p>
                <p>Customer Name: <?php echo $custName; ?></p>
            </div>
            <div class="right-info">
                <p>Rent Date: <?php echo $rentDate; ?></p>
                <p>Return Date: <?php echo $returnDate; ?></p>
            </div>
        </div>
        <table class="rental-detail-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Item Type</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT rd.item_id, i.item_name, i.item_type, rd.RD_quantity
                        FROM rentaldetail rd
                        JOIN Item i ON rd.item_id = i.item_id
                        WHERE rd.rent_id = ?";
                if ($stmt = mysqli_prepare($dbCon, $sql)) {
                    mysqli_stmt_bind_param($stmt, "i", $rentId);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $counter++ . "</td>
                                <td>" . $row["item_id"] . "</td>
                                <td>" . $row["item_name"] . "</td>
                                <td>" . $row["item_type"] . "</td>
                                <td>" . $row["RD_quantity"] . "</td>
                              </tr>";
                    }
                    mysqli_stmt_close($stmt);
                }
                $dbCon->close();
                ?>
            </tbody>
        </table>
        <div class="actions">
            <?php if ($rentStatus == 1): ?>
                <button onclick="confirmReturn()">Confirm Return</button>
            <?php endif; ?>
            <button onclick="printReport()">Print</button>
        </div>
    </div>

    <script>
        function confirmReturn() {
            var rentId = <?php echo $rentId; ?>;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "processReturn.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert("Return confirmed successfully!");
                    location.reload();
                } else {
                    alert("Error confirming return. Please try again.");
                }
            };
            xhr.send("rent_id=" + rentId);
        }

        function printReport() {
            window.print();
        }
    </script>
</body>
</html>
