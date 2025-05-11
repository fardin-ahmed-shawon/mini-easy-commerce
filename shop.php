<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce | Shop</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/productList.css">
    <link rel="stylesheet" href="css/cartbar.css">

    <!--========== Remixicon ==========-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        .card {
            cursor: pointer;
        }
        .card-body h6 {
            font-weight: 500;
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

<?php 
include 'database/dbConnection.php';
?>

<!--==========================================-->
<!--============ START SHOP SECTION ==========-->
<!--==========================================-->
<div class="pb-5 js-waypoint-sticky">
    <!-- Category -->
    <section class="py-5">
        <div class="container">
            <h1>Shop</h1>
            <p>Find Your Favorite Products Here..</p>
            <br><br>

            <!-- Search Feature -->
            <form class="form-group" id="searchForm" action="javascript:void(0);">
                <input type="search" name="search" id="searchBar" placeholder="Search Product..." class="form-control py-3">
            </form>
            <br><br>
            
        </div>
        <div class="bg-gray">
            <div class="container grid-container py-5 mens-fashion-products">
                <!-- Product Will Add Automatically -->             
                <?php
                    $sql = "SELECT product_info.*, main_category.main_ctg_name 
                            FROM product_info 
                            JOIN main_category 
                            ON product_info.main_ctg_id = main_category.main_ctg_id";
                    $result = mysqli_query($conn, $sql);
                    
                    $products = array();
                    while ($item = mysqli_fetch_array($result)) {
                        echo "<div class='card' product-id='$item[product_id]' product-title='$item[product_title]' product-img='img/$item[product_img1]' product-price='$item[product_price]' product-quantity='1'>
                        <img onclick='window.location.href=\"product.php?pi=$item[product_id]\"' src='img/$item[product_img1]' class='card-img-top' alt='img'>
                        <div class='card-body'>
                            <h6 onclick='window.location.href=\"product.php?pi=$item[product_id]\"'>$item[product_title]</h6>
                            <p onclick='window.location.href=\"product.php?pi=$item[product_id]\"'>$item[main_ctg_name]</p>

                            <div class='price-inf' style='display: flex; justify-content: space-between;'>
                                <h6 onclick='window.location.href=\"product.php?pi=$item[product_id]\"'>BDT $item[product_price]</h6>
                                <h6 style='text-decoration: line-through; color: var(--theme);' onclick='window.location.href=\"product.php?pi=$item[product_id]\"'>BDT $item[product_regular_price]</h6>
                            </div>

                            <button onclick='addToCart(this)' class='btn btn-outline-dark'><span>Add to Cart</span> <i class='ri-shopping-bag-line'></i></button>
                            <a href='product.php?pi=$item[product_id]'>
                                <button class='btn btn-dark'><span>Order Now</span> <i class='ri-shopping-cart-2-line'></i></button>
                            </a>
                        </div>
                    </div>";
                    }
                ?>
            </div>
        </div>
    </section>
</div>
<!--==========================================-->
<!--============ END SHOP SECTION ==========-->
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
<script src="js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/cartCalculation.js"></script>
<script src="js/search.js"></script>

<script>
// Sticky Navbar
$(document).ready(function () {
    $(".js-waypoint-sticky").waypoint(function (t) {
        "down" == t ? $("nav").addClass("sticky") : $("nav").removeClass("sticky");
    });
});
// Cart Added Alert
// Swal.fire({
//             title: "Cart Added Successful!",
//             icon: "success",
//             draggable: true
//         });
</script>

<script>
    $(document).ready(function () {
    $('#searchBar').on('input', function () {
        const query = $(this).val();

        $.ajax({
            url: 'searchProducts.php', // PHP script to handle the search
            method: 'POST',
            data: { search: query },
            success: function (response) {
                $('.mens-fashion-products').html(response); // Update the product list
            },
            error: function () {
                console.error('Error fetching search results.');
            }
        });
    });
});
</script>

</body>
</html>
<?php
// Close the connection
mysqli_close($conn);
?>