<!DOCTYPE html>
<html>
<head>
    <title>Item List</title>
    <link rel="stylesheet" type="text/css" href="css/itemList2.css">
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
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Type</th>
                        <th>Fee</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'dbConnect.php';

                    $sql = "SELECT item_id, item_name, item_type, item_fee, item_quantity, item_image_url FROM Item";
                    $result = $dbCon->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["item_id"]. "</td>
                                    <td>" . $row["item_name"]. "</td>
                                    <td>" . $row["item_type"]. "</td>
                                    <td>" . $row["item_fee"]. "</td>
                                    <td>" . $row["item_quantity"]. "</td>
                                    <td>
                                        <button onclick=\"viewImage('" . $row["item_image_url"] . "')\">View Image</button>
                                        <button onclick=\"window.location.href='updItem.php?item_id=" . $row["item_id"] . "'\">Update</button>
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
        function viewImage(url) {
            var modal = document.getElementById("imageModal");
            var img = document.getElementById("itemImage");
            img.src = url;
            modal.style.display = "block";
        }

        // Get the modal
        var modal = document.getElementById("imageModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

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

        function searchAndFilter() {
            var searchBar = document.getElementById("search-bar").value.toLowerCase();
            var filterType = document.getElementById("filter-type").value.toLowerCase();
            var table = document.querySelector(".item-table tbody");
            var rows = table.getElementsByTagName("tr");

            for (var i = 0; i < rows.length; i++) {
                var itemName = rows[i].getElementsByTagName("td")[1].innerText.toLowerCase();
                var itemType = rows[i].getElementsByTagName("td")[2].innerText.toLowerCase();
                if (itemName.includes(searchBar) && (filterType === "" || itemType === filterType)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
