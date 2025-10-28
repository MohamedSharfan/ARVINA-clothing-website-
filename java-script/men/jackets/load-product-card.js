const products = [
    {
        title: 'Leather Jacket',
        price: 'Rs 18,500.00',
        save: 'SAVE RS 3,000.00',
        thumbnail: '../../assest/men/jackets/(1).jpg',
        collection: 'Premium Collection',
        about: 'Classic leather jacket for stylish look'
    },
    {
        title: 'Denim Jacket',
        price: 'Rs 8,900.00',
        save: 'SAVE RS 1,500.00',
        thumbnail: '../../assest/men/jackets/(2).jpg',
        collection: 'Casual Wear',
        about: 'Timeless denim jacket'
    },
    {
        title: 'Bomber Jacket',
        price: 'Rs 12,500.00',
        save: 'SAVE RS 2,000.00',
        thumbnail: '../../assest/men/jackets/(3).jpg',
        collection: 'Modern Collection',
        about: 'Trendy bomber style jacket'
    },
    {
        title: 'Puffer Jacket',
        price: 'Rs 15,800.00',
        save: 'SAVE RS 2,500.00',
        thumbnail: '../../assest/men/jackets/(4).jpg',
        collection: 'Winter Collection',
        about: 'Warm puffer jacket for cold weather'
    },
    {
        title: 'Windbreaker',
        price: 'Rs 7,500.00',
        save: 'SAVE RS 1,200.00',
        thumbnail: '../../assest/men/jackets/(5).jpg',
        collection: 'Athletic Wear',
        about: 'Lightweight windbreaker jacket'
    },
    {
        title: 'Blazer Jacket',
        price: 'Rs 14,000.00',
        save: 'SAVE RS 2,200.00',
        thumbnail: '../../assest/men/jackets/(6).jpg',
        collection: 'Business Casual',
        about: 'Smart blazer jacket'
    },
    {
        title: 'Field Jacket',
        price: 'Rs 11,500.00',
        save: 'SAVE RS 1,800.00',
        thumbnail: '../../assest/men/jackets/(7).jpg',
        collection: 'Utility Wear',
        about: 'Functional field jacket with pockets'
    },
    {
        title: 'Varsity Jacket',
        price: 'Rs 10,800.00',
        save: 'SAVE RS 1,700.00',
        thumbnail: '../../assest/men/jackets/(8).jpg',
        collection: 'Sports Collection',
        about: 'Classic varsity style jacket'
    },
    {
        title: 'Parka Jacket',
        price: 'Rs 16,500.00',
        save: 'SAVE RS 2,800.00',
        thumbnail: '../../assest/men/jackets/(9).jpg',
        collection: 'Winter Collection',
        about: 'Heavy-duty parka for extreme cold'
    },
    {
        title: 'Track Jacket',
        price: 'Rs 6,900.00',
        save: 'SAVE RS 1,000.00',
        thumbnail: '../../assest/men/jackets/(10).jpg',
        collection: 'Athletic Wear',
        about: 'Sporty track jacket'
    },
    {
        title: 'Suede Jacket',
        price: 'Rs 17,200.00',
        save: 'SAVE RS 2,900.00',
        thumbnail: '../../assest/men/jackets/(11).jpg',
        collection: 'Luxury Collection',
        about: 'Premium suede jacket'
    },
    {
        title: 'Harrington Jacket',
        price: 'Rs 9,500.00',
        save: 'SAVE RS 1,500.00',
        thumbnail: '../../assest/men/jackets/(12).jpg',
        collection: 'Classic Collection',
        about: 'Iconic Harrington style jacket'
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
