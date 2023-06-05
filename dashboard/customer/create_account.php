<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Create Account | Calbeans Coffee</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/icon/favicon.png" />

    <?php
    session_start();
    include('config/config.php');
    //login 
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
                $success = "Customer Account Created" && header("refresh:1; url=index.php");
            } else {
                $err = "Please Try Again Or Try Later";
            }
        }
    }
    require_once('partials/_head.php');
    require_once('config/code-generator.php');
    ?>

    <!-- STYLES -->
    <link rel="stylesheet" href="../../assets/css/calbeans-style.css" />

    <style>
        html,
        body {
            background-image: url("../../assets/img/hero/1.png");
        }
        
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>

    <script>
        function validateForm() {
            var email = document.forms["contactForm"]["customer_email"].value;
            var password = document.forms["contactForm"]["customer_password"].value;
            var phoneNumber = document.forms["contactForm"]["customer_phoneno"].value;

            // Email validation
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.match(emailRegex)) {
                displayErrorMessage("Please enter a valid email address", "customer_email");
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
</head>

<body class="bg-dark hero-overly">
    <div class="main-content">
        <div class="header bg-gradient-primar py-7">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">CREATE ACCOUNT</h1>
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
                            <form method="post" role="form" name="contactForm" onsubmit="return validateForm()">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input class="form-control" required name="customer_name" placeholder="Full Name" type="text">
                                        <input class="form-control" value="<?php echo $cus_id; ?>" required name="customer_id" type="hidden">
                                    </div>
                                    <div class="error-message" id="customer_name-error"></div>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input class="form-control" required name="customer_phoneno" placeholder="Phone Number" type="text">
                                    </div>
                                    <div class="error-message" id="customer_phoneno-error"></div>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" required name="customer_email" placeholder="Email" type="email">
                                    </div>
                                    <div class="error-message" id="customer_email-error"></div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" required name="customer_password" placeholder="Password" type="password">
                                    </div>
                                    <div class="error-message" id="customer_password-error"></div>
                                </div>

                                <div class="text-center">
                                </div>
                                <div class="form-group">
                                    <div class="text-left">
                                        <button type="submit" name="addCustomer" class="btn btn-primary my-4">Create Account</button>
                                        <a href="index.php" class=" btn btn-success pull-right">Log In</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- <div class="row mt-3">
                        <div class="col-6">
                            <a href="../admin/forgot_pwd.php" target="_blank" class="text-light"><small>Forgot password?</small></a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hide all error messages initially
        document.querySelectorAll('.error-message').forEach(function(element) {
            element.style.display = 'none';
        });
    </script>
    <!-- Footer -->
    <?php
    // require_once('partials/_footer.php');
    ?>
    <!-- Argon Scripts -->
    <?php
    require_once('partials/_scripts.php');
    ?>
</body>

</html>