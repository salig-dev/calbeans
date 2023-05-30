<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
require_once('partials/_analytics.php');

// Calculate total sales for paid orders
$ret = "SELECT SUM(prod_price * prod_qty) AS total_sales FROM rpos_orders WHERE order_status = 'Paid'";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_object();
$total_sales = $row->total_sales;

// Store total sales value in session variable
$_SESSION['total_sales'] = $total_sales;
?>

<!DOCTYPE html>
<html lang="en">

<?php require_once('partials/_head.php'); ?>

<body>
    <!-- Sidenav -->
    <?php require_once('partials/_sidebar.php'); ?>
    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <?php require_once('partials/_topnav.php'); ?>
        <!-- Header -->
        <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body">
                    <!-- Card stats -->
                    <div class="row">
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Customers</h5>
                                            <span class="h2 font-weight-bold mb-0"><?php echo $customers; ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Products</h5>
                                            <span class="h2 font-weight-bold mb-0"><?php echo $products; ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                                <i class="fas fa-utensils"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Orders</h5>
                                            <span class="h2 font-weight-bold mb-0"><?php echo $orders; ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                                <i class="fas fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
                                            <span class="h2 font-weight-bold mb-0">₱ <?php echo number_format($_SESSION['total_sales'], 2); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                                <i class="fas fa-chart-bar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--7">
            <div class="row mt-5">
                <div class="col-xl-12 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Recent Orders</h3>
                                </div>
                                <div class="col text-right">
                                    <a href="orders_reports.php" class="btn btn-sm btn-primary">See all</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
    <!-- Orders table -->
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                <th class="text-success" scope="col">Code</th>
                <th scope="col">Customer</th>
                <th class="text-success" scope="col">Product</th>
                <th scope="col">Unit Price</th>
                <th class="text-success" scope="col">Quantity</th>
                <th scope="col">Total Price</th>
                <th scope="col">Status</th>
                <th scope="col">Order Date</th>
                <th scope="col">Order Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $ret = "SELECT customer_name, GROUP_CONCAT(order_id SEPARATOR ',') AS order_ids, GROUP_CONCAT(order_code SEPARATOR ',') AS order_codes, GROUP_CONCAT(prod_name SEPARATOR ',') AS prod_names, GROUP_CONCAT(prod_price SEPARATOR ',') AS prod_prices, GROUP_CONCAT(prod_qty SEPARATOR ',') AS prod_quantities, GROUP_CONCAT(order_status SEPARATOR ',') AS order_statuses, GROUP_CONCAT(created_at SEPARATOR ',') AS created_dates FROM rpos_orders GROUP BY customer_name ORDER BY created_at DESC";
            $stmt = $mysqli->prepare($ret);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_object()) {
                $order_ids = explode(',', $row->order_ids);
                $order_codes = explode(',', $row->order_codes);
                $prod_names = explode(',', $row->prod_names);
                $prod_prices = explode(',', $row->prod_prices);
                $prod_quantities = explode(',', $row->prod_quantities);
                $order_statuses = explode(',', $row->order_statuses);
                $created_dates = explode(',', $row->created_dates);
                $num_orders = count($order_ids);
                $total_price = 0;
                for ($i = 0; $i < $num_orders; $i++) {
                    $order_id = $order_ids[$i];
                    $order_code = $order_codes[$i];
                    $customer_name = $row->customer_name;
                    $prod_name = $prod_names[$i];
                    $prod_price = $prod_prices[$i];
                    $prod_qty = $prod_quantities[$i];
                    $total_price += $prod_price * $prod_qty;
                    $order_status = $order_statuses[$i];
                    $created_date = date('d/M/Y', strtotime($created_dates[$i]));
                    $created_time = date('g:i', strtotime($created_dates[$i]));
            ?>
                    <tr>
                        <?php if ($i === 0) { ?>
                            <td rowspan="<?php echo $num_orders; ?>" class="text-success" scope="row"><?php echo $order_code; ?></td>
                            <td rowspan="<?php echo $num_orders; ?>"><?php echo $customer_name; ?></td>
                        <?php } ?>
                        <td class="text-success"><?php echo $prod_name; ?></td>
                        <td>₱ <?php echo number_format($prod_price, 2); ?></td>
                        <td class="text-success"><?php echo $prod_qty; ?></td>
                        <?php if ($i === 0) { ?>
                            <td rowspan="<?php echo $num_orders; ?>">₱ <?php echo number_format($total_price, 2); ?></td>
                            <td rowspan="<?php echo $num_orders; ?>">
                                <?php if ($order_status == 'Paid') { ?>
                                    <span class="badge badge-success"><?php echo $order_status; ?></span>
                                <?php } else { ?>
                                    <span class="badge badge-danger"><?php echo $order_status; ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <td><?php echo $created_date; ?></td>
                        <td><?php echo $created_time; ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>


                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php //require_once('partials/_footer.php'); ?>
        </div>
    </div>
    <!-- Argon Scripts -->
    <?php require_once('partials/_scripts.php'); ?>
</body>
<!-- -->
</html>
