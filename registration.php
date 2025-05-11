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
    <title>E-Commerce | Registration</title>
    
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
    <style>
        .msg-box {
            max-width: 800px;
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


<!--==================================================-->
<!--============ START REGISTRATION SECTION ==========-->
<!--==================================================-->
<section class="account py-5 js-waypoint-sticky">
    <div class="container">
        <h4 class="msg-box text-center"></h4>
        <h1 class="text-center">Account</h1>
        <br>
        <div class="registration">
            <!-- Title section -->
            <div class="title">Registration</div>
            <div class="content">
                <!-- Registration form -->
                <form action="#" method="post">
                    <div class="user-details">
                        <!-- Input for First Name -->
                        <div class="input-box">
                            <span class="details">First Name</span>
                            <input name="fName" type="text" placeholder="Enter your first name" required>
                        </div>
                        <!-- Input for Last Name -->
                        <div class="input-box">
                            <span class="details">Last Name</span>
                            <input name="lName" type="text" placeholder="Enter your last name" required>
                        </div>
                        <!-- Input for Email -->
                        <div class="input-box">
                            <span class="details">Email</span>
                            <input name="email" type="email" placeholder="Enter your email" required>
                        </div>
                        <!-- Input for Phone Number -->
                        <div class="input-box">
                            <span class="details">Phone Number</span>
                            <input name="phone" type="text" placeholder="Enter your number" required>
                        </div>
                        <!-- Input for Password -->
                        <div class="input-box">
                            <span class="details">Password</span>
                            <input minlength="8" name="password" type="password" placeholder="Enter your password" required>
                        </div>
                        <!-- Input for Confirm Password -->
                        <div class="input-box">
                            <span class="details">Confirm Password</span>
                            <input minlength="8" name="confirm_password" type="password" placeholder="Confirm your password" required>
                        </div>
                    </div>
                    <div class="gender-details">
                        <!-- Radio buttons for gender selection -->
                        <input type="radio" name="gender" id="dot-1" value="Male">
                        <input type="radio" name="gender" id="dot-2" value="Female">
                        <input type="radio" name="gender" id="dot-3" value="Others">
                        <span class="gender-title">Gender</span>
                        <div class="category">
                            <!-- Label for Male -->
                            <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">Male</span>
                            </label>
                            <!-- Label for Female -->
                            <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">Female</span>
                            </label>
                            <!-- Label for Prefer not to say -->
                            <label for="dot-3">
                            <span class="dot three"></span>
                            <span class="gender">Others</span>
                            </label>
                        </div>
                    </div>
                    <br>
                    <p>Already have an account ? <a style="color: var(--theme)" href="login.php">Login</a></p>
                    <!-- Submit button -->
                    <div class="button">
                    <input type="submit" value="Register">
                    </div>
                </form>
            </div>
        </div>
        <br><hr>
    </div>
</section>
<!--==================================================-->
<!--============ END REGISTRATION SECTION ============-->
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

<!-- PHP -->
<?php
error_reporting(0);
include 'database/dbConnection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $gender = $_POST['gender'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        ?>
            <script>
                let msg_box = document.querySelector(".msg-box");
                msg_box.style.display = "block";
                msg_box.innerText = "Passwords did not match!";
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
            </script>
        <?php
        exit();
    }

    // check fill up the radio or not
    if ($gender == "") {
        ?>
        <script>
                let msg_box = document.querySelector(".msg-box");
                msg_box.style.display = "block";
                msg_box.innerText = "Gender Option Not Selected!";
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
            </script>
        <?php
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement
    $sql = "INSERT INTO user_info (user_fName, user_lName, user_phone, user_email, user_gender, user_password) VALUES (?, ?, ?, ?, ?, ?)";

    // Initialize the prepared statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstName, $lastName, $phone, $email, $gender, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        ?>
            <script>
                let msg_box = document.querySelector(".msg-box");
                msg_box.style.display = "block";
                msg_box.innerText = "Registration successful!";
                let timeBar = document.createElement("div");
                timeBar.className = "time-bar";
                msg_box.appendChild(timeBar);
                setTimeout(() => {
                    msg_box.style.display = "none";
                    msg_box.removeChild(timeBar);
                }, 1000);
                setTimeout(() => {
                    timeBar.style.width = "100%";
                }, 0);
            </script>
            <meta http-equiv="refresh" content="1;url=login.php">
        <?php
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
    
</body>
</html>