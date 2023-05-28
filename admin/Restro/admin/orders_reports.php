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

    $stmt = $mysqli->prepare("UPDATE rpos_orders SET order_status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success'] = "Order status updated successfully";
    } else {
        $_SESSION['error'] = "Failed to update order status";
    }
}

?>

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
        <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
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
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            Orders Records
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-success" scope="col">Code</th>
                                        <th scope="col">Customer</th>
                                        <th class="text-success" scope="col">Product</th>
                                        <th scope="col">Unit Price</th>
                                        <th class="text-success" scope="col">#</th>
                                        <th scope="col">Total Price</th>
                                        <th scop="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th> <!-- New column for action -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT customer_name, GROUP_CONCAT(order_id SEPARATOR ',') AS order_ids, GROUP_CONCAT(order_code SEPARATOR ',') AS order_codes, GROUP_CONCAT(prod_name SEPARATOR ',') AS prod_names, GROUP_CONCAT(prod_price SEPARATOR ',') AS prod_prices, GROUP_CONCAT(prod_qty SEPARATOR ',') AS prod_quantities, GROUP_CONCAT(order_status SEPARATOR ',') AS order_statuses, GROUP_CONCAT(created_at SEPARATOR ',') AS created_dates FROM rpos_orders GROUP BY customer_name ORDER BY `created_at` DESC";
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

                                        // Get the total number of orders made by the customer
                                        $num_orders = count($order_ids);
                                    ?>
                                        <tr>
                                            <td rowspan="<?php echo $num_orders; ?>" class="text-success" scope="row"><?php echo $order_codes[0]; ?></td>
                                            <td rowspan="<?php echo $num_orders; ?>"><?php echo $row->customer_name; ?></td>
                                            <td class="text-success"><?php echo $prod_names[0]; ?></td>
                                            <td>$ <?php echo $prod_prices[0]; ?></td>
                                            <td class="text-success"><?php echo $prod_quantities[0]; ?></td>
                                            <td rowspan="<?php echo $num_orders; ?>">$ <?php echo array_sum($prod_prices); ?></td>
                                            <td rowspan="<?php echo $num_orders; ?>">
                                                <?php
                                                if ($order_statuses[0] == '') {
                                                    echo "<span class='badge badge-danger'>Not Paid</span>";
                                                } else {
                                                    echo "<span class='badge badge-success'>$order_statuses[0]</span>";
                                                }
                                                ?>
                                            </td>
                                            <td rowspan="<?php echo $num_orders; ?>"><?php echo date('d/M/Y g:i', strtotime($created_dates[0])); ?></td>
                                            <td rowspan="<?php echo $num_orders; ?>">
                                                <!-- Edit Status Form -->
                                                <form action="order_summary.php" method="POST" target="_self">
                                                    <input type="hidden" name="order_id" value="<?php echo $order_ids[0]; ?>">
                                                    <button type="submit" name="view_order" class="btn btn-primary btn-sm">View Order</button>
                                                </form>
                                                <!-- <form action="order_summary.php" method="POST" target="order_summary.php">
                                                    <input type="hidden" name="order_id" value="<?php echo $order_ids[0]; ?>">
                                                    <button type="submit" name="update_status" class="btn btn-success btn-sm">Update Status</button>
                                                </form> -->
                                            </td>
                                        </tr>
                                        <?php
                                        for ($i = 1; $i < $num_orders; $i++) {
                                        ?>
                                            <tr>
                                                <td class="text-success"><?php echo $prod_names[$i]; ?></td>
                                                <td>$ <?php echo $prod_prices[$i]; ?></td>
                                                <td class="text-success"><?php echo $prod_quantities[$i]; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <?php
            require_once('partials/_footer.php');
            ?>
        </div>
    </div>

    <!-- Argon Scripts -->
    <?php
    require_once('partials/_scripts.php');
    ?>
</body>

</html>
