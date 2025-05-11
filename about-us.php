<?php
session_start();
if (isset($_SESSION['phone'])) {
    header("Location: profile.php");
    exit();
}
include 'database/dbConnection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/cartbar.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/login.css">

    <!--========== Remixicon ==========-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .msg-box {
            max-width: 500px;
            margin: auto;
            background: #ebebeb;
            padding-top: 10px;
            margin-bottom: 10px;
            display: none;
        }
        .time-bar {
            height: 5px;
            margin-top: 10px;
            background-color: var(--theme);
            transition: width 3s linear;
            width: 0;
        }
        .card-body ul li {
            list-style: disc;
        }
        .card-body ol li {
            list-style: decimal;
        }
    </style>
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
<!--============ START Main SECTION ==========-->
<!--============================================-->
<section class="account py-5">
    <div class="container js-waypoint-sticky">
        

        <div class="card">
            <div class="card-body py-5">
                
            <?php
                $query = "SELECT about_us FROM footer_info"; // Adjust LIMIT as needed
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $about_us_content = $row['about_us'];
                } else {
                    $about_us_content = "No content available.";
                }

                echo $about_us_content;

            ?>

            </div>
        </div>


    </div>
</section>
<!--===========================================-->
<!--============ END Main SECTION ============-->
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