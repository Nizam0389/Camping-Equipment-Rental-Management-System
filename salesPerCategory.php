<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['user_type'] !== 'staff') {
    header("location: login.php");
    exit;
}
include 'dbConnect.php';

// Fetch sales data per category
$sql = "SELECT item_type, SUM(total_fee) as total_sales
        FROM rentaldetail
        JOIN item ON rentaldetail.item_id = item.item_id
        JOIN payment ON rentaldetail.rent_id = payment.rent_id
        GROUP BY item_type";
$result = $dbCon->query($sql);

// Prepare data for the chart
$categorySalesData = [];
$categoryLabels = [];
while ($row = $result->fetch_assoc()) {
    $categorySalesData[] = $row['total_sales'];
    $categoryLabels[] = $row['item_type'];
}
$dbCon->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Per Category Report</title>
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
        <h2 class="title-page">Sales Per Category Report</h2>
        <div class="report-container">
            <div class="chart-container">
                <canvas id="salesPerCategoryChart"></canvas>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Total Sales (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($categorySalesData as $index => $total_sales) {
                            echo "<tr>
                                    <td>" . $categoryLabels[$index] . "</td>
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
        const ctx = document.getElementById('salesPerCategoryChart').getContext('2d');
        const salesPerCategoryChart = new Chart(ctx, {
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
                    borderWidth: 1,
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
