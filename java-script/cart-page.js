
function updateQuantity(cartKey, newQuantity) {
    if (newQuantity < 1 || newQuantity > 10) {
        if (newQuantity < 1) {
            if (confirm('Remove this item from cart?')) {
                removeItem(cartKey);
            }
        }
        return;
    }
    
    fetch('./php/update_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            cart_key: cartKey,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error updating cart:', error);
        alert('Error updating cart');
    });
}

function removeItem(cartKey) {
    if (!confirm('Are you sure you want to remove this item?')) {
        return;
    }
    
    fetch('./php/remove_from_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            cart_key: cartKey
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error removing item:', error);
        alert('Error removing item from cart');
    });
}
