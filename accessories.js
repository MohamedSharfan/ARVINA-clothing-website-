// Add to Cart Alert
document.querySelectorAll('.accessory-card button').forEach((button) => {
    button.addEventListener('click', () => {
      const productName = button.parentElement.querySelector('h3').textContent;
      alert(`${productName} has been added to your cart!`);
    });
  });
  