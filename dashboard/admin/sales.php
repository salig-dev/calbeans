<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');

// Fetch Top 10 Products
$topProducts = array();
$result = $mysqli->query("SELECT prod_name, SUM(prod_qty) AS total_quantity FROM rpos_orders GROUP BY prod_name ORDER BY total_quantity DESC LIMIT 10");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $topProducts[$row['prod_name']] = $row['total_quantity'];
    }
} else {
    $topProducts = array(); // Set an empty array if no top products found
}

// Fetch Daily Sales Data
$dailySalesData = array();
$result = $mysqli->query("SELECT DATE(created_at) AS order_date, SUM(prod_price * prod_qty) AS total_sales FROM rpos_orders GROUP BY DATE(created_at)");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dailySalesData[$row['order_date']] = $row['total_sales'];
    }
} else {
    $dailySalesData[date('Y-m-d')] = 0; // Set today's sales to 0 if no sales found
}

// Get today's sales amount
$todaySales = isset($dailySalesData[date('Y-m-d')]) ? $dailySalesData[date('Y-m-d')] : 0;


// Fetch Monthly Sales Data
$monthlySalesData = array();
$result = $mysqli->query("SELECT DATE_FORMAT(created_at, '%Y-%m') AS order_month, SUM(prod_price * prod_qty) AS total_sales FROM rpos_orders GROUP BY DATE_FORMAT(created_at, '%Y-%m')");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $monthlySalesData[$row['order_month']] = $row['total_sales'];
    }
}

// Calculate Yearly Sales
$yearlySales = 0;
$result = $mysqli->query("SELECT SUM(prod_price * prod_qty) AS total_sales FROM rpos_orders");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $yearlySales = $row['total_sales'];
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
            <div class="row">
                <div class="col-lg-4">
                   <!-- Daily Sales Summary -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Daily Sales</h5>
                        <h3 class="card-text">₱<?php echo $todaySales; ?></h3>
                    </div>
                </div>
                </div>
                <div class="col-lg-4">
                    <!-- Monthly Sales Summary -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Monthly Sales</h5>
                            <h3 class="card-text">₱<?php echo array_sum($monthlySalesData); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Yearly Sales Summary -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Yearly Sales</h5>
                            <h3 class="card-text">₱<?php echo $yearlySales; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-lg-6">
    <!-- Top 10 Products -->
    <div class="card shadow mb-4">
        <div class="card-header border-0">
            <h3 class="mb-0">Top 10 Products</h3>
        </div>
        <div class="table-responsive" style="padding: 0 20px;">
            <?php if (count($topProducts) > 0) { ?>
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>Rank</th>
                            <th>Product</th>
                            <th class="text-right">Quantity Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rank = 1;
                        foreach ($topProducts as $product => $quantity) {
                            echo "<tr>";
                            echo "<td>$rank</td>";
                            echo "<td>$product</td>";
                            echo "<td class='text-right'>$quantity</td>";
                            echo "</tr>";
                            $rank++;
                        }
                        ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>No top products found.</p>
            <?php } ?>
        </div>
    </div>
</div>

                <div class="col-lg-6">
                    <!-- Daily Sales Chart -->
                    <div class="card shadow mb-4">
                        <div class="card-header border-0">
                            <h3 class="mb-0">Daily Sales</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="dailySalesChart" style="height: 400px; width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- Monthly Sales Chart -->
                    <div class="card shadow mb-4">
                        <div class="card-header border-0">
                            <h3 class="mb-0">Monthly Sales</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlySalesChart" style="height: 400px; width: 100%;"></canvas>
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

   <!-- Initialize Daily Sales Chart -->
    <script>
        var dailySalesData = <?php echo json_encode(array_values($dailySalesData)); ?>;
        var dailySalesLabels = <?php echo json_encode(array_map(function ($date) {
            return date('M j, Y', strtotime($date));
        }, array_keys($dailySalesData))); ?>;

        var dailySalesChart = new Chart(document.getElementById('dailySalesChart'), {
            type: 'line',
            data: {
                labels: dailySalesLabels,
                datasets: [{
                    label: 'Daily Sales (in ₱)',
                    data: dailySalesData,
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    pointRadius: 5, // Increased the point radius to make dots bigger
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHoverRadius: 5, // Increased the point hover radius to make dots bigger
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    lineTension: 0.3
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            displayFormats: {
                                day: 'MMM D, Y'
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
                                    return '₱' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                var value = context.parsed.y;
                                if (Math.floor(value) === value) {
                                    return '₱' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                } else {
                                    return '₱' + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                                }
                            }
                        }
                    }
                },
                legend: {
                    display: false
                }
            }
        });
    </script>

    <!-- Initialize Monthly Sales Chart -->
    <script>
        var monthlySalesData = <?php echo json_encode(array_values($monthlySalesData)); ?>;
        var monthlySalesLabels = <?php echo json_encode(array_keys($monthlySalesData)); ?>;

        var monthlySalesChart = new Chart(document.getElementById('monthlySalesChart'), {
            type: 'bar',
            data: {
                labels: monthlySalesLabels,
                datasets: [{
                    label: 'Monthly Sales (in ₱)',
                    data: monthlySalesData,
                    backgroundColor: 'rgba(78, 115, 223, 0.5)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 0,
                            autoSkip: true
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value, index, values) {
                                if (Math.floor(value) === value) {
                                    return '₱' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                var value = context.parsed.y;
                                if (Math.floor(value) === value) {
                                    return '₱' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                } else {
                                    return '₱' + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                                }
                            }
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
