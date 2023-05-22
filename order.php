<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
</head>
<body>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "myshop";

//create connection
$conn = mysqli_connect($servername,$username,$password,$database);

//Check connection
if(!$conn){
  die("Connection failed: ".mysqli_connect_error());
}

// Get the submitted form data
$customerName = $_POST['customer-name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$category = $_POST['category'];
$items = $_POST['items'];
// $quantities = $_POST['quantity'];
$additionalNotes = $_POST['additional-notes'];

// Fixed prices for each item
// $itemPrices = array(
//   "Americano (8 oz)" => 69.00,
//   "Vanilla Hot (12 oz)" => 69.00,
//   "Vanilla Cold Brew (16 oz)" => 100.00,
//   // Add more items and prices here for other categories
// );

// Calculate the total price
// $totalPrice = 0;
// for ($i = 0; $i < count($items); $i++) {
//   $item = $items[$i];
//   $quantity = $quantities[$i];
//   $price = $itemPrices[$item];
//   $totalPrice += $price * $quantity;
// }

// Display the order summary
echo "Order Summary:<br>";
echo "Customer Name: " . $customerName . "<br>";
echo "Phone: " . $phone . "<br>";
echo "Email: " . $email . "<br>";
echo "Category: " . $category . "<br>";
echo "Items:<br>";
for ($i = 0; $i < count($items); $i++) {
  $item = $items[$i];
//   $quantity = $quantities[$i];
//   $price = $itemPrices[$item];
  echo $item . "<br>";
//   echo $item . " - Quantity: " . $quantity . " - Price: $" . $price . "<br>";
}
echo "Total Price: $" . $totalPrice . "<br>";
echo "Additional Notes: " . $additionalNotes;
?>


</body>
</html>