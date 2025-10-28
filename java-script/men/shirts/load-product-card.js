const products = [
    {
        title: 'Classic Dress Shirt',
        price: 'Rs 5,450.00',
        save: 'SAVE RS 550.00',
        thumbnail: '../../assest/men/shirts/(1).jpeg',
        collection: 'Formal Wear',
        about: 'Elegant dress shirt perfect for formal occasions'
    },
    {
        title: 'Casual Button-Down',
        price: 'Rs 4,500.00',
        save: 'SAVE RS 450.00',
        thumbnail: '../../assest/men/shirts/(2).jpeg',
        collection: 'Casual Wear',
        about: 'Comfortable casual shirt for everyday wear'
    },
    {
        title: 'Premium Cotton Shirt',
        price: 'Rs 6,700.00',
        save: 'SAVE RS 670.00',
        thumbnail: '../../assest/men/shirts/(3).jpeg',
        collection: 'Premium Collection',
        about: 'High-quality cotton shirt with modern design'
    },
    {
        title: 'Oxford Shirt',
        price: 'Rs 5,200.00',
        save: 'SAVE RS 800.00',
        thumbnail: '../../assest/men/shirts/(4).jpeg',
        collection: 'Business Wear',
        about: 'Classic Oxford weave for professional look'
    },
    {
        title: 'Slim Fit Shirt',
        price: 'Rs 5,800.00',
        save: 'SAVE RS 700.00',
        thumbnail: '../../assest/men/shirts/(5).jpeg',
        collection: 'Modern Fit',
        about: 'Contemporary slim fit design'
    },
    {
        title: 'Linen Blend Shirt',
        price: 'Rs 6,200.00',
        save: 'SAVE RS 800.00',
        thumbnail: '../../assest/men/shirts/(6).jpeg',
        collection: 'Summer Collection',
        about: 'Breathable linen blend for warm weather'
    },
    {
        title: 'Check Pattern Shirt',
        price: 'Rs 4,900.00',
        save: 'SAVE RS 500.00',
        thumbnail: '../../assest/men/shirts/(7).jpeg',
        collection: 'Casual Wear',
        about: 'Stylish check pattern casual shirt'
    },
    {
        title: 'Striped Formal Shirt',
        price: 'Rs 5,600.00',
        save: 'SAVE RS 600.00',
        thumbnail: '../../assest/men/shirts/(8).jpeg',
        collection: 'Formal Wear',
        about: 'Professional striped shirt'
    },
    {
        title: 'Denim Shirt',
        price: 'Rs 5,300.00',
        save: 'SAVE RS 700.00',
        thumbnail: '../../assest/men/shirts/(9).jpeg',
        collection: 'Casual Wear',
        about: 'Classic denim shirt for casual occasions'
    },
    {
        title: 'White Dress Shirt',
        price: 'Rs 4,800.00',
        save: 'SAVE RS 500.00',
        thumbnail: '../../assest/men/shirts/(10).jpeg',
        collection: 'Essentials',
        about: 'Timeless white dress shirt'
    },
    {
        title: 'Printed Casual Shirt',
        price: 'Rs 5,100.00',
        save: 'SAVE RS 600.00',
        thumbnail: '../../assest/men/shirts/(11).jpeg',
        collection: 'Weekend Wear',
        about: 'Trendy printed design for weekends'
    },
    {
        title: 'Smart Casual Shirt',
        price: 'Rs 5,500.00',
        save: 'SAVE RS 650.00',
        thumbnail: '../../assest/men/shirts/(12).jpeg',
        collection: 'Smart Casual',
        about: 'Versatile shirt for any occasion'
    }
];

function createProductCard(product, index) {
    const card = document.createElement('div');
    card.classList.add('product-card');
    card.innerHTML = `
        <div class="thambnail" onclick="buyProduct(${index})">
            <img class="thambnail-image" src="${product.thumbnail}">
        </div>
        <div class="save"><p>${product.save}</p></div>
        <div class="product-details">
            <div class="title"><p>${product.title}</p></div>
            <div class="price"><p>${product.price}</p></div>
            <div class="button-section">
                <div class="thambnail-switch">
                    <div class="thambnail-switch-1">
                        <img class="thambnail-switch-image" src="${product.thumbnail}">
                    </div>
                </div>
                <div class="buy-btn">
                    <button onclick="buyProduct(${index})">Buy</button>
                </div>
            </div>
        </div>
    `;
    return card;
}

function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

function renderProducts() {
    const productList = document.querySelector('.product-list');
    shuffleArray(products);
    products.forEach((product, index) => {
        const card = createProductCard(product, index);
        productList.appendChild(card);
    });
}

function buyProduct(index) {
    localStorage.removeItem('selectedProduct');
    const product = products[index];
    localStorage.setItem('selectedProduct', JSON.stringify(product));
    window.location.href = '../../product-buy.php';
}
