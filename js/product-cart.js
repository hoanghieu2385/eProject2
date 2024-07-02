document.addEventListener('DOMContentLoaded', function() {
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    const cartIcon = document.getElementById('cart-icon');
    const cart = document.querySelector('.cart');
    const closeCartBtn = document.querySelector('.cart .close');
    const cartItems = document.querySelector('.cart-items');
    const subtotalElem = document.querySelector('.subtotal');
    const minusBtn = document.querySelector('.minus-btn');
    const plusBtn = document.querySelector('.plus-btn');
    const quantitySpan = document.querySelector('.quantity');

    let quantity = 1;
    let isAddingToCart = false;
    function updateQuantity(newQuantity) {
        quantity = Math.max(1, newQuantity);
        quantitySpan.textContent = quantity;
    }

    if (minusBtn) {
        minusBtn.addEventListener('click', () => updateQuantity(quantity - 1));
    }

    if (plusBtn) {
        plusBtn.addEventListener('click', () => updateQuantity(quantity + 1));
    }

    function openCart() {
        if (cart) {
            cart.classList.add('open');
            console.log('Cart opened');
        }
    }

    function closeCart() {
        if (cart) {
            cart.classList.remove('open');
            console.log('Cart closed');
        }
    }

    function addToCart(e) {
        e.preventDefault();
        e.stopPropagation();
    
        if (isAddingToCart) {
            console.log("Already adding to cart, ignoring this click");
            return;
        }
    
        isAddingToCart = true;
        console.log("Adding to cart");
    
        const productTitle = document.querySelector('.title').textContent;
        const productPrice = document.querySelector('.price').textContent;
        const productImage = document.querySelector('.image-container img').src;
        console.log('Product:', productTitle, productPrice, productImage, quantity);
    
        const existingItem = Array.from(cartItems.children).find(item => 
            item.querySelector('h3') && 
            item.querySelector('h3').textContent === productTitle && 
            !item.style.display.includes('none')
        );
    
        if (existingItem) {
            const quantityInput = existingItem.querySelector('.quantity input');
            const currentQuantity = parseInt(quantityInput.value);
            quantityInput.value = currentQuantity;
            console.log('Updated quantity:', quantityInput.value);
        } else {
            const template = cartItems.querySelector('.item[style*="display: none"]');
            if (!template) {
                console.error('Template item not found');
                isAddingToCart = false;
                return;
            }
            const newItem = template.cloneNode(true);
            newItem.style.display = 'flex';
    
            newItem.querySelector('img').src = productImage;
            newItem.querySelector('h3').textContent = productTitle;
            newItem.querySelector('.price').textContent = productPrice;
            newItem.querySelector('.quantity input').value = 1;
    
            cartItems.appendChild(newItem);
            console.log('New item added:', newItem);
        }
    
        updateSubtotal();
        openCart();
        updateQuantity(1);
        
        setTimeout(() => {
            isAddingToCart = false;
        }, 500);
    }

    function updateSubtotal() {
        const items = cartItems.querySelectorAll('.item:not([style*="display: none"])');
        const total = Array.from(items).reduce((sum, item) => {
            const price = parseFloat(item.querySelector('.price').textContent.replace('$', ''));
            const quantity = parseInt(item.querySelector('.quantity input').value);
            return sum + price * quantity;
        }, 0);
        subtotalElem.textContent = '$' + total.toFixed(2);
        console.log('Subtotal updated:', subtotalElem.textContent);

        if (items.length === 0) {
            closeCart();
        }
    }

    if (addToCartBtn) {
        console.log('Adding event listener to Add To Cart button');
        addToCartBtn.addEventListener('click', addToCart);
    }

    if (cartIcon) {
        cartIcon.addEventListener('click', openCart);
    }

    if (closeCartBtn) {
        closeCartBtn.addEventListener('click', closeCart);
    }

    cartItems.addEventListener('click', function(e) {
        e.stopPropagation();

        const item = e.target.closest('.item');
        if (!item) return;

        if (e.target.classList.contains('increase') || e.target.classList.contains('decrease')) {
            const input = item.querySelector('.quantity input');
            const newValue = e.target.classList.contains('increase') ? parseInt(input.value) + 1 : Math.max(1, parseInt(input.value) - 1);
            input.value = newValue;
            console.log(`${e.target.classList.contains('increase') ? 'Increased' : 'Decreased'} quantity:`, newValue);
            updateSubtotal();
        } else if (e.target.classList.contains('remove')) {
            item.remove();
            console.log('Item removed');
            updateSubtotal();
        }
    });

    document.addEventListener('click', function(e) {
        if (cart && cart.classList.contains('open') && 
            !cart.contains(e.target) && 
            e.target !== cartIcon && 
            e.target !== addToCartBtn &&
            !e.target.closest('.cart-items')) {
            closeCart();
        }
    });

    cart.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevent clicks inside cart from closing it
    });

    if (addToCartBtn && window.getEventListeners) {
        const listeners = getEventListeners(addToCartBtn);
        console.log('Event listeners on Add To Cart button:', listeners);
    }

    console.log('Cart script loaded');
});