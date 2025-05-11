<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce | Category</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/productList.css">
    <link rel="stylesheet" href="css/cartbar.css">

    <link rel="stylesheet" href="css/dark.css">

    <!--========== Remixicon ==========-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        .card {
            cursor: pointer;
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

<!--==========================================-->
<!--============ START CATEGORY SECTION ==========-->
<!--==========================================-->
<div class="pb-5">
    <!-- Category -->
    <section class="py-5">
        <div class="container">
            <h1>Tracking Your Order</h1>
            <p>Enter your invoice number to see your order</p>
            <br><br>

            <form class="form-group" action="" method="post">
                <div style="max-width: 700px; display: flex; justify-content: center; gap: 10px;">
                    <input type="text" name="order_search" id="searchBar" placeholder="Enter invoice no..." class="form-control py-3">
                    <input type="submit" value="Search" class="btn px-5 btn-dark mt-3">
                </div>
            </form>

            <br>

            <div style="overflow-x: auto">
            <div style="overflow-x: auto">
            <br>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Order No</th>
                        <th>Invoice No</th>
                        <th>Order Date</th>
                        <th>Shipping Address</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Payment Method</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody id="searchResult">
                <?php
                    // Database connection
                    include 'database/dbConnection.php';


                    // Check if the form is submitted
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_search'])) {
                        $invoice_no = $conn->real_escape_string($_POST['order_search']); // Sanitize input

                        // Update the query to filter by invoice number
                        $query = "SELECT order_no, invoice_no, order_date, user_address, product_title, product_quantity, total_price, payment_method, order_status 
                                FROM order_info 
                                WHERE invoice_no = '$invoice_no' 
                                ORDER BY order_date DESC";

                        // Execute the query
                        $result = $conn->query($query);

                        // Check if there are results
                        if ($result->num_rows > 0) {
                            // Loop through the results and display them in the table
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['order_no']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['invoice_no']) . "</td>";
                                echo "<td>" . date("F j, Y", strtotime($row['order_date'])) . "</td>";
                                echo "<td>" . htmlspecialchars($row['user_address']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_title']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_quantity']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['total_price']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['payment_method']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['order_status']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            // Display a message if no results are found
                            echo "<tr><td colspan='6' class='text-center'>No orders found for the given invoice number.</td></tr>";
                        }
                    }
                ?>
            </tbody>
            </table>

            </div>
            </div>

        <br><hr><br>
        </div>
    </section>
</div>
<!--==========================================-->
<!--============ END CATEGORY SECTION ==========-->
<!--==========================================-->


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
<script src="js/mens.js"></script>
<script src="js/womens.js"></script>
<script src="js/main.js"></script>
<script src="js/cartCalculation.js"></script>
<script src="js/search.js"></script>

<script>
    // Sticky Navbar
    $(document).ready(function () {
        $(".js-waypoint-sticky").waypoint(function (t) {
            "down" == t ? $("nav").addClass("sticky") : $("nav").removeClass("sticky");
        });
    });
</script>

</body>
</html>
<?php
// Close the connection
mysqli_close($conn);
?>