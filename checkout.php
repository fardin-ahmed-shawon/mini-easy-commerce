<?php
error_reporting(E_ALL);
session_start();

// Redirect to login page if user is not logged in
// if (!isset($_SESSION['phone'])) {
//     header("Location: login.php?rd='checkout'");
//     exit();
// }

// database connection
include 'database/dbConnection.php';

error_reporting(0);

// Database insertion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $payment_method = $_POST['payment_method'];
    $accNum = $_POST['accNum'];
    $transactionID = $_POST['transactionID'];

    // Assuming you have user_id in session
    // $user_id = $_SESSION['id'];
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : '0'; 
    

    // Generate a unique invoice number
    function generateInvoiceNo() {
        // Get the current timestamp in microseconds
        $timestamp = microtime(true) * 10000; // More digits by multiplying
        // Convert timestamp to a unique string
        $uniqueString = 'INV-' . strtoupper(base_convert($timestamp, 10, 36));
        return $uniqueString;
    }

    $invoice_no = generateInvoiceNo();

    $_SESSION['temporary_invoice_no'] = $invoice_no;

    if ($payment_method != "Cash On Delivery" && ($accNum == "" || $transactionID == "")) {
        // echo "Please Provide both Account Number and Transaction ID!";
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT="2; URL=checkout.php">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let msg_box = document.getElementById("msg");
                if (msg_box) {
                    msg_box.style.display = "block";
                    msg_box.innerText = "Please Provide both Account Number and Transaction ID!";
                    setTimeout(() => {
                        msg_box.style.display = "none";
                    }, 3000);
                }
            });
        </script>
        <?php
    } else {
        // Retrieve cart data from POST request
        $cartData = json_decode($_POST['cartData'], true);

        foreach ($cartData as $product) {
            $product_id = $product['id'];
            $product_title = $product['name'];
            $product_quantity = $product['quantity'];
            $product_size = isset($product['size']) ? $product['size'] : 'Default';
            $total_price = $product['price'] * $product_quantity;

            // Insert data into order_info table
            $sql = "INSERT INTO order_info (user_id, user_first_name, user_last_name, user_phone, user_email, user_address, city_address, invoice_no, product_id, product_title, product_quantity, product_size, total_price, payment_method)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssssssisisss", $user_id, $firstName, $lastName, $phone, $email, $address, $city, $invoice_no, $product_id, $product_title, $product_quantity, $product_size, $total_price, $payment_method);

            if ($stmt->execute()) {
                if ($payment_method != "Cash On Delivery") {
                    // Get the last inserted order number
                    $order_no = $conn->insert_id;

                    // Insert data into payment_info table
                    $sql_payment = "INSERT INTO payment_info (invoice_no, order_no, order_status, payment_method, acc_number, transaction_id, payment_status)
                    VALUES (?, ?, 'Pending', ?, ?, ?, 'Unpaid')";
                    $stmt_payment = $conn->prepare($sql_payment);
                    $stmt_payment->bind_param("sisss", $invoice_no, $order_no, $payment_method, $accNum, $transactionID);

                    $stmt_payment->execute();
                    $stmt_payment->close();
                }
            } else {
                $err_msg = "Order Not Placed!";
            }
            $stmt->close();
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce | Checkout</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/cartbar.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/checkout.css">

    <!--========== Remixicon ==========-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        /* Add custom styles to ensure radio buttons are displayed correctly */
        .radio-input-box input[type="radio"] {
            height: 15px;
            display: inline-block;
            margin-right: 5px;
        }

        .radio-input-box label {
            display: inline-block;
            margin-right: 15px;
        }
        .radio-input-box .details {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
        }
        #msg {
            font-size: 25px;
            font-weight: 700;
            text-align: center;
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border-bottom: 3px solid #9c202c;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            display: none;
        }
        #success-msg {
            background-color: #d1e7dd;
            color: #0f5132;
            font-size: 25px;
            font-weight: 700;
            text-align: center;
            padding: 10px;
            border-bottom: 3px solid #0f5132;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            display: none;
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


