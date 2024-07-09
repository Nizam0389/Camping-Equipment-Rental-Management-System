<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'staff') {
    header("location: login.php");
    exit;
}
include 'dbConnect.php';

// Fetch distinct years from payment_date
$yearResult = $dbCon->query("SELECT DISTINCT YEAR(payment_date) as year FROM payment ORDER BY year DESC");
$years = [];
while ($row = $yearResult->fetch_assoc()) {
    $years[] = $row['year'];
}

// Get the selected year
$year = isset($_GET['year']) ? $_GET['year'] : date("Y");

// Fetch sales data for the selected year
$sql = "SELECT MONTH(payment_date) as month, SUM(total_fee) as total_sales
        FROM payment
        WHERE YEAR(payment_date) = $year
        GROUP BY MONTH(payment_date)";
$result = $dbCon->query($sql);

// Prepare data for the chart
$monthlySalesData = array_fill(1, 12, 0); // Initialize array for 12 months
while ($row = $result->fetch_assoc()) {
    $monthlySalesData[(int)$row['month']] = $row['total_sales'];
}
$dbCon->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Per Year Report</title>
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
        <h2 class="title-page">Sales Per Year Report for <?php echo $year; ?></h2>
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
                <canvas id="salesPerYearChart"></canvas>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Total Sales (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($monthlySalesData as $month => $total_sales) {
                            echo "<tr>
                                    <td>" . date("F", mktime(0, 0, 0, $month, 1)) . "</td>
                                    <td>RM " . number_format($total_sales, 2) . "</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const ctx = document.getElementById('salesPerYearChart').getContext('2d');
        const salesPerYearChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Total Sales (RM)',
                    data: <?php echo json_encode(array_values($monthlySalesData)); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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
