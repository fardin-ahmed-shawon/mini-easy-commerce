<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('database/dbConnection.php'); // Include database connection file

// Image Compression Function
function compressImage($source, $destination, $quality = 75) {
    $imgInfo = getimagesize($source);
    if (!$imgInfo) return false;

    $mime = $imgInfo['mime'];
    switch ($mime) {
        case 'image/jpeg': $image = imagecreatefromjpeg($source); break;
        case 'image/png': $image = imagecreatefrompng($source); break;
        case 'image/webp': $image = imagecreatefromwebp($source); break;
        default: return false;
    }

    // Resize Image to 800x800 (Square Shape)
    $newWidth = 800;
    $newHeight = 800;
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($image), imagesy($image));
    $image = $newImage;

    // Save Compressed Image
    switch ($mime) {
        case 'image/jpeg': imagejpeg($image, $destination, $quality); break;
        case 'image/png': imagepng($image, $destination, round($quality / 10)); break;
        case 'image/webp': imagewebp($image, $destination, $quality); break;
    }
    imagedestroy($image);
    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_title = $_POST['product_title'];
    $product_regular_price = $_POST['product_regular_price'];
    $product_price = $_POST['product_price'];
    $product_main_ctg_id = $_POST['product_main_ctg'];
    $product_sub_ctg_id = $_POST['product_sub_ctg'];
    $available_stock = $_POST['available_stock'];
    $size_option = "Default";
    $product_keyword = $_POST['product_keyword'];
    $product_description = $_POST['product_description'];
    $product_code = $_POST['product_code'];
    $product_type = $_POST['product_type'];

    // Array to store image details
    $images = [
        ['name' => $_FILES['product_img1']['name'], 'tmp_name' => $_FILES['product_img1']['tmp_name']],
        ['name' => $_FILES['product_img2']['name'], 'tmp_name' => $_FILES['product_img2']['tmp_name']],
        ['name' => $_FILES['product_img3']['name'], 'tmp_name' => $_FILES['product_img3']['tmp_name']],
        ['name' => $_FILES['product_img4']['name'], 'tmp_name' => $_FILES['product_img4']['tmp_name']]
    ];

    $uploadSuccess = true;
    $originalFiles = [];
    $compressedFiles = [];

    foreach ($images as $index => $image) {
        if (!empty($image['name'])) {
            $folder = '../img/' . basename($image['name']);
            $compressed_folder = '../img/compressed_' . basename($image['name']);

            if (move_uploaded_file($image['tmp_name'], $folder)) {
                if (compressImage($folder, $compressed_folder, 60)) {
                    $originalFiles[] = $folder; // Track the original file
                    $compressedFiles[] = $compressed_folder; // Track the compressed file
                } else {
                    $uploadSuccess = false;
                    break;
                }
            } else {
                $uploadSuccess = false;
                break;
            }
        } else {
            $compressedFiles[] = null; // No file uploaded for this index
        }
    }

    if ($uploadSuccess) {
        // Prepare the SQL query
        $query = "INSERT INTO product_info (product_title, product_regular_price, product_price, main_ctg_id, sub_ctg_id, available_stock, size_option, product_keyword, product_code, product_description, product_img1, product_img2, product_img3, product_img4, product_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sddssisssssssss", $product_title, $product_regular_price, $product_price, $product_main_ctg_id, $product_sub_ctg_id, $available_stock, $size_option, $product_keyword, $product_code, $product_description, $compressedFiles[0], $compressedFiles[1], $compressedFiles[2], $compressedFiles[3], $product_type);

        // Execute the query
        if ($stmt->execute()) {
            $product_added_status = "Product Added Successfully!";
            // Delete the original images after successful database entry
            foreach ($originalFiles as $file) {
                unlink($file);
            }
        } else {
            echo "Error: " . $stmt->error;
        }

    } else {
        echo "Failed to upload one or more images.";
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
                </span> Product
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
                <h1 class="text-center">Add Product</h1>
                <div class="content">
                    <!-- Product Add form -->
                    <form action="" method="post" enctype="multipart/form-data">
                      <div class="user-details full-input-box">
                        <!-- title -->
                        <div class="input-box">
                          <span class="details">Product Title *</span>
                          <input name="product_title" type="text" placeholder="Enter your product title" required>
                        </div>
                        <!-- regular price -->
                        <div class="input-box">
                          <span class="details">Regular Price *</span>
                          <input name="product_regular_price" type="text" placeholder="Enter product regular price" required>
                        </div>
                        <!-- sale price -->
                        <div class="input-box">
                          <span class="details">Sale Price *</span>
                          <input name="product_price" type="text" placeholder="Enter product sale price" required>
                        </div>
                        <!-- Main Category -->
                        <div class="input-box">
                          <span class="details">Choose Main Category *</span>
                          <select id="main_ctg_name" name="product_main_ctg" required>
                            <option value="">Select Main Category</option>
                            <?php
                              // Fetch main categories from the database
                              $result = mysqli_query($conn, "SELECT main_ctg_id, main_ctg_name FROM main_category");
                              while ($row = mysqli_fetch_assoc($result)) {
                                $category_name = htmlspecialchars($row['main_ctg_name'], ENT_QUOTES, 'UTF-8');
                                $category_id = $row['main_ctg_id'];
                                  echo "<option value='$category_id'>$category_name</option>";
                              }
                            ?>
                          </select>
                        </div>
                        <!-- Sub Category -->
                        <div class="input-box">
                          <span class="details">Choose Sub Category</span>
                          <select id="main_sub_name" name="product_sub_ctg">
                            <option value="">Select Sub Category</option>
                            <?php
                              // Fetch main categories from the database
                              $result = mysqli_query($conn, "SELECT sub_ctg_id, sub_ctg_name FROM sub_category");
                              while ($row = mysqli_fetch_assoc($result)) {
                                $category_name = htmlspecialchars($row['sub_ctg_name'], ENT_QUOTES, 'UTF-8');
                                $category_id = $row['sub_ctg_id'];
                                  echo "<option value='$category_id'>$category_name</option>";
                              }
                            ?>
                          </select>
                        </div>
                        <!-- Total Stock -->
                        <div class="input-box">
                          <span class="details">Total Stock Amount *</span>
                          <input name="available_stock" type="text" placeholder="Enter your total stock amount" required>
                        </div>
                        <!-- keyword -->
                        <div class="input-box">
                          <span class="details">Product Keyword *</span>
                          <input name="product_keyword" type="text" placeholder="Enter your product keyword" required>
                        </div>
                        <!-- product code -->
                        <div class="input-box">
                          <span class="details">Product Code</span>
                          <input name="product_code" type="text" placeholder="Enter your product code">
                        </div>
                        <!-- product type -->
                        <div class="input-box">
                          <span class="details">Choose Product Type</span>
                          <select id="product_type" name="product_type">
                            <option value="">Select Product Type</option>
                            <option value='new_arrival'>New Arrival</option>
                            <option value='top_selling'>Top Selling</option>
                            <option value='trending'>Trending</option>
                            <option value='top_rated'>Top Rated</option>
                          </select>
                        </div>
                        <!-- Description -->

                        <!--  Script For Text Editor -->
                        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

                        <div class="form-group m-auto"> 
                          <span class="details">Product Description *</span>
                          <textarea id="summernote" rows="4" name="product_description" cols="58" class="mytextarea"> </textarea>
                        </div>
                        <br><br>

                          <script>
                            $('#summernote').summernote({
                              placeholder: 'Design your website',
                              tabsize: 2,
                              height: 400
                            });
                            
                          </script>

                        <!-- main image -->
                        <div>
                          <span class="details">Attach Primary Image *</span>
                          <h4>(1000 X 1000)</h4>
                          <input type="file" name="product_img1" id="file" class="inputfile" required/><br>
                        </div>
                        <!-- image 2 -->
                        <div>
                          <span class="details">Attach Image 2</span>
                          <h4>(1000 X 1000)</h4>
                          <input type="file" name="product_img2" id="file" class="inputfile"/><br>
                        </div>
                        <!-- image 3 -->
                        <div>
                          <span class="details">Attach Image 3</span>
                          <h4>(1000 X 1000)</h4>
                          <input type="file" name="product_img3" id="file" class="inputfile"/><br>
                        </div>
                        <!-- image 4 -->
                        <div>
                          <span class="details">Attach Image 4</span>
                          <h4>(1000 X 1000)</h4>
                          <input type="file" name="product_img4" id="file" class="inputfile"/><br>
                        </div>
                      </div>
                      <!-- Submit button -->
                      <div class="button">
                        <input type="submit" value="Add Product">
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