<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>List of Clients</h2>
        <a class="btn btn-primary" href="/calbeans/dashboard/create.php" role="button">New Client</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Order</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP !-->
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
                    //read all row from database table
                    $sql = "SELECT * FROM clients";
                    $result = $conn->query($sql);

                    if(!$result){
                        die("Invalid query: " . $conn->error);
                    }
                    
                    //read data of each row
                    while($row = $result->fetch_assoc()){
                        
                        echo "
                        <tr>
                            <td>$row[id]</td>
                            <td>$row[name]</td>
                            <td>$row[user_order]</td>
                            <td>$row[email]</td>
                            <td>$row[phone]</td>
                            <td>$row[address]</td>
                            <td>$row[created_at]</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href='/calbeans/dashboard/edit.php?id=$row[id]'>Edit</a>
                                <a class='btn btn-danger btn-sm' href='/calbeans/dashboard/delete.php?id=$row[id]'>Delete</a>
                            </td>
                        </tr>
                    ";
                        
                    }

                ?>
                <!--END OF PHP!-->
            </tbody>
        </table>
    </div>
    <div class="container my-5">
        <h2>List of Contacts</h2>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Message</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP !-->
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
                    //read all row from database table
                    $sql = "SELECT * FROM contacts";
                    $result = $conn->query($sql);

                    if(!$result){
                        die("Invalid query: " . $conn->error);
                    }

                    //read data of each row
                    while($row = $result->fetch_assoc()){
                        echo "
                        <tr>
                            <td>$row[id]</td>
                            <td>$row[name]</td>
                            <td>$row[message]</td>
                            <td>$row[email]</td>
                            <td>$row[subject]</td>
                            <td>$row[created_at]</td>
                            <td>
                                <a class='btn btn-danger btn-sm' href='/calbeans/dashboard/delcontacts.php?id=$row[id]'>Delete</a>
                            </td>
                        </tr>
                    ";
                        
                    }

                ?>
                <!--END OF PHP!-->
            </tbody>
        </table>
    </div>
</body>
</html>