<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');


if (isset($_GET['proceed']) && $_GET["proceed"] == "true") {
    $order_id = $_GET['order_id'];

    // Fetch the order details including customer name
    $stmt = $mysqli->prepare("SELECT * FROM rpos_orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_object();
    if ($order) {
        // Fetch all the orders made by the customer
        $stmt = $mysqli->prepare("SELECT * FROM rpos_orders WHERE customer_name = ?");
        $stmt->bind_param("s", $order->customer_name);
        $stmt->execute();
        $orders_result = $stmt->get_result();
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <center><h2>Customer Orders</h2></center>
                    <div class="card shadow">
                        <div class="card-body">
                            <h3>Orders Summary</h3>
                            <?php
                            while ($order_row = $orders_result->fetch_object()) {
                                ?>
                                <p><strong>Customer:</strong> <?php echo $order_row->customer_name; ?></p>
                                <hr>
                                <p><strong>Product:</strong> <?php echo $order_row->prod_name; ?></p>
                                <p><strong>Unit Price:</strong> ₱<?php echo $order_row->prod_price; ?></p>
                                <p><strong>Quantity:</strong> <?php echo $order_row->prod_qty; ?></p>
                                <p><strong>Total Price:</strong> ₱<?php echo $order_row->prod_price * $order_row->prod_qty; ?></p>
                                <p><strong>Status:</strong> <?php echo $order_row->order_status; ?></p>
                                <form action="update_order_status.php" method="POST">
                                    <input type="hidden" name="order_id" value="<?php echo $order_row->order_id; ?>">
                                    <input type="hidden" name="customer_name" value="<?php echo $order_row->customer_name; ?>">
                                    <select name="new_status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                                </form>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        $_SESSION['error'] = "Order not found";
        header("Location: orders_reports.php"); // Redirect back to the order list page
        exit();
    }
}
?>

