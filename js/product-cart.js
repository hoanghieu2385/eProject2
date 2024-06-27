
document.addEventListener('DOMContentLoaded', function() {
    var addToCartBtn = document.querySelector('.add-to-cart-btn');
    var cartIcon = document.getElementById('cart-icon');
    var cart = document.querySelector('.cart');
    var closeCartBtn = document.querySelector('.cart .close');

    function openCart() {
        if(cart) {
            cart.classList.add('open');
        }
    }

    function closeCart() {
        if(cart) {
            cart.classList.remove('open');
        }
    }

    if(addToCartBtn) {
        addToCartBtn.addEventListener('click', openCart);
    }

    if(cartIcon) {
        cartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            openCart();
        });
    }

    if(closeCartBtn) {
        closeCartBtn.addEventListener('click', closeCart);
    }

    // Đóng giỏ hàng khi click bên ngoài
    document.addEventListener('click', function(e) {
        if (cart && cart.classList.contains('open') && !cart.contains(e.target) && e.target !== cartIcon && e.target !== addToCartBtn) {
            closeCart();
        }
    });

    console.log('AddToCartBtn:', addToCartBtn);
    console.log('CartIcon:', cartIcon);
    console.log('Cart:', cart);
    console.log('CloseCartBtn:', closeCartBtn);
});