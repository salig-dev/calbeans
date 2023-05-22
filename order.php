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
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form data
  $customerName = $_POST['customer-name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $category = $_POST['category'];
  $items = $_POST['items'];
  $additionalNotes = $_POST['additional-notes'];

  // Display submitted order details
  echo "<h2>Order Details:</h2>";
  echo "<p><strong>Customer Name:</strong> $customerName</p>";
  echo "<p><strong>Phone Number:</strong> $phone</p>";
  echo "<p><strong>Email Address:</strong> $email</p>";
  echo "<p><strong>Category:</strong> $category</p>";
  echo "<p><strong>Items:</strong></p>";
  echo "<ul>";
  foreach ($items as $item) {
    echo "<li>$item</li>";
  }
  echo "</ul>";
  echo "<p><strong>Additional Notes:</strong> $additionalNotes</p>";
}
?>

</body>
</html>