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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will be logged out',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Logging Out!',
                        text: 'You are being logged out.',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    setTimeout(() => {
                        window.location.href = 'logout.php';
                    }, 1000);
                }
            });
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
                    <a href="staffAccountSetting.php">Profile</a>
                    <a href="javascript:void(0);" onclick="confirmLogout()">Logout</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <h2 class="title-page">- CUSTOMER LIST -</h2>
        <div class="container">
            <div class="search-filter-bar">
                <input type="text" id="search-bar" placeholder="Search by customer name" onkeyup="searchAndFilter()">
                <select id="rent-status-filter" onchange="searchAndFilter()">
                    <option value="">All Status</option>
                    <option value="1">renting</option>
                    <option value="0">Returned</option>
                </select>
            </div>
            <table class="customer-table">
                <thead>
                    <tr>
                        <th class="col-rent-id">Rent ID</th>
                        <th class="col-cust-id">Customer ID</th>
                        <th class="col-name">Customer Name</th>
                        <th class="col-rent-date">Rent Date</th>
                        <th class="col-return-date">Return Date</th>
                        <th class="col-total-fee">Total Fee</th>
                        <th class="col-actions">Actions</th>
                    </tr>
                </thead>
                <tbody id="customer-table-body">
                    <?php
                    include 'dbConnect.php';

                    $sql = "SELECT r.rent_id, c.cust_id, c.name, r.rent_date, r.return_date, p.total_fee, r.rent_status
                            FROM rent r
                            JOIN customer c ON r.cust_id = c.cust_id
                            JOIN Payment p ON r.rent_id = p.rent_id";
                    $result = $dbCon->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr data-status='" . $row["rent_status"] . "'>
                                    <td class='col-rent-id'>" . $row["rent_id"]. "</td>
                                    <td class='col-cust-id'>" . $row["cust_id"]. "</td>
                                    <td class='col-name'>" . $row["name"]. "</td>
                                    <td class='col-rent-date'>" . $row["rent_date"]. "</td>
                                    <td class='col-return-date'>" . $row["return_date"]. "</td>
                                    <td class='col-total-fee'>" . $row["total_fee"]. "</td>
                                    <td class='col-actions'><button class='view-button' onclick=\"window.location.href='viewrentaldetail.php?rent_id=" . $row["rent_id"] . "&status=" . $row["rent_status"] . "'\">View Details</button></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No results</td></tr>";
                    }
                    $dbCon->close();
                    ?>
                </tbody>
            </table>
            <div class="pagination">
                <button id="prevPage" onclick="prevPage()">Prev</button>
                <span id="pageIndicator"></span>
                <button id="nextPage" onclick="nextPage()">Next</button>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;
        const rowsPerPage = 9;

        function paginateTable() {
            const table = document.querySelector(".customer-table tbody");
            const rows = Array.from(table.getElementsByTagName("tr"));
            const totalRows = rows.length;

            rows.forEach((row, index) => {
                row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? "" : "none";
            });

            document.getElementById("prevPage").disabled = currentPage === 1;
            document.getElementById("nextPage").disabled = currentPage * rowsPerPage >= totalRows;
            document.getElementById("pageIndicator").textContent = `Page ${currentPage}`;
        }

        function nextPage() {
            currentPage++;
            paginateTable();
        }

        function prevPage() {
            currentPage--;
            paginateTable();
        }

        function searchAndFilter() {
            const searchBar = document.getElementById("search-bar").value.toLowerCase();
            const rentStatusFilter = document.getElementById("rent-status-filter").value;
            const table = document.querySelector(".customer-table tbody");
            const rows = Array.from(table.getElementsByTagName("tr"));
            let filteredRows = rows;

            filteredRows = rows.filter(row => {
                const customerName = row.getElementsByTagName("td")[2].innerText.toLowerCase();
                const rentStatus = row.getAttribute("data-status");
                return customerName.includes(searchBar) && (rentStatusFilter === "" || rentStatus === rentStatusFilter);
            });

            rows.forEach(row => row.style.display = "none");
            filteredRows.slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage).forEach(row => row.style.display = "");

            document.getElementById("prevPage").disabled = currentPage === 1;
            document.getElementById("nextPage").disabled = currentPage * rowsPerPage >= filteredRows.length;
        }

        document.addEventListener("DOMContentLoaded", () => {
            paginateTable();
        });
    </script>
</body>
</html>
