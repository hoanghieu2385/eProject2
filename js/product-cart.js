document.addEventListener('DOMContentLoaded', function() {
    var addToCartBtn = document.querySelector('.add-to-cart-btn');
    var cart = document.querySelector('.cart');
    var closeCartBtn = document.querySelector('.cart .close');

    if(addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            if(cart) {
                cart.classList.add('open');
            }
        });
    }

    if(closeCartBtn) {
        closeCartBtn.addEventListener('click', function() {
            if(cart) {
                cart.classList.remove('open');
            }
        });
    }
});