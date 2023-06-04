<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin | Calbeans Coffee</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="../../assets/img/icon/favicon.png"
    />

<?php
session_start();
include('config/config.php');
//login 
if (isset($_POST['login'])) {
  $admin_email = $_POST['admin_email'];
  $admin_password = sha1(md5($_POST['admin_password'])); //double encrypt to increase security
  $stmt = $mysqli->prepare("SELECT admin_email, admin_password, admin_id  FROM   rpos_admin WHERE (admin_email =? AND admin_password =?)"); //sql to log in user
  $stmt->bind_param('ss',  $admin_email, $admin_password); //bind fetched parameters
  $stmt->execute(); //execute bind 
  $stmt->bind_result($admin_email, $admin_password, $admin_id); //bind result
  $rs = $stmt->fetch();
  $_SESSION['admin_id'] = $admin_id;
  if ($rs) {
    //if its sucessfull
	
    header("location:dashboard.php");
  } else {
    $err = "Incorrect Authentication Credentials ";
  }
}
require_once('partials/_head.php');
?>

    <!-- STYLES -->
    <link rel="stylesheet" href="../../assets/css/calbeans-style.css" />

    <style>
        html,
        body {
            background-image: url("../../assets/img/hero/3.png");
            background-size: cover;
            height: 100vh;
            overflow: hidden;
        }
    </style>
</head>

<body  class="bg-dark hero-overly">
  <div class="main-content">
    <div class="position-absolute  pt-md-5 pl-md-5 pt-4 pl-4  return-text">
      <a href="../../dashboard/index.php" class="  text-white">
          <i class="fa-solid fa-chevron-left"></i> Return
      </a>
  </div>

    <div class="header bg-gradient-primar py-7">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">ADMIN LOGIN</h1>
            </div>
          </div>
        </div>
      </div>
    </div><!--   -->
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">
              <form method="post" role="form">
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" required name="admin_email" placeholder="Email" type="email">
                  </div>
                </div><!--   -->
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" required name="admin_password" placeholder="Password" type="password">
                  </div>
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span class="text-muted">Remember Me</span>
                  </label>
                  </div>
                  <div class="mt-2">
                  <a href="#" id="showPasswordBtn"  class="text-muted">Show Password</a>
                </div>

                <!--   -->
                <div class="text-center">
                  <button type="submit" name="login" class="btn btn-primary my-4">Log In</button>
                </div>
              </form>

            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <!-- <a href="forgot_pwd.php" class="text-light"><small>Forgot password?</small></a> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <?php
  require_once('partials/_footer.php');
  ?>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
  <script>
    var showPasswordBtn = document.getElementById('showPasswordBtn');
    var passwordInput = document.querySelector('input[name="admin_password"]');

    var showPassword = false;

    showPasswordBtn.addEventListener('mousedown', function() {
      passwordInput.type = "text";
      showPassword = true;
    });

    showPasswordBtn.addEventListener('mouseup', function() {
      if (!showPassword) {
        passwordInput.type = "password";
      }
      showPassword = false;
    });

    showPasswordBtn.addEventListener('mouseleave', function() {
      if (!showPassword) {
        passwordInput.type = "password";
      }
      showPassword = false;
    });
  </script>
</body>
<!--  -->
</html>