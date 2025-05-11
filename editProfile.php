<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce | Update Profile</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/cartbar.css">
    <link rel="stylesheet" href="css/form.css">

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


<!--==================================================-->
<!--============ START REGISTRATION SECTION ==========-->
<!--==================================================-->
<section class="account py-5 js-waypoint-sticky">
    <div class="container">
        <h1 class="text-center">Account</h1>
        <br>
        <div class="registration">
            <!-- Title section -->
            <div class="title">Update</div>
            <div class="content">
                <!-- Registration form -->
                <form action="#">
                    <div class="user-details">
                        <!-- Input for First Name -->
                        <div class="input-box">
                            <span class="details">First Name</span>
                            <input type="text" placeholder="Enter your first name" required>
                        </div>
                        <!-- Input for Last Name -->
                        <div class="input-box">
                            <span class="details">Last Name</span>
                            <input type="text" placeholder="Enter your last name" required>
                        </div>
                        <!-- Input for Email -->
                        <div class="input-box">
                            <span class="details">Email</span>
                            <input type="email" placeholder="Enter your email" required>
                        </div>
                        <!-- Input for Phone Number -->
                        <div class="input-box">
                            <span class="details">Phone Number</span>
                            <input type="text" placeholder="Enter your number" required>
                        </div>
                        <!-- Input for Password -->
                        <div class="input-box">
                            <span class="details">Old Password</span>
                            <input type="password" placeholder="Enter your old password" required>
                        </div>
                        <!-- Input for Confirm Password -->
                        <div class="input-box">
                            <span class="details">New Password</span>
                            <input type="password" placeholder="Confirm your new password" required>
                        </div>
                    </div>
                    <!-- Submit button -->
                    <div class="button">
                    <input type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
        <br><hr>
    </div>
</section>
<!--==================================================-->
<!--============ END EDIT PROFILE SECTION ============-->
<!--==================================================-->


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