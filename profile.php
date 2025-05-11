<?php
session_start();
if (!isset($_SESSION['phone'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce | Profile</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/cartbar.css">
    <link rel="stylesheet" href="css/profile.css">

    <!--========== Remixicon ==========-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>
<body>


<?php
// order tracking bar
include 'order-tracking-bar.php';
// header file
include 'header.php';
// cart bar
include 'cartBar.php';
?>


<!--============================================-->
<!--============ START PROFILE SECTION =========-->
<!--============================================-->
<section class="profile py-5 js-waypoint-sticky">
    <div class="container">
        <h1 class="text-center pb-5">Profile</h1>
        <div class="profile-container">
        <div style="overflow-x: auto;">
            <div style="overflow-x: auto;">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>First Name</td>
                                <td>:</td>
                                <td><?php echo $_SESSION['firstname']; ?></td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td>:</td>
                                <td><?php echo $_SESSION['lastname']; ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><?php echo $_SESSION['email']; ?></td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td>:</td>
                                <td><?php echo $_SESSION['phone']; ?></td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <br>
            <div class="profile-btn-container">
                <a href="editProfile.php">
                    <button class="btn btn-dark">
                        Edit Information <i class="ri-edit-box-line"></i>
                    </button>
                </a>    
                <a href="logout.php">
                    <button class="btn btn-dark">
                       Logout <i class="ri-logout-box-line"></i>
                    </button>
                </a>
            </div>
        </div>
        </div>
        <br><hr>
    </div>
</section>
<!--===========================================-->
<!--============ END PROFILE SECTION ==========-->
<!--===========================================-->


<?php
// header file
include 'footer.php';
// cart bar
include 'bottomNavBar.php';
?>


<!-- Google Hosted Jquery --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!--JQuery Plugins-->
<script src="js/jquery.waypoints.min.js"></script>

<!-- Main JS -->
<script src="js/main.js"></script>
<script src="js/cartCalculation.js"></script>
<script src="js/search.js"></script>

<script>
    function myFunction() {
    // Sticky Navbar
    $(document).ready(function () {
            $(".js-waypoint-sticky").waypoint(function (t) {
                "down" == t ? $("nav").addClass("sticky") : $("nav").removeClass("sticky");
            });
        });
    }

    function handleResize(event) {
    if (event.matches) {
        // The width matches the condition
        myFunction();
    } else {
        console.log("Device width does not match the condition.");
    }
    }

    // Define the device width condition
    const mediaQuery = window.matchMedia("(max-width: 1150px)"); // Example: max-width of 768px

    // Add an event listener to monitor changes in width
    mediaQuery.addEventListener("change", handleResize);

    // Run the function on initial load if the condition matches
    if (mediaQuery.matches) {
    myFunction();
    }
</script>
    
</body>
</html>