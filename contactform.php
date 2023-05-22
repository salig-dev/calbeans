<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback Summary</title>
</head>
<body>
<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form data
  $message = $_POST['message'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];

  // Display submitted order details
  echo "<h2>Customer Feedback Details:</h2>";
  echo "<p><strong>Message: </strong> $message</p>";
  echo "<p><strong>Name: </strong> $email</p>";
  echo "<p><strong>Email Address: </strong> $name</p>";
  echo "<p><strong>Subject: </strong> $subject</p>";
}
?>
</body>
</html>