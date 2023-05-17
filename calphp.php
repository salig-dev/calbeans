<?php

//sql connection

$servername = "localhost";
$username = "root";
$password = "";

//connection 

$conn = mysqli_connect($servername,$username,$password);

//check conn 
if(!$conn){
    die("Connection failed : " . mysqli_connect_error());
}echo "Connected Successfully <br>";

$sql = "use caltest";
if(mysqli_query($conn,$sql)){
    echo "Database successfully used <br>";
} else {
    echo "Error creating Database : " . mysqli_error($conn);
}

// sql php 

$name = $_POST['name'];
$order = $_POST['order'];
$address = $_POST['address'];
$message = $_POST['message'];

$sql = "INSERT INTO `orders` (`order`, `name`, `address`, `message`) VALUES ('$order','$name','$address','$message')";

if(mysqli_query($conn,$sql)){
    echo "order stored.";
} else {
    echo "error: " . $sql . "<br>" . mysqli_error($conn);
}


?>