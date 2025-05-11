<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
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
          <!-- START VIEW CUSTOMERS AREA -->
          <!--------------------------->
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Customers
              </h3>
            </div>
            <br>
            <div class="row">
              <h1>Your Customer List</h1>
              <!-- <form class="form-group" action="#">
                <input type="search" name="search" id="search" placeholder="Search Customer" class="form-control">
              </form> -->
              <!-- Table Area -->
              <div style="overflow-y: auto;">
                <table class="table table-under-bordered">
                  <tbody>
                      <tr>
                        <th>Serial No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Customer ID</th>
                        <th>Customer Phone</th>
                        <th>Customer Email</th>
                        <th>Gender</th>
                        <!-- <th>Action</th> -->
                      </tr>
                      <?php
                      include 'database/dbConnection.php';
                      $sql = "SELECT user_id, user_fName, user_lName, user_phone, user_email, user_gender FROM user_info";
                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                        $serialNo = 1;
                          while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $serialNo++ . "</td>";
                            echo "<td>" . $row["user_fName"] . "</td>";
                            echo "<td>" . $row["user_lName"] . "</td>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["user_phone"] . "</td>";
                            echo "<td>" . $row["user_email"] . "</td>";
                            echo "<td>" . $row["user_gender"] . "</td>";
                            //echo '<td><button class="btn btn-dark">Remove</button></td>';
                            echo "</tr>";
                          }
                      } else {
                        echo "<tr><td colspan='8'>No customers found</td></tr>";
                      }
                      $conn->close();
                      ?>
                  </tbody>
               </table>
              </div>
            </div>
          </div>
          <!--------------------------->
          <!-- END VIEW CUSTOMERS AREA -->
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