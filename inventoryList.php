<!DOCTYPE html>
<html>
<head>
    <title>Inventory List</title>
    <link rel="stylesheet" type="text/css" href="css/inventoryList.css">
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="index.html">HOMEPAGE</a></li>
            <li><a href="category.html">RENTAL</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="contactus.html">CONTACT US</a></li>
            <li class="right"><a href="login.html"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
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
                        <tr>
                            <td>A001</td>
                            <td>Compact 2 Person Pop-up Tent</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td>A002</td>
                            <td>Single Person Tent</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <td>A003</td>
                            <td>3-5 Person Camping Tent</td>
                            <td>7</td>
                        </tr>
                        <tr>
                            <td>A004</td>
                            <td>5-8 Person Camping Tent</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td>A005</td>
                            <td>12 Person Camping Tent</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>B001</td>
                            <td>Groundsheet</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td>B002</td>
                            <td>Camping Lamp rechargeable</td>
                            <td>16</td>
                        </tr>
                        <tr>
                            <td>B003</td>
                            <td>Low Folding Camping Chair</td>
                            <td>18</td>
                        </tr>
                        <tr>
                            <td>B004</td>
                            <td>Large Folding Camping Chair</td>
                            <td>15</td>
                        </tr>
                        <tr>
                            <td>B005</td>
                            <td>Torch Light</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>B006</td>
                            <td>Multipurpose Rope (10m)</td>
                            <td>28</td>
                        </tr>
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
                        <tr>
                            <td>Single Person Tent</td>
                            <td>Tent</td>
                            <td class="rented">Rented</td>
                            <td>1/4/2024</td>
                            <td>11/4/2024</td>
                        </tr>
                        <tr>
                            <td>Torch Light</td>
                            <td>Accessory</td>
                            <td class="rented">Rented</td>
                            <td>5/4/2024</td>
                            <td>8/4/2024</td>
                        </tr>
                        <tr>
                            <td>Groundsheet</td>
                            <td>Accessory</td>
                            <td class="available">Available</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Multipurpose Rope (10m)</td>
                            <td>Accessory</td>
                            <td class="available">Available</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="buttons">
                    <button onclick="addItem()">ADD</button>
                    <button onclick="editItem()">EDIT</button>
                    <button onclick="goBack()">BACK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addItem() {
            // Add item functionality
        }

        function editItem() {
            // Edit item functionality
        }

        function goBack() {
            // Go back functionality
        }
    </script>
</body>
</html>
