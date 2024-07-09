<!-- cart.php -->
<link rel="stylesheet" href="../css/cart.css">
<div class="cart">
    <div class="cart-header">
        <h2>Cart</h2>
        <span class="close">&times;</span>
    </div>
    <div class="cart-items">
        <div class="item" style="display: none;">
            <img src="" alt="Product Image">
            <div class="item-details">
                <h3></h3>
                <p class="price"></p>
                <div class="quantity">
                    <button class="decrease">-</button>
                    <input type="number" value="1" min="1">
                    <button class="increase">+</button>
                    <button class="remove">🗑️</button>
                </div>
            </div>
        </div>
        <!-- Sản phẩm sẽ được thêm vào đây -->
    </div>
    <div class="cart-footer">
        <p>Subtotal: <span class="subtotal">$0.00</span></p>
        <p class="shipping-note">Shipping and taxes calculated at checkout</p>
        <button class="view-cart">VIEW CART</button>
    </div>
</div>

<script src="../js/product-cart.js"></script>
