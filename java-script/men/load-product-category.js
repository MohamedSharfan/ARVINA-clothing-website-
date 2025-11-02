async function fetchProducts() {
    try {
        const response = await fetch('../../php/get_men_categories.php'); 
        const products = await response.json();

        if (!Array.isArray(products)) {
            console.error("Invalid response:", products);
            return;
        }

        renderProducts(products);
    } catch (error) {
        console.error("Error fetching products:", error);
    }
}

function createProductCard(product) {
    const card = document.createElement('div');
    card.classList.add('category');

    card.innerHTML = `
        <div class="category-thambnail" onclick="window.location.href='${product.link}';">
            <img class="category-thambnail-image" src="${product.thumbnail}">
            <div class="category-title">
                <p>${product.title}</p>
            </div>
        </div>
    `;

    return card;
}

function renderProducts(products) {
    const productList = document.querySelector('.product-category');
    productList.innerHTML = '';

    products.forEach((product) => {
        const card = createProductCard(product);
        productList.appendChild(card);
    });
}

// Load data when page is ready
document.addEventListener('DOMContentLoaded', fetchProducts);
