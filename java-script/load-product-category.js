
const products = [
    {
        title: "WOMEN",
        thumbnails: [
            "./assest/category/women.webp",
            "./assest/category/women1.jpg",
            "./assest/category/women3.webp",
            "./assest/category/women4.webp",
            "./assest/category/women2.avif",
            "./assest/category/women5.webp"
        ],
        link:"./women/women.html",
    },
    {
        title: "MEN",
        thumbnails: [
            "./assest/category/men.jpg",
            "./assest/category/men1.jpg",
            "./assest/category/men2.jpg"
        ],
        link:"./men/men.html",
    },
    {
        title: "WATCHES",
        thumbnails: [
            "./assest/category/watch.jpg",
            "./assest/category/watch1.jpg",
            "./assest/category/watch2.jpg",
            "./assest/category/watch3.jpg",
            "./assest/category/watch4.jpg"
        ],
        link:"./watches/watches.html",
    },
    {
        title: "SHOES",
        thumbnails: [
            "./assest/category/shoes.jpg",
            "./assest/category/shoes1.jpg",
            "./assest/category/shoes2.jpg"
        ],
        link:"./shoes/shoes.html",
    },
    {
        title: "BESTSELLERS",
        thumbnails: [
            "./assest/category/bestseller.jpg",
            "./assest/category/bestseller1.jpg",
            "./assest/category/bestseller2.jpg"
        ],
        link:"./bestsellers/bestsellers.html",
    },
    {
        title: "ABOUT US",
        thumbnails: [
            "./assest/category/about.jpg",
            "./assest/category/about1.jpg",
            "./assest/category/about2.jpg",
            "./assest/category/about3.jpg"
        ],
        link:"./about/about.html",
    },
    
];


function createProductCard(product) {
    const card = document.createElement('div');
    card.classList.add('category');

    const imageId = `img-${Math.random().toString(36).substr(2, 9)}`;

    card.innerHTML = `
        <div class="category-thambnail" onclick="window.location.href='${product.link}';">
            <img id="${imageId}" class="category-thambnail-image" src="${product.thumbnails[0]}">
            <div class="category-title">
                <p>${product.title}</p>
            </div>
        </div>
    `;

    let index = 0;
    const randomStartDelay = Math.random() * 3000 + 1000;

    setTimeout(() => {
        setInterval(() => {
            index = (index + 1) % product.thumbnails.length;
            const imgElement = document.getElementById(imageId);
            if (imgElement) {
                imgElement.classList.add('zoom-effect');
                setTimeout(() => {
                    imgElement.src = product.thumbnails[index];
                }, 200);
                setTimeout(() => {
                    imgElement.classList.remove('zoom-effect');
                }, 2000);  
            }
        }, 5000);
    }, randomStartDelay);
    

    return card;
}


function renderProducts() {
    const productList = document.querySelector('.product-category');

    products.forEach((product) => {
        const card = createProductCard(product);
        productList.appendChild(card);
    });
    
}


