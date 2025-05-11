<!--====================================-->
<!--========== START CART BAR ==========-->
<!--====================================-->
<section class="cart">
    <div class="cls-btn-area text-end" onclick="closeCartBar()">
        <i class="ri-close-large-fill"></i>
    </div><br>
    <h2 class="cart-title">Your Cart</h2><hr>

    
    <div class="cart-content">
        <!-- Recreatable component -->
        <h2 style="border-radius: 10px;padding: 30px 0;background: var(--topback);" class="card cart-title">No Items Found</h2>
        <!-- End -->
    </div>

    <hr>
    <div class="total">
        <div class="total-title">Total</div>
        <div class="total-price text-end">Tk. 0</div>
    </div>
    <br>
    <div class="cart-bottom-button">
        <button onclick="window.location.href='checkout.php'" class="btn btn-dark btn-checkout">Checkout</button>
        <button onclick="window.location.href='viewCart.php';" class="btn btn-dark btn-cart">View Cart</button>
    </div>
</section>
<!--==================================-->
<!--========== END CART BAR ==========-->
<!--==================================-->