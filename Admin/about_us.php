<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('database/dbConnection.php'); // Include database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get the description from the form
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Check if the description is not empty
    if (!empty($description)) {
        // Insert or update the about_us content in the footer_info table
        $query = "INSERT INTO `footer_info` (`id`, `about_us`, `contact_us`, `faq`, `terms_of_use`, `privacy_policy`, `shipping_delivery`)
                  VALUES (1, '$description', '', '', '', '', '')
                  ON DUPLICATE KEY UPDATE
                  `about_us` = VALUES(`about_us`);";

        if (mysqli_query($conn, $query)) {
            $product_added_status = "About Us content saved successfully!";
        } else {
            $product_added_status = "Error: " . mysqli_error($conn);
        }
    } else {
        $product_added_status = "Please fill in the About Us content.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
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

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/thinline.css">

    <!-- Custom CSS-->
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
      #success-box {
        max-width: 800px;
        margin: auto;
        text-align: center;
        font-size: 18px;
        padding: 20px;
        color: #0A3622;
        background: #D1E7DD;
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
          <!-- START ADD PRODUCT AREA -->
          <!--------------------------->
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> About Us
              </h3>
            </div>
            <br>
            <?php
            if (isset($product_added_status)) {
              echo '<div id="success-box">'.$product_added_status.'</div>';
            }
            ?>
            <div class="row">
              <div class="form-container">
                <h1 class="text-center">Write About Us</h1>
                <div class="content">
                    <!-- Product Add form -->
                    <form action="" method="post" enctype="multipart/form-data">
                      <div class="user-details full-input-box">
                        
                        <!-- Description -->

                        <!--  Script For Text Editor -->
                        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

                        <?php
                            $query = "SELECT about_us FROM footer_info LIMIT 1"; // Adjust LIMIT as needed
                            $result = mysqli_query($conn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $about_us_content = $row['about_us'];
                            } else {
                                $about_us_content = "";
                            }
                        ?>

                        <div class="form-group m-auto"> 
                          <span class="details">Write About Us *</span>
                          <textarea id="summernote" rows="4" name="description" cols="58" class="mytextarea">
                            <?php 
                                echo htmlspecialchars($about_us_content);
                            ?>
                          </textarea>
                        </div>
                        <br><br>

                          <script>
                            $('#summernote').summernote({
                              placeholder: 'Design your website',
                              tabsize: 2,
                              height: 400
                            });
                            
                          </script>

                      </div>
                      <!-- Submit button -->
                      <div class="button">
                        <input type="submit" value="Save Changes" name="submit" class="btn btn-primary">
                      </div>
                    </form>
                    
                </div>
              </div>
            </div>
          </div>
          <!--------------------------->
          <!-- END ADD PRODUCT AREA -->
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
<?php 
$conn->close();
?>