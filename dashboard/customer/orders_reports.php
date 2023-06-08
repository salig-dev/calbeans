<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Place Order | Calbeans Coffee</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/icon/favicon.png" />

  <?php
  session_start();
  include('config/config.php');
  include('config/checklogin.php');
  check_login();
  require_once('partials/_head.php');

  // Delete Order
  if (isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];

    $stmt = $mysqli->prepare("DELETE FROM rpos_orders WHERE order_id = ? LIMIT 1");
    $stmt->bind_param("s", $order_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      $_SESSION['success'] = "Order deleted successfully";
    } else {
      $_SESSION['error'] = "Failed to delete order";
    }
  }
  ?>

  <!-- STYLES -->
  <link rel="stylesheet" href="../../assets/css/calbeans-style.css" />
  <link rel="stylesheet" href="../../assets/css/dashboard.css">
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
    <main class="container-fluid mt--8">
      <!-- Table -->
      <div class="row">
        <div class="col mx-auto">
          <div class="card shadow">
            <div class="card-header border-0">
              Orders Records
            </div>
            <div class="table-responsive">
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
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $customer_id = $_SESSION['customer_id'];
                  $ret = "SELECT * FROM rpos_orders WHERE customer_id = '$customer_id' ORDER BY created_at DESC LIMIT 10";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($order = $res->fetch_object()) {
                    $total = (int)$order->prod_price * (int)$order->prod_qty;
                  ?>
                    <tr>
                      <td scope="row"><?php echo $order->order_code; ?></td>
                      <td><?php echo $order->customer_name; ?></td>
                      <td><?php echo $order->prod_name; ?></td>
                      <td>₱ <?php echo number_format($order->prod_price, 2, '.', ','); ?></td>
                      <td><?php echo $order->prod_qty; ?></td>
                      <td>₱ <?php echo number_format($total, 2, '.', ','); ?></td>
                      <td>
                        <?php if ($order->order_status == '') { ?>
                          <span class="badge badge-danger">Not Paid</span>
                        <?php } else if ($order->order_status == 'Pending') { ?>
                          <span class="badge badge-warning">Pending</span>
                        <?php } else if ($order->order_status == 'Cancelled') { ?>
                          <span class="badge badge-light">Cancelled</span>
                        <?php } else { ?>
                          <span class="badge badge-success"><?php echo $order->order_status; ?></span>
                        <?php } ?>
                      </td>
                      <td><?php echo date('d/M/Y g:i A', strtotime($order->created_at)); ?></td>
                      <td>
                        <form method="POST" action="">
                          <input type="hidden" name="order_id" value="<?php echo $order->order_id; ?>">
                          <button type="submit" name="delete_order" onclick="return confirm('Are you sure you want to delete this order?')" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <!-- Argon Scripts -->
  <?php require_once('partials/_scripts.php'); ?>
</body>

</html>
