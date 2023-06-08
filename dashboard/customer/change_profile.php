<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Profile | Calbeans Coffee</title>
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
if (isset($_POST['ChangeProfile'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["customer_phoneno"]) || empty($_POST["customer_name"]) || empty($_POST['customer_email'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $customer_name = $_POST['customer_name'];
    $customer_phoneno = $_POST['customer_phoneno'];
    $customer_email = $_POST['customer_email'];
    $customer_id = $_SESSION['customer_id'];

    //Insert Captured information to a database table
    $postQuery = "UPDATE rpos_customers SET customer_name = ?, customer_phoneno = ?, customer_email = ? WHERE customer_id = ?";
    $postStmt = $mysqli->prepare($postQuery);
    // Bind parameters
    $rc = $postStmt->bind_param('sssi', $customer_name, $customer_phoneno, $customer_email, $customer_id);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Profile Updated" && header("refresh:1; url=dashboard.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}
if (isset($_POST['changePassword'])) {
    $error = 0;

    // Validate input fields
    if (empty($_POST['old_password'])) {
        $error = 1;
        $err = "Old Password cannot be empty";
    } elseif (empty($_POST['new_password'])) {
        $error = 1;
        $err = "New Password cannot be empty";
    } elseif (empty($_POST['confirm_password'])) {
        $error = 1;
        $err = "Confirmation Password cannot be empty";
    }

    if (!$error) {
        $customer_id = $_SESSION['customer_id'];
        $old_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['old_password']))));
        $new_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['new_password']))));
        $confirm_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['confirm_password']))));

        $sql = "SELECT * FROM rpos_customers WHERE customer_id = '$customer_id'";
        $res = mysqli_query($mysqli, $sql);

        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            
            if ($old_password != $row['customer_password']) {
                $err = "Please enter the correct old password";
            } elseif ($new_password != $confirm_password) {
                $err = "Confirmation password does not match";
            } else {
                // Update password in the database
                $new_password = sha1(md5($_POST['new_password']));
                $query = "UPDATE rpos_customers SET customer_password = ? WHERE customer_id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('si', $new_password, $customer_id);
                $stmt->execute();

                if ($stmt) {
                    $success = "Password changed successfully";
                    header("refresh:1; url=dashboard.php");
                } else {
                    $err = "Failed to update the password";
                }
            }
        }
    }
}
require_once('partials/_head.php');
?>

    <!-- STYLES -->
    <link rel="stylesheet" href="../../assets/css/calbeans-style.css" />
    <link rel="stylesheet" href="../../assets/css/dashboard.css">

    <script>
    // Function to toggle password visibility
    function togglePasswordVisibility(inputId, toggleId) {
        const input = document.getElementById(inputId);
        const toggle = document.getElementById(toggleId);
        if (input.type === "password") {
            input.type = "text";
            toggle.classList.remove("fa-eye");
            toggle.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            toggle.classList.remove("fa-eye-slash");
            toggle.classList.add("fa-eye");
        }
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
        $customer_id = $_SESSION['customer_id'];
        //$login_id = $_SESSION['login_id'];
        $ret = "SELECT * FROM  rpos_customers  WHERE customer_id = '$customer_id'";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($customer = $res->fetch_object()) {
        ?>
            <!-- Header -->
            <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(../../assets/img/hero/hero.png); background-size: cover; background-position: center top;">
                <!-- Mask -->
                <span class="mask bg-gradient-default opacity-8"></span>
                <!-- Header container -->
                <div class="container-fluid d-flex align-items-center">
                    <div class="row">
                        <div class="col-lg-7 col-md-10">
                            <h1 class="display-2 text-white">Hello <?php echo $customer->customer_name; ?></h1>
                            <p class="text-white mt-0 mb-5">This is your profile page. You can customize your profile as you want And also change password too</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page content -->
            <div class="container-fluid mt--8">
                <div class="row">
                    <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                        <div class="card card-profile shadow">
                            <div class="row justify-content-center">
                                <div class="col-lg-3 order-lg-2">
                                    <div class="card-profile-image">
                                        <a href="#">
                                            <img src="../admin/assets/img/theme/user-a-min.png" class="rounded-circle">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                                <div class="d-flex justify-content-between">
                                </div>
                            </div>
                            <div class="card-body pt-0 pt-md-4">
                                <div class="row">
                                    <div class="col">
                                        <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                            <div>
                                            </div>
                                            <div>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h3>
                                        <?php echo $customer->customer_name; ?></span>
                                    </h3>
                                    <div class="h5 font-weight-300">
                                        <i class="fas fa-envelope mr-2"></i><?php echo $customer->customer_email; ?>
                                    </div>
                                    <div class="h5 font-weight-300">
                                        <i class="fas fa-phone mr-2"></i><?php echo $customer->customer_phoneno; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 order-xl-1">
                        <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">My account</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <h6 class="heading-small text-muted mb-4">User information</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-username">Full Name</label>
                                                    <input type="text" name="customer_name" value="<?php echo $customer->customer_name; ?>" id="input-username" class="form-control form-control-alternative" ">
                                                </div>
                                            </div>
                                            <div class=" col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-email">Phone Number</label>
                                                    <input type="text" id="input-email" value="<?php echo $customer->customer_phoneno; ?>" name="customer_phoneno" class="form-control form-control-alternative">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-email">Email address</label>
                                                    <input type="email" id="input-email" value="<?php echo $customer->customer_email; ?>" name="customer_email" class="form-control form-control-alternative">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="submit" id="input-email" name="ChangeProfile" class="btn btn-success form-control-alternative" value="Submit"">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr>

                                <form method="post">
    <h6 class="heading-small text-muted mb-4">Change Password</h6>
    <div class="pl-lg-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-old-password">Old Password</label>
                    <div class="input-group">
                        <input type="password" name="old_password" id="input-old-password" placeholder="Enter your current password" class="form-control form-control-alternative">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-eye" id="toggleOldPassword" onclick="togglePasswordVisibility('input-old-password', 'toggleOldPassword')"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-email">New Password <small>(min. 8 characters, at least 1 Uppercase and 1 lowercase letter, and 1 number)</small></label>
                    <div class="input-group">
                        <input type="password" name="new_password" id="input-new-password" placeholder="New password (Ex: calBeans123)" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" required class="form-control form-control-alternative">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-eye" id="toggleNewPassword" onclick="togglePasswordVisibility('input-new-password', 'toggleNewPassword')"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-email">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" id="input-confirm-password" placeholder="Confirm new password (Must match the new password)" class="form-control form-control-alternative">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-eye" id="toggleConfirmPassword" onclick="togglePasswordVisibility('input-confirm-password', 'toggleConfirmPassword')"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <input type="submit" name="changePassword" class="btn btn-success form-control-alternative" value="Change Password">
                </div>
            </div>
        </div>
    </div>
</form>

                                <?php if (isset($err)) { ?>
                                    <div class="alert alert-danger mt-3">
                                    <?php echo $err; ?>
                                    </div>
                                <?php } ?>
                                    <?php if (isset($success)) { ?>
                                    <div class="alert alert-success mt-3">
                                    <?php echo $success; ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
            <?php
            //require_once('partials/_footer.php');
        }
            ?>
            </div>
    </div>
    <!-- Argon Scripts -->
    <?php
    require_once('partials/_sidebar.php');
    ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
$(".navbar-toggler").click(function() {
    $("#sidenav-collapse-main").removeClass("collapsing").addClass("collapse show");
});
});

document.querySelector("#sidenav-collapse-main > div > div > div.col-6.collapse-close > button").addEventListener("click", function() {
            document.querySelector("#sidenav-collapse-main").classList.toggle("show");
});

document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("#sidenav-collapse-main > div > div > div.col-6.collapse-close > button").addEventListener("click", function() {
        console.log("Test");
        setTimeout(function() {
            document.querySelector("#sidenav-collapse-main").classList.toggle("show");
        }, 10);
    });
});
</script>

</body>

</html>