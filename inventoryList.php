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
            <li><a href="category.php">RENTAL</a></li>
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
                    <input type="text" placeholder="Search">
                    <button><img src="image/search.png" alt="Search"></button>
                </div>
                <table class="stock-table">
                    <thead>
                        <tr>
                            <th>Equipment Id</th>
                            <th>Equipment Name</th>
                            <th>Available Stocks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Replace with your database connection details
                        $conn = new mysqli("localhost", "username", "password", "database");

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT equipment_id, equipment_name, available_stocks FROM stock";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr><td>" . $row["equipment_id"]. "</td><td>" . $row["equipment_name"]. "</td><td>" . $row["available_stocks"]. "</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No results</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="container1">
                <div class="inventory-list">
                    <table>
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Rent Date</th>
                                <th>Return Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Replace with your database connection details
                            $conn = new mysqli("localhost", "username", "password", "database");

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT product_name, type, status, rent_date, return_date FROM inventory";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . $row["product_name"]. "</td><td>" . $row["type"]. "</td><td class='". strtolower($row["status"]) ."'>" . $row["status"]. "</td><td>" . $row["rent_date"]. "</td><td>" . $row["return_date"]. "</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No results</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                    <div class="buttons">
                        <button onclick="openModal()">ADD</button>
                        <button onclick="openEditModal()">EDIT</button>
                        <button onclick="goBack()">BACK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>ADD ITEM</h2>
            <form action="process-add-item.php" method="post">
                <label for="equipId">Equipment ID</label>
                <input type="text" id="equipId" name="equipId" required>

                <label for="equipName">Equipment Name</label>
                <input type="text" id="equipName" name="equipName" required>

                <label for="equipType">Equipment Type</label>
                <input type="text" id="equipType" name="equipType" required>

                <label for="price">Price</label>
                <input type="text" id="price" name="price" required>

                <label for="quantity">Quantity</label>
                <input type="text" id="quantity" name="quantity" required>

                <button type="submit" class="save-button">Save</button>
            </form>
        </div>
    </div>
    
    <!-- Edit Item Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>EDIT ITEM</h2>
            <form action="process-edit-item.php" method="post">
                <label for="editEquipId">Equipment ID</label>
                <select id="editEquipId" name="equipId">
                    <?php
                    // Replace with your database connection details
                    $conn = new mysqli("localhost", "username", "password", "database");

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT equipment_id FROM stock";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["equipment_id"] ."'>" . $row["equipment_id"]. "</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>

                <label for="editEquipName">Equipment Name</label>
                <input type="text" id="editEquipName" name="equipName" required>

                <label for="editEquipType">Equipment Type</label>
                <input type="text" id="editEquipType" name="equipType" required>

                <label for="editPrice">Price</label>
                <input type="text" id="editPrice" name="price" required>

                <label for="editQuantity">Quantity</label>
                <input type="text" id="editQuantity" name="quantity" required>

                <div class="buttons">
                    <button type="submit" class="save-button">Save</button>
                    <button type="button" class="delete-button">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.querySelector("button[onclick='openModal()']");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        function openModal() {
            modal.style.display = "block";
        }

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

        function openEditModal() {
            // Get the edit modal
            var editModal = document.getElementById("editModal");

            // Get the <span> element that closes the edit modal
            var editSpan = editModal.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal
            editModal.style.display = "block";

            // When the user clicks on <span> (x), close the edit modal
            editSpan.onclick = function() {
                editModal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == editModal) {
                    editModal.style.display = "none";
                }
            }
        }

        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
