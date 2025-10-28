
const products = [
    {
        title: "WOMEN DRESSES",
        thumbnail: "../assest/women/category/dress5.webp",
        link:"./dresses.html",
    },
    {
        title: "WOMEN BOTTOMS",
        thumbnail: "../assest/women/category/bottom.jpg",
        link:"./bottoms.html",
    },
    {
        title: "WOMEN OUTWARE",
        thumbnail: "../assest/women/category/(9).jpg",
        link:"./outerwear.html",
    },
    {
        title: "WOMEN TOPS",
        thumbnail: "../assest/women/category/(8).jpg",
        link:"./tops.html",
    },
    {
        title: "WOMEN ACCESSORIES",
        thumbnail: "../assest/women/category/accessories7.jpg",
        link:"./accessories.html",
    },
    
];



function createProductCard(product, index) {
    const card = document.createElement('div');
    card.classList.add('category');


    card.innerHTML = `
       <div class="category-thambnail" onclick="window.location.href ='${product.link}';" >
            <img class="category-thambnail-image" src="${product.thumbnail}">
            <div class="category-title">
                <p>${product.title}</p>
            </div>
        </div>
        
    `;

    return card;
}

function renderProducts() {
    const productList = document.querySelector('.product-category');

    products.forEach((product, index) => {
        const card = createProductCard(product, index);
        productList.appendChild(card);
    });
    
}


