
let selectedColor = '';
let selectedSize = '';
let cartCount = 0;

document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
    initializeColorSelector();
    initializeSizeSelector();
    initializeQuantityControls();
});

function updateCartCount() {
    fetch('./php/get_cart.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cartCount = data.count;
                const cartCountElement = document.getElementById('cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = cartCount;
                    if (cartCount > 0) {
                        cartCountElement.style.display = 'inline-block';
                    } else {
                        cartCountElement.style.display = 'none';
                    }
                }
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
}

function initializeColorSelector() {
    const colorOptions = document.querySelectorAll('.color-option');
    colorOptions.forEach(option => {
        option.addEventListener('click', function() {
            colorOptions.forEach(opt => opt.classList.remove('color-selected'));
            this.classList.add('color-selected');
            selectedColor = this.getAttribute('data-color');
            
            const errorElement = document.getElementById('color-error');
            if (errorElement) {
                errorElement.remove();
            }
        });
    });
}

function initializeSizeSelector() {
    const sizeButtons = document.querySelectorAll('.size-options button');
    sizeButtons.forEach(button => {
        button.addEventListener('click', function() {
            sizeButtons.forEach(btn => btn.classList.remove('size-selected'));
            this.classList.add('size-selected');
            selectedSize = this.textContent.trim();
            
            const errorElement = document.getElementById('size-error');
            if (errorElement) {
                errorElement.remove();
            }
        });
    });
}

function initializeQuantityControls() {
    const quantityInput = document.querySelector('.quantity-control input[type="number"]');
    const decreaseBtn = document.querySelector('.quantity-control button:first-child');
    const increaseBtn = document.querySelector('.quantity-control button:last-child');
    
    if (quantityInput && decreaseBtn && increaseBtn) {
        decreaseBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value) || 1;
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
        
        increaseBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value) || 1;
            if (currentValue < 10) {
                quantityInput.value = currentValue + 1;
            }
        });
        
        quantityInput.addEventListener('input', function() {
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) {
                this.value = 1;
            } else if (value > 10) {
                this.value = 10;
            }
        });
    }
}

function addToCart() {
    const productData = JSON.parse(localStorage.getItem('selectedProduct'));
    
    if (!productData) {
        showNotification('Error: Product data not found', 'error');
        return;
    }
    
    if (!selectedColor) {
        showValidationError('color-error', 'Please select a color');
        return;
    }
    
    if (!selectedSize) {
        showValidationError('size-error', 'Please select a size');
        return;
    }
    
    const quantityInput = document.querySelector('.quantity-control input[type="number"]');
    const quantity = parseInt(quantityInput ? quantityInput.value : 1);
    
    if (quantity < 1 || quantity > 10) {
        showNotification('Quantity must be between 1 and 10', 'error');
        return;
    }
    
    const priceString = productData.price.replace(/Rs\s?/g, '').replace(/,/g, '');
    const price = parseFloat(priceString);
    
    const productId = Math.floor(Math.random() * 10000);
    
    const cartData = {
        product_id: productId,
        product_name: productData.title,
        price: price,
        color: selectedColor,
        size: selectedSize,
        quantity: quantity,
        image_url: productData.thumbnail
    };
    
    fetch('./php/add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(cartData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Product added to cart successfully!', 'success');
            updateCartCount();
        } else {
            showNotification('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error adding to cart:', error);
        showNotification('Error adding product to cart', 'error');
    });
}

function showValidationError(errorId, message) {
    const existingError = document.getElementById(errorId);
    if (existingError) {
        existingError.remove();
    }
    
    const errorElement = document.createElement('p');
    errorElement.id = errorId;
    errorElement.className = 'validation-error';
    errorElement.textContent = message;
    errorElement.style.color = 'red';
    errorElement.style.fontSize = '14px';
    errorElement.style.marginTop = '5px';
    
    if (errorId === 'color-error') {
        const colorSection = document.querySelector('.color-options');
        if (colorSection) {
            colorSection.parentNode.insertBefore(errorElement, colorSection.nextSibling);
        }
    } else if (errorId === 'size-error') {
        const sizeSection = document.querySelector('.size-options');
        if (sizeSection) {
            sizeSection.parentNode.insertBefore(errorElement, sizeSection.nextSibling);
        }
    }
}

function showNotification(message, type = 'info') {
    const existingNotification = document.querySelector('.cart-notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = 'cart-notification ' + type;
    notification.textContent = message;
    
    notification.style.position = 'fixed';
    notification.style.top = '100px';
    notification.style.right = '20px';
    notification.style.padding = '15px 25px';
    notification.style.borderRadius = '5px';
    notification.style.zIndex = '10000';
    notification.style.fontWeight = 'bold';
    notification.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
    notification.style.animation = 'slideIn 0.3s ease-out';
    
    if (type === 'success') {
        notification.style.backgroundColor = '#4CAF50';
        notification.style.color = 'white';
    } else if (type === 'error') {
        notification.style.backgroundColor = '#f44336';
        notification.style.color = 'white';
    } else {
        notification.style.backgroundColor = '#2196F3';
        notification.style.color = 'white';
    }
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
