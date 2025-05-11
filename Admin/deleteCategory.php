<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
// database connection
include('database/dbConnection.php');

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['delete_main_category'])) {
      $mainCategoryId = $_POST['main_ctg_id'];
      $deleteMainCategoryQuery = "DELETE FROM main_category WHERE main_ctg_id = $mainCategoryId";
      $conn->query($deleteMainCategoryQuery);
  } elseif (isset($_POST['delete_sub_category'])) {
      $subCategoryId = $_POST['sub_ctg_id'];
      $deleteSubCategoryQuery = "DELETE FROM sub_category WHERE sub_ctg_id = $subCategoryId";
      $conn->query($deleteSubCategoryQuery);
  }
}
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
          <!-- START DELETE CATEGORY AREA -->
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
              <h1>Delete Category</h1>
              <!-- Table Area -->
              <div style="overflow-y: auto;">
                <table class="table table-bordered">
                  <?php
                    // Fetch main categories
                    $mainCategoriesQuery = "SELECT * FROM main_category";
                    $mainCategoriesResult = $conn->query($mainCategoriesQuery);

                    if ($mainCategoriesResult->num_rows > 0) {
                        echo '<tbody>';
                        while ($mainCategory = $mainCategoriesResult->fetch_assoc()) {
                            $mainCategoryId = $mainCategory['main_ctg_id'];
                            $mainCategoryName = $mainCategory['main_ctg_name'];

                            // Escape the main category name to prevent SQL syntax errors
                            $escapedMainCategoryName = $conn->real_escape_string($mainCategoryName);

                            // Fetch sub categories for the current main category
                            $subCategoriesQuery = "SELECT * FROM sub_category WHERE main_ctg_name = '$escapedMainCategoryName'";
                            $subCategoriesResult = $conn->query($subCategoriesQuery);

                            $subCategoriesCount = $subCategoriesResult->num_rows;
                            echo '<tr>';
                            echo '<td rowspan="' . ($subCategoriesCount + 1) . '">' . $mainCategoryId . '</td>';
                            echo '<td rowspan="' . ($subCategoriesCount + 1) . '">' . $mainCategoryName . '</td>';
                            echo '<th>Serial No</th>';
                            echo '<th>Sub Category Name</th>';
                            echo '<th>Action</th>';
                            echo '<td rowspan="' . ($subCategoriesCount + 1) . '">';
                            echo '<form method="POST" action="">';
                            echo '<input type="hidden" name="main_ctg_id" value="' . $mainCategoryId . '">';
                            echo '<button type="submit" name="delete_main_category" class="btn btn-dark">Delete</button>';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';

                            if ($subCategoriesCount > 0) {
                                $serialNo = 1;
                                while ($subCategory = $subCategoriesResult->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $serialNo++ . '</td>';
                                    echo '<td>' . $subCategory['sub_ctg_name'] . '</td>';
                                    echo '<td>';
                                    echo '<form method="POST" action="">';
                                    echo '<input type="hidden" name="sub_ctg_id" value="' . $subCategory['sub_ctg_id'] . '">';
                                    echo '<button type="submit" name="delete_sub_category" class="btn btn-danger">Delete</button>';
                                    echo '</form>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            }
                        }
                        echo '</tbody>';
                    }
                  ?>
               </table>
              </div>
            </div>
          </div>
          <!--------------------------->
          <!-- END DELETE CATEGORY AREA -->
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