<!--==============================================-->
<!--============ START CHECKOUT SECTION ==========-->
<!--============================================-->
<section class="checkout py-5">
    <div class="container js-waypoint-sticky">
        <h1 class="text-center">Checkout</h1><hr><br>
        <br>
        <!-- Checkout Form -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="checkout-container">
                <!-- left area -->
                <div class="checkout">
                    <div class="title">Billing Address</div><br>
                    <div class="content">
                    <!-- input form -->
                        <div class="user-details full-input-box">
                            <!-- Input for First Name -->
                            <div class="input-box">
                                <span class="details">First Name<i class="text-danger">*</i></span>
                                <input name="firstName" type="text" placeholder="Enter your first name" required>
                            </div>
                            <!-- Input for Lasat Name -->
                            <div class="input-box">
                                <span class="details">Last Name<i class="text-danger">*</i></span>
                                <input name="lastName" type="text" placeholder="Enter your last name" required>
                            </div>
                            <!-- Input for phone number -->
                            <div class="input-box">
                                <span class="details">Phone Number<i class="text-danger">*</i></span>
                                <input minlength="11" name="phone" type="text" placeholder="Enter your number" required>
                            </div>
                            <!-- Input for email number -->
                            <div class="input-box">
                                <span class="details">Email</span>
                                <input name="email" type="email" placeholder="Enter your email">
                            </div>
                            <!-- Input for address -->
                            <div class="input-box">
                                <span class="details">Address<i class="text-danger">*</i></span>
                                <input name="address" type="text" placeholder="Enter your address" required>
                            </div><br>
                            <!-- Input for city -->
                            <div class="radio-input-box">
                                <span class="details">Choose Your Delivery Location</span>
                                <input name="city" type="radio" id="dhaka" value="Inside Dhaka" checked>
                                <label for="dhaka">Inside Dhaka</label>
                                <br>
                                <input name="city" type="radio" id="outside" value="Outside Dhaka">
                                <label for="outside">Outside Dhaka</label>
                                <br><br>
                                <i>
                                    <p class="text-muted">* Delivery Charge Inside Dhaka 80 Tk.</p>
                                    <p class="text-muted">* Delivery Charge Outside Dhaka 150 Tk.</p>
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right area -->
                <div class="order-info">
                    <div class="products-info">
                        <div class="title">Your Order</div>
                        <br>
                        <div class="order-list">
                            <div class="order-titles">
                                <h5>Products</h5>
                                <h5>Subtotal</h5>
                            </div><hr>
                            <div class="order-items" id="order-items">
                            <!-- Cart item will add dynamically -->
                            </div>
                            <hr>
                            <div class="subtotal">
                                <div class="subtotal-title">Subtotal</div>
                                <div class="subtotal-price amount" id="subtotal-price">Tk. 0</div>
                            </div><br>
                            <div class="shipping">
                                <div class="shipping-title">Shipping</div>
                                <div class="shipping-price amount" id="shipping-price">Tk. 0</div>
                            </div>
                            <hr>
                            <div class="total-product-price">
                                <div class="total-product-price-title">Total</div>
                                <div class="total-product-price-price amount" id="total-price">Tk. 0</div>
                            </div>
                        </div>
                    </div>
                    <!-- Bottom -->
                    <br>
                    <div class="payment-info">
                        <div class="title">Payment Method</div>
                        <br>
                            <div class="selection-box">
                                <p>Pay With Cash Upon Delivery</p>
                                <br>
                                <div class="radio-input-box">
                                    <input name="payment_method" type="radio" id="cod" value="Cash On Delivery" checked>
                                    <label for="cod">Cash On Delivery</label><br>
                                </div>
                            </div>

                            

                            <br>
                            <div class="button">
                                <input class="btn btn-dark" type="submit" value="Place Order">
                            </div>
                        <br>
                    </div>
                </div>   
            </div>
        </form>
        <br><hr>
    </div>
