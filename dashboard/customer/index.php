<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | Calbeans Coffee</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/icon/favicon.png" />

    <?php
    session_start();
    include('config/config.php');
    //login 
    if (isset($_POST['login'])) {
        $customer_email = $_POST['customer_email'];
        $customer_password = sha1(md5($_POST['customer_password'])); //double encrypt to increase security

        // Check if it's an admin login
        if ($customer_email === 'admin@mail.com' && $customer_password === sha1(md5('admin123'))) {
            // Redirect to the admin dashboard
            header("location: ../admin/dashboard.php");
            exit(); // Make sure to exit after redirection
        }

        $stmt = $mysqli->prepare("SELECT customer_email, customer_password, customer_id  FROM  rpos_customers WHERE (customer_email =? AND customer_password =?)"); //sql to log in user
        $stmt->bind_param('ss',  $customer_email, $customer_password); //bind fetched parameters
        $stmt->execute(); //execute bind 
        $stmt->bind_result($customer_email, $customer_password, $customer_id); //bind result
        $rs = $stmt->fetch();
        $_SESSION['customer_id'] = $customer_id;
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
            background-image: url("../../assets/img/hero/4.png");
            height: 100%;
        }
    </style>
</head>

<body class="bg-dark hero-overly">
    <div class="main-content">

        <div class="position-absolute  pt-md-5 pl-md-5 pt-4 pl-4  return-text">
            <a href="../../index.html" class="  text-white">
                <i class="fa-solid fa-chevron-left"></i> Return
            </a>
        </div>

        <div class="header bg-gradient-primar py-7">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">CUSTOMER LOGIN</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                        <input class="form-control" required name="customer_email" placeholder="Email" type="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" required name="customer_password" placeholder="Password" type="password">
                                        <div class="input-group-append">
                                            <span class="input-group-text show-password-icon">
                                                <i id="showPasswordIcon" class="fa-solid fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                                    <label class="custom-control-label" for=" customCheckLogin">
                                        <span class="text-muted">Remember Me</span>

                                    </label>
                                </div>
                                <div class="form-group">
                                    <div class="text-left">
                                        <button type="submit" name="login" class="btn btn-primary my-4">Log In</button>
                                        <a href="create_account.php" class=" btn btn-success pull-right">Create Account</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <!-- <a href="../admin/forgot_pwd.php" target="_blank" class="text-light"><small>Forgot password?</small></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php
    //require_once('partials/_footer.php');
    ?>
    <!-- Argon Scripts -->
    <?php
    require_once('partials/_scripts.php');
    ?>
    <script>
        var showPasswordIcon = document.getElementById('showPasswordIcon');
        var passwordInput = document.querySelector('input[name="customer_password"]');
        var passwordVisible = false;

        showPasswordIcon.addEventListener('click', function() {
            if (passwordVisible) {
                passwordInput.type = "password";
                showPasswordIcon.classList.remove('fa-eye-slash');
                showPasswordIcon.classList.add('fa-eye');
                passwordVisible = false;
            } else {
                passwordInput.type = "text";
                showPasswordIcon.classList.remove('fa-eye');
                showPasswordIcon.classList.add('fa-eye-slash');
                passwordVisible = true;
            }
        });
    </script>

</body>

</html>