(function() {
    if (document.querySelector('script[data-cart-initialized]')) {
        console.log("Cart script already initialized. Skipping...");
        return;
    }

    document.currentScript.dataset.cartInitialized = 'true';

    console.log("Cart script loaded. Version: " + new Date().getTime());

    function initializeCart() {
        console.log("Initializing cart...");

        const addToCartBtn = document.querySelector('.add-to-cart-btn');
        const cartIcon = document.getElementById('cart-icon');
        const cart = document.querySelector('.cart');
        const closeCartBtn = document.querySelector('.cart .close');
        const cartItems = document.querySelector('.cart-items');
        const subtotalElem = document.querySelector('.subtotal');

        console.log("Number of 'Add To Cart' buttons:", document.querySelectorAll('.add-to-cart-btn').length);

        function addToCart(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log("addToCart function called at: " + new Date().getTime());

            const productTitle = document.querySelector('.title').textContent;
            const productPrice = document.querySelector('.price').textContent;
            const productImage = document.querySelector('.image-container img').src;
            const quantity = 1;

            console.log('Product details:', { productTitle, productPrice, productImage, quantity });

            const existingItem = Array.from(cartItems.children).find(item => 
                item.querySelector('h3') && 
                item.querySelector('h3').textContent === productTitle && 
                !item.style.display.includes('none')
            );

            console.log('Existing item found:', existingItem ? 'Yes' : 'No');

            if (existingItem) {
                const quantityInput = existingItem.querySelector('.quantity input');
                quantityInput.value = parseInt(quantityInput.value) + quantity;
                console.log('Updated quantity for existing item:', quantityInput.value);
            } else {
                const template = cartItems.querySelector('.item[style*="display: none"]');
                if (!template) {
                    console.error('Template item not found');
                    return;
                }
                const newItem = template.cloneNode(true);
                newItem.style.display = 'flex';

                newItem.querySelector('img').src = productImage;
                newItem.querySelector('h3').textContent = productTitle;
                newItem.querySelector('.price').textContent = productPrice;
                newItem.querySelector('.quantity input').value = quantity;

                cartItems.appendChild(newItem);
                console.log('New item added to cart');
            }

            updateSubtotal();
            openCart();

            console.log("Current cart items:");
            Array.from(cartItems.children).forEach(item => {
                if (item.style.display !== 'none') {
                    console.log(item.querySelector('h3').textContent + ": " + item.querySelector('.quantity input').value);
                }
            });
        }

        function updateSubtotal() {
            console.log("Updating subtotal...");
            const items = cartItems.querySelectorAll('.item:not([style*="display: none"])');
            let total = 0;
            items.forEach(function(item) {
                const price = parseFloat(item.querySelector('.price').textContent.replace('$', ''));
                const quantity = parseInt(item.querySelector('.quantity input').value);
                total += price * quantity;
            });
            subtotalElem.textContent = '$' + total.toFixed(2);
            console.log('New subtotal:', subtotalElem.textContent);
        }

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

        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function(e) {
                console.log("Add To Cart button clicked at: " + new Date().getTime());
                addToCart(e);
            });
            console.log("Add To Cart event listener added");
        } else {
            console.error("Add To Cart button not found");
        }

        if (cartIcon) {
            cartIcon.addEventListener('click', function(e) {
                e.preventDefault();
                console.log("Cart icon clicked");
                openCart();
            });
        }

        if (closeCartBtn) {
            closeCartBtn.addEventListener('click', function() {
                console.log("Close cart button clicked");
                closeCart();
            });
        }

        cartItems.addEventListener('click', function(e) {
            e.stopPropagation();
            const item = e.target.closest('.item');
            if (!item) return;

            if (e.target.classList.contains('increase')) {
                const input = item.querySelector('.quantity input');
                input.value = parseInt(input.value) + 1;
                console.log('Increased quantity:', input.value);
            } else if (e.target.classList.contains('decrease')) {
                const input = item.querySelector('.quantity input');
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                    console.log('Decreased quantity:', input.value);
                }
            } else if (e.target.classList.contains('remove')) {
                item.remove();
                console.log('Item removed from cart');
            }
            updateSubtotal();
        });

        document.addEventListener('click', function(e) {
            if (cart && cart.classList.contains('open') && !cart.contains(e.target) && e.target !== cartIcon && e.target !== addToCartBtn) {
                console.log('Closing cart due to outside click');
                closeCart();
            }
        });

        console.log("Cart initialization complete");
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOMContentLoaded event fired");
        initializeCart();
    });
})();