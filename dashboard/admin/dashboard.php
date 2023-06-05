<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Dashboard | Calbeans Coffee</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/icon/favicon.png" />

    <?php
    session_start();
    include('config/config.php');
    include('config/checklogin.php');
    check_login();
    require_once('partials/_head.php');
    require_once('partials/_analytics.php');

    // Calculate total sales
    $ret = "SELECT SUM(prod_price * prod_qty) AS total_sales FROM rpos_orders";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_object();
    $total_sales = $row->total_sales;

    // Store total sales value in session variable
    $_SESSION['total_sales'] = $total_sales;
    ?>
    <?php
    // Calculate total sales for paid orders
    $ret = "SELECT SUM(prod_price * prod_qty) AS total_sales
        FROM rpos_orders
        WHERE order_status = 'paid'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_object();
    $total_sales = $row->total_sales;

    // Store total sales value in session variable
    $_SESSION['total_sales'] = $total_sales;
    ?>

    <?php require_once('partials/_head.php'); ?>

    <!-- STYLES -->
    <link rel="stylesheet" href="../../assets/css/calbeans-style.css" />
    <link rel="stylesheet" href="../../assets/css/dashboard.css">

<body>
    <!-- Sidenav -->
    <?php require_once('partials/_sidebar.php'); ?>
    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <?php require_once('partials/_topnav.php'); ?>
        <!-- Header -->
        <div class="header container-fluid pb-8 pt-5 pt-md-8" style="background-image: url(../../assets/img/hero/hero.png); background-size: cover;">
            <span class="mask bg-gradient-dark opacity-8"></span>
                <!-- Card stats -->
                <div class="header-body container row mx-auto">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-11 mx-md-0 px-xl-1 mx-auto">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Customers</h5>
                                        <span class="h2 font-weight-bold mb-0"><?php echo $customers; ?></span>
                                    </div>
                                    <div class="col-auto px-0 mr-1">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-11 mx-md-0 px-xl-1 mx-auto">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Products</h5>
                                        <span class="h2 font-weight-bold mb-0"><?php echo $products; ?></span>
                                    </div>
                                    <div class="col-auto px-0 mr-1">
                                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                            <i class="fas fa-utensils"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-11 mx-md-0 px-xl-1 mx-auto">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Orders</h5>
                                        <span class="h2 font-weight-bold mb-0"><?php echo $orders; ?></span>
                                    </div>
                                    <div class="col-auto px-0 mr-1">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-11 mx-md-0 px-xl-1 mx-auto">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row justify-content-between">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
                                            <span class="h2 font-weight-bold mb-0">₱ <?php echo number_format($_SESSION['total_sales'], 2); ?></span>
                                        </div>
                                        <div class="col-auto px-0 mr-1">
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
        <!-- Page content -->
        <main class="container-fluid row overflow-visible mt--7 ">
            <div class="card shadow col-xl-12 col mt-5 mb-xl-0 mb-5 px-0 mx-auto">

                <!-- Card Header -->
                <section class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Recent Orders</h3>
                        </div>
                        <div class="col text-right">
                            <a href="orders_reports.php" class="btn btn-sm btn-primary">See all</a>
                        </div>
                    </div>
                </section>

                <!-- Projects table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr class="__prod_tr">
                                <th scope="col">Code</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Product</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Status</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Order Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ret = "SELECT order_id, order_code, customer_name, prod_name, prod_price, prod_qty, order_status, created_at FROM rpos_orders ORDER BY created_at DESC";
                            $stmt = $mysqli->prepare($ret);
                            $stmt->execute();
                            $res = $stmt->get_result();
                            while ($row = $res->fetch_object()) {
                                $order_id = $row->order_id;
                                $order_code = $row->order_code;
                                $customer_name = $row->customer_name;
                                $prod_name = $row->prod_name;
                                $prod_price = $row->prod_price;
                                $prod_qty = $row->prod_qty;
                                $order_status = $row->order_status;
                                $created_at = $row->created_at;

                                $total_price = (int)$prod_price * (int)$prod_qty;
                                $date = date('d/M/Y', strtotime($created_at));
                                $time = date('g:i A', strtotime($created_at));
                            ?>
                                <tr class="__prod_tr">
                <!-- CODE -->       <td class="__prod_code " scope="row"><?php echo $order_code; ?></td>
                <!-- CUSTOMER -->   <td class="__td-w-0" ><?php echo $customer_name; ?></td>
                <!-- PRODUCT -->    <td class="__prod_name "><?php echo $prod_name; ?></td>
                <!-- UNIT PRICE --> <td class="__td-w-0"><b>₱</b> <?php echo number_format($prod_price, 2, '.', ','); ?></td>
                <!-- QUANTITY -->   <td class="__td-w-0 "><?php echo $prod_qty; ?></td>
                <!-- TOTAL PRICE --><td class=""><b>₱</b> <?php echo number_format($total_price, 2, '.', ','); ?></td>
                <!-- STATUS -->     <td>
                                        <?php if ($row->order_status == '') { ?>
                                            <span class='badge badge-danger'>Not Paid</span>
                                        <?php } else if ($row->order_status == 'Pending') { ?>
                                            <span class='badge badge-warning'>Pending</span>
                                        <?php } else if ($row->order_status == 'Cancelled') { ?>
                                            <span class='badge badge-light'>Cancelled</span>
                                        <?php } else { ?>
                                            <span class='badge badge-success'><?php echo $row->order_status; ?></span>
                                        <?php } ?>
                                    </td>
                <!-- ORDER DATE --> <td><?php echo $date; ?></td>
                <!-- ORDER TIME --> <td><?php echo $time; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- Footer -->
            <?php //require_once('partials/_footer.php'); 
            ?>
        </main>
    </div>
    <!-- Argon Scripts -->
    <?php require_once('partials/_scripts.php'); ?>
</body>
<!-- -->

</html>