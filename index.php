<?php
// database connection
session_start();
include 'database/dbConnection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <!-- <link rel="icon" href="img/favicon.ico" type="image/x-icon"> -->
    <title>E-Commerce | Home</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/cartbar.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/productList.css">

    <link rel="stylesheet" href="css/dark.css">

    <!--========== Remixicon ==========-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        #success-box {
            margin: auto;
            text-align: center;
            font-size: 20px;
            font-weight: 500;
            padding: 20px;
            color: #0A3622;
            background: #D1E7DD;
        }
        .card {
            cursor: pointer;
        }
    </style>
    <style>
        /* Import Google font - Poppins */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
        }
        .new-wrapper {
        width: 100%;
        position: relative;
        }
        .new-wrapper i {
        top: 50%;
        height: 50px;
        width: 50px;
        cursor: pointer;
        font-size: 1.25rem;
        position: absolute;
        text-align: center;
        line-height: 50px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 3px 6px rgba(0,0,0,0.23);
        transform: translateY(-50%);
        transition: transform 0.1s linear;
        }
        .new-wrapper i:active{
        transform: translateY(-50%) scale(0.85);
        }
        .new-wrapper i:first-child{
        left: -22px;
        }
        .new-wrapper i:last-child{
        right: -22px;
        }
        .new-wrapper .new-carousel,
        .new-wrapper .none-carousel{
        display: grid;
        grid-auto-flow: column;
        grid-auto-columns: calc((100% / 4) - 5px);
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        gap: 16px;
        border-radius: 8px;
        scroll-behavior: smooth;
        scrollbar-width: none;
        }
        .new-carousel::-webkit-scrollbar {
        display: none;
        }
        .new-carousel.no-transition {
        scroll-behavior: auto;
        }
        .new-carousel.dragging {
        scroll-snap-type: none;
        scroll-behavior: auto;
        }
        .new-carousel.dragging .new-card {
        cursor: grab;
        user-select: none;
        }
        .new-carousel :where(.new-card, .new-img),
        .none-carousel :where(.new-card, .new-img) {
        display: flex;
        justify-content: center;
        align-items: center;
        }
        .new-carousel .new-card,
        .none-carousel .new-card {
        scroll-snap-align: start;
        height: 342px;
        list-style: none;
        background: #fff;
        cursor: pointer;
        padding-bottom: 15px;
        flex-direction: column;
        border-radius: 8px;
        }
        .new-carousel .new-card .new-img,
        .none-carousel .new-card .new-img {
        background:#ffac53;
        height: 148px;
        width: 148px;
        border-radius: 50%;
        }
        .new-card .new-img img {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        }
        .new-carousel .new-card h2,
        .none-carousel .new-card h2 {
        font-weight: 500;
        font-size: 1.56rem;
        margin: 30px 0 5px;
        }
        .new-carousel .new-card span,
        .none-carousel .new-card span {
        color: #6A6D78;
        font-size: 1.31rem;
        }
        @media screen and (max-width: 900px) {
        .new-wrapper .new-carousel,
        .new-wrapper .none-carousel {
            grid-auto-columns: calc(100% / 3);
        }
        }
        @media screen and (max-width: 600px) {
        .new-wrapper .new-carousel,
        .new-wrapper .none-carousel {
            grid-auto-columns: calc(100% / 2);
        }
        }
        @media screen and (max-width: 500px) {
        .new-wrapper .new-carousel,
        .new-wrapper .none-carousel {
            grid-auto-columns: calc((100% / 1) + 45px);
        }
        }
        .card-body h6 {
            font-weight: 500;
        }
    </style>

</head>
<body>

<?php
    if (isset($_GET['or_msg'])) {
        echo '<div id="success-box">Order Successfully Placed... Your Invoice No: <b>'.$_SESSION['temporary_invoice_no'].'</b></div>';
    }
?>

<?php
// order tracking bar
include 'order-tracking-bar.php';
// header file
include 'header.php';
// cart bar
include 'cartBar.php';
?>

