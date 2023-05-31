<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
        }

        table {
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Confirmation</h1>
        
        <?php if (isset($success)) { ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php } ?>

        <?php 
            $order_code = isset($_GET['order_code']) ? $_GET['order_code'] : null;
            
            if ($order_code) {
                // Retrieve the order details based on the order code
                $ret = "SELECT * FROM rpos_orders WHERE order_code ='$order_code'";
                $stmt = $mysqli->prepare($ret);
                $stmt->bind_param('s', $order_code);
                $stmt->execute();
                $res = $stmt->get_result();
                $order = $res->fetch_object();
                $stmt->close();
            }
        ?>

       <?php if (isset($order)) { ?>
    <p>Order Code: <?php echo $order->order_code; ?></p>
<?php } else { ?>
    <p>No order found with the provided order code.</p>
<?php } ?>

        <p>Please review your order details and select an action:</p>

        <form method="POST">
            <input type="submit" name="cancel" value="Cancel Order">
            <input type="submit" name="proceed" value="Proceed with Order">
        </form>

        <?php
            // ...
            
            if (isset($_POST['cancel'])) {
                // Code for canceling the order
            
                // Redirect back to make_order.php
                header("Location: orders.php");
                exit;
            }
            
            if (isset($_POST['proceed'])) {
                $success = "Order Submitted";
                header("refresh:1; url=order_summary.php");
            
                // Redirect to order_summary.php with the order_code parameter
                $order_code = $order->order_code;
                header("Location: order_summary.php?proceed=true&order_id={$_GET['order_id']}");
                exit;
            }
            ?>
    </div>
</body>
</html>
