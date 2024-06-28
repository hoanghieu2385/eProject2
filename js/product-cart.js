document.addEventListener('DOMContentLoaded', function() {
    var addToCartBtn = document.querySelector('.add-to-cart-btn');
    var cartIcon = document.getElementById('cart-icon');
    var cart = document.querySelector('.cart');
    var closeCartBtn = document.querySelector('.cart .close');
    var cartItems = document.querySelector('.cart-items');
    var subtotalElem = document.querySelector('.subtotal');

    console.log('AddToCartBtn:', addToCartBtn);
    console.log('CartIcon:', cartIcon);
    console.log('Cart:', cart);
    console.log('CloseCartBtn:', closeCartBtn);
    console.log('CartItems:', cartItems);
    console.log('SubtotalElem:', subtotalElem);

    function openCart() {
        if(cart) {
            cart.classList.add('open');
            console.log('Cart opened');
        }
    }

    function closeCart() {
        if(cart) {
            cart.classList.remove('open');
            console.log('Cart closed');
        }
    }

    function addToCart(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("Adding to cart");

        var productTitle = document.querySelector('.title').textContent;
        var productPrice = document.querySelector('.price').textContent;
        var productImage = document.querySelector('.image-container img').src;
        var quantity = 1;

        console.log('Product:', productTitle, productPrice, productImage, quantity);

        var existingItem = Array.from(cartItems.children).find(item => 
            item.querySelector('h3') && 
            item.querySelector('h3').textContent === productTitle && 
            !item.style.display.includes('none')
        );

        console.log('Existing item:', existingItem);

        if (existingItem) {
            var quantityInput = existingItem.querySelector('.quantity input');
            quantityInput.value = parseInt(quantityInput.value) + quantity;
            console.log('Updated quantity:', quantityInput.value);
        } else {
            var template = cartItems.querySelector('.item[style*="display: none"]');
            if (!template) {
                console.error('Template item not found');
                return;
            }
            var newItem = template.cloneNode(true);
            newItem.style.display = 'flex';

            newItem.querySelector('img').src = productImage;
            newItem.querySelector('h3').textContent = productTitle;
            newItem.querySelector('.price').textContent = productPrice;
            newItem.querySelector('.quantity input').value = quantity;

            cartItems.appendChild(newItem);
            console.log('New item added:', newItem);
        }

        updateSubtotal();
        openCart();
    }

    function updateSubtotal() {
        var items = cartItems.querySelectorAll('.item:not([style*="display: none"])');
        var total = 0;
        items.forEach(function(item) {
            var price = parseFloat(item.querySelector('.price').textContent.replace('$', ''));
            var quantity = parseInt(item.querySelector('.quantity input').value);
            total += price * quantity;
        });
        subtotalElem.textContent = '$' + total.toFixed(2);
        console.log('Subtotal updated:', subtotalElem.textContent);
    }

    if(addToCartBtn) {
        console.log('Adding event listener to Add To Cart button');
        addToCartBtn.removeEventListener('click', addToCart);
        addToCartBtn.addEventListener('click', addToCart);
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

    cartItems.addEventListener('click', function(e) {
        e.stopPropagation();
        var item = e.target.closest('.item');
        if (!item) return;

        if (e.target.classList.contains('increase')) {
            var input = item.querySelector('.quantity input');
            input.value = parseInt(input.value) + 1;
            console.log('Increased quantity:', input.value);
        } else if (e.target.classList.contains('decrease')) {
            var input = item.querySelector('.quantity input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                console.log('Decreased quantity:', input.value);
            }
        } else if (e.target.classList.contains('remove')) {
            item.remove();
            console.log('Item removed');
        }
        updateSubtotal();
    });

    document.addEventListener('click', function(e) {
        if (cart && cart.classList.contains('open') && !cart.contains(e.target) && e.target !== cartIcon && e.target !== addToCartBtn) {
            closeCart();
        }
    });

    console.log('Cart script loaded');
});