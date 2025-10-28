const products = [
    {
        title: "DAEGU COTTON COLLAR T-SHIRT",
        price: "Rs 11,794.92",
        save: "SAVE RS 3,334.95",
        thumbnail: "../assest/women/bottoms/bottom (1).jpg",
        collection: "Casual Wear",
        about: "A stylish cotton t-shirt with a buttoned collar for everyday comfort."
    },
    {
        title: "SEOUL FLORAL SUMMER DRESS",
        price: "Rs 9,499.50",
        save: "SAVE RS 2,000.00",
        thumbnail: "../assest/women/bottoms/bottom (1).jpeg",
        collection: "Summer Collection",
        about: "Lightweight floral dress perfect for sunny days and vacations."
    },
    {
        title: "BUSAN LINEN WRAP DRESS",
        price: "Rs 10,999.00",
        save: "SAVE RS 2,500.00",
        thumbnail: "../assest/women/bottoms/bottom (5).jpg",
        collection: "Linen Essentials",
        about: "A breezy linen wrap dress that blends comfort with elegance."
    },
    {
        title: "JEJU PRINTED MAXI",
        price: "Rs 13,250.00",
        save: "SAVE RS 3,750.00",
        thumbnail: "../assest/women/bottoms/bottom (6).webp",
        collection: "Maxi Dresses",
        about: "Printed maxi dress inspired by the coastal beauty of Jeju Island."
    },
    {
        title: "INCHEON CHECKED MIDI",
        price: "Rs 7,950.00",
        save: "SAVE RS 1,999.00",
        thumbnail: "../assest/women/bottoms/bottom (5).webp",
        collection: "Workwear",
        about: "Midi dress with a checked pattern — classic and professional."
    },
    {
        title: "BUSAN LINEN WRAP DRESS",
        price: "Rs 10,999.00",
        save: "SAVE RS 2,500.00",
        thumbnail: "../assest/women/bottoms/bottom (8).webp",
        collection: "Linen Essentials",
        about: "Elegant wrap design with natural linen texture for breathable comfort."
    },
    {
        title: "BUSAN LINEN WRAP DRESS",
        price: "Rs 10,999.00",
        save: "SAVE RS 2,500.00",
        thumbnail: "../assest/women/bottoms/bottom (5).webp",
        collection: "Linen Essentials",
        about: "Refined version of the wrap dress, featuring premium stitching."
    },
    {
        title: "DAEGU COTTON COLLAR T-SHIRT",
        price: "Rs 11,794.92",
        save: "SAVE RS 3,334.95",
        thumbnail: "../assest/women/bottoms/bottom (7).webp",
        collection: "Casual Wear",
        about: "A stylish cotton t-shirt with a buttoned collar for everyday comfort."
    },
    {
        title: "SEOUL FLORAL SUMMER DRESS",
        price: "Rs 9,499.50",
        save: "SAVE RS 2,000.00",
        thumbnail: "../assest/women/bottoms/bottom (5).jpg",
        collection: "Summer Collection",
        about: "Lightweight floral dress perfect for sunny days and vacations."
    },
    {
        title: "BUSAN LINEN WRAP DRESS",
        price: "Rs 10,999.00",
        save: "SAVE RS 2,500.00",
        thumbnail: "../assest/women/bottoms/bottom (4).webp",
        collection: "Linen Essentials",
        about: "A breezy linen wrap dress that blends comfort with elegance."
    },
    {
        title: "JEJU PRINTED MAXI",
        price: "Rs 13,250.00",
        save: "SAVE RS 3,750.00",
        thumbnail: "../assest/women/bottoms/bottom (1).webp",
        collection: "Maxi Dresses",
        about: "Printed maxi dress inspired by the coastal beauty of Jeju Island."
    },
    {
        title: "INCHEON CHECKED MIDI",
        price: "Rs 7,950.00",
        save: "SAVE RS 1,999.00",
        thumbnail: "../assest/women/bottoms/bottom (1).jpg",
        collection: "Workwear",
        about: "Midi dress with a checked pattern — classic and professional."
    },
    {
        title: "BUSAN LINEN WRAP DRESS",
        price: "Rs 10,999.00",
        save: "SAVE RS 2,500.00",
        thumbnail: "../assest/women/bottoms/bottom (5).webp",
        collection: "Linen Essentials",
        about: "Elegant wrap design with natural linen texture for breathable comfort."
    },
    {
        title: "BUSAN LINEN WRAP DRESS",
        price: "Rs 10,999.00",
        save: "SAVE RS 2,500.00",
        thumbnail: "../assest/women/bottoms/bottom (8).webp",
        collection: "Linen Essentials",
        about: "Refined version of the wrap dress, featuring premium stitching."
    },
];



function createProductCard(product, index) {
    const card = document.createElement('div');
    card.classList.add('product-card');


    card.innerHTML = `
        <div class="thambnail" onclick="buyProduct(${index})">
            <img class="thambnail-image" src="${product.thumbnail}">
        </div>
        <div class="save">
            <p>${product.save}</p>
        </div>
        <div class="product-details">
            <div class="title">
                <p>${product.title}</p>
            </div>
            <div class="price">
                <p>${product.price}</p>
            </div>
            <div class="button-section">
                <div class="thambnail-switch">
                    <div class="thambnail-switch-1">
                        <img class="thambnail-switch-image" src="${product.thumbnail}">
                    </div>
                    <div class="thambnail-switch-1">
                        <img class="thambnail-switch-image" src="${product.thumbnail}">
                    </div>
                </div>
                <div class="buy-btn">
                    <button onclick="buyProduct(${index})">
                        Buy
                    </button>
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
    window.location.href = '../product-buy.html';
}
