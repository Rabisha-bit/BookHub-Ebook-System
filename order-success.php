<?php
$title = "Order Success | BOOKHUB";
include "header.php";

// Get order number from URL
$orderNumber = isset($_GET['order']) ? htmlspecialchars($_GET['order']) : '';

if (empty($orderNumber)) {
    header("Location: booklist.php");
    exit();
}
?>

<style>
    :root {
        --body-font: "Inter", sans-serif;
        --heading-font: "Boldonse", system-ui;
        --primary-color: #531f96ff;
        --text-dark: #252525ff;
        --text-light: #ffffff;
    }

    .success-container {
        max-width: 800px;
        margin: 80px auto;
        padding: 0 25px;
        text-align: center;
    }

    .success-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 60px 40px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--primary-color);
    }

    .success-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #48bb78, #38a169);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        animation: scaleIn 0.5s ease-out;
    }

    .success-icon i {
        font-size: 3.5rem;
        color: white;
    }

    @keyframes scaleIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .success-title {
        font-family: var(--heading-font);
        font-size: 2.5rem;
        color: #1a202c;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .success-message {
        font-family: var(--body-font);
        font-size: 1.1rem;
        color: #4a5568;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .order-number {
        background: #f7fafc;
        border: 2px solid var(--primary-color);
        border-radius: 12px;
        padding: 20px;
        margin: 30px 0;
    }

    .order-number-label {
        font-family: var(--body-font);
        font-size: 0.9rem;
        color: #718096;
        margin-bottom: 5px;
    }

    .order-number-value {
        font-family: var(--body-font);
        font-size: 1.8rem;
        color: var(--primary-color);
        font-weight: 700;
        letter-spacing: 1px;
    }

    .info-box {
        background: #edf2f7;
        border-left: 4px solid var(--primary-color);
        padding: 20px;
        margin: 30px 0;
        text-align: left;
        border-radius: 8px;
    }

    .info-box p {
        font-family: var(--body-font);
        margin: 8px 0;
        color: #2d3748;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .info-box i {
        color: var(--primary-color);
        margin-right: 8px;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .btn {
        font-family: var(--body-font);
        padding: 15px 35px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 8px 20px rgba(83, 31, 150, 0.3);
    }

    .btn-primary:hover {
        background: #2c5282;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(83, 31, 150, 0.4);
        color: white;
    }

    .btn-secondary {
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    .btn-secondary:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    @media(max-width: 768px) {
        .success-container {
            margin: 40px auto;
        }

        .success-card {
            padding: 40px 25px;
        }

        .success-title {
            font-size: 2rem;
        }

        .order-number-value {
            font-size: 1.4rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="success-container">
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1 class="success-title">Order Placed Successfully!</h1>
        
        <p class="success-message">
            Thank you for your order! We've received your request and will process it shortly.
        </p>

        <div class="order-number">
            <div class="order-number-label">Your Order Number</div>
            <div class="order-number-value"><?php echo $orderNumber; ?></div>
        </div>

        <div class="info-box">
            <p><i class="fas fa-info-circle"></i> <strong>What happens next?</strong></p>
            <p><i class="fas fa-envelope"></i> You'll receive an order confirmation email shortly</p>
            <p><i class="fas fa-box"></i> We'll prepare your books for delivery</p>
            <p><i class="fas fa-truck"></i> Your order will be shipped within 2-3 business days</p>
            <p><i class="fas fa-phone"></i> We'll contact you if we need any additional information</p>
        </div>

        <div class="action-buttons">
            <a href="booklist.php" class="btn btn-primary">
                <i class="fas fa-book"></i> Continue Shopping
            </a>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>