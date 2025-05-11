<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
// database connection
include('database/dbConnection.php');



// admin password change
$sql = "UPDATE admin_info 
SET admin_password = ? 
WHERE admin_username = ? AND admin_password = ?;";

if (isset($_POST['changePass'])) {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword == $confirmPassword) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $newPassword, $_SESSION['admin'], $oldPassword);
        $stmt->execute();
        $password_updated_status = "Password Successfully Updated!";
        $stmt->close();
    }
}
?>

<?php

// if (isset($_POST['submit'])) {

//     $old_password =  $_POST['oldPassword'];

//     $new_password1 = $_POST['newPassword'];
//     $new_password2 = $_POST['confirmPassword'];


//     // get user id
//     $admin_username = $_SESSION['admin'];

//     if ($new_password1 == $new_password2) {
//         $sql = "SELECT * FROM admin_info WHERE admin_username = '$admin_username' and admin_password = '$old_password'";

//         $result = mysqli_query($con, $sql);
//         $data = mysqli_fetch_assoc($result);
//         $count = mysqli_num_rows($result);

//         if($count > 0){
//             // update password
//             $new_password = $new_password1;
//             $sql2 = "UPDATE admin_info SET admin_password = '$new_password' WHERE admin_username = '$admin_username'";

//             if (mysqli_query($con, $sql2)) {
//                 // echo '<div class="alert alert-success" role="alert">Password Updated Successfully!</div>';
//                 $password_updated_status = "Password Successfully Updated!";
//             } else {
//                 echo "Error updating password: " . mysqli_error($con);
//             }

//         } else {
//           $password_updated_status = "Old Password Does Not Match!";
//         }

//     } else {
//       $password_updated_status = "Password Does Not Match!";
//     }
// }

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
            <h1>Settings</h1>
            <div class="row">
                <!-- Left Form -->
                <div class="col-md-6 mt-3">
                    <div class="card p-3">
                        <?php
                            if (isset($password_updated_status)) {
                            echo '<div class="card-header"><div id="success-box">'.$password_updated_status.'</div></div>';
                            }
                        ?>
                        <div class="card-body">
                            <h4 class="text-center">Change Admin Password</h4> 
                            <br>
                            <form action="" method="POST">
                                <div class="form-group>
                                <label for="oldPassword">Enter Old Password *</label>
                                <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                                </div><br>
                                <div class="form-group>
                                <label for="newPassword">Enter New Password *</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                </div><br>
                                <div class="form-group>
                                <label for="confirmPassword">Enter Confirm Password *</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                </div><br>
                                <button name="changePass" type="submit" class="btn btn-primary">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>  
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