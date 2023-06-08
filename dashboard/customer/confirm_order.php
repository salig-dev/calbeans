<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Confirm Order | Calbeans Coffee</title>
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

    if (isset($_POST['cancel'])) {
        // Code for canceling the order

        // Delete the order from the database
        $stmt = $mysqli->prepare("DELETE FROM rpos_orders WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

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
}
?>


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Head content -->
</head>
<body class="hero-overly">
    <!-- HTML content -->
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Order Summary | Calbeans Coffee</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="../../assets/img/icon/favicon.png"
    />

    <!-- STYLES -->
    <link rel="stylesheet" href="../../assets/css/calbeans-style.css" />
    <link rel="stylesheet" href="../../assets/css/nice-select.css" />

</head>

    <body class="hero-overly">
        <style>
            .main-content {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                padding: 25px;
                height: 100%;
            }

            .card {
                width: 40%;
                height: 100%;
                margin: 0 auto;
                /* Center the card horizontally */
                padding: 10px;
                /* Add some padding */
                text-align: center;
                background-color: #f6f1ea;
            }

            html,
            body {
                background-image: url("../../assets/img/hero/3.png");
                background-size: cover;
                font-family: 'Chivo', sans-serif;
                font-weight: 200;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-family: "Brice", "Chivo", sans-serif;
                color: #d4ac63;
                margin-top: 0px;
                font-style: normal;
                font-weight: 500;
                text-transform: normal;
                letter-spacing: 0.1rem;
            }

            .margin {
                margin-top: 1rem;
            }
        </style>
        <!-- Main Content -->
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-body">
                                <h1 class="title">CONFIRM ORDER</h1>
                                <hr>
                                <p><strong>Customer:</strong> <?php echo $order->customer_name; ?></p>
                                <p><strong>Products:</strong> <?php echo $order->prod_name; ?></p>
                                <p><strong>Unit Price:</strong> ₱<?php echo $order->prod_price; ?></p>
                                <p><strong>Quantity:</strong> <?php echo $order->prod_qty . ' ' . $order->prod_name; ?></p>
                                <p><strong>Total Price:</strong> ₱<?php echo $order->prod_price * $order->prod_qty; ?></p>
                                <hr>
                                <form method="POST">
                                    <input type="submit" name="cancel" value="Cancel Order" class="btn btn-danger margin">
                                    <input type="submit" name="proceed" value="Proceed with Order" class="btn btn-primary margin">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
