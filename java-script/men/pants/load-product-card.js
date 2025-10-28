const products = [
    {
        title: 'Classic Dress Pants',
        price: 'Rs 6,500.00',
        save: 'SAVE RS 1,000.00',
        thumbnail: '../../assest/men/pants/(1).jpg',
        collection: 'Formal Wear',
        about: 'Professional dress pants for formal occasions'
    },
    {
        title: 'Slim Fit Chinos',
        price: 'Rs 5,800.00',
        save: 'SAVE RS 800.00',
        thumbnail: '../../assest/men/pants/(2).jpg',
        collection: 'Casual Wear',
        about: 'Modern slim fit chino pants'
    },
    {
        title: 'Cargo Pants',
        price: 'Rs 5,200.00',
        save: 'SAVE RS 700.00',
        thumbnail: '../../assest/men/pants/(3).jpg',
        collection: 'Utility Wear',
        about: 'Functional cargo pants with multiple pockets'
    },
    {
        title: 'Pleated Trousers',
        price: 'Rs 7,200.00',
        save: 'SAVE RS 1,200.00',
        thumbnail: '../../assest/men/pants/(4).jpg',
        collection: 'Executive Wear',
        about: 'Classic pleated trousers'
    },
    {
        title: 'Khaki Pants',
        price: 'Rs 4,900.00',
        save: 'SAVE RS 600.00',
        thumbnail: '../../assest/men/pants/(5).jpg',
        collection: 'Weekend Wear',
        about: 'Versatile khaki casual pants'
    },
    {
        title: 'Corduroy Pants',
        price: 'Rs 6,800.00',
        save: 'SAVE RS 900.00',
        thumbnail: '../../assest/men/pants/(6).jpg',
        collection: 'Autumn Collection',
        about: 'Stylish corduroy pants'
    },
    {
        title: 'Flat Front Pants',
        price: 'Rs 6,300.00',
        save: 'SAVE RS 800.00',
        thumbnail: '../../assest/men/pants/(7).jpg',
        collection: 'Business Casual',
        about: 'Modern flat front design'
    },
    {
        title: 'Linen Pants',
        price: 'Rs 5,500.00',
        save: 'SAVE RS 700.00',
        thumbnail: '../../assest/men/pants/(8).jpg',
        collection: 'Summer Collection',
        about: 'Breathable linen pants'
    },
    {
        title: 'Jogger Pants',
        price: 'Rs 4,500.00',
        save: 'SAVE RS 500.00',
        thumbnail: '../../assest/men/pants/(9).jpg',
        collection: 'Athletic Wear',
        about: 'Comfortable jogger style pants'
    },
    {
        title: 'Check Pattern Pants',
        price: 'Rs 6,000.00',
        save: 'SAVE RS 800.00',
        thumbnail: '../../assest/men/pants/(10).jpg',
        collection: 'Fashion Forward',
        about: 'Trendy check pattern pants'
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
