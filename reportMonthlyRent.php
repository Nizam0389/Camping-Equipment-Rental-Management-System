<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'staff') {
    header("location: login.php");
    exit;
}
include 'dbConnect.php';

// Get the selected year
$year = isset($_GET['year']) ? $_GET['year'] : date("Y");

// Fetch distinct years from rent_date
$yearResult = $dbCon->query("SELECT DISTINCT YEAR(rent_date) as year FROM rent ORDER BY year DESC");
$years = [];
while ($row = $yearResult->fetch_assoc()) {
    $years[] = $row['year'];
}

// Fetch data for the selected year
$sql = "SELECT MONTH(rent_date) as month, SUM(RD_quantity) as total_quantity, COUNT(DISTINCT rent.cust_id) as total_customers
        FROM rentaldetail
        JOIN rent ON rentaldetail.rent_id = rent.rent_id
        WHERE YEAR(rent_date) = $year
        GROUP BY MONTH(rent_date)";
$result = $dbCon->query($sql);

// Prepare data for the chart
$monthlyData = array_fill(1, 12, 0); // Initialize array for 12 months
$monthlyCustomers = array_fill(1, 12, 0); // Initialize array for customers per month
while ($row = $result->fetch_assoc()) {
    $monthlyData[(int)$row['month']] = $row['total_quantity'];
    $monthlyCustomers[(int)$row['month']] = $row['total_customers'];
}
$dbCon->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly rent Report</title>
    <link rel="stylesheet" href="css/report.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="adminDashboard.php">HOME</a></li>
            <li><a href="report.php">BACK TO REPORTS</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2 class="title-page">Monthly rent Report for <?php echo $year; ?></h2>
        <div class="report-container">
            <div class="chart-container">
                <form method="GET" action="" class="year-select-form">
                    <select name="year" onchange="this.form.submit()">
                        <?php
                        foreach ($years as $y) {
                            echo "<option value='$y'" . ($y == $year ? " selected" : "") . ">$y</option>";
                        }
                        ?>
                    </select>
                </form>
                <canvas id="monthlyrentChart"></canvas>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Total Items rented</th>
                            <th>Total Customers renting</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($monthlyData as $month => $total_quantity) {
                            echo "<tr>
                                    <td>" . date("F", mktime(0, 0, 0, $month, 1)) . "</td>
                                    <td>" . $total_quantity . "</td>
                                    <td>" . $monthlyCustomers[$month] . "</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const ctx = document.getElementById('monthlyrentChart').getContext('2d');
        const monthlyrentChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Total Items rented',
                    data: <?php echo json_encode(array_values($monthlyData)); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false,
                    tension: 0.4
                },
                {
                    label: 'Total Customers renting',
                    data: <?php echo json_encode(array_values($monthlyCustomers)); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: false,
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
