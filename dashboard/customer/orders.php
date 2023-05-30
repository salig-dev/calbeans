<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

require_once('partials/_head.php');
?>


<link rel="stylesheet" href="../../assets/css/nice-select.css" />
<link rel="stylesheet" href="../../assets/css/dashboard.css">

<style>

.__prod_name, .__prod_category{
  overflow-wrap: break-word;
  white-space: break-spaces !important;
  max-width: 140px;
}

</style>

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
    <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
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
        <div class="col">
          <div class="card shadow">
            <!-- SELECTION MENU-->
            <section class="row mx-0 py-2">
              <div class="card-header border-0 col-lg-5 col-md-6 col-11 text-md-left text-center mx-auto">Select On Any Product To Make An Order</div>

              <div class="__menu-select-ctn col-lg-7 col-md-6 col-10  mx-auto d-flex justify-content-start align-items-center">
                <select class="__menu-select-sub-ctn text-center w-75 mx-auto" id="menu-combobox" onchange="main();">
                  <option disabled value="disabled">Select a category</option>
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

            </section>

            <div class="table-responsive mt-lg-2 mt-md-4 mt-5">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM  rpos_products  ORDER BY `rpos_products`.`created_at` DESC ";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($prod = $res->fetch_object()) {
                  ?>
                    <tr value="<?php echo $prod->prod_category; ?>" class="prod_category_row">
                      <td>
                        <?php
                        if ($prod->prod_img) {
                          echo "<img src='../admin/assets/img/products/$prod->prod_img' height='60' width='60 class='img-thumbnail'>";
                        } else {
                          echo "<img src='../admin/assets/img/products/default.jpg' height='60' width='60 class='img-thumbnail'>";
                        }

                        ?>
                      </td>
                      <td><?php echo $prod->prod_code; ?></td>
                      <td class="__prod_name"><?php echo $prod->prod_name; ?></td>
                      <td class="__prod_category"><?php echo $prod->prod_category; ?></td>
                      <td class="__prod_price">₱ <?php echo $prod->prod_price; ?></td>
                      <td>
                        <a href="make_oder.php?prod_id=<?php echo $prod->prod_id; ?>&prod_name=<?php echo $prod->prod_name; ?>&prod_price=<?php echo $prod->prod_price; ?>">
                          <button class="btn btn-sm btn-warning">
                            <i class="fas fa-cart-plus"></i>
                            Place Order
                          </button>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?php
      // require_once('partials/_footer.php');
      ?>
    </div>
  </div>
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

<script src="js/orders.js"></script>

<script>



  
</script>

</body>

</html>