<!--==========================================-->
<!--============ START HOME SECTION ==========-->
<!--==========================================-->
<div class="pb-5 js-waypoint-sticky">

    <!-- Carousel Slider Area -->
    <div class="container">
        <br>
        <div class="img-carousel-area">
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner rounded">
                <?php 
                    $query = "SELECT slider_id, slider_img FROM slider";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($count == 1) {
                                echo '<div class="carousel-item active rounded">';
                                echo '<img src="img/'.htmlspecialchars($row['slider_img']).'" class="d-block w-100 rounded" alt="...">';
                                echo '</div>';
                            } else {
                                echo '<div class="carousel-item">';
                                echo '<img src="img/'.htmlspecialchars($row['slider_img']).'" class="d-block w-100 rounded" alt="...">';
                                echo '</div>';
                            }
                            $count++;
                        }
                    }
                ?>  
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Info Area -->
    <div class="info-area">
        <div class="container">
            <div class="row py-5 d-none d-md-flex">
                <div class="col-md-3 text-center p-3">
                    <i class="info-icons fa-solid fa-hand-holding-dollar"></i>
                    <h5>Cash On Delivery</h5>
                    <p>COD in whole Bangladesh</p>
                </div>
                <div class="col-md-3 text-center p-3">
                    <i class="info-icons fa-solid fa-people-carry-box"></i>
                    <h5>Easy return</h5>
                    <p>Easy return facility for any problem</p>
                </div>
                <div class="col-md-3 text-center p-3">
                    <i class="info-icons fa-solid fa-truck"></i>
                    <h5>Fast Delivery</h5>
                    <p>Delivery in 1 day within Dhaka, 2 days outside Dhaka</p>
                </div>
                <div class="col-md-3 text-center p-3">
                    <i class="info-icons fa-solid fa-headset"></i>
                    <h5>24/7 Support</h5>
                    <p>24 hours live support at your service</p>
                  </div>
            </div>
        </div>
    </div>

    <!-- Category List Area -->
    <section class="category py-5 bg-gray1">
        <div class="container">
            <h1>Categories</h1>
            <p>Explore all the product categories</p>
            <br><br>
            <!-- Category Card Slider -->
            <div class="new-wrapper">
                    <?php 
                        $sql = "SELECT * FROM main_category";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_num_rows($result);
                        
                        if ($row > 3) {
                            ?>
                            <i id="left" class="fa-solid fa-angle-left"></i>
                            <ul class="new-carousel">
                            <?php
                            while ($category = mysqli_fetch_array($result)) {
                                echo "<li class='new-card'>
                                        <a href='category.php?main_ctg_id={$category['main_ctg_id']}'>
                                            <div class='new-img'><img src='img/{$category['main_ctg_img']}' alt='img' draggable='false'></div>
                                            <h2 class='text-center'>{$category['main_ctg_name']}</h2>
                                        </a>
                                    </li>";
                            }
                            ?>
                            </ul>
                            <i id="right" class="fa-solid fa-angle-right"></i>
                            <?php
                        } else if ($row < 4 && $row > 0) {
                            ?>
                            <ul class="none-carousel">
                            <?php
                            while ($category = mysqli_fetch_array($result)) {
                                echo "<li class='new-card'>
                                        <a href='category.php?main_ctg_id={$category['main_ctg_id']}'>
                                            <div class='new-img'><img src='img/{$category['main_ctg_img']}' alt='img' draggable='false'></div>
                                            <h2 class='text-center'>{$category['main_ctg_name']}</h2>
                                        </a>
                                    </li>";
                            }
                            ?>
                            </ul>
                            <?php
                        }
                    ?>
            </div>
        </div>
    </section>
            <script>
                const wrapper = document.querySelector(".new-wrapper");
                const carousel = document.querySelector(".new-carousel");
                const firstCardWidth = carousel.querySelector(".new-card").offsetWidth;
                const arrowBtns = document.querySelectorAll(".new-wrapper i");
                const carouselChildrens = [...carousel.children];
                let isDragging = false, isAutoPlay = true, startX, startScrollLeft, timeoutId;
                // Get the number of cards that can fit in the carousel at once
                let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);
                // Insert copies of the last few cards to beginning of carousel for infinite scrolling
                carouselChildrens.slice(-cardPerView).reverse().forEach(card => {
                    carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
                });
                // Insert copies of the first few cards to end of carousel for infinite scrolling
                carouselChildrens.slice(0, cardPerView).forEach(card => {
                    carousel.insertAdjacentHTML("beforeend", card.outerHTML);
                });
                // Scroll the carousel at appropriate postition to hide first few duplicate cards on Firefox
                carousel.classList.add("no-transition");
                carousel.scrollLeft = carousel.offsetWidth;
                carousel.classList.remove("no-transition");
                // Add event listeners for the arrow buttons to scroll the carousel left and right
                arrowBtns.forEach(btn => {
                    btn.addEventListener("click", () => {
                        carousel.scrollLeft += btn.id == "left" ? -firstCardWidth : firstCardWidth;
                    });
                });
                const dragStart = (e) => {
                    isDragging = true;
                    carousel.classList.add("dragging");
                    // Records the initial cursor and scroll position of the carousel
                    startX = e.pageX;
                    startScrollLeft = carousel.scrollLeft;
                }
                const dragging = (e) => {
                    if(!isDragging) return; // if isDragging is false return from here
                    // Updates the scroll position of the carousel based on the cursor movement
                    carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
                }
                const dragStop = () => {
                    isDragging = false;
                    carousel.classList.remove("dragging");
                }
                const infiniteScroll = () => {
                    // If the carousel is at the beginning, scroll to the end
                    if(carousel.scrollLeft === 0) {
                        carousel.classList.add("no-transition");
                        carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
                        carousel.classList.remove("no-transition");
                    }
                    // If the carousel is at the end, scroll to the beginning
                    else if(Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
                        carousel.classList.add("no-transition");
                        carousel.scrollLeft = carousel.offsetWidth;
                        carousel.classList.remove("no-transition");
                    }
                    // Clear existing timeout & start autoplay if mouse is not hovering over carousel
                    clearTimeout(timeoutId);
                    if(!wrapper.matches(":hover")) autoPlay();
                }
                const autoPlay = () => {
                    if(window.innerWidth < 800 || !isAutoPlay) return; // Return if window is smaller than 800 or isAutoPlay is false
                    // Autoplay the carousel after every 2500 ms
                    timeoutId = setTimeout(() => carousel.scrollLeft += firstCardWidth, 2500);
                }
                autoPlay();
                carousel.addEventListener("mousedown", dragStart);
                carousel.addEventListener("mousemove", dragging);
                document.addEventListener("mouseup", dragStop);
                carousel.addEventListener("scroll", infiniteScroll);
                wrapper.addEventListener("mouseenter", () => clearTimeout(timeoutId));
                wrapper.addEventListener("mouseleave", autoPlay);
            </script>


    <!-- New Arrival Area -->
     <section class="new-arrival py-5">
        <div class="container">
            <div class="grid-container-2x">
                <div class="title-align-left">
                    <h1>New Arrival Products</h1>
                    <p>Explore all the new product</p>
                </div>
                <div class="btn-align-end">
                    <a href="shop.php">
                        <button class="btn btn-dark btn-see-all">See All The Products <i class="ri-arrow-right-line"></i></button>
                    </a>
                </div>
            </div>
            <br><hr><br>
            <div class="grid-container new-arrival-products">
                <!-- All Product Card Will Add Here Dynamically -->
                <?php
                    $sql = "SELECT product_info.*, main_category.main_ctg_name 
                            FROM product_info 
                            JOIN main_category 
                            ON product_info.main_ctg_id = main_category.main_ctg_id
                            WHERE product_info.product_type = 'new_arrival'
                            ORDER BY product_info.product_id DESC";

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
                            </div>";

                            if ($item['available_stock'] > 0) {
                                echo "<button onclick='addToCart(this)' class='btn btn-outline-dark'><span>Add to Cart</span> <i class='ri-shopping-bag-line'></i></button>";

                            } else {
                                echo "<button style='font-weight: 700' class='btn btn-outline-danger'>Out of stock!</button>";
                            }


                            echo "<a href='product.php?pi=$item[product_id]'>
                                <button class='btn btn-dark'><span>Order Now</span> <i class='ri-shopping-cart-2-line'></i></button>
                            </a>
                        </div>
                    </div>";
                    }
                ?>
            </div>
        </div>
     </section>

    <!-- Top Selling Product -->
    <section class="top-selling py-5 bg-gray1">
        <div class="container">
            <div class="grid-container-2x">
                <div class="title-align-left">
                    <h1>Top Selling Products</h1>
                    <p>Explore all the top selling product</p>
                </div>
                <div class="btn-align-end">
                    <a href="shop.php">
                        <button class="btn btn-dark btn-see-all">See All The Products <i class="ri-arrow-right-line"></i></button>
                    </a>
                </div>
            </div>
            <br><hr><br>
            <div class="grid-container top-selling-products">
                <!-- All Product Card Will Add Here Dynamically -->
                <?php
                    $sql = "SELECT product_info.*, main_category.main_ctg_name 
                            FROM product_info 
                            JOIN main_category 
                            ON product_info.main_ctg_id = main_category.main_ctg_id
                            WHERE product_info.product_type = 'top_selling'
                            ORDER BY product_info.product_id DESC";
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

    <!-- Trending Product -->
    <section class="top-selling py-5">
        <div class="container">
            <div class="grid-container-2x">
                <div class="title-align-left">
                    <h1>Trending Products</h1>
                    <p>Explore all the trending product</p>
                </div>
                <div class="btn-align-end">
                    <a href="shop.php">
                        <button class="btn btn-dark btn-see-all">See All The Products <i class="ri-arrow-right-line"></i></button>
                    </a>
                </div>
            </div>
            <br><hr><br>
            <div class="grid-container top-selling-products">
                <!-- All Product Card Will Add Here Dynamically -->
                <?php
                    $sql = "SELECT product_info.*, main_category.main_ctg_name 
                            FROM product_info 
                            JOIN main_category 
                            ON product_info.main_ctg_id = main_category.main_ctg_id
                            WHERE product_info.product_type = 'trending'
                            ORDER BY product_info.product_id DESC";
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

    <!-- Top Rated Product -->
    <section class="top-selling py-5 bg-gray1">
        <div class="container">
            <div class="grid-container-2x">
                <div class="title-align-left">
                    <h1>Top Rated Products</h1>
                    <p>Explore all the top rated product</p>
                </div>
                <div class="btn-align-end">
                    <a href="shop.php">
                        <button class="btn btn-dark btn-see-all">See All The Products <i class="ri-arrow-right-line"></i></button>
                    </a>
                </div>
            </div>
            <br><hr><br>
            <div class="grid-container top-selling-products">
                <!-- All Product Card Will Add Here Dynamically -->
                <?php
                    $sql = "SELECT product_info.*, main_category.main_ctg_name 
                            FROM product_info 
                            JOIN main_category 
                            ON product_info.main_ctg_id = main_category.main_ctg_id
                            WHERE product_info.product_type = 'top_rated'
                            ORDER BY product_info.product_id DESC";
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
     
    <!--=====================================================-->
    <!--============= All Category List & Items =============-->
    <div class="all-categories">
        <?php
            include 'database/dbConnection.php';

            // Fetch main categories
            $mainCategoriesSql = "SELECT * FROM main_category";
            $mainCategoriesResult = $conn->query($mainCategoriesSql);
            $count = 0;
            if ($mainCategoriesResult->num_rows > 0) {
                while ($mainCategory = $mainCategoriesResult->fetch_assoc()) {
                    $categoryName = $mainCategory['main_ctg_name'];
                    $categoryId = $mainCategory['main_ctg_id'];

                    // Fetch products for each category
                    $sql = "SELECT product_info.*, main_category.main_ctg_name 
                        FROM product_info 
                        JOIN main_category 
                        ON product_info.main_ctg_id = main_category.main_ctg_id 
                        WHERE product_info.main_ctg_id = $categoryId LIMIT 10";

                    $result = mysqli_query($conn, $sql);


                    // Skip if no product found for this category
                    if (mysqli_num_rows($result) <= 0) {
                        continue;
                    }

                    // printing product card
                    if ($count % 2 == 0) {
                        echo '<section class="py-5">';
                    } else {
                        echo '<section class="py-5 bg-gray1">';
                    }

                    echo '        <div class="container">
                                <div class="grid-container-2x">
                                    <div class="title-align-left">
                                        <h1>'.$categoryName.'</h1>
                                        <p>Explore All The '.$categoryName.' Products</p>
                                    </div>
                                    <div class="btn-align-end">
                                        <button onclick="window.location.href=\'category.php?main_ctg_id='.$categoryId.'\';" class="btn btn-dark btn-see-all">See All The Products <i class="ri-arrow-right-line"></i></button>
                                    </div>
                                </div>
                                <br><hr><br>
                                <div class="grid-container">
                    ';
                        
                        // $products = array();
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

                    echo '</div>
                        </div>
                    </section>'
                    ;  

                    $count++;

                }
            }
        ?>
        
            
    </div> 


    <!-- All Product -->
    <section class="top-selling py-5 bg-gray1">
        <div class="container">
            <div class="grid-container-2x">
                <div class="title-align-left">
                    <h1>All Products</h1>
                    <p>Explore all the products</p>
                </div>
                <div class="btn-align-end">
                    <a href="shop.php">
                        <button class="btn btn-dark btn-see-all">See All The Products <i class="ri-arrow-right-line"></i></button>
                    </a>
                </div>
            </div>
            <br><hr><br>
            <div class="grid-container top-selling-products">
                <!-- All Product Card Will Add Here Dynamically -->
                <?php
                    $sql = "SELECT product_info.*, main_category.main_ctg_name 
                            FROM product_info 
                            JOIN main_category 
                            ON product_info.main_ctg_id = main_category.main_ctg_id
                            ORDER BY product_info.product_id DESC";
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
<!--============ END HOME SECTION ==========-->
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

</body>
</html>
<?php
// Close the connection
mysqli_close($conn);
?>