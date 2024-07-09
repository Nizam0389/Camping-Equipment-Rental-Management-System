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
    <title>Item List</title>
    <link rel="stylesheet" type="text/css" href="css/itemList2.css">
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
        <h2 class="title-page">- ITEM LIST -</h2>
        <div class="container">
            <div class="search-filter-bar">
                <input type="text" id="search-bar" placeholder="Search" onkeyup="searchAndFilter()">
                <select id="filter-type" onchange="searchAndFilter()">
                    <option value="">All Types</option>
                    <option value="tent">Tent</option>
                    <option value="accessory">Accessory</option>
                    <option value="cooking set">Cooking Set</option>
                    <option value="bed">Bed</option>
                    <option value="table">Table</option>
                </select>
                <button onclick="window.location.href='addItem.php'">Add Item</button>
            </div>
            <table class="item-table">
                <thead>
                    <tr>
                        <th class="col-id">Item ID</th>
                        <th>Item Name</th>
                        <th>Type</th>
                        <th>Fee</th>
                        <th class="col-quantity">Quantity</th>
                        <th class="col-action">Actions</th>
                    </tr>
                </thead>
                <tbody id="item-table-body">
                    <?php
                    include 'dbConnect.php';

                    $sql = "SELECT item_id, item_name, item_type, item_fee, item_quantity, item_image_url FROM Item";
                    $result = $dbCon->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td class='col-id'>" . $row["item_id"]. "</td>
                                    <td>" . $row["item_name"]. "</td>
                                    <td>" . $row["item_type"]. "</td>
                                    <td>" . $row["item_fee"]. "</td>
                                    <td class='col-quantity'>" . $row["item_quantity"]. "</td>
                                    <td class='col-action'>
                                        <button class='view-button' onclick=\"viewImage('" . $row["item_image_url"] . "')\">View Image</button>
                                        <button class='update-button' onclick=\"window.location.href='updItem.php?item_id=" . $row["item_id"] . "'\">Update</button>
                                        <button class='delete-button' onclick=\"confirmDelete('" . $row["item_id"] . "')\">Delete</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No results</td></tr>";
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

    <!-- Modal for viewing image -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="itemImage" src="" alt="Item Image">
        </div>
    </div>

    <script>
        let currentPage = 1;
        const rowsPerPage = 9;

        function paginateTable() {
            const table = document.querySelector(".item-table tbody");
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
            const filterType = document.getElementById("filter-type").value.toLowerCase();
            const table = document.querySelector(".item-table tbody");
            const rows = Array.from(table.getElementsByTagName("tr"));
            let filteredRows = rows;

            filteredRows = rows.filter(row => {
                const itemName = row.getElementsByTagName("td")[1].innerText.toLowerCase();
                const itemType = row.getElementsByTagName("td")[2].innerText.toLowerCase();
                return itemName.includes(searchBar) && (filterType === "" || itemType === filterType);
            });

            rows.forEach(row => row.style.display = "none");
            filteredRows.slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage).forEach(row => row.style.display = "");

            document.getElementById("prevPage").disabled = currentPage === 1;
            document.getElementById("nextPage").disabled = currentPage * rowsPerPage >= filteredRows.length;
        }

        function viewImage(url) {
            const modal = document.getElementById("imageModal");
            const img = document.getElementById("itemImage");
            img.src = url;
            modal.style.display = "block";
        }

        // Get the modal
        const modal = document.getElementById("imageModal");

        // Get the <span> element that closes the modal
        const span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function confirmDelete(itemId) {
            if (confirm("Are you sure you want to delete this item?")) {
                window.location.href = 'deleteItem.php?item_id=' + itemId;
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            paginateTable();
        });
    </script>
</body>
</html>
