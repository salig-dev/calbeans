<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');

if (isset($_POST['view_order'])) {
    $order_id = $_POST['order_id'];

    // Fetch the order details
    $stmt = $mysqli->prepare("SELECT * FROM rpos_orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_object();

    if ($order) {
        // Display the order summary and status change form
        ?>
        <body>
            <!-- Main content -->
            <div class="main-content">
                <div class="container-fluid mt--8">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h2>Order Summary</h2>
                                    <p><strong>Code:</strong> <?php echo $order->order_code; ?></p>
                                    <p><strong>Customer:</strong> <?php echo $order->customer_name; ?></p>
                                    <p><strong>Product:</strong> <?php echo $order->prod_name; ?></p>
                                    <p><strong>Unit Price:</strong> $<?php echo $order->prod_price; ?></p>
                                    <p><strong>Quantity:</strong> <?php echo $order->prod_qty; ?></p>
                                    <p><strong>Total Price:</strong> $<?php echo $order->prod_price * $order->prod_qty; ?></p>
                                    <p><strong>Status:</strong> <?php echo $order->order_status; ?></p>
                                    <form action="update_order_status.php?order_id=<?php echo $order->order_id; ?>" method="POST">
                                        <select name="new_status" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="Paid">Paid</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Cancelled">Cancelled</option>
                                        </select>
                                        <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        $_SESSION['error'] = "Order not found";
        header("Location: orders_reports.php"); // Redirect back to the order list page
        exit();
    }
}
?>
