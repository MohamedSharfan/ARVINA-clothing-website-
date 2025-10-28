const products = [
    {
        title: 'Leather Belt',
        price: 'Rs 3,500.00',
        save: 'SAVE RS 500.00',
        thumbnail: '../../assest/men/accessories/(1).jpg',
        collection: 'Essentials',
        about: 'Classic leather belt for formal and casual wear'
    },
    {
        title: 'Silk Tie',
        price: 'Rs 2,800.00',
        save: 'SAVE RS 400.00',
        thumbnail: '../../assest/men/accessories/(2).jpg',
        collection: 'Formal Wear',
        about: 'Premium silk tie'
    },
    {
        title: 'Leather Wallet',
        price: 'Rs 4,200.00',
        save: 'SAVE RS 600.00',
        thumbnail: '../../assest/men/accessories/(3).jpg',
        collection: 'Everyday Carry',
        about: 'Genuine leather bifold wallet'
    },
    {
        title: 'Bow Tie',
        price: 'Rs 2,200.00',
        save: 'SAVE RS 300.00',
        thumbnail: '../../assest/men/accessories/(4).jpg',
        collection: 'Formal Events',
        about: 'Elegant bow tie for special occasions'
    },
    {
        title: 'Cufflinks Set',
        price: 'Rs 3,800.00',
        save: 'SAVE RS 500.00',
        thumbnail: '../../assest/men/accessories/(5).jpg',
        collection: 'Premium Collection',
        about: 'Stylish cufflinks set'
    },
    {
        title: 'Pocket Square',
        price: 'Rs 1,500.00',
        save: 'SAVE RS 200.00',
        thumbnail: '../../assest/men/accessories/(6).jpg',
        collection: 'Style Essentials',
        about: 'Designer pocket square'
    },
    {
        title: 'Suspenders',
        price: 'Rs 2,500.00',
        save: 'SAVE RS 350.00',
        thumbnail: '../../assest/men/accessories/(7).jpg',
        collection: 'Classic Collection',
        about: 'Adjustable suspenders'
    },
    {
        title: 'Leather Gloves',
        price: 'Rs 4,500.00',
        save: 'SAVE RS 700.00',
        thumbnail: '../../assest/men/accessories/(8).jpg',
        collection: 'Winter Collection',
        about: 'Premium leather gloves'
    },
    {
        title: 'Wool Scarf',
        price: 'Rs 3,200.00',
        save: 'SAVE RS 450.00',
        thumbnail: '../../assest/men/accessories/(9).jpg',
        collection: 'Winter Wear',
        about: 'Warm wool scarf'
    },
    {
        title: 'Fedora Hat',
        price: 'Rs 5,500.00',
        save: 'SAVE RS 800.00',
        thumbnail: '../../assest/men/accessories/(10).jpg',
        collection: 'Fashion Forward',
        about: 'Classic fedora hat'
    },
    {
        title: 'Sunglasses',
        price: 'Rs 6,800.00',
        save: 'SAVE RS 1,000.00',
        thumbnail: '../../assest/men/accessories/(11).jpg',
        collection: 'Eyewear',
        about: 'Designer sunglasses'
    },
    {
        title: 'Watch',
        price: 'Rs 15,000.00',
        save: 'SAVE RS 2,500.00',
        thumbnail: '../../assest/men/accessories/(12).jpg',
        collection: 'Luxury Collection',
        about: 'Premium wristwatch'
    },
    {
        title: 'Messenger Bag',
        price: 'Rs 8,500.00',
        save: 'SAVE RS 1,200.00',
        thumbnail: '../../assest/men/accessories/(13).jpg',
        collection: 'Business Collection',
        about: 'Leather messenger bag'
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
