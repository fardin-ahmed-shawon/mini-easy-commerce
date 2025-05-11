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
  <head>
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
          <!-- START SETTINGS AREA -->
          <!--------------------------->
          
<div class="content-wrapper">
<section class="content-main">
    
    <div class="card">
        <div class="card-body">
            
            <div class="content-header">
                <h1 class="content-title">Settings</h1>
                <hr><br>
            </div>

            <div class="row gx-5">
                <aside class="col-lg-3 border-end">
                    <nav class="nav nav-pills flex-lg-column mb-4">
                        <a class="nav-link active" aria-current="page" href="">Information </a>
                        <!-- <a class="nav-link" href="/settings/social-links/">Social Links</a>
                     -->
                    </nav>
                </aside>
                <div class="col-lg-9">
                                        <section class="content-body p-xl-4">
                        <h2>Lioo BD</h2>
                        <p>lioobd.com</p>
                        
                        <hr class="my-5">
                        <div class="row" style="max-width: 920px">

                            <div class="col-md-4">
                                <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                    <h6>Admin Password</h6>
                                    <small class="text-muted d-block" style="width: 70%">You can reset or change your password by clicking here</small>
                                    <br>
                                    <a class="btn btn-dark" href="change-password.php">Change</a>
                                </article>
                            </div>
                        </div>    
                        <br><hr><br>
                        <div class="row" style="max-width: 920px">

                            <div class="col-md-4">
                                <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                    <h6>About Us</h6>
                                    <small class="text-muted d-block" style="width: 70%">Your About Us Section. You Can Write by Clicking Here</small>
                                    <br>
                                    <a class="btn btn-dark" href="about_us.php">Edit</a>
                                </article>
                            </div>

                            <div class="col-md-4">
                                <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                    <h6>Contact Us</h6>
                                    <small class="text-muted d-block" style="width: 70%">Your Contact Us Section. You Can Write by Clicking Here</small>
                                    <br>
                                    <a class="btn btn-dark" href="contact_us.php">Edit</a>
                                </article>
                            </div>

                            <div class="col-md-4">
                                <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                    <h6>FAQ</h6>
                                    <small class="text-muted d-block" style="width: 70%">Your FAQ Section. You Can Write by Clicking Here</small>
                                    <br>
                                    <a class="btn btn-dark" href="faq.php">Edit</a>
                                </article>
                            </div>

                            <div class="col-md-4">
                                <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                    <h6>Terms Of Use</h6>
                                    <small class="text-muted d-block" style="width: 70%">Your Terms Of Use Section. You Can Write by Clicking Here</small>
                                    <br>
                                    <a class="btn btn-dark" href="terms_of_use.php">Edit</a>
                                </article>
                            </div>

                            <div class="col-md-4">
                                <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                    <h6>Privacy & Policy</h6>
                                    <small class="text-muted d-block" style="width: 70%">Your Privacy & Policy Section. You Can Write by Clicking Here</small>
                                    <br>
                                    <a class="btn btn-dark" href="privacy_policy.php">Edit</a>
                                </article>
                            </div>

                            <div class="col-md-4">
                                <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                    <h6>Shipping & Delivery</h6>
                                    <small class="text-muted d-block" style="width: 70%">Your Shipping & Delivery Section. Write by Clicking Here</small>
                                    <br>
                                    <a class="btn btn-dark" href="shipping_delivery.php">Edit</a>
                                </article>
                            </div>
                            
                        </div>
                        <!-- row.// -->
                    </section>
                    <!-- content-body .// -->
                </div>
                <!-- col.// -->
            </div>
            <!-- row.// -->
        </div>
        <!-- card body end// -->
    </div>
    <!-- card end// -->
</section>
          </div>



          <!--------------------------->
          <!-- END SETTINGS AREA -->
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
    <script src="js/main.js"></script>

  </body>
</html>