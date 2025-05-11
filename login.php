<?php
session_start();
if (isset($_SESSION['phone'])) {
    header("Location: profile.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce | Login</title>
    
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
<!--============ START LOGIN SECTION ==========-->
<!--============================================-->
<section class="account py-5">
    <div class="container js-waypoint-sticky">
        <h4 class="msg-box text-center">
            <?php
                echo $error;
            ?>
        </h4>
        <h1 class="text-center">Account</h1>
        <br>
        <div class="login">
            <!-- Title section -->
            <div class="title">Login</div>
            <div class="content">
              <!-- Login form -->
              <form action="#" method="post">
                <div class="user-details full-input-box">
                  <!-- Input for phone number -->
                  <div class="input-box">
                    <span class="details">Phone Number</span>
                    <input name="phone" type="text" placeholder="Enter your number" required>
                  </div>
                  <!-- Input for Password -->
                  <div class="input-box">
                    <span class="details">Password</span>
                    <input name="password" type="password" placeholder="Enter your password" required>
                  </div>
                </div>
                <br>
                <p>Don't have an account ? <a style="color: var(--theme)" href="registration.php">Register</a></p>
                <!-- Submit button -->
                <div class="button">
                  <input type="submit" value="Login">
                </div>
              </form>
            </div>
        </div>
        <br><hr>
    </div>
</section>
<!--===========================================-->
<!--============ END LOGIN SECTION ============-->
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

    // Print Login error Message
    function printErrorMsg() {
            let msg_box = document.querySelector(".msg-box");
            msg_box.style.display = "block";
            msg_box.innerText = "Invalid phone number or password";
            let timeBar = document.createElement("div");
            timeBar.className = "time-bar";
            msg_box.appendChild(timeBar);
            setTimeout(() => {
                msg_box.style.display = "none";
                msg_box.removeChild(timeBar);
            }, 3000);
            setTimeout(() => {
                timeBar.style.width = "100%";
            }, 10);
    }

</script>

<?php
// error_reporting(0);
include 'database/dbConnection.php'; // Include database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $query = "SELECT * FROM user_info WHERE user_phone='$phone'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['user_password'])) {
            // Set value
            $_SESSION['id'] = $user['user_id'];
            $_SESSION['firstname'] = $user['user_fName'];
            $_SESSION['lastname'] = $user['user_lName'];
            $_SESSION['phone'] = $user['user_phone'];
            $_SESSION['email'] = $user['user_email'];
            // header("Location: profile.php");
            if (isset($_GET['rd'])) {
                ?>
                <meta http-equiv="refresh" content="0;url=checkout.php">
                <?php
                exit();
            } else {
                ?>
                <meta http-equiv="refresh" content="0;url=profile.php">
                <?php
                exit();
            }
        } else {
            echo "<script>printErrorMsg();</script>";
        }
    } else {
        echo "<script>printErrorMsg();</script>";
    }
}
?>

</body>
</html>