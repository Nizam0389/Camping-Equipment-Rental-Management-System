<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'staff') {
    header("location: login.php");
    exit;
}
include 'dbConnect.php';

// Pagination variables
$limit = 10; // Number of entries to show in a page.
if (isset($_GET["page"])) { 
    $page  = $_GET["page"]; 
} else { 
    $page = 1; 
};
$start_from = ($page - 1) * $limit;

// Fetch data from database
$sql = "SELECT * FROM staff LIMIT $start_from, $limit";
$result = $dbCon->query($sql);

// Get total records
$sqlTotal = "SELECT COUNT(staff_id) FROM staff";
$rsResult = $dbCon->query($sqlTotal);
$rowTotal = $rsResult->fetch_row();
$total_records = $rowTotal[0];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff List Report</title>
    <link rel="stylesheet" href="css/report.css">
    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchBar");
            filter = input.value.toUpperCase();
            table = document.getElementById("staffTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="adminDashboard.php">HOME</a></li>
            <li><a href="report.php">BACK TO REPORTS</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2 class="title-page">Staff List</h2>
        <input type="text" id="searchBar" onkeyup="searchTable()" placeholder="Search for staff..">
        <table id="staffTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $counter = $start_from + 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $counter++ . "</td>
                                <td>" . $row['name'] . "</td>
                                <td>" . $row['username'] . "</td>
                                <td>" . $row['email'] . "</td>
                                <td>" . $row['phone_no'] . "</td>
                                <td>" . $row['address'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No staff found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='reportStaffList.php?page=" . $i . "'";
                if ($i == $page) echo " class='active'";
                echo ">" . $i . "</a> ";
            }
            ?>
        </div>
    </div>
</body>
</html>
