// product-cart.js
(function () {
    if (document.querySelector('script[data-cart-initialized]')) {
        console.log("Cart script already initialized. Skipping...");
        return;
    }
    document.currentScript.dataset.cartInitialized = 'true';

    console.log("Cart script loaded. Version: " + new Date().getTime());

    function initializeCart() {
        console.log("Initializing cart...");

        const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
        const cartIcon = document.getElementById('cart-icon');
        const cart = document.querySelector('.cart');
        const closeCartBtn = document.querySelector('.cart .close');
        const cartItems = document.querySelector('.cart-items');
        const subtotalElem = document.querySelector('.subtotal');
        const checkoutBtn = document.querySelector('.view-cart');


        function addToCart(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log("addToCart function called at: " + new Date().getTime());
        
            const productContainer = e.target.closest('.productcontainer') || e.target.closest('.album-item');
            if (!productContainer) {
                console.error('Product container not found');
                return;
            }
        
            const productId = e.target.dataset.productId || productContainer.dataset.productId;
            let productTitle = '';
            let productPrice = '';
        
            // For index page (album-item)
            if (productContainer.classList.contains('album-item')) {
                productTitle = productContainer.querySelector('.album-title')?.textContent.trim() || '';
                productPrice = productContainer.querySelector('.album-price')?.textContent.trim() || '';
            }
            // For product detail page
            else {
                productTitle = productContainer.querySelector('.title')?.textContent.trim() || '';
                productPrice = productContainer.querySelector('.price')?.textContent.trim() || '';
            }
        
            // Extract numeric value from price
            const priceMatch = productPrice.match(/\$?(\d+(\.\d{1,2})?)/);
            if (priceMatch) {
                productPrice = '$' + priceMatch[1];
            } else {
                console.error('Invalid price format:', productPrice);
                return;
            }
        
            const productImage = productContainer.querySelector('img')?.src || '';
            const quantity = productContainer.querySelector('.quantity-box .quantity') ?
                parseInt(productContainer.querySelector('.quantity-box .quantity').textContent) : 1;
        
            console.log('Product details:', { productId, productTitle, productPrice, productImage, quantity });
        
            if (!productTitle || !productPrice) {
                console.error('Missing product information');
                return;
            }
        
            updateCart(productId, productTitle, productPrice, productImage, quantity);
            updateSubtotal();
            openCart();
            saveCart();
        }

        function updateCart(productId, productTitle, productPrice, productImage, quantity) {
            const existingItem = Array.from(cartItems.children).find(item =>
                item.querySelector('h3') &&
                item.querySelector('h3').textContent === productTitle &&
                !item.style.display.includes('none')
            );

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
                newItem.dataset.productId = productId;

                cartItems.appendChild(newItem);
                console.log('New item added to cart');
            }
        }

        function saveCart() {
            const items = Array.from(cartItems.querySelectorAll('.item:not([style*="display: none"])'))
                .map(item => ({
                    id: item.dataset.productId,
                    title: item.querySelector('h3').textContent,
                    price: item.querySelector('.price').textContent,
                    quantity: item.querySelector('.quantity input') ? item.querySelector('.quantity input').value : item.querySelector('.quantity').textContent,
                    image: item.querySelector('img').src
                }));
            localStorage.setItem('cart', JSON.stringify(items));
            console.log('Cart saved to localStorage');
        }

        function loadCart() {
            const savedCart = localStorage.getItem('cart');
            if (savedCart) {
                const items = JSON.parse(savedCart);
                items.forEach(item => {
                    const newItem = cartItems.querySelector('.item[style*="display: none"]').cloneNode(true);
                    newItem.style.display = 'flex';
                    newItem.querySelector('img').src = item.image;
                    newItem.querySelector('h3').textContent = item.title;
                    newItem.querySelector('.price').textContent = item.price;
                    newItem.querySelector('.quantity input').value = item.quantity;
                    newItem.dataset.productId = item.id;
                    cartItems.appendChild(newItem);
                });
                updateSubtotal();
                console.log('Cart loaded from localStorage');
            }
        }

        function updateSubtotal() {
            const cartCountElement = document.getElementById('cart-count');
            if (!cartCountElement) {
                console.error("Cart count element not found");
                return;
            }

            const items = cartItems.querySelectorAll('.item:not([style*="display: none"])');
            let totalItems = 0;
            let total = 0;

            items.forEach(function (item) {
                const price = parseFloat(item.querySelector('.price').textContent.replace('$', ''));
                const quantity = parseInt(item.querySelector('.quantity input').value);
                totalItems += quantity;
                total += price * quantity;
            });

            cartCountElement.textContent = totalItems;
            cartCountElement.style.display = totalItems > 0 ? 'flex' : 'none';
            console.log('Cart count updated:', totalItems);

            subtotalElem.textContent = '$' + total.toFixed(2);
            console.log('New subtotal:', subtotalElem.textContent);
        }

        function openCart() {
            if (cart && !cart.classList.contains('open')) {
                cart.classList.add('open');
                console.log('Cart opened');
            }
        }

        function closeCart() {
            if (cart && cart.classList.contains('open')) {
                cart.classList.remove('open');
                console.log('Cart closed');
            }
        }

        addToCartBtns.forEach(btn => {
            btn.addEventListener('click', function (e) {
                console.log("Add To Cart button clicked at: " + new Date().getTime());
                addToCart(e);
            });
        });

        if (cartIcon) {
            cartIcon.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                console.log("Cart icon clicked");
                if (cart.classList.contains('open')) {
                    closeCart();
                } else {
                    openCart();
                }
            });
        } else {
            console.error("Cart icon not found");
        }

        if (closeCartBtn) {
            closeCartBtn.addEventListener('click', function () {
                console.log("Close cart button clicked");
                closeCart();
            });
        } else {
            console.error("Close cart button not found");
        }

        cartItems.addEventListener('click', function (e) {
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
            saveCart();
        });

        document.addEventListener('click', function (e) {
            if (!e.target.classList.contains('quantity-input')) {
                updateSubtotal();
                saveCart();
            }
        });

        document.addEventListener('click', function (e) {
            if (cart && cart.classList.contains('open') && !cart.contains(e.target) && e.target !== cartIcon) {
                console.log('Closing cart due to outside click');
                closeCart();
            }
        });

        // Thêm xử lý sự kiện cho nút tăng/giảm số lượng
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('minus-btn') || e.target.classList.contains('plus-btn')) {
                const quantityBox = e.target.closest('.quantity-box');
                const quantitySpan = quantityBox.querySelector('.quantity');
                let quantity = parseInt(quantitySpan.textContent);

                if (e.target.classList.contains('minus-btn') && quantity > 1) {
                    quantity--;
                } else if (e.target.classList.contains('plus-btn')) {
                    quantity++;
                }

                quantitySpan.textContent = quantity;
                updateSubtotal();
                saveCart();
            }
        });


        checkoutBtn.addEventListener('click', function () {
            const cartData = localStorage.getItem('cart');
            if (cartData) {
                // Kiểm tra xem người dùng đã đăng nhập chưa
                fetch('includes/check_login_status.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.isLoggedIn) {
                            // Nếu đã đăng nhập, tiến hành checkout
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '../checkout.php';

                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'cartData';
                            input.value = cartData;

                            form.appendChild(input);
                            document.body.appendChild(form);
                            form.submit();
                        } else {
                            window.location.href = 'login/login.php';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            } else {
                alert('Your cart is empty!');
            }
        });

        loadCart();

        updateSubtotal();

        console.log("Cart initialization complete");
    }

    document.addEventListener('DOMContentLoaded', function () {
        console.log("DOMContentLoaded event fired");
        initializeCart();
    });
})();
