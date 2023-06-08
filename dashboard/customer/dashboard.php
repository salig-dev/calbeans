<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Dashboard | Calbeans Coffee</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="../../assets/img/icon/favicon.png"
    />

<?php
session_start();
include('config/config.php'); 
include('config/checklogin.php');
check_login();

require_once('partials/_head.php');
require_once('partials/_analytics.php');
?>

    <!-- STYLES -->
    <link rel="stylesheet" href="../../assets/css/calbeans-style.css" />
    <link rel="stylesheet" href="../../assets/css/dashboard.css">

<body>
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    ?>
    <!-- Header -->
    <div style="background-image: url(../../assets/img/hero/hero.png); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 col-11 mx-md-0 mx-auto">
              <a href="orders.php">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row justify-content-between">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Available Items</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $products; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-purple text-white rounded-circle shadow">
                          <i class="fas fa-utensils"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 col-11 mx-md-0 mx-auto">
              <a href="orders_reports.php">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row justify-content-between">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total Orders</h5>
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
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <main class="container-fluid mt--7 mx-auto">
        <div class="row">
          <div class="card shadow col-xl-11 col-12 mt-5 mx-auto mb-5 mb-xl-0 px-0">
            <section class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Recent Orders</h3>
                </div>
                <div class="col text-right">
                  <a href="orders_reports.php" class="btn btn-sm btn-primary">See all</a>
                </div>
            </section>
            
            <section class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Product</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">#</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $customer_id = $_SESSION['customer_id'];
                  $ret = "SELECT * FROM  rpos_orders WHERE customer_id = '$customer_id' ORDER BY `rpos_orders`.`created_at` DESC LIMIT 10 ";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($order = $res->fetch_object()) {
                    $total = ((int)$order->prod_price * (int)$order->prod_qty); // convert the variables to integers in your code:

                  ?>
                    <tr>
                      <td class="" scope="row"><?php echo $order->order_code; ?></td>
                      <td class="__td-w-0"><?php echo $order->customer_name; ?></td>
                      <td class="__prod_name"><?php echo $order->prod_name; ?></td>
                      <td class="__td-w-0"><b>₱</b> <?php echo number_format($order->prod_price, 2, '.', ','); ?></td>
                      <td class="__td-w-0"><?php echo $order->prod_qty; ?></td>
                      <td class="__td-w-0"><b>₱</b> <?php echo number_format($total, 2, '.', ',');?></td>
                      <td class="">
                        <?php if ($order->order_status == '') { ?>
                          <span class='badge badge-danger'>Not Paid</span>
                        <?php } else if ($order->order_status == 'Pending') { ?>
                          <span class='badge badge-warning'>Pending</span>
                        <?php } else if ($order->order_status == 'Cancelled') { ?>
                          <span class='badge badge-light'>Cancelled</span>
                        <?php } else { ?>
                          <span class='badge badge-success'><?php echo $order->order_status; ?></span>
                        <?php } ?>
                      </td>
                      <td class="__td-w-0"><?php echo date('d/M/Y g:i A', strtotime($order->created_at)); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </section>
          </div>
        </div>
    </main>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>
</html>