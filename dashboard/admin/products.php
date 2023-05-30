<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $adn = "DELETE FROM  rpos_products  WHERE  prod_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $stmt->close();
  if ($stmt) {
    $success = "Deleted" && header("refresh:1; url=products.php");
  } else {
    $err = "Try Again Later";
  }
}
require_once('partials/_head.php');
?>

<link rel="stylesheet" href="../../assets/css/nice-select.css" />
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
        <div class="col mx-auto card shadow">
            <!-- SELECTION MENU-->
            <section class="row mx-0 py-2">
              <div class="card-header border-0 col-xl-5 col-lg-4 col-md-8 col-sm-10 col-11 text-lg-left text-center mx-auto">
                Select On Any Product To Update
              </div>

              <div class="__menu-select-ctn col-xl-4 col-lg-4 col-md-6 col-sm-6 col-8  mx-auto d-flex justify-content-start align-items-center">
                <select placeholder="Select a category" class="__menu-select-sub-ctn text-center w-100 mx-auto" id="menu-combobox" onchange="main();">
                  <option disabled selected value="disabled">Select a category</option>
                  <option value="All">All</option>
                  <option value="Espresso">Espresso</option>
                  <option value="Fresh Black Coffee/Cold Brew">Fresh Black Coffee/Cold Brew</option>
                  <option value="Non-Coffee Drinks">Non-Coffee Drinks</option>
                  <option value="Sandwich">Sandwich</option>
                  <option value="Pastries">Pastries</option>
                  <option value="Pasta">Pasta</option>
                  <option value="Starters">Starters</option>
                  <!-- <option value="Matcha Series">Matcha Series</option> Unavailable -->
                  <option value="Coffee Beans / Ground">Coffee Beans / Ground</option>
                </select>
              </div>

              <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12  mx-auto d-flex mt-sm-0 mt-3 justify-content-md-start justify-content-center align-items-center">
                <a href="add_product.php" class="btn btn-outline-success">
                <i class="fas fa-utensils"></i>
                Add New Product</a>
              </div> <!-- Add New Product -->

            </section>

            <div class="table-responsive mt-lg-2 mt-md-4 mt-5">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="__prod_code __col-odd"scope="col">Product Code</th>
                    <th class="__prod_name" scope="col">Name</th>
                    <th class="__prod_category __col-odd" scope="col">Category</th>
                    <th class="__prod_price" scope="col">Price</th>
                    <th class="__col-odd" scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM  rpos_products ORDER BY prod_name";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($prod = $res->fetch_object()) {
                  ?>
                  <tr value="<?php echo $prod->prod_category; ?>" class="prod_category_row">
                      <td class = "__prod_code __col-odd"><?php echo $prod->prod_code; ?></td>
                      <td class = "__prod_name"><?php echo $prod->prod_name; ?></td>
                      <td class = "__prod_category __col-odd"><?php echo $prod->prod_category; ?></td>
                      <td class = "__prod_price">₱ <?php echo $prod->prod_price; ?></td>
                      <td class = "__prod_id __col-odd">
                        <a href="products.php?delete=<?php echo $prod->prod_id; ?>">
                          <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete
                          </button>
                        </a> <!-- Btn: Delete  -->

                        <a href="update_product.php?update=<?php echo $prod->prod_id; ?>">
                          <button class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                            Update
                          </button>
                        </a> <!-- Btn: Update  -->
                      </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
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
<script src="../../assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="../../assets/js/jquery.nice-select.min.js"></script>

<script>
  $(document).ready(function() {
    $('select').niceSelect();
  });
</script>

<script src="../../../calbeans/assets/js/orders-combobox.js"></script>

</body>
</html>