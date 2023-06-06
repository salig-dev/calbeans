<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Place Order | Calbeans Coffee</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" type="image/x-icon" href="../../assets/img/icon/favicon.png"/>

<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['make'])) {
    // Prevent Posting Blank Values
    if (empty($_POST["order_code"]) || empty($_POST["customer_name"]) || empty($_POST['prod_qty'])) {
        $err = "Blank Values Not Accepted";
    } else {
        $order_id = $_POST['order_id'];
        $order_code = $_POST['order_code'];
        $customer_id = $_SESSION['customer_id'];
        $customer_name = $_POST['customer_name'];
        $prod_id = $_GET['prod_id'];
        $prod_name = $_GET['prod_name'];
        $prod_price = $_GET['prod_price'];
        $prod_qty = $_POST['prod_qty'];

        // Insert Captured information to a database table
        $postQuery = "INSERT INTO rpos_orders (prod_qty, order_id, order_code, customer_id, customer_name, prod_id, prod_name, prod_price) VALUES(?,?,?,?,?,?,?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        if (
            $postStmt &&
            $postStmt->bind_param(
                'ssssssss',
                $prod_qty,
                $order_id,
                $order_code,
                $customer_id,
                $customer_name,
                $prod_id,
                $prod_name,
                $prod_price
            ) &&
            $postStmt->execute()
        ) {
            $success = "Order Submitted";
           header("refresh:1; url=confirm_order.php?order_id=$order_id");
        } else {
            $err = "Please Try Again Or Try Later";
        }
    }
}
require_once('partials/_head.php');
?>

    <!-- STYLES -->
    <link rel="stylesheet" href="../../assets/css/dashboard.css">

    <link rel="stylesheet" href="../../assets/css/calbeans-style.css" />
    
<body>
    <!-- Sidenav -->
    <?php require_once('partials/_sidebar.php'); ?>
    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <?php require_once('partials/_topnav.php'); ?>
        <!-- Header -->
        <div style="background-image: url(../../assets/img/hero/hero.png); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
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
                <div class="col-xl-11 col-lg-10 col-sm-12 col-11 mx-auto">
                    <div class="card shadow">
                        <div class="card-header border-0 pb-2">
                            <h3>Please Fill All Fields</h3>
                        </div>
                        <div class="card-body py-0">
                            <form method="POST" enctype="multipart/form-data">
                            <div class="card-body py-0">
                            <form method="POST" enctype="multipart/form-data">


                                <div class="col-md-12">
                                    <?php
                                    //Load All Customers
                                    $customer_id = $_SESSION['customer_id'];
                                    $ret = "SELECT * FROM  rpos_customers WHERE customer_id = '$customer_id' ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($cust = $res->fetch_object()) {
                                        $prod_id = $_GET['prod_id'];
                                        $ret = "SELECT * FROM  rpos_products WHERE prod_id = '$prod_id'";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($prod = $res->fetch_object()) {
                                    ?>

                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <table>
                                                        <tr>
                                                            <th scope="col"> Name:</th>
                                                        </tr>

                                                        <tr>
                                                            <td> <?php echo $prod->prod_name; ?> </td>
                                                        </tr>
                                                            <?php } ?> 
                                                    </table>
                                                </div>

                                                <hr>

                                                <div class="col-md-6">
                                                    <label>Customer Name:</label>
                                                    <input class="form-control" readonly name="customer_name" value="<?php echo $cust->customer_name;
                                                                                                                    } ?>">
                                                </div>

                                                <input type="hidden" name="order_id" value="<?php echo $orderid; ?>" class="form-control">

                                                <?php
                                                $prod_id = $_GET['prod_id'];
                                                $ret = "SELECT * FROM  rpos_products WHERE prod_id = '$prod_id'";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                while ($prod = $res->fetch_object()) {
                                                ?>


                                                    <div class="col-md-6">
                                                        <label>Order Code</label>
                                                        <input type="text" readonly name="order_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
                                                    </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label>Product Price</label>
                                                    <input type="text" readonly name="prod_price" value="₱ <?php echo $prod->prod_price; ?>" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Product Quantity</label>
                                                    <input type="number" name="prod_qty" class="form-control" value="" min="1" max="30" required aria-required="true">
                                                </div>
                                            </div>

                                            <!-- <div class="form-row"> 
                                                <div class="col-md-6">
                                                    <label>Product Size</label>
                                                    <select id="prod_size" name="prod_size" class="form-control">
                                                        <option value="8oz">8oz</option>
                                                        <option value="12oz">12oz</option>
                                                    </select>
                                                </div> 

                                                <div class="col-md-6">
                                                    <label>Hot/Cold</label>
                                                    <select id="hotorcold" name="hotorcold" class="form-control">
                                                        <option value="hot">Hot</option>
                                                        <option value="cold">Cold</option>
                                                    </select>
                                                </div>
                                            </div> -->

                                            <div class="form-row">
                                                <div class="mt-4 col-md-12">
                                                    <tr>
                                                        <th scope="col"> Description:</th>
                                                    </tr>
                                                    <td> <?php echo $prod->prod_desc; ?> </td>
                                                </div>

                                                <div class="mt-4 col-md-12 mb-4 mx-auto">
                                                <form action="order_summary.php" method="POST" target="_self" style="display: inline-block;">
                                                    <input style="width:50%; margin-left:22.5%" type="submit" name="make" value="Make Order" class="btn btn-success" value="">
                                                </form>
                                                </div>

                                            </div>
                                </div>
                            <?php } ?>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php
            // require_once('partials/_footer.php');
            ?>
        </div>
    </div>

                        
            <!-- Footer -->
            <?php // require_once('partials/_footer.php'); ?>
        </div>
    </div>
    <!-- Argon Scripts -->
    <?php require_once('partials/_scripts.php'); ?>
</body>
