<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');

// Fetch Sales Data
$salesData = array();
$result = $mysqli->query("SELECT DATE(created_at) AS order_date, SUM(prod_price * prod_qty) AS total_sales FROM rpos_orders GROUP BY DATE(created_at)");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $salesData[$row['order_date']] = $row['total_sales'];
    }
}

// Fetch Top 10 Products
$topProducts = array();
$result = $mysqli->query("SELECT prod_name, SUM(prod_qty) AS total_quantity FROM rpos_orders GROUP BY prod_name ORDER BY total_quantity DESC LIMIT 10");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $topProducts[$row['prod_name']] = $row['total_quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales | Calbeans Coffee</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/icon/favicon.png" />

    <!-- STYLES -->
    <link rel="stylesheet" href="../../assets/css/calbeans-style.css" />
    <link rel="stylesheet" href="../../assets/css/dashboard.css">

    <!-- CHART.JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Sidenav -->
    <?php require_once('partials/_sidebar.php'); ?>

    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <?php require_once('partials/_topnav.php'); ?>

        <!-- Header -->
        <div style="background-image: url(../../assets/img/hero/hero.png); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body">
                </div>
            </div>
        </div>

        <!-- Page content -->
        <div class="container-fluid mt--8">
            <!-- Sales Chart -->
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            Sales Chart
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top 10 Products -->
            <div class="row mt-4">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            Top 10 Products
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity Sold</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($topProducts as $product => $quantity) {
                                        echo "<tr>";
                                        echo "<td>$product</td>";
                                        echo "<td>$quantity</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <?php require_once('partials/_footer.php'); ?>
        </div>
    </div>

    <!-- Argon Scripts -->
    <?php require_once('partials/_scripts.php'); ?>

    <!-- Initialize Sales Chart -->
    <script>
        var salesData = <?php echo json_encode(array_values($salesData)); ?>;
        var salesLabels = <?php echo json_encode(array_keys($salesData)); ?>;

        var salesChart = new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: salesLabels,
                datasets: [{
                    label: 'Total Sales',
                    data: salesData,
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    pointRadius: 1,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    lineTension: 0.3
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            displayFormats: {
                                day: 'MMM D'
                            }
                        },
                        ticks: {
                            source: 'auto',
                            maxRotation: 0,
                            autoSkip: true
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value, index, values) {
                                if (Math.floor(value) === value) {
                                    return value;
                                }
                            }
                        }
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function (context) {
                            return '₱' + context.value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                        }
                    }
                },
                legend: {
                    display: false
                }
            }
        });
    </script>
</body>
</html>
