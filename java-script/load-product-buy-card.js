function getBuyProduct() {
    
    const productData = localStorage.getItem('selectedProduct');

    if (productData) {
        const product = JSON.parse(productData);
        console.log(product.title);
        let thumbnail = product.thumbnail;

        // Handle different path formats
        // From women/dresses.html: "../assest/..." or "../images/..."
        // From product-buy.php (root): needs to be "assest/..." or "images/..."
        
        // Count how many ../ are at the start
        let parentDirs = 0;
        let tempPath = thumbnail;
        while (tempPath.startsWith('../')) {
            parentDirs++;
            tempPath = tempPath.substring(3);
        }
        
        // If path starts with ../, remove all leading ../
        if (parentDirs > 0) {
            thumbnail = tempPath;
        }
        
        // If path starts with ./, remove it
        if (thumbnail.startsWith('./')) {
            thumbnail = thumbnail.substring(2);
        }
        
        document.getElementById("product").src = thumbnail;
        
        
        document.getElementById("title").textContent = product.title;
        document.getElementById("collection").textContent = product.collection; 
        document.getElementById("price").textContent = product.price;
        document.getElementById("about").textContent = product.about;


    } else {
        console.warn("No product data found in localStorage.");
    }
}





