<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    // Fetch the current order status and created_at from the database
    $stmt = $mysqli->prepare("SELECT order_status, created_at FROM rpos_orders WHERE order_id = ?");
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_object();

    if ($order) {
        $current_status = $order->order_status;
        $created_at = $order->created_at;

        // Update the order status in the database for the specific order
        $stmt = $mysqli->prepare("UPDATE rpos_orders SET order_status = ? WHERE order_id = ? AND order_status = ?");
        $stmt->bind_param("sss", $new_status, $order_id, $current_status);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                // Reset the created_at value
                $stmt = $mysqli->prepare("UPDATE rpos_orders SET created_at = ? WHERE order_id = ? AND order_status = ?");
                $stmt->bind_param("sss", $created_at, $order_id, $new_status);
                $stmt->execute();

                $_SESSION['success'] = "Order status updated successfully";
            } else {
                $_SESSION['error'] = "Failed to update order status";
            }
        } else {
            $_SESSION['error'] = "Failed to execute the update query";
        }
    } else {
        $_SESSION['error'] = "Order not found";
    }
}

header("Location: orders_reports.php"); // Redirect back to the order list page
exit();
?>
