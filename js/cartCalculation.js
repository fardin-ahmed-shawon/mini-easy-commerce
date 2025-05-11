// Adding Cart list & Calculation
let carts = [];
var total_price;

        function addToCart(button) {
            // Accessing grand parent which is card class
            let product = button.parentElement.parentElement;
            let id = product.getAttribute("product-id");
            let image = product.getAttribute("product-img");
            let name = product.getAttribute("product-title");
            let price = product.getAttribute("product-price");
            let quantity = product.getAttribute("product-quantity");

            let ind = 0;

            // Checking same product exist or not in the carts
            if (carts.length == 0) {
                carts.push({id, image, name, price, quantity});
                updateCart();
            } else {
                carts.forEach(data=> {
                    if (data.id == id) {
                        ind = 1;
                    }
                });

                if (ind == 0) {
                    carts.push({id, image, name, price, quantity});
                    updateCart();
                } else {
                    alert("Product Already Added!");
                }
            }
        }

        function updateCart() {
            total_price = 0;
            let total_price_container = document.querySelector('.total-price');
            let cart_content = document.querySelector('.cart-content');

            cart_content.innerHTML = "";
            carts.forEach(item=> {
                // create cart-box element
                const cartList = document.createElement("div");
                cartList.className = "cart-box";
                cartList.setAttribute("id", `${item.id}`);

                cartList.innerHTML = `
                    <img src="${item.image}" alt="cart-img">
                    <div class="cart-details">
                        <h2 class="cart-product-title">${item.name}</h2>
                        <span class="cart-price">Tk. ${item.price}</span>
                        <div class="cart-quantity">
                            <button onclick="decrementQuantity(this)" class="decrement" id="decrement">-</button>
                            <span class="number">${item.quantity}</span>
                            <button onclick="incrementQuantity(this)" class="increment" id="increment">+</button>
                        </div>
                    </div>
                    <i onclick="removeCart(this)" class="ri-delete-bin-line cart-remove"></i>
                `;
                total_price += parseInt(item.price) * item.quantity;
                cart_content.appendChild(cartList);
            });
            total_price_container.innerHTML = `Tk. ${total_price}`;

            // cart counter on top and bottom icons
            const top_cart_counter = document.querySelector('.top-cart-counter');
            const bottom_cart_counter = document.querySelector('.bottom-cart-counter');

            top_cart_counter.innerHTML = carts.length;
            bottom_cart_counter.innerHTML = carts.length;

            // Save cart data to local storage
            localStorage.setItem('cartData', JSON.stringify(carts));
        }

        function removeCart(button) {
            // Accessing parent
            const cart_box = button.parentElement;
            let id = cart_box.getAttribute("id");
        
            // Removing cart element according to product id
            const updatedCarts = carts.filter(item => item.id !== id);
            carts = [...updatedCarts];
        
            // Reset the quantity of the removed item in the carts array
            const cartItem = carts.find(item => item.id === id);
            if (cartItem) {
                cartItem.quantity = 1;
            }
        
            // Update the product-quantity attribute in the corresponding card
            const card = document.querySelector(`.card[product-id="${id}"]`);
            if (card) {
                card.setAttribute("product-quantity", 1);
            }

            // Save cart data to local storage
            localStorage.setItem('cartData', JSON.stringify(carts));
        
            // Update the cart
            updateCart();
        }

        // Quantity Increment
        function incrementQuantity(button) {
            const cartBox = button.closest(".cart-box");
            const quantitySpan = cartBox.querySelector(".number");
            let quantity = parseInt(quantitySpan.textContent);
            if (!isNaN(quantity)) {
                quantity += 1;
                quantitySpan.textContent = quantity;
        
                // Update the product-quantity attribute in the corresponding card
                const productId = cartBox.getAttribute("id");
                const card = document.querySelector(`.card[product-id="${productId}"]`);
                if (card) {
                    card.setAttribute("product-quantity", quantity);
                }
        
                // Update the quantity in the carts array
                const cartItem = carts.find(item => item.id === productId);
                if (cartItem) {
                    cartItem.quantity = quantity;
                }

                // Save cart data to local storage
                localStorage.setItem('cartData', JSON.stringify(carts));

                // Update the cart
                updateCart();

            } else {
                quantitySpan.textContent = 1;
            }
        }

        // Quantity Decrement
        function decrementQuantity(button) {
            const cartBox = button.closest(".cart-box");
            const quantitySpan = cartBox.querySelector(".number");
            let quantity = parseInt(quantitySpan.textContent);
            if (!isNaN(quantity) && quantity > 1) {
                quantity -= 1;
                quantitySpan.textContent = quantity;
        
                // Update the product-quantity attribute in the corresponding card
                const productId = cartBox.getAttribute("id");
                const card = document.querySelector(`.card[product-id="${productId}"]`);
                if (card) {
                    card.setAttribute("product-quantity", quantity);
                }
        
                // Update the quantity in the carts array
                const cartItem = carts.find(item => item.id === productId);
                if (cartItem) {
                    cartItem.quantity = quantity;
                }

                // Save cart data to local storage
                localStorage.setItem('cartData', JSON.stringify(carts));

                // Update the cart
                updateCart();

            } else if (isNaN(quantity)) {
                quantitySpan.textContent = 1;
            }
        }

        console.log(carts);

        // To get the cart data from local storage when the page is loaded
        document.addEventListener('DOMContentLoaded', () => {
            const savedCartData = JSON.parse(localStorage.getItem('cartData')) || [];
            if (savedCartData.length > 0) {
                carts = savedCartData;
                updateCart();
            }
        });

        // Cart Calculation For Single Product Page
        function addProductToCart(button) {
            // Accessing grand parent which is card class
            let product = button.parentElement.parentElement.parentElement.parentElement;

            let id = product.getAttribute("product-id");
            let image = product.getAttribute("product-img");
            let name = product.getAttribute("product-title");
            let price = product.getAttribute("product-price");
            let quantity = product.getAttribute("product-quantity");

            let ind = 0;

            // Checking same product exist or not in the carts
            if (carts.length == 0) {
                carts.push({id, image, name, price, quantity});
                updateCart();
            } else {
                carts.forEach(data=> {
                    if (data.id == id) {
                        ind = 1;
                    }
                });

                if (ind == 0) {
                    carts.push({id, image, name, price, quantity});
                    updateCart();
                } else {
                    alert("Product Already Added!");
                }
            }
        }

        // function To clear all cart data
        function clearCart() {
            window.onload = function() {
                localStorage.clear();
            };
        }