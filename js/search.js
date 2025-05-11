// Fetch product data from the API using AJAX
const xhr = new XMLHttpRequest();
xhr.open('GET', 'get_products.php', true);
xhr.onload = function() {
    if (this.status === 200) {
        const products = JSON.parse(this.responseText);

        // Generate keywords array from product titles
        let keywords = products.map(product => product.title);

        const resultBoxDesktop = document.querySelector(".search-suggestions");
        const inputBoxDesktop = document.getElementById("input-box");

        const resultBoxMobile = document.querySelector(".search-suggestions-mobile");
        const inputBoxMobile = document.getElementById("input-box-mobile");

        function handleSearch(inputBox, resultBox) {
            inputBox.onkeyup = function() {
                let result = [];
                let input = inputBox.value;
                if (input.length) {
                    result = products.filter((product) => {
                        return product.title.toLowerCase().includes(input.toLowerCase());
                    });
                }
                display(result, resultBox);
            }
        }

        function display(result, resultBox) {
            if (result.length) {
                const content = result.map((item) => {
                    return `
                        <div>
                            <a class="dropdown-item" href="#" onclick='window.location.href=\"product.php?pi=${item.id}\"'>
                                <img class="suggestion-left" src="${item.image}" alt="${item.title}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                <span class="suggestion-mid">${item.title}</span>
                                <span class="suggestion-right" style="float: right;">Tk. ${item.price}</span>
                            </a>
                        </div>`;
                }).join('');
                resultBox.innerHTML = content;
                resultBox.style.display = 'block';
            } else {
                resultBox.innerHTML = '';
                resultBox.style.display = 'none';
            }
        }

        function openProduct(id, title) {
            // Store the product ID and title in localStorage or pass them as query parameters
            localStorage.setItem('selectedProductId', id);
            localStorage.setItem('selectedProductTitle', title);
            window.location.href = 'product.php';
        }

        // Initialize search handlers for both desktop and mobile
        handleSearch(inputBoxDesktop, resultBoxDesktop);
        handleSearch(inputBoxMobile, resultBoxMobile);
    } else {
        console.error('Error fetching products:', this.statusText);
    }
};
xhr.onerror = function() {
    console.error('Request error...');
};
xhr.send();