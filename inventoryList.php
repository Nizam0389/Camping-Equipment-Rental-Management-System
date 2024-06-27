<!DOCTYPE html>
<html>
<head>
    <title>Inventory List</title>
    <link rel="stylesheet" type="text/css" href="css/inventoryList.css">
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="index.php">CUSTOMER</a></li>
            <li><a href="inventoryList.php">ITEM</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="contactus.php">CONTACT US</a></li>
            <li class="right"><a href="login.php"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2 class="title-page">- INVENTORY LIST -</h2>
        <div class="container">
            <div class="stock-details">
                <h3>STOCK DETAILS</h3>
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Search">
                    <button onclick="searchItems()"><img src="image/search.png" alt="Search"></button>
                </div>
                <div class="filter-bar">
                    <select id="filterType" onchange="filterItems()">
                        <option value="">All Types</option>
                        <option value="Tent">Tent</option>
                        <option value="Accessory">Accessory</option>
                        <option value="Cooking Set">Cooking Set</option>
                        <option value="Bed">Bed</option>
                        <option value="Table">Table</option>
                    </select>
                </div>
                <table class="stock-table">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Item Type</th>
                            <th>Item Fee</th>
                            <th>Available Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="itemTableBody">
                        <?php
                        // Replace with your database connection details
                        $conn = new mysqli("localhost", "username", "password", "database");

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT item_id, item_name, item_type, item_fee, item_quantity, item_image_url FROM Item";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["item_id"]. "</td>";
                                echo "<td>" . $row["item_name"]. "</td>";
                                echo "<td>" . $row["item_type"]. "</td>";
                                echo "<td>" . $row["item_fee"]. "</td>";
                                echo "<td>" . $row["item_quantity"]. "</td>";
                                echo "<td>";
                                echo "<button onclick=\"viewImage('" . $row["item_image_url"] . "')\">View Image</button> ";
                                echo "<button onclick=\"location.href='updItem.php?id=" . $row["item_id"] . "'\">Update</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No results</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
                <div class="buttons">
                    <button onclick="location.href='addItem.php'">ADD</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewImage(url) {
            var imageWindow = window.open("");
            imageWindow.document.write("<img src='" + url + "' alt='Item Image'>");
        }

        function searchItems() {
            var input = document.getElementById("searchInput").value.toUpperCase();
            var table = document.getElementById("itemTableBody");
            var tr = table.getElementsByTagName("tr");

            for (var i = 0; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td");
                var found = false;
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].innerText.toUpperCase().indexOf(input) > -1) {
                            found = true;
                        }
                    }
                }
                tr[i].style.display = found ? "" : "none";
            }
        }

        function filterItems() {
            var filter = document.getElementById("filterType").value.toUpperCase();
            var table = document.getElementById("itemTableBody");
            var tr = table.getElementsByTagName("tr");

            for (var i = 0; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[2];
                if (td) {
                    if (filter === "" || td.innerText.toUpperCase() === filter) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>
