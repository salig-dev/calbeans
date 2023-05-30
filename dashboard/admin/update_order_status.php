<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    // Fetch the order details including customer name
    $stmt = $mysqli->prepare("SELECT * FROM rpos_orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_object();

    if ($order) {
        // Update the order status in the database for orders with the same customer name
        $stmt = $mysqli->prepare("UPDATE rpos_orders SET order_status = ? WHERE customer_name = ?");
        $stmt->bind_param("ss", $new_status, $order->customer_name);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Order status updated successfully";
        } else {
            $_SESSION['error'] = "Failed to update order status";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Order not found";
    }

    $mysqli->close();

    header("Location: orders_reports.php");
    exit();
}
?>
