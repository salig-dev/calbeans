<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    // Update the order status in the database for the specific order
    $stmt = $mysqli->prepare("UPDATE rpos_orders SET order_status = ? WHERE order_id = ? LIMIT 1");
    $stmt->bind_param("ss", $new_status, $order_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success'] = "Order status updated successfully";
    } else {
        $_SESSION['error'] = "Failed to update order status";
    }
}

header("Location: orders_reports.php"); // Redirect back to the order list page
exit();
?>
