<?php
$title = "Cart | BOOKHUB";
include "header.php";

// Calculate subtotal from session cart
$subtotal = 0;
$cartCount = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['price'] * $item['quantity'];
        $cartCount += $item['quantity'];
    }
}

?>

<style>
    /* GENERAL STYLING */
    :root {
        --body-font: "Inter", sans-serif;
        --heading-font: "Boldonse", system-ui;
        --primary-color: #531f96ff;
        --text-dark: #252525ff;
        --text-light: #ffffff;
        --light: #d1d1d1a4;
    }

    .cart-container {
        max-width: 1300px;
        margin: 60px auto;
        padding: 0 25px;
    }

    .cart-header {
        text-align: center;
        margin-bottom: 50px;
        padding: 30px 0;
    }

    .cart-header h1 {
        font-family: var(--heading-font);
        font-size: 2rem;
        font-weight: 700;
        color: #1a202c;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .cart-header i {
        color: var(--primary-color);
        font-size: 2.5rem;
    }

    /* CART ITEM CARD */
    .cart-item {
        display: flex;
        align-items: center;
        background: #ffffff;
        border-radius: 20px;
        /* box-shadow: 0 10px 25px rgba(0,0,0,0.08), 0 4px 10px rgba(0,0,0,0.04); */
        padding: 10px;
        margin-bottom: 30px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
    }





    .cart-item img {
        width: 140px;
        height: 180px;
        object-fit: cover;
        border-radius: 15px;
        margin-right: 30px;
        flex-shrink: 0;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .cart-item:hover img {
        transform: scale(1.05);
    }

    /* ITEM DETAILS */
    .item-details {
        flex: 1;
        padding-right: 20px;
    }

    .item-title {
        font-family: var(--body-font);
        font-size: 1.5rem;
        /* font-weight: 600; */
        color: #1a202c;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .item-format {
        font-family: var(--body-font);
        font-size: 1rem;
        color: #718096;
        /* font-weight: 500; */
    }

    /* PRICE */
    .item-price {
        font-family: var(--body-font);
        font-size: 1rem;
        /* font-weight: 700; */
        color: var(--text-dark);
        min-width: 120px;
        text-align: right;
        background: var(--text-dark);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* QUANTITY CONTROLS */
    .quantity-controls {
        font-family: var(--body-font);
        display: flex;
        align-items: center;
        gap: 5px;
        /* margin: 0 25px; */
        background: #f7fafc;
        border-radius: 10px;
        padding: 4px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .quantity-controls:hover {
        border-color: var(--primary-color);
        background: #edf2f7;
    }

    .quantity-controls button {
        width: 30px;
        height: 30px;
        border-radius: 10px;
        border: none;
        background: var(--primary-color);
        color: white;
        font-size: 1.2rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 8px rgba(49, 130, 206, 0.3);
    }

    .quantity-controls button:hover {
        background: #2c5282;
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 6px 12px var(--primary-color);
    }

    .quantity-controls button:active {
        transform: scale(0.95);
    }

    .quantity-controls span {
        min-width: 40px;
        text-align: center;
        font-weight: 600;
        font-size: 1.1rem;
        color: #2d3748;
    }

    /* REMOVE BUTTON */
    .remove-btn {
        background: transparent;
        border: 2px solid #e53e3e;
        color: #e53e3e;
        padding: 10px 20px;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .remove-btn:hover {
        background: #e53e3e;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(229, 62, 62, 0.3);
    }

    .remove-btn:active {
        transform: translateY(0);
    }

    /* CART SUMMARY */
    .cart-summary {
        background: linear-gradient(135deg, #ffffff 0%, #f7fafc 100%);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1), 0 5px 15px rgba(0, 0, 0, 0.05);
        max-width: 450px;
        margin-left: auto;
        border: 1px solid var(--primary-color);
        position: sticky;
        top: 20px;
    }

    .cart-summary h4 {
        font-family: var(--body-font);
        /* font-weight: 700; */
        margin-bottom: 25px;
        color: #1a202c;
        font-size: 1.6rem;
        text-align: center;
        position: relative;
    }

    .cart-summary h4::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, #531f96ff, #e9e6e6ff);
        border-radius: 2px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-family: var(--body-font);

        font-size: 1.1rem;
        padding: 8px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .summary-row:last-child {
        border-bottom: none;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 2px solid #3182ce;
    }

    .summary-row strong {
        font-family: var(--body-font);
        font-weight: 700;
        font-size: 1.3rem;
        color: #2d3748;
    }

    .checkout-btn {
        display: block;
        width: 100%;
        padding: 18px;
        font-family: var(--body-font);

        background: var(--primary-color);
        color: white;
        font-size: 1.2rem;
        /* font-weight: 600; */
        border-radius: 10px;
        text-align: center;
        margin-top: 30px;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 20px rgba(49, 130, 206, 0.3);
        position: relative;
        overflow: hidden;
    }

    .checkout-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .checkout-btn:hover {
        transform: translateY(-3px);
        color: var(--text-light);
    }

    .checkout-btn:hover::before {
        left: 100%;
    }

    .checkout-btn:active {
        transform: translateY(-1px);
    }

    /* EMPTY CART */
    .empty-cart {
        text-align: center;
        padding: 80px 40px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--primary-color);
        margin-top: 50px;
    }

    .empty-cart h3 {
        font-family: var(--body-font);
        font-size: 2rem;
        color: var(--text-dark);
        margin-bottom: 25px;
        /* font-weight: 600; */
    }

    .empty-cart p {
        font-family: var(--body-font);
        font-size: 1.1rem;
        color: #a0aec0;
        margin-bottom: 30px;
    }

    .empty-cart a {
        color: var(---primary-color);
        font-weight: 600;
        text-decoration: none;
        font-size: 1.1rem;
        padding: 12px 25px;
        border: 2px solid var(--primary-color);
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .empty-cart a:hover {

        transform: translateY(-2px);
    }

    /* RESPONSIVE */
    @media(max-width: 1024px) {
        .cart-summary {
            max-width: 100%;
            margin-left: 0;
            margin-top: 30px;
        }
    }

    @media(max-width: 768px) {
        .cart-container {
            padding: 0 15px;
            margin: 40px auto;
        }

        .cart-header h1 {
            font-size: 2.2rem;
            flex-direction: column;
            gap: 10px;
        }

        .cart-item {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .cart-item img {
            width: 100px;
            height: 140px;
            margin-right: 0;
            margin-bottom: 15px;
            align-self: center;
        }

        .item-details {
            padding-right: 0;
            text-align: center;
            margin-bottom: 15px;
        }

        .item-price {
            text-align: center;
            margin-top: 10px;
            min-width: auto;
        }

        .quantity-controls {
            margin: 15px 0;
            justify-content: center;
        }

        .remove-btn {
            align-self: center;
        }

        .cart-summary {
            padding: 25px;
        }

        .empty-cart {
            padding: 50px 20px;
        }

        .empty-cart h3 {
            font-size: 1.6rem;
        }
    }

    @media(max-width: 480px) {
        .cart-header h1 {
            font-size: 1.8rem;
        }

        .cart-item {
            padding: 15px;
        }

        .item-title {
            font-size: 1.2rem;
        }

        .quantity-controls button {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }

        .checkout-btn {
            padding: 15px;
            font-size: 1.1rem;
        }
    }
</style>

<div class="cart-container">
    <div class="cart-header">
        <h1><i class="fas fa-shopping-cart"></i> Your Shopping Cart</h1>
    </div>

    <?php if (!empty($_SESSION['cart'])): ?>
        <div style="display: flex; flex-direction: column; gap: 30px;">
            <div style="display: grid; grid-template-columns: 1fr auto; gap: 30px; align-items: start;">
                <div>
                    <?php foreach ($_SESSION['cart'] as $cartKey => $item): ?>
                        <div class="cart-item">
                            <img src="./admin/bookimages/<?php echo htmlspecialchars($item['image']); ?>" alt="Book Cover">
                            <div class="item-details d-flex flex-column justify-content-center">
                                <div class="item-title"><?php echo htmlspecialchars($item['title']); ?></div>
                                <div class="item-format">
                                    Author: <?php echo htmlspecialchars($item['author']); ?>
                                </div>
                                <div class="item-format mt-1">
                                    Format: <?php echo strtoupper($item['format']); ?>
                                </div>
                                <div class="mt-2">Rs. <?php echo number_format($item['price'], 0); ?></div>
                            </div>
                            <div class="quantity-controls">
                                <a href="update-cart.php?key=<?php echo $cartKey; ?>&action=decrease">
                                    <button type="button">-</button>
                                </a>
                                <span id="qty-<?php echo $cartKey; ?>"><?php echo $item['quantity']; ?></span>
                                <a href="update-cart.php?key=<?php echo $cartKey; ?>&action=increase">
                                    <button type="button">+</button>
                                </a>
                            </div>
                            <div class="item-price me-3">
                                Rs. <?php echo number_format($item['price'] * $item['quantity'], 0); ?>
                            </div>
                            <button class="remove-btn">
                                <a href="remove-from-cart.php?id=<?php echo $cartKey ?>">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-summary">
                    <h4>Cart Summary</h4>
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>Rs. <?php echo number_format($subtotal, 0); ?></span>
                    </div>

                    <div class="summary-row">
                        <strong>Total:</strong>
                        <strong>Rs. <?php echo number_format($subtotal, 0); ?></strong>
                    </div>
                    <a href="checkout.php" class="checkout-btn">
                        <i class="fas fa-credit-card"></i> Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-cart">
            <h3>Your Cart Is Empty</h3>
            <p>Looks like you haven't added any books to your cart yet.</p>
            <a href="booklist.php">Continue Shopping</a>
        </div>
    <?php endif; ?>
</div>



<?php include "footer.php"; ?>