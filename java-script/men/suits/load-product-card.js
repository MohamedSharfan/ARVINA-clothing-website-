const products = [
    {
        title: 'Classic Black Suit',
        price: 'Rs 35,000.00',
        save: 'SAVE RS 5,000.00',
        thumbnail: '../../assest/men/suits/(1).jpg',
        collection: 'Formal Wear',
        about: 'Elegant black suit for formal occasions'
    },
    {
        title: 'Navy Blue Suit',
        price: 'Rs 38,000.00',
        save: 'SAVE RS 7,000.00',
        thumbnail: '../../assest/men/suits/(2).jpg',
        collection: 'Business Collection',
        about: 'Professional navy blue business suit'
    },
    {
        title: 'Charcoal Grey Suit',
        price: 'Rs 36,500.00',
        save: 'SAVE RS 6,500.00',
        thumbnail: '../../assest/men/suits/(3).jpg',
        collection: 'Executive Wear',
        about: 'Sophisticated charcoal grey suit'
    },
    {
        title: 'Three-Piece Suit',
        price: 'Rs 42,000.00',
        save: 'SAVE RS 8,000.00',
        thumbnail: '../../assest/men/suits/(4).jpg',
        collection: 'Premium Collection',
        about: 'Complete three-piece suit with vest'
    },
    {
        title: 'Slim Fit Suit',
        price: 'Rs 34,000.00',
        save: 'SAVE RS 6,000.00',
        thumbnail: '../../assest/men/suits/(5).jpg',
        collection: 'Modern Fit',
        about: 'Contemporary slim fit design'
    },
    {
        title: 'Double-Breasted Suit',
        price: 'Rs 40,000.00',
        save: 'SAVE RS 7,500.00',
        thumbnail: '../../assest/men/suits/(6).jpg',
        collection: 'Classic Collection',
        about: 'Timeless double-breasted style'
    },
    {
        title: 'Pinstripe Suit',
        price: 'Rs 37,500.00',
        save: 'SAVE RS 6,500.00',
        thumbnail: '../../assest/men/suits/(7).jpg',
        collection: 'Business Wear',
        about: 'Classic pinstripe pattern'
    },
    {
        title: 'Linen Suit',
        price: 'Rs 32,000.00',
        save: 'SAVE RS 5,000.00',
        thumbnail: '../../assest/men/suits/(8).jpg',
        collection: 'Summer Collection',
        about: 'Breathable linen suit for warm weather'
    },
    {
        title: 'Tuxedo',
        price: 'Rs 45,000.00',
        save: 'SAVE RS 10,000.00',
        thumbnail: '../../assest/men/suits/(9).jpg',
        collection: 'Formal Events',
        about: 'Premium tuxedo for special occasions'
    },
    {
        title: 'Brown Tweed Suit',
        price: 'Rs 39,000.00',
        save: 'SAVE RS 7,000.00',
        thumbnail: '../../assest/men/suits/(10).jpg',
        collection: 'Heritage Collection',
        about: 'Traditional tweed suit'
    },
    {
        title: 'Light Grey Suit',
        price: 'Rs 33,500.00',
        save: 'SAVE RS 5,500.00',
        thumbnail: '../../assest/men/suits/(11).jpg',
        collection: 'Spring Collection',
        about: 'Fresh light grey suit'
    },
    {
        title: 'Check Pattern Suit',
        price: 'Rs 36,000.00',
        save: 'SAVE RS 6,000.00',
        thumbnail: '../../assest/men/suits/(12).jpg',
        collection: 'Fashion Forward',
        about: 'Modern check pattern suit'
    },
    {
        title: 'Velvet Blazer Suit',
        price: 'Rs 41,000.00',
        save: 'SAVE RS 8,000.00',
        thumbnail: '../../assest/men/suits/(13).jpg',
        collection: 'Luxury Collection',
        about: 'Premium velvet blazer suit'
    },
    {
        title: 'Beige Suit',
        price: 'Rs 31,000.00',
        save: 'SAVE RS 5,000.00',
        thumbnail: '../../assest/men/suits/(14).jpg',
        collection: 'Casual Formal',
        about: 'Versatile beige suit'
    },
    {
        title: 'Burgundy Suit',
        price: 'Rs 38,500.00',
        save: 'SAVE RS 7,500.00',
        thumbnail: '../../assest/men/suits/(15).jpg',
        collection: 'Bold Collection',
        about: 'Bold burgundy statement suit'
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
