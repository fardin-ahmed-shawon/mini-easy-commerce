<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
// database connection
include('database/dbConnection.php');
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <!-- Custom CSS-->
    <link rel="stylesheet" href="css/style.css">
    <style>
      .accordion-body ul li {
        font-size: 18px;
      }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.php -->
      <?php include('navbar.php'); ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        
        <!-- partial:partials/_sidebar.php -->
        <?php include('sidebar.php'); ?>
        <div class="main-panel">


          <!--------------------------->
          <!-- START VIEW CATEGORY AREA -->
          <!--------------------------->
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Product Categories
              </h3>
            </div>
            <br>
            <div class="row">
              <h1 class="text-center">View Category</h1>
              <!-- Accordion Start -->
              <div class="accordion accordion-flush" id="accordionFlushExample">
                <?php
                // Fetch main categories
                $mainCategoriesSql = "SELECT * FROM main_category";
                $mainCategoriesResult = $conn->query($mainCategoriesSql);

                if ($mainCategoriesResult->num_rows > 0) {
                    $index = 0;
                    while ($mainCategory = $mainCategoriesResult->fetch_assoc()) {
                        $index++;
                        $mainCtgName = $mainCategory['main_ctg_name'];

                        // Prepare statement for subcategories
                        $subCategoriesStmt = $conn->prepare("SELECT * FROM sub_category WHERE main_ctg_name = ?");
                        $subCategoriesStmt->bind_param("s", $mainCtgName);
                        $subCategoriesStmt->execute();
                        $subCategoriesResult = $subCategoriesStmt->get_result();
                        ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-heading<?php echo $index; ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $index; ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $index; ?>">
                                    <?php echo $mainCtgName; ?>
                                </button>
                            </h2>
                            <div id="flush-collapse<?php echo $index; ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $index; ?>" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        <?php
                                        if ($subCategoriesResult->num_rows > 0) {
                                            while ($subCategory = $subCategoriesResult->fetch_assoc()) {
                                                echo "<li>" . $subCategory['sub_ctg_name'] . "</li>";
                                            }
                                        } else {
                                            echo "<li>No subcategories available</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php
                        $subCategoriesStmt->close();
                    }
                }
                $conn->close();
                ?>
              </div>
              <!-- End -->
            </div>
          </div>
          <!--------------------------->
          <!-- END VIEW CATEGORY AREA -->
          <!--------------------------->


          <!-- partial:partials/_footer.php -->
          <?php include('footer.php'); ?>
        </div>
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- JS FILES  -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>


  </body>
</html>