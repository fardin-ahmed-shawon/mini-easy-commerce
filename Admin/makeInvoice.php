<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
// database connection
include('database/dbConnection.php');

// Update order status to "Shipped" if the Mark As Shipped button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_shipped"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE order_info SET order_status = 'Shipped' WHERE invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}

// Update order status to "Completed" if the Mark As Completed button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_completed"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE order_info SET order_status = 'Completed' WHERE invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}

// Update order status to "Canceled" if the Mark As Canceled button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_canceled"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE order_info SET order_status = 'Canceled' WHERE invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}

//------------------- For order_info & payment_info table both -----------------------------

// Update order status to "Shipped" if the Mark As Shipped button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_shipped_both"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE order_info, payment_info SET order_info.order_status = 'Shipped', payment_info.order_status = 'Shipped' WHERE order_info.invoice_no = '$invoice_no' AND payment_info.invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}

// Update order status to "Completed" if the Mark As Completed button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_completed_both"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE order_info, payment_info SET order_info.order_status = 'Completed', payment_info.order_status = 'Completed' WHERE order_info.invoice_no = '$invoice_no' AND payment_info.invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}

// Update order status to "Canceled" if the Mark As Canceled button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_canceled_both"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE order_info, payment_info SET order_info.order_status = 'Canceled', payment_info.order_status = 'Canceled' WHERE order_info.invoice_no = '$invoice_no' AND payment_info.invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
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
          <!-- START INVOICE AREA -->
          <!--------------------------->
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Invoice
              </h3>
            </div>
            <br><hr><br>
            <div class="row">
              <!-- Table Area -->
              <div style="overflow-y: auto;">
                <table class="table table-under-bordered">
                  <tbody>
                      <tr>
                        <th>Serial No</th>
                        <th>Invoice No</th>
                        <th>Order No</th>
                        <th>Order Status</th>
                        <th>Payment Method</th>
                        <th>Invoice List</th>
                        <th>Shipped</th>
                        <th>Completed</th>
                        <th>Canceled</th>
                      </tr>

                      <?php
                      // Fetch data from order_info table

                      // Grouping the same Invoice No at Order No Column
                      $sql = "SELECT invoice_no, GROUP_CONCAT(order_no ORDER BY order_no SEPARATOR ', ') as order_no, order_status, order_visibility, payment_method
                      FROM order_info
                      WHERE payment_method = 'Cash On Delivery' AND order_status != 'Pending'
                      GROUP BY invoice_no, order_status, payment_method";

                      $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                          $count = 1;
                          while($row = $result->fetch_assoc()) {
                            if ($row["payment_method"] == "Cash On Delivery" && $row["order_status"] != "Pending" && $row["order_visibility"] == "Show") {
                              echo '<tr>
                                <td>' . $count . '</td>
                                <td>' . $row["invoice_no"] . '</td>
                                <td>' . $row["order_no"] . '</td>
                                <td class="order-status">' . $row["order_status"] . '</td>
                                <td>' . $row["payment_method"] . '</td>
                                
                                <td class="invoice-button">
                                  <a href="invoice.php?inv='.$row['invoice_no'].'" class="btn btn-dark">See Invoice</a>
                                </td>

                                <td class="shipped-button">
                                    <form method="post" action="">
                                        <input type="hidden" name="order_no" value="' . $row["order_no"] . '">
                                        <input type="hidden" name="invoice_no" value="' . $row["invoice_no"] . '">
                                        <button type="submit" name="mark_shipped" class="btn btn-success">Mark As Shipped</button>
                                    </form>
                                </td>
                                
                                <td class="completed-button">
                                  <form method="post" action="">
                                        <input type="hidden" name="order_no" value="' . $row["order_no"] . '">
                                        <input type="hidden" name="invoice_no" value="' . $row["invoice_no"] . '">
                                        <button type="submit" name="mark_completed" class="btn btn-success">Mark As Completed</button>
                                  </form>
                                </td>
                                <td class="canceled-button">
                                  <form method="post" action="">
                                        <input type="hidden" name="order_no" value="' . $row["order_no"] . '">
                                        <input type="hidden" name="invoice_no" value="' . $row["invoice_no"] . '">
                                        <button type="submit" name="mark_canceled" class="btn btn-danger">Mark As Canceled</button>
                                  </form>
                                </td>
                              </tr>';
                              $count++;
                            }
                          }
                        } 
                      ?>
                  </tbody>
               </table>
              </div>
            </div>

          </div>
          <!--------------------------->
          <!-- END INVOICE AREA -->
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