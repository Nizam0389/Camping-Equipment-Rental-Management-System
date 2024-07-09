<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'staff') {
    header("location: login.php");
    exit;
}
include 'dbConnect.php';

// Fetch yearly sales data
$yearlySalesResult = $dbCon->query("SELECT YEAR(payment_date) as year, SUM(total_fee) as total_sales FROM payment GROUP BY YEAR(payment_date) ORDER BY year ASC");
$yearlySalesLabels = [];
$yearlySalesData = [];
while ($row = $yearlySalesResult->fetch_assoc()) {
    $yearlySalesLabels[] = $row['year'];
    $yearlySalesData[] = $row['total_sales'];
}

// Fetch category sales data
$categorySalesResult = $dbCon->query("SELECT item_type, SUM(rd_fee) as total_sales FROM rentaldetail rd JOIN item i ON rd.item_id = i.item_id GROUP BY item_type ORDER BY total_sales DESC");
$categoryLabels = [];
$categorySalesData = [];
while ($row = $categorySalesResult->fetch_assoc()) {
    $categoryLabels[] = $row['item_type'];
    $categorySalesData[] = $row['total_sales'];
}

$dbCon->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Summary</title>
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
        <h2 class="title-page">Sales Summary</h2>
        <div class="report-container">
            <div class="chart-container">
                <h3>Yearly Sales</h3>
                <canvas id="yearlySalesChart"></canvas>
            </div>
            <div class="chart-container">
                <h3>Sales by Category</h3>
                <canvas id="categorySalesChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        const yearlyCtx = document.getElementById('yearlySalesChart').getContext('2d');
        const yearlySalesChart = new Chart(yearlyCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($yearlySalesLabels); ?>,
                datasets: [{
                    label: 'Total Sales (RM)',
                    data: <?php echo json_encode($yearlySalesData); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true,
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

        const categoryCtx = document.getElementById('categorySalesChart').getContext('2d');
        const categorySalesChart = new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($categoryLabels); ?>,
                datasets: [{
                    label: 'Total Sales (RM)',
                    data: <?php echo json_encode($categorySalesData); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
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