</section>
<!--==============================================-->
<!--============ END CHECKOUT SECTION ==========-->
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
            const orderItemsContainer = document.getElementById('order-items');
            const subtotalPriceContainer = document.getElementById('subtotal-price');
            const shippingPriceContainer = document.getElementById('shipping-price');
            const totalPriceContainer = document.getElementById('total-price');
            const send_amount = document.querySelectorAll('.send-amount');

            let subtotal = 0;

            // sipping cost
            let shipping_inside_dhaka = 80;
            let shipping_outside_dhaka = 150;
            let shipping = shipping_inside_dhaka; 

            cartData.forEach(item => {
                const orderItem = document.createElement('div');
                orderItem.className = 'order-item';
                orderItem.innerHTML = `
                    <div class="order-product-info">
                        <div class="cart-box" id="${item.id}">
                            <img src="${item.image}" alt="cart-img">
                            <div class="cart-details">
                                <h2 class="cart-product-title">${item.name}</h2>
                                <!--
                                <h2 class="cart-product-title product-size">Size: XL</h2>
                                -->
                                <div class="cart-quantity">
                                    <button class="decrement" id="decrement">-</button>
                                    <span class="number">${item.quantity}</span>
                                    <button class="increment" id="increment">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-product-price amount">Tk. ${item.price * item.quantity}</div>
                `;
                subtotal += item.price * item.quantity;
                orderItemsContainer.appendChild(orderItem);
            });

            subtotalPriceContainer.textContent = `Tk. ${subtotal}`;
            shippingPriceContainer.textContent = `Tk. ${shipping}`;
            totalPriceContainer.textContent = `Tk. ${subtotal + shipping}`;
            send_amount.forEach(element => {
                element.innerHTML = totalPriceContainer.textContent;
            });

            // Add event listeners for increment and decrement buttons
            orderItemsContainer.addEventListener('click', (event) => {
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
                        const finalPrice = cartBox.closest('.order-item').querySelector('.order-product-price');
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
                        const finalPrice = cartBox.closest('.order-item').querySelector('.order-product-price');
                        finalPrice.textContent = `Tk. ${cartItem.price * cartItem.quantity}`;

                        // Update the subtotal and total prices
                        updatePrices();
                    }
                }
            });

            // Add event listeners for the radio buttons to update the shipping cost
            document.getElementById('dhaka').addEventListener('change', () => {
                shipping = shipping_inside_dhaka;
                shippingPriceContainer.innerHTML = shipping_inside_dhaka;
                updatePrices();
            });

            document.getElementById('outside').addEventListener('change', () => {
                shipping = shipping_outside_dhaka;
                shippingPriceContainer.innerHTML = shipping_outside_dhaka;
                updatePrices();
            });

            function updatePrices() {
                let newSubtotal = 0;
                cartData.forEach(item => {
                    newSubtotal += item.price * item.quantity;
                });
                subtotalPriceContainer.textContent = `Tk. ${newSubtotal}`;
                totalPriceContainer.textContent = `Tk. ${newSubtotal + shipping}`;
                send_amount.forEach(element => {
                    element.innerHTML = totalPriceContainer.textContent;
                });
            }

        });
    

// Handle Payment Information Input Area -------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
    const paymentMethods = [
        { id: 'bKash', inputAreaId: 'bkash-input-area', accordionId: 'flush-collapseOne' },
        { id: 'nagad', inputAreaId: 'nagad-input-area', accordionId: 'flush-collapseTwo' },
        { id: 'rocket', inputAreaId: 'rocket-input-area', accordionId: 'flush-collapseThree' },
        { id: 'upay', inputAreaId: 'upay-input-area', accordionId: 'flush-collapseFour' }
    ];

    paymentMethods.forEach(method => {
        const radio = document.getElementById(method.id);
        const inputArea = document.getElementById(method.inputAreaId);
        const accordionButton = document.querySelector(`[data-bs-target="#${method.accordionId}"]`);
        const accordion = document.getElementById(method.accordionId);

        radio.addEventListener('change', function () {
            if (radio.checked) {
                inputArea.innerHTML = `
                    <div class="input-box">
                        <label for="${method.id}_accNum">Your ${method.id} Account Number</label>
                        <input name="accNum" class="form-control" id="${method.id}_accNum" type="text" placeholder="01XXXXXXXXX" required>
                    </div>
                    <br>
                    <div class="input-box">
                        <label for="${method.id}_transactionID">Your ${method.id} Transaction ID</label>
                        <input name="transactionID" class="form-control" id="${method.id}_transactionID" type="text" placeholder="Enter Transaction ID" required>
                    </div>
                `;
            } else {
                inputArea.innerHTML = '';
            }
        });

        accordionButton.addEventListener('click', function () {
            radio.checked = true;
            radio.dispatchEvent(new Event('change'));
        });

        const allAccordions = document.querySelectorAll('.accordion-collapse');
        allAccordions.forEach(acc => {
            acc.addEventListener('show.bs.collapse', function () {
                if (acc !== accordion) {
                    inputArea.innerHTML = '';
                }
            });
        });
    });

    // Clear input areas when "Cash On Delivery" is selected
    const codRadio = document.getElementById('cod');
    codRadio.addEventListener('change', function () {
        if (codRadio.checked) {
            paymentMethods.forEach(method => {
                const inputArea = document.getElementById(method.inputAreaId);
                inputArea.innerHTML = '';
            });
        }
    });
});
//-----------------------------------------------------------------------------------------


// Send product data from the localstora to the server
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const cartData = JSON.parse(localStorage.getItem('cartData')) || [];
        const formData = new FormData(form);

        // Add cart data to form data
        formData.append('cartData', JSON.stringify(cartData));

        // Send the form data to the server
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.body.innerHTML = data;
            localStorage.clear();
            window.location.href = "index.php?or_msg='successful'";
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>

</body>
</html>