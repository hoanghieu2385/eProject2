window.addEventListener('DOMContentLoaded', function() {
    const minusBtn = document.querySelector('.minus-btn');
    const plusBtn = document.querySelector('.plus-btn');
    const quantitySpan = document.querySelector('.quantity');
  
    let quantity = 1;
  
    minusBtn.addEventListener('click', () => {
      if (quantity > 1) {
        quantity--;
        quantitySpan.textContent = quantity;
      }
    });
  
    plusBtn.addEventListener('click', () => {
      quantity++;
      quantitySpan.textContent = quantity;
    });
  });