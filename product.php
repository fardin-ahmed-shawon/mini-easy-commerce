<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce | Product</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/cartbar.css">
    <link rel="stylesheet" href="css/product.css">
    <!-- <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/productList.css"> -->

    <link rel="stylesheet" href="css/dark.css">

    <!--========== Remixicon ==========-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .product-details ul li {
            list-style: disc;
        }
        #review_content .reviewer-dp {
            width: 50px;
            height: 50px;
            background-color: #f1f1f1;
            border-radius: 50%;
            margin-top: 15px;
            margin-bottom: 10px;
            /* margin-left: 50px; */
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

<!-- 
                const cartData = JSON.parse(localStorage.getItem('cartData')) || [];
                const cartProduct = cartData.find(item => item.id === productId);
                const quantity = cartProduct ? cartProduct.quantity : 1;

                const product_details = document.querySelector(".product-container");

                product_details.setAttribute("product-id", `${product.id}`);
                product_details.setAttribute("product-title", `${product.title}`);
                product_details.setAttribute("product-img", `${product.image}`);
                product_details.setAttribute("product-price", `${product.price}`);
                product_details.setAttribute("product-quantity", `${quantity}`); 
-->

<!--==========================================-->
<!--============ START PRODUCT AREA ==========-->
<!--==========================================-->
<section class="product py-5">
    <div class="container">
        <!-- Product Details will be displayed here Dynamically -->
            <?php
                require 'database/dbConnection.php';
                $product_id = $_GET['pi'];
                $quantity = 1;

                $sql = "SELECT p.*, mc.main_ctg_name, sc.sub_ctg_name 
                        FROM product_info p
                        JOIN main_category mc ON p.main_ctg_id = mc.main_ctg_id
                        JOIN sub_category sc ON p.sub_ctg_id = sc.sub_ctg_id
                        WHERE p.product_id='$product_id'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $product = $result->fetch_assoc();
                    echo "
                        <div class='product-container' product-id='$product[product_id]' product-title='$product[product_title]' product-img='Admin/$product[product_img1]' product-price='$product[product_price]' product-quantity='$quantity'>
                            <div class='product-images'>
                                <div class='img-thumb'>
                                    <img id='main-image' src='img/{$product['product_img1']}' alt='Product Image'>";
                                    ?>
                                    <div class='img-small'>
                                        <?php
                                        if (!empty($product['product_img1'])) {
                                            echo "<img src='img/{$product['product_img1']}' alt='Thumbnail 1' onclick='changeImage(\"img/{$product['product_img1']}\")'>";
                                        }
                                        if (!empty($product['product_img2'])) {
                                            echo "<img src='img/{$product['product_img2']}' alt='Thumbnail 2' onclick='changeImage(\"img/{$product['product_img2']}\")'>";
                                        }
                                        if (!empty($product['product_img3'])) {
                                            echo "<img src='img/{$product['product_img3']}' alt='Thumbnail 3' onclick='changeImage(\"img/{$product['product_img3']}\")'>";
                                        }
                                        if (!empty($product['product_img4'])) {
                                            echo "<img src='img/{$product['product_img4']}' alt='Thumbnail 4' onclick='changeImage(\"img/{$product['product_img4']}\")'>";
                                        }
                                        ?>
                                    </div>
                                    <?php
                                echo " </div>
                            </div>
                            <div class='product-details'>
                                <div>
                                    <h2 class='js-waypoint-sticky'>{$product['product_title']}</h2>
                                    
                                    <p>{$product['main_ctg_name']} / {$product['sub_ctg_name']}</p>
                                    <br>
                                    <p class='description'>{$product['product_description']}</p>

                                    <div class='price-inf' style='display: flex; justify-content: space-between;'>
                                        <h3 class='price'>Tk. {$product['product_price']}</h3>
                                        <h3 style='text-decoration: line-through; color: var(--theme);' class='price'>Tk. {$product['product_regular_price']}</h3>
                                    </div>
                                    <br>";

                                    if ($product['available_stock'] > 0) {
                                        echo "<h5>Available in Stock: <span style='color: var(--theme);'>{$product['available_stock']}</span></h5>";

                                        echo "<br>
                                    <br>
                                    <div class='btn-and-counter'>
                                        <div class='counter'>
                                            <button onclick='minus()' class='minus'>-</button>
                                            <span class='num'>$quantity</span>
                                            <button onclick='plus()' class='plus'>+</button>
                                        </div>
                                        <button onclick='addProductToCart(this)' class='btn btn-danger add-cart'>
                                            <span>Add to Cart</span> <i class='ri-shopping-bag-line'></i>
                                        </button>
                                    </div>";

                                    } else {
                                        echo "<h5 style='color: red;'>Out of stock!</h5>";
                                    }

                                echo"<br>
                                    <button onclick='window.location.href=\"viewCart.php\";' class='btn btn-dark buy-now'>
                                        <span>View Cart</span> <i class='ri-shopping-cart-2-line'></i>
                                    </button>
                                </div>
                            </div>
                        </div>    
                    ";
                }
            ?>
        <br><br><hr>
    </div>
</section>
<!--========================================-->
<!--============ END PRODUCT AREA ==========-->
<!--========================================-->

<!--==========================================-->
<!-- Rating and Review Section -->
<!--==========================================-->
<?php include 'ratings.php'; ?>
<div class="container">
<br><hr><br>
</div>
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
    
    // Increment and Decrement product quantity
    function plus() {
        const numElement = document.querySelector(".num");
        let count = parseInt(numElement.textContent);
        numElement.textContent = count + 1;
        updateProductQuantity(count + 1);

        // Update product-quantity attribute
        const productContainer = document.querySelector(".product-container");
        productContainer.setAttribute("product-quantity", count + 1);
    }

    function minus() {
        const numElement = document.querySelector(".num");
        let count = parseInt(numElement.textContent);
        if (count > 1) {
            numElement.textContent = count - 1;
            updateProductQuantity(count - 1);

            // Update product-quantity attribute
            const productContainer = document.querySelector(".product-container");
            productContainer.setAttribute("product-quantity", count - 1);
        }
    }
    
    function updateProductQuantity(quantity) {
        const productId = localStorage.getItem('selectedProductId');
        if (!productId) return;
    
        const cartData = JSON.parse(localStorage.getItem('cartData')) || [];
        const product = cartData.find(item => item.id === productId);
        if (product) {
            product.quantity = quantity;
            localStorage.setItem('cartData', JSON.stringify(cartData));
        }
    }
    
    // localStorage.clear();

</script>

</body>
</html>
<?php
// Close the connection
mysqli_close($conn);
?>