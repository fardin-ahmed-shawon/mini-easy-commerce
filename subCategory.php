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

    $sub_category_id = $_GET['sub_ctg_id'];

    $sql = "SELECT * FROM sub_category WHERE sub_ctg_id='$sub_category_id'";

    $result = mysqli_query($conn, $sql);

    while ($item = mysqli_fetch_array($result)) {
        $sub_category_name = $item['sub_ctg_name'];
        $main_category_name = $item['main_ctg_name'];
    }
?>

<!--==========================================-->
<!--============ START CATEGORY SECTION ==========-->
<!--==========================================-->
<div class="pb-5 js-waypoint-sticky">
    <!-- Category -->
    <section class="py-5">
        <div class="container">
            <h1><?php echo $sub_category_name; ?></h1>
            <p><?php echo $main_category_name; ?> / <?php echo $sub_category_name; ?></p>
            <br><br>
            <!-- <form class="form-group" action="#">
                <input type="search" name="search" id="searchBar" placeholder="Search Product..." class="form-control py-3">
            </form> -->
            <br>
        </div>
        <div class="bg-gray">
            <div class="container grid-container py-5 mens-fashion-products">
                <!-- Product Will Add Automatically -->             
                    <?php
                        $sql = "SELECT product_info.*, main_category.main_ctg_name, sub_category.sub_ctg_id 
                                FROM product_info 
                                JOIN main_category ON product_info.main_ctg_id = main_category.main_ctg_id 
                                JOIN sub_category ON product_info.sub_ctg_id = sub_category.sub_ctg_id
                                WHERE product_info.sub_ctg_id='$sub_category_id'";

                        $result = mysqli_query($conn, $sql);

                        $total = mysqli_num_rows($result);
                        if ($total == 0) {
                            ?>
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 50px 0;">
                                    <svg width="141" height="119" viewBox="0 0 141 119" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M23.7614 118.662H117.48L103.802 23.459H37.429L23.7614 118.662Z" fill="#E6ECF2"></path><path d="M82.6137 96.3569C77.8268 96.3569 73.3249 98.9015 70.8648 102.997C70.3788 103.806 70.6424 104.855 71.4535 105.34C72.2646 105.825 73.316 105.562 73.8019 104.753C75.6471 101.681 79.0235 99.7724 82.6137 99.7724C86.214 99.7724 89.5953 101.689 91.4382 104.774C91.7586 105.31 92.3271 105.608 92.9105 105.608C93.2085 105.608 93.5105 105.53 93.7851 105.367C94.5974 104.884 94.8635 103.836 94.3796 103.026C91.9226 98.9123 87.4141 96.3569 82.6137 96.3569Z" fill="white"></path><path opacity="0.1" d="M37.4286 23.4478L47.8467 118.673H23.761L37.4286 23.4478Z" fill="#222836"></path><path d="M84.6231 30.1166L88.5312 29.2953C88.5312 29.2186 86.8187 21.2138 84.9964 13.1324C82.9764 4.1202 74.0952 -0.00810683 66.6741 1.16359C59.253 2.33529 55.0374 8.06238 55.8059 15.7167C56.7719 25.3093 57.5075 29.8428 57.5294 30.029L61.4705 29.3938C61.4705 29.3938 60.735 24.7727 59.7799 15.3225C58.9566 7.09872 65.3348 5.41236 67.3108 5.09479C72.9096 4.18591 79.5952 7.2849 81.1101 14.0085C82.9105 22.057 84.6121 30.0399 84.6231 30.1166Z" fill="#222836"></path><g opacity="0.1"><path d="M46.3212 118.367L46.8262 117.513L34.3113 110.307L24.475 117.523L25.0678 118.323L34.3771 111.49L46.3212 118.367Z" fill="#222836"></path><path d="M36.3087 37.9261L37.3071 37.96L34.8174 110.902L33.819 110.868L36.3087 37.9261Z" fill="#222836"></path></g><path d="M82.6037 29.7113C82.6059 30.4949 82.8408 31.2602 83.2788 31.9107C83.7168 32.5611 84.3382 33.0675 85.0645 33.3658C85.7909 33.6642 86.5896 33.7411 87.3597 33.5869C88.1299 33.4327 88.837 33.0544 89.3917 32.4995C89.9463 31.9447 90.3237 31.2384 90.4762 30.4697C90.6286 29.7011 90.5493 28.9046 90.2482 28.1809C89.9471 27.4572 89.4377 26.8387 88.7845 26.4037C88.1312 25.9686 87.3633 25.7363 86.5777 25.7363C86.0549 25.7363 85.5373 25.8392 85.0544 26.0391C84.5715 26.239 84.133 26.532 83.7638 26.9012C83.3946 27.2705 83.1021 27.7088 82.9031 28.191C82.704 28.6732 82.6023 29.1899 82.6037 29.7113Z" fill="#1890FF"></path><path d="M55.8283 29.7113C55.8283 30.4975 56.062 31.2661 56.4999 31.9197C56.9378 32.5734 57.5602 33.0829 58.2883 33.3838C59.0165 33.6846 59.8178 33.7633 60.5908 33.61C61.3638 33.4566 62.0738 33.078 62.6312 32.5221C63.1885 31.9662 63.568 31.2579 63.7218 30.4868C63.8755 29.7158 63.7966 28.9165 63.495 28.1902C63.1934 27.4638 62.6826 26.843 62.0273 26.4062C61.3719 25.9694 60.6015 25.7363 59.8133 25.7363C58.7564 25.7363 57.7428 26.1551 56.9955 26.9006C56.2482 27.646 55.8283 28.6571 55.8283 29.7113Z" fill="#1890FF"></path><path d="M140.621 118.273C140.621 117.872 109.278 117.578 70.6233 117.578C31.969 117.578 0.621094 117.872 0.621094 118.273C0.621094 118.675 31.9581 118.969 70.6276 118.969C109.297 118.969 140.621 118.648 140.621 118.273Z" fill="#222836"></path></svg>
                                    <br><br>
                                    <h3>No Products Found!</h3>
                                    <p>Try selecting different category</p>
                                </div>
                            <?php
                        }
                        
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