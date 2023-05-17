<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $name = $_POST['name'];
        $order = $_POST['order'];
        $address = $_POST['address'];
        $message = $_POST['message'];

        echo "<h1>Order Received! <br></h1>";
        echo "$name <br> $order <br> $address <br> $message"; 
    ?>
</body>
</html>