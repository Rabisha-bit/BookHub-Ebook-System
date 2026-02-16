<?php
$title = "Checkout | BOOKHUB";
include "header.php";

// Redirect if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Calculate totals
$subtotal = 0;
$cartCount = 0;

foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
    $cartCount += $item['quantity'];
}

$deliveryCharges = 200; // Fixed delivery charges
$total = $subtotal + $deliveryCharges;
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

    .checkout-container {
        max-width: 1300px;
        margin: 60px auto;
        padding: 0 25px;
    }

    .checkout-header {
        text-align: center;
        margin-bottom: 50px;
        padding: 30px 0;
    }

    .checkout-header h1 {
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

    .checkout-header i {
        color: var(--primary-color);
        font-size: 2.5rem;
    }

    /* GRID LAYOUT */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 40px;
        align-items: start;
    }

    /* BILLING FORM */
    .billing-section {
        background: #ffffff;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid #e2e8f0;
    }

    .billing-section h3 {
        font-family: var(--heading-font);
        font-size: 1.6rem;
        color: #1a202c;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--primary-color);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-family: var(--body-font);
        display: block;
        margin-bottom: 8px;
        color: #2d3748;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .form-group label span {
        color: #e53e3e;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        font-family: var(--body-font);
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f7fafc;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary-color);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(83, 31, 150, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    /* ORDER SUMMARY */
    .order-summary {
        background: linear-gradient(135deg, #ffffff 0%, #f7fafc 100%);
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--primary-color);
        position: sticky;
        top: 20px;
    }

    .order-summary h3 {
        font-family: var(--heading-font);
        font-size: 1.6rem;
        color: #1a202c;
        margin-bottom: 25px;
        text-align: center;
        position: relative;
    }

    .order-summary h3::after {
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

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e2e8f0;
        font-family: var(--body-font);
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-info {
        flex: 1;
    }

    .item-name {
        font-size: 0.95rem;
        color: #2d3748;
        margin-bottom: 3px;
    }

    .item-qty {
        font-size: 0.85rem;
        color: #718096;
    }

    .item-price {
        font-weight: 600;
        color: #1a202c;
    }

    .summary-divider {
        height: 2px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        margin: 20px 0;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-family: var(--body-font);
        font-size: 1rem;
        color: #4a5568;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 2px solid var(--primary-color);
        font-family: var(--body-font);
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a202c;
    }

    /* PAYMENT SECTION */
    .payment-section {
        background: #ffffff;
        border-radius: 20px;
        padding: 35px;
        margin-top: 25px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid #e2e8f0;
    }

    .payment-section h3 {
        font-family: var(--heading-font);
        font-size: 1.6rem;
        color: #1a202c;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--primary-color);
    }

    .payment-options {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .payment-option {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f7fafc;
    }

    .payment-option:hover {
        border-color: var(--primary-color);
        background: #ffffff;
    }

    .payment-option input[type="radio"] {
        width: 20px;
        height: 20px;
        margin-right: 15px;
        cursor: pointer;
        accent-color: var(--primary-color);
    }

    .payment-option label {
        font-family: var(--body-font);
        font-size: 1.05rem;
        color: #2d3748;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        flex: 1;
    }

    .payment-option i {
        font-size: 1.5rem;
        color: var(--primary-color);
    }

    /* PLACE ORDER BUTTON */
    .place-order-btn {
        width: 100%;
        padding: 18px;
        font-family: var(--body-font);
        background: var(--primary-color);
        color: white;
        font-size: 1.2rem;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-top: 30px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 20px rgba(83, 31, 150, 0.3);
        position: relative;
        overflow: hidden;
    }

    .place-order-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .place-order-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(83, 31, 150, 0.4);
    }

    .place-order-btn:hover::before {
        left: 100%;
    }

    .place-order-btn:active {
        transform: translateY(-1px);
    }

    /* RESPONSIVE */
    @media(max-width: 1024px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }

        .order-summary {
            position: static;
        }
    }

    @media(max-width: 768px) {
        .checkout-container {
            padding: 0 15px;
            margin: 40px auto;
        }

        .checkout-header h1 {
            font-size: 1.8rem;
            flex-direction: column;
            gap: 10px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .billing-section,
        .payment-section,
        .order-summary {
            padding: 25px;
        }
    }

    @media(max-width: 480px) {
        .checkout-header h1 {
            font-size: 1.5rem;
        }

        .billing-section h3,
        .payment-section h3,
        .order-summary h3 {
            font-size: 1.3rem;
        }

        .place-order-btn {
            padding: 15px;
            font-size: 1.1rem;
        }
    }
</style>

<div class="checkout-container">
    <div class="checkout-header">
        <h1><i class="fas fa-credit-card"></i> Checkout</h1>
    </div>

    <form action="process-order.php" method="POST" id="checkoutForm">
        <div class="checkout-grid">
            <!-- Left Column: Billing & Payment -->
            <div>
                <!-- Billing Information -->
                <div class="billing-section">
                    <h3><i class="fas fa-user-circle"></i> Billing Information</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name <span>*</span></label>
                            <input type="text" name="first_name" required placeholder="Enter first name">
                        </div>
                        <div class="form-group">
                            <label>Last Name <span>*</span></label>
                            <input type="text" name="last_name" required placeholder="Enter last name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email Address <span>*</span></label>
                        <input type="email" name="email" required placeholder="your.email@example.com">
                    </div>

                    <div class="form-group">
                        <label>Phone Number <span>*</span></label>
                        <input type="tel" name="phone" required placeholder="+92 300 1234567">
                    </div>

                    <div class="form-group">
                        <label>Street Address <span>*</span></label>
                        <input type="text" name="address" required placeholder="House #, Street name">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>City <span>*</span></label>
                            <input type="text" name="city" required placeholder="Enter city">
                        </div>
                        <div class="form-group">
                            <label>Postal Code <span>*</span></label>
                            <input type="text" name="postal_code" required placeholder="Enter postal code">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Province <span>*</span></label>
                        <select name="province" required>
                            <option value="">Select Province</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Sindh">Sindh</option>
                            <option value="KPK">Khyber Pakhtunkhwa</option>
                            <option value="Balochistan">Balochistan</option>
                            <option value="Gilgit-Baltistan">Gilgit-Baltistan</option>
                            <option value="AJK">Azad Jammu & Kashmir</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Order Notes (Optional)</label>
                        <textarea name="order_notes" rows="3" placeholder="Any special instructions for delivery..."></textarea>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="payment-section">
                    <h3><i class="fas fa-money-check-alt"></i> Payment Method</h3>
                    
                    <div class="payment-options">
                        <div class="payment-option">
                            <input type="radio" id="cod" name="payment_method" value="cod" checked>
                            <label for="cod">
                                <i class="fas fa-hand-holding-usd"></i>
                                Cash on Delivery (COD)
                            </label>
                        </div>

                        <div class="payment-option">
                            <input type="radio" id="bank" name="payment_method" value="bank_transfer">
                            <label for="bank">
                                <i class="fas fa-university"></i>
                                Bank Transfer
                            </label>
                        </div>

                        <div class="payment-option">
                            <input type="radio" id="card" name="payment_method" value="card">
                            <label for="card">
                                <i class="fas fa-credit-card"></i>
                                Debit/Credit Card
                            </label>
                        </div>

                        <div class="payment-option">
                            <input type="radio" id="easypaisa" name="payment_method" value="easypaisa">
                            <label for="easypaisa">
                                <i class="fas fa-mobile-alt"></i>
                                Easypaisa / JazzCash
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="order-summary">
                <h3>Order Summary</h3>
                
                <div style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="order-item">
                            <div class="item-info">
                                <div class="item-name"><?php echo htmlspecialchars($item['title']); ?></div>
                                <div class="item-qty">Qty: <?php echo $item['quantity']; ?> × Rs. <?php echo number_format($item['price'], 0); ?></div>
                            </div>
                            <div class="item-price">
                                Rs. <?php echo number_format($item['price'] * $item['quantity'], 0); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>Rs. <?php echo number_format($subtotal, 0); ?></span>
                </div>

                <div class="summary-row">
                    <span>Delivery Charges:</span>
                    <span>Rs. <?php echo number_format($deliveryCharges, 0); ?></span>
                </div>

                <div class="summary-total">
                    <strong>Total:</strong>
                    <strong>Rs. <?php echo number_format($total, 0); ?></strong>
                </div>

                <button type="submit" class="place-order-btn">
                    <i class="fas fa-check-circle"></i> Place Order
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    // Form validation
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.style.borderColor = '#e53e3e';
            } else {
                field.style.borderColor = '#e2e8f0';
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields!');
        }
    });

    // Clear error styling on input
    document.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('input', function() {
            this.style.borderColor = '#e2e8f0';
        });
    });
</script>

<?php include "footer.php"; ?>