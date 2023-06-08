<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Order | Calbeans Coffee</title>
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
include('config/code-generator.php');
check_login();
//Add Customer
if (isset($_POST['addCustomer'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["customer_phoneno"]) || empty($_POST["customer_name"]) || empty($_POST['customer_email']) || empty($_POST['customer_password'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $customer_name = $_POST['customer_name'];
    $customer_phoneno = $_POST['customer_phoneno'];
    $customer_email = $_POST['customer_email'];
    $customer_password = sha1(md5($_POST['customer_password'])); //Hash This 
    $customer_id = $_POST['customer_id'];

    //Insert Captured information to a database table
    $postQuery = "INSERT INTO rpos_customers (customer_id, customer_name, customer_phoneno, customer_email, customer_password) VALUES(?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('sssss', $customer_id, $customer_name, $customer_phoneno, $customer_email, $customer_password);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Customer Added" && header("refresh:1; url=customes.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}
require_once('partials/_head.php');
?>

    <!-- STYLES -->
    <link rel="stylesheet" href="../../assets/css/calbeans-style.css" />
    <link rel="stylesheet" href="../../assets/css/dashboard.css">

    <script>
        function validateForm() {
            var email = document.forms["contactForm"]["customer_email"].value;
            var password = document.forms["contactForm"]["customer_password"].value;
            var phoneNumber = document.forms["contactForm"]["customer_phoneno"].value;

            // Email validation
            var emailRegex = /^[^\s@]+@(gmail\.com|mail\.com|yahoo\.com)$/;
            if (!email.match(emailRegex)) {
            displayErrorMessage("Please enter a valid email address (e.g., example@gmail.com, example@mail.com, example@yahoo.com)", "customer_email");
             return false;
             } else {
             hideErrorMessage("customer_email");
              }
          // Password validation
               if (password.length < 6) {
                displayErrorMessage("Password must be at least 6 characters long", "customer_password");
                return false;
            } else {
                hideErrorMessage("customer_password");
            }
            

            // Phone number validation
            var phoneNumberRegex = /^(09|\+639)\d{9}$/;
            if (!phoneNumber.match(phoneNumberRegex)) {
                displayErrorMessage("Please enter a valid phone number (e.g., 09123456789 or +639123456789)", "customer_phoneno");
                return false;
            } else {
                hideErrorMessage("customer_phoneno");
            }

            // If all validations pass, the form will be submitted
            return true;
        }

        function displayErrorMessage(message, fieldId) {
            var errorElement = document.getElementById(fieldId + "-error");
            errorElement.innerText = message;
            errorElement.style.display = "block";
        }

        function hideErrorMessage(fieldId) {
            var errorElement = document.getElementById(fieldId + "-error");
            errorElement.style.display = "none";
        }
    </script>
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
    <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
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
        <div class="col-xl-12 col-11 mx-auto">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3>Please Fill All Fields</h3>
            </div>
            <div class="card-body">
              <form method="POST" role="form" name="contactForm" onsubmit="return validateForm()">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Customer Name</label>
                    <input type="text" name="customer_name" class="form-control">
                    <input type="hidden" name="customer_id" value="<?php echo $cus_id; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                  <label>Customer Phone Number</label>
                      <input type="text" name="customer_phoneno" class="form-control"  required> <div class="error-message" id="customer_phoneno-error"></div>
                  </div>
                </div>
                <hr>
                <div class="form-row">
                <div class="col-md-6">
                <input type="email" name="customer_email" class="form-control" required><div class="error-message" id="customer_email-error"></div>
                  </div>


                  <div class="col-md-6">
                  <label>Customer Password</label>
                      <input type="password" name="customer_password" class="form-control"  required><div class="error-message" id="customer_password-error"></div>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="addCustomer" value="Add Customer" class="btn btn-success" value="">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?php
      require_once('partials/_footer.php');
      ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>