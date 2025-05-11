<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce | View Cart</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/cartbar.css">
    <link rel="stylesheet" href="css/viewCart.css">

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


<!--==============================================-->
<!--============ START VIEW CART SECTION ==========-->
<!--============================================-->
<section class="checkout py-5 js-waypoint-sticky">
    <div class="container">
        <h1 class="text-center">Cart</h1><br>
        <br>
        <div class="view-cart-container">
            <!-- Left Area -->
            <div class="cart-list" id="cart-list">
                <!-- Cart item Dynamically Added Here -->
            </div>
            <!-- Right Area -->
            <div class="carts-total">
                <div class="carts-total-box">
                    <h5>Cart Totals</h5>
                    <br>
                    <div class="subtotal">
                        <p>Subtotals</p>
                        <p id="subtotal-price">Tk. 100000</p>
                    </div>
                    <div class="shipping pb-3">
                        <p>Shipping</p>
                        <p id="shipping-price">Tk. 80</p>
                    </div>
                    <hr>
                    <div class="total pt-3">
                        <p>Total</p>
                        <h5 id="total-price">Tk. 100070</h5>
                    </div>
                </div>
                <br>
                <button onclick="window.location.href='checkout.php'" class="btn btn-dark py-3">Proceed To Checkout</button>
            </div>
        </div>
        <br><hr>
    </div>
</section>
<!--==============================================-->
<!--============ END IEW CART SECTION ==========-->
<!--============================================-->


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

    
// Cart item show from the Local Storage
document.addEventListener('DOMContentLoaded', () => {
            const cartData = JSON.parse(localStorage.getItem('cartData')) || [];
            const cartListContainer = document.getElementById('cart-list');
            const subtotalPriceContainer = document.getElementById('subtotal-price');
            const shippingPriceContainer = document.getElementById('shipping-price');
            const totalPriceContainer = document.getElementById('total-price');
            let subtotal = 0;
            const shipping = 80; // Assuming shipping cost is 80

            cartData.forEach(item => {
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <div class="product-img">
                        <img src="${item.image}" alt="cart-img">
                    </div>
                    <div class="product-title">
                        <h5>${item.name}</h5>
                        <!--
                        <p class="product-size">Size: XL</p>
                        -->
                    </div>
                    <div class="unit-price">
                        Tk. <span>${item.price}</span>
                    </div>
                    <div class="quantity cart-box" id="${item.id}">
                        <div class="cart-quantity">
                            <button class="decrement" id="decrement">-</button>
                            <span class="number">${item.quantity}</span>
                            <button class="increment" id="increment">+</button>
                        </div>       
                    </div>
                    <div class="final-price">
                        Tk. ${item.price * item.quantity}
                    </div>
                    <div class="remove-product">
                        <i onclick="removeViewCart(this)" class="ri-delete-bin-line cart-remove"></i>
                    </div>
                `;
                subtotal += item.price * item.quantity;
                cartListContainer.appendChild(cartItem);
            });

            subtotalPriceContainer.textContent = `Tk. ${subtotal}`;
            totalPriceContainer.textContent = `Tk. ${subtotal + shipping}`;

            // Add event listeners for increment and decrement buttons
            cartListContainer.addEventListener('click', (event) => {
                if (event.target.classList.contains('increment')) {
                    const cartBox = event.target.closest('.cart-box');
                    const quantitySpan = cartBox.querySelector('.number');
                    let quantity = parseInt(quantitySpan.textContent);
                    if (!isNaN(quantity)) {
                        quantity += 1;
                        quantitySpan.textContent = quantity;
                        
                        // Update the quantity in the cartData array
                        const productId = cartBox.getAttribute('id');
                        const cartItem = cartData.find(item => item.id === productId);
                        if (cartItem) {
                            cartItem.quantity = quantity;
                            localStorage.setItem('cartData', JSON.stringify(cartData));
                        }

                        // Update the final price
                        const finalPrice = cartBox.closest('.cart-item').querySelector('.final-price');
                        finalPrice.textContent = `Tk. ${cartItem.price * cartItem.quantity}`;

                        // Update the subtotal and total prices
                        updatePrices();
                    }
                }

                if (event.target.classList.contains('decrement')) {
                    const cartBox = event.target.closest('.cart-box');
                    const quantitySpan = cartBox.querySelector('.number');
                    let quantity = parseInt(quantitySpan.textContent);
                    if (!isNaN(quantity) && quantity > 1) {
                        quantity -= 1;
                        quantitySpan.textContent = quantity;

                        // Update the quantity in the cartData array
                        const productId = cartBox.getAttribute('id');
                        const cartItem = cartData.find(item => item.id === productId);
                        if (cartItem) {
                            cartItem.quantity = quantity;
                            localStorage.setItem('cartData', JSON.stringify(cartData));
                        }

                        // Update the final price
                        const finalPrice = cartBox.closest('.cart-item').querySelector('.final-price');
                        finalPrice.textContent = `Tk. ${cartItem.price * cartItem.quantity}`;

                        // Update the subtotal and total prices
                        updatePrices();
                    }
                }
            });

            function updatePrices() {
                let newSubtotal = 0;
                cartData.forEach(item => {
                    newSubtotal += item.price * item.quantity;
                });
                subtotalPriceContainer.textContent = `Tk. ${newSubtotal}`;
                totalPriceContainer.textContent = `Tk. ${newSubtotal + shipping}`;
            }
        });

        function removeViewCart(button) {
            const cartBox = button.closest('.cart-item');
            const productId = cartBox.querySelector('.cart-box').getAttribute('id');

            // Remove the item from the cartData array
            const cartData = JSON.parse(localStorage.getItem('cartData')) || [];
            const updatedCartData = cartData.filter(item => item.id !== productId);
            localStorage.setItem('cartData', JSON.stringify(updatedCartData));

            // Remove the cart item from the DOM
            cartBox.remove();
            location.reload();
            // Update the subtotal and total prices
            updatePrices();
        }

</script>

</body>
</html>