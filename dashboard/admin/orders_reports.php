<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Records | Calbeans Coffee</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/icon/favicon.png"
    />

    <?php
    session_start();
    include('config/config.php');
    include('config/checklogin.php');
    check_login();
    require_once('partials/_head.php');

    // Update Order Status
    if (isset($_POST['update_status'])) {
        $order_id = $_POST['order_id'];
        $new_status = $_POST['new_status'];

        $stmt = $mysqli->prepare("UPDATE rpos_orders SET order_status = ? WHERE order_id = ? limit 1");
        $stmt->bind_param("ss", $new_status, $order_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Order status updated successfully";
        } else {
            $_SESSION['error'] = "Failed to update order status";
        }
    }

    // Delete Order
    if (isset($_POST['delete_order'])) {
        $order_id = $_POST['order_id'];

        $stmt = $mysqli->prepare("DELETE FROM rpos_orders WHERE order_id = ? limit 1");
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
        <div class="container-fluid mt--8">
            <!-- Table -->
            <div class="row">
                <div class="col mx-auto">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            Orders Records
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Code</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Order Date</th>
                                        <th scope="col">Action</th> <!-- New column for action -->
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $ret = "SELECT order_id, order_code, customer_name, prod_name, prod_price, prod_qty, order_status, created_at FROM rpos_orders ORDER BY created_at DESC";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($row = $res->fetch_object()) {
                                    ?>
                                    <tr>
                                        <td class="__prod_code"><?php echo $row->order_code; ?></td>
                                        <td class="__td-w-0"><?php echo $row->customer_name; ?></td>
                                        <td class="__prod_name"><?php echo $row->prod_name; ?></td>
                                        <td><b>₱</b> <?php echo number_format($row->prod_price, 2, '.', ','); ?></td>
                                        <td class="__td-w-0"><?php echo $row->prod_qty; ?></td>
                                        <td class="__td-w-0"><b>₱</b> <?php echo number_format((int)$row->prod_price * (int)$row->prod_qty, 2, '.', ','); ?></td>
                                        <td>
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
                                        <td class="__td-w-0"><?php echo date('d/M/Y g:i A', strtotime($row->created_at)); ?></td>
                                        <td>
                                            <!-- View Order Form -->
                                            <form action="order_summary.php" method="POST" target="_self" style="display: inline-block;">
                                                <input type="hidden" name="order_id" value="<?php echo $row->order_id; ?>">
                                                <!-- <?php // RESERVED FOR DEBUGGING: echo $row->order_id; ?> -->
                                                <button type="submit" name="view_order" style="width:85px" class="btn btn-primary btn-sm">View Order</button>
                                            </form>
                                            <div class="my-2"></div>
                                            <!-- Delete Order Form -->
                                            <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?')" style="display: inline-block;">
                                                <input type="hidden" name="order_id" value="<?php echo $row->order_id; ?>">
                                                <?php // RESERVED FOR DEBUGGING: echo $row->order_id; ?>
                                                <button type="submit" name="delete_order" style="min-width:85px" class="btn btn-danger btn-sm">Delete</button>
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

            <!-- Footer -->
            <?php require_once('partials/_footer.php'); ?>
        </div>
    </div>

    <!-- Argon Scripts -->
    <?php require_once('partials/_scripts.php'); ?>
</body>
</html>
