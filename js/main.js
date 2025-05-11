// Menu bar open and close
const pages = document.getElementById('pages');

function openMenuBtn() {
    pages.style.left = '0';
}

function closeMenuBtn() {
    pages.style.left = '-100%';
}

// Search bar open and close
const searchBtn = document.querySelector('.search-icon');
const closeSearchBtn = document.querySelector('.search-close-icon');

const searchBox = document.querySelector('.mobile-search-box');

searchBtn.addEventListener('click', () => {
    searchBox.style.display = 'block';
    closeSearchBtn.style.display = 'block';
    searchBtn.style.display = 'none';
});

closeSearchBtn.addEventListener('click', ()=>{
    searchBox.style.display = 'none';
    closeSearchBtn.style.display = 'none';
    searchBtn.style.display = 'block';
});

// Cart Bar Open and Close
const cart = document.querySelector('.cart');

function openCartBar() {
    cart.style.right = '0';
}

function closeCartBar() {
    cart.style.right = '-100%';
}

//-------------------------- Other Functions --------------------------------------
function openProduct(id) {
    localStorage.setItem('selectedProductId', id);
    window.location.href = 'product.php';
}

// Product Page
function changeImage(imageSrc) {
    document.getElementById('main-image').src = imageSrc;
}