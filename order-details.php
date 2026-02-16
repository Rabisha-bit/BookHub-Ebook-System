<?php
session_start();
include "database/config.php"; 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch order details
$orderQuery = mysqli_query($conn, "SELECT * FROM orders WHERE id='$orderId' AND user_id='$userId'");

if (mysqli_num_rows($orderQuery) == 0) {
    header("Location: user-account.php");
    exit();
}

$order = mysqli_fetch_assoc($orderQuery);

// Fetch order items
$itemsQuery = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id='$orderId'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - <?php echo $order['order_number']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #531f96ff;
            --body-font: "Inter", sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--body-font);
            background: #f7fafc;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 30px;
            padding: 10px 20px;
            border: 2px solid var(--primary-color);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .order-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .order-header h1 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 2rem;
        }

        .order-meta {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            color: #718096;
        }

        .order-meta div {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-approved,
        .status-processing {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-shipped {
            background: #e0e7ff;
            color: #3730a3;
        }

        .status-delivered {
            background: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .card h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .order-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .order-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .item-info {
            flex: 1;
        }

        .item-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .item-meta {
            color: #718096;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .item-price {
            text-align: right;
        }

        .item-price .price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .item-price .qty {
            color: #718096;
            font-size: 0.85rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row strong {
            color: #2d3748;
        }

        .info-row span {
            color: #4a5568;
        }

        .total-row {
            background: #f7fafc;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .total-row .info-row {
            border: none;
            padding: 8px 0;
        }

        .grand-total {
            font-size: 1.3rem;
            color: var(--primary-color);
            font-weight: 700;
            padding-top: 15px;
            margin-top: 15px;
            border-top: 2px solid var(--primary-color);
        }

        .address-box {
            background: #f7fafc;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid var(--primary-color);
        }

        .address-box p {
            margin: 8px 0;
            color: #4a5568;
            line-height: 1.6;
        }

        .address-box strong {
            color: #2d3748;
        }

        .timeline {
            position: relative;
            padding-left: 40px;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 30px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -33px;
            top: 0;
            width: 2px;
            height: 100%;
            background: #e2e8f0;
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .timeline-dot {
            position: absolute;
            left: -40px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--primary-color);
        }

        .timeline-dot.active {
            width: 20px;
            height: 20px;
            left: -42px;
            box-shadow: 0 0 0 4px rgba(83, 31, 150, 0.2);
        }

        .timeline-content h4 {
            color: #2d3748;
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .timeline-content p {
            color: #718096;
            font-size: 0.85rem;
        }

        @media (max-width: 968px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .order-item {
                flex-direction: column;
            }

            .item-price {
                text-align: left;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 20px 10px;
            }

            .order-header h1 {
                font-size: 1.5rem;
            }

            .card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <a href="useraccount.php" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

    <div class="order-header">
        <h1>Order #<?php echo $order['order_number']; ?></h1>
        <div class="order-meta">
            <div>
                <i class="far fa-calendar"></i>
                <span><?php echo date('F d, Y - h:i A', strtotime($order['created_at'])); ?></span>
            </div>
            <div>
                <i class="fas fa-credit-card"></i>
                <span><?php echo strtoupper($order['payment_method']); ?></span>
            </div>
            <div>
                <span class="status-badge status-<?php echo $order['order_status']; ?>">
                    <?php echo ucfirst($order['order_status']); ?>
                </span>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <!-- Left Column -->
        <div>
            <!-- Order Items -->
            <div class="card">
                <h3><i class="fas fa-shopping-bag"></i> Order Items</h3>
                
                <?php while ($item = mysqli_fetch_assoc($itemsQuery)): ?>
                    <div class="order-item">
                        <div class="item-info">
                            <div class="item-title"><?php echo htmlspecialchars($item['title']); ?></div>
                            <div class="item-meta">
                                <div><strong>Author:</strong> <?php echo htmlspecialchars($item['author']); ?></div>
                                <div><strong>Format:</strong> <?php echo strtoupper($item['format']); ?></div>
                                <div><strong>Quantity:</strong> <?php echo $item['quantity']; ?></div>
                            </div>
                        </div>
                        <div class="item-price">
                            <div class="price">Rs. <?php echo number_format($item['total'], 0); ?></div>
                            <div class="qty"><?php echo $item['quantity']; ?> × Rs. <?php echo number_format($item['price'], 0); ?></div>
                        </div>
                    </div>
                <?php endwhile; ?>

                <div class="total-row">
                    <div class="info-row">
                        <span>Subtotal:</span>
                        <strong>Rs. <?php echo number_format($order['subtotal'], 0); ?></strong>
                    </div>
                    <div class="info-row">
                        <span>Delivery Charges:</span>
                        <strong>Rs. <?php echo number_format($order['delivery_charges'], 0); ?></strong>
                    </div>
                    <div class="info-row grand-total">
                        <span>Grand Total:</span>
                        <span>Rs. <?php echo number_format($order['total'], 0); ?></span>
                    </div>
                </div>
            </div>

            <!-- Delivery Address -->
            <div class="card">
                <h3><i class="fas fa-map-marker-alt"></i> Delivery Address</h3>
                <div class="address-box">
                    <p><strong><?php echo $order['first_name'] . ' ' . $order['last_name']; ?></strong></p>
                    <p><?php echo htmlspecialchars($order['address']); ?></p>
                    <p><?php echo htmlspecialchars($order['city']); ?>, <?php echo htmlspecialchars($order['province']); ?></p>
                    <p>Postal Code: <?php echo htmlspecialchars($order['postal_code']); ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($order['phone']); ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($order['email']); ?></p>
                </div>
                
                <?php if (!empty($order['order_notes'])): ?>
                    <div class="address-box" style="margin-top: 20px; border-left-color: #4299e1;">
                        <p><strong><i class="fas fa-sticky-note"></i> Order Notes:</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($order['order_notes'])); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <!-- Order Status -->
            <div class="card">
                <h3><i class="fas fa-clipboard-list"></i> Order Status</h3>
                
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot <?php echo in_array($order['order_status'], ['pending', 'approved', 'processing', 'shipped', 'delivered']) ? 'active' : ''; ?>"></div>
                        <div class="timeline-content">
                            <h4>Order Placed</h4>
                            <p><?php echo date('M d, Y - h:i A', strtotime($order['created_at'])); ?></p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-dot <?php echo in_array($order['order_status'], ['approved', 'processing', 'shipped', 'delivered']) ? 'active' : ''; ?>"></div>
                        <div class="timeline-content">
                            <h4>Order Approved</h4>
                            <p><?php echo in_array($order['order_status'], ['approved', 'processing', 'shipped', 'delivered']) ? 'Approved by admin' : 'Waiting for approval'; ?></p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-dot <?php echo in_array($order['order_status'], ['processing', 'shipped', 'delivered']) ? 'active' : ''; ?>"></div>
                        <div class="timeline-content">
                            <h4>Processing</h4>
                            <p><?php echo in_array($order['order_status'], ['processing', 'shipped', 'delivered']) ? 'Order is being prepared' : 'Not started yet'; ?></p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-dot <?php echo in_array($order['order_status'], ['shipped', 'delivered']) ? 'active' : ''; ?>"></div>
                        <div class="timeline-content">
                            <h4>Shipped</h4>
                            <p><?php echo in_array($order['order_status'], ['shipped', 'delivered']) ? 'Out for delivery' : 'Not shipped yet'; ?></p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-dot <?php echo $order['order_status'] == 'delivered' ? 'active' : ''; ?>"></div>
                        <div class="timeline-content">
                            <h4>Delivered</h4>
                            <p><?php echo $order['order_status'] == 'delivered' ? 'Successfully delivered' : 'Not delivered yet'; ?></p>
                        </div>
                    </div>

                    <?php if ($order['order_status'] == 'cancelled'): ?>
                        <div class="timeline-item">
                            <div class="timeline-dot" style="background: #e53e3e;"></div>
                            <div class="timeline-content">
                                <h4 style="color: #e53e3e;">Order Cancelled</h4>
                                <p>This order has been cancelled</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="card">
                <h3><i class="fas fa-credit-card"></i> Payment Info</h3>
                <div class="info-row">
                    <strong>Payment Method:</strong>
                    <span><?php echo strtoupper($order['payment_method']); ?></span>
                </div>
                <div class="info-row">
                    <strong>Payment Status:</strong>
                    <span><?php echo $order['order_status'] == 'delivered' ? 'Paid' : 'Pending'; ?></span>
                </div>
                <div class="info-row">
                    <strong>Amount:</strong>
                    <span>Rs. <?php echo number_format($order['total'], 0); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php mysqli_close($conn); ?>