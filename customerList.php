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
    <title>Customer List</title>
    <link rel="stylesheet" type="text/css" href="css/customerList.css">
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="adminDashboard.php">HOME</a></li>
            <li><a href="customerList.php">CUSTOMER</a></li>
            <li><a href="itemList.php">ITEM</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="contactus.php">CONTACT US</a></li>
            <li class="right"><a href="login.php"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2 class="title-page">- CUSTOMER LIST -</h2>
        <div class="container">
            <div class="search-filter-bar">
                <input type="text" id="search-bar" placeholder="Search by customer name" onkeyup="searchAndFilter()">
                <select id="rent-status-filter" onchange="searchAndFilter()">
                    <option value="">All Status</option>
                    <option value="1">Renting</option>
                    <option value="0">Returned</option>
                </select>
            </div>
            <table class="customer-table">
                <thead>
                    <tr>
                        <th>Rent ID</th>
                        <th>Customer ID</th>
                        <th>Customer Name</th>
                        <th>Rent Date</th>
                        <th>Return Date</th>
                        <th>Total Fee</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'dbConnect.php';

                    $sql = "SELECT r.rent_id, c.cust_id, c.name, r.rent_date, r.return_date, p.total_fee, r.rent_status
                            FROM Rent r
                            JOIN customer c ON r.cust_id = c.cust_id
                            JOIN Payment p ON r.rent_id = p.rent_id";
                    $result = $dbCon->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr data-status='" . $row["rent_status"] . "'>
                                    <td>" . $row["rent_id"]. "</td>
                                    <td>" . $row["cust_id"]. "</td>
                                    <td>" . $row["name"]. "</td>
                                    <td>" . $row["rent_date"]. "</td>
                                    <td>" . $row["return_date"]. "</td>
                                    <td>" . $row["total_fee"]. "</td>
                                    <td><button onclick=\"window.location.href='viewRentalDetail.php?rent_id=" . $row["rent_id"] . "&status=" . $row["rent_status"] . "'\">View Details</button></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No results</td></tr>";
                    }
                    $dbCon->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function searchAndFilter() {
            var searchBar = document.getElementById("search-bar").value.toLowerCase();
            var rentStatusFilter = document.getElementById("rent-status-filter").value;
            var table = document.querySelector(".customer-table tbody");
            var rows = table.getElementsByTagName("tr");

            for (var i = 0; i < rows.length; i++) {
                var customerName = rows[i].getElementsByTagName("td")[2].innerText.toLowerCase();
                var rentStatus = rows[i].getAttribute("data-status");
                if (customerName.includes(searchBar) && (rentStatusFilter === "" || rentStatus === rentStatusFilter)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
