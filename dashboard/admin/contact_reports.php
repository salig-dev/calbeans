<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Contact Reports | Calbeans Coffee</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/icon/favicon.png" />

  <?php
  session_start();
  include('config/config.php');
  include('config/checklogin.php');
  check_login();
  require_once('partials/_head.php');
  $_SESSION['id'] = $_SESSION['admin_id'];
  ?>

  <!-- STYLES -->
  <link rel="stylesheet" href="../../assets/css/calbeans-style.css" />
  <link rel="stylesheet" href="../../assets/css/dashboard.css">

<body>
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    ?>
    <!-- Header -->
    <div style="background-image: url(../../assets/img/hero/hero.png); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div>
    <!-- Page content -->
    <main class="container-fluid mt--8">
      <!-- Table -->
      <div class="row">
        <div class="col mx-auto">
          <div class="card shadow">
            <div class="card-header border-0">
              Orders Records
            </div>
            <section class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Contact #</th>
                    <th scope="col">Email</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Message</th>
                    <th scope="col">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $servername = "localhost";
                  $username = "root";
                  $password = "";
                  $database = "rposystem";
                  
                  // Create connection
                  $conn = mysqli_connect($servername, $username, $password, $database);
                  
                  // Check connection
                  if (!$conn) {
                      die("Connection failed: " . mysqli_connect_error());
                  }

                  if (isset($_SESSION['id'])) {
                    $id = $_SESSION['id'];
                    // Rest of your code that uses the $id variable

                    $ret = "SELECT * FROM rposystem.contacts ORDER BY created_at DESC LIMIT 10";
                    $stmt = $conn->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($contacts = $res->fetch_object()) {
                      $total = $contacts->message; // convert the variables to integers in your code:

                  ?>
                      <tr>
                        <td class="__td-w-0" scope="row"><?php echo $contacts->id; ?></td>
                        <td class="__prod_name"><?php echo $contacts->name; ?></td>
                        <td class=""><?php echo $contacts->contactnum; ?></td>
                        <td class="__td-w-0"><?php echo $contacts->email; ?></td>
                        <td class="__td-w-0"><?php echo $contacts->subject; ?></td>
                        <td style="width:0; min-width:375px; white-space: break-spaces !important;"><?php echo $contacts->message; ?></td>
                        <td class="__td-w-0"><?php echo date('d/M/Y g:i A', strtotime($contacts->created_at)); ?></td>
                      </tr>
                  <?php }
                  } else {
                    // Handle the case when 'id' is not set
                    echo "Session 'id' is not set";
                  } ?>
                </tbody>
              </table>
            </section>
          </div>
        </div>
      </div>
    </main>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>