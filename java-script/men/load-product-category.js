async function fetchProducts() {
    try {
        // ✅ Fetch using the new get_sub_categories.php API
        // Assuming '1' is the category_id for Men
        const response = await fetch('../php/get_sub_categories.php?category_id=1'); 
        const products = await response.json();
        
console.log(products);

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
            <img class="category-thambnail-image" src="${product.thumbnail}" alt="${product.title}">
            <div class="category-title">
                <p>${product.title}</p>
            </div>
        </div>
    `;

    return card;
}

function renderProducts(products) {
    const productList = document.querySelector('.product-category');
    if (!productList) {
        console.error("Container '.product-category' not found!");
        return;
    }

    productList.innerHTML = '';

    if (products.length === 0) {
        productList.innerHTML = '<p class="no-products">No subcategories found.</p>';
        return;
    }

    products.forEach((product) => {
        const card = createProductCard(product);
        productList.appendChild(card);
    });
}

// Load data when page is ready
document.addEventListener('DOMContentLoaded', fetchProducts);
