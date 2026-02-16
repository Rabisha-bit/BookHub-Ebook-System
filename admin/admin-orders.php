<?php

include "includes/header.php";



// Handle status update
if (isset($_POST['update_status'])) {
    $orderId = (int)$_POST['order_id'];
    $newStatus = mysqli_real_escape_string($conn, $_POST['status']);
    
    $updateQuery = "UPDATE orders SET order_status = '$newStatus', updated_at = NOW() WHERE id = $orderId";
    if (mysqli_query($conn, $updateQuery)) {
        $successMessage = "Order status updated successfully!";
    } else {
        $errorMessage = "Failed to update order status.";
    }
}

// Get filter
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';

// Build query
$query = "SELECT * FROM orders";
if ($statusFilter !== 'all') {
    $query .= " WHERE order_status = '" . mysqli_real_escape_string($conn, $statusFilter) . "'";
}
$query .= " ORDER BY created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #531f96ff;
            --success-color: #48bb78;
            --danger-color: #e53e3e;
            --warning-color: #ed8936;
            --info-color: #4299e1;
        }

        body {
            background: #f7fafc;
            font-family: 'Inter', sans-serif;
        }

        .admin-header {
            background: linear-gradient(135deg, var(--primary-color), #7c3aed);
            color: white;
            padding: 30px 0;
            margin-bottom: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .admin-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            border-left: 4px solid var(--primary-color);
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            color: var(--primary-color);
        }

        .stats-card p {
            margin: 5px 0 0 0;
            color: #718096;
            font-size: 0.9rem;
        }

        .filter-tabs {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .filter-tabs .btn {
            margin-right: 10px;
            margin-bottom: 10px;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .filter-tabs .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .filter-tabs .btn-outline-primary:hover,
        .filter-tabs .btn-outline-primary.active {
            background: var(--primary-color);
            color: white;
        }

        .order-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border-left: 4px solid #e2e8f0;
        }

        .order-card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .order-card.pending {
            border-left-color: var(--warning-color);
        }

        .order-card.processing {
            border-left-color: var(--info-color);
        }

        .order-card.approved {
            border-left-color: var(--success-color);
        }

        .order-card.rejected {
            border-left-color: var(--danger-color);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f7fafc;
        }

        .order-number {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .order-date {
            color: #718096;
            font-size: 0.9rem;
        }

        .customer-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-item i {
            color: var(--primary-color);
            width: 20px;
        }

        .info-item span {
            color: #2d3748;
            font-size: 0.95rem;
        }

        .order-items {
            background: #f7fafc;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .order-items h6 {
            font-weight: 700;
            margin-bottom: 15px;
            color: #2d3748;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background: #edf2f7;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .order-total strong {
            font-size: 1.2rem;
            color: var(--primary-color);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-processing {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .status-shipped {
            background: #e0e7ff;
            color: #3730a3;
        }

        .status-delivered {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-action {
            flex: 1;
            min-width: 120px;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-approve {
            background: var(--success-color);
            color: white;
            border: none;
        }

        .btn-approve:hover {
            background: #38a169;
            color: white;
            transform: translateY(-2px);
        }

        .btn-reject {
            background: var(--danger-color);
            color: white;
            border: none;
        }

        .btn-reject:hover {
            background: #c53030;
            color: white;
            transform: translateY(-2px);
        }

        .btn-view {
            background: var(--info-color);
            color: white;
            border: none;
        }

        .btn-view:hover {
            background: #3182ce;
            color: white;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        @media (max-width: 768px) {
            .customer-info {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <div class="container">
            <h1><i class="fas fa-shopping-bag"></i> Manage Orders</h1>
        </div>
    </div>

    <div class="container">
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> <?php echo $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> <?php echo $errorMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Statistics -->
        <div class="row mb-4">
            <?php
            $stats = [
                'pending' => mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE order_status = 'pending'")),
                'processing' => mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE order_status = 'processing'")),
                'approved' => mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE order_status = 'shipped' OR order_status = 'delivered'")),
                'total' => mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders"))
            ];
            ?>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card">
                    <h3><?php echo $stats['pending']; ?></h3>
                    <p>Pending Orders</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card">
                    <h3><?php echo $stats['processing']; ?></h3>
                    <p>Processing</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card">
                    <h3><?php echo $stats['approved']; ?></h3>
                    <p>Approved Orders</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card">
                    <h3><?php echo $stats['total']; ?></h3>
                    <p>Total Orders</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-tabs">
            <a href="?status=all" class="btn btn-outline-primary <?php echo $statusFilter === 'all' ? 'active' : ''; ?>">
                All Orders
            </a>
            <a href="?status=pending" class="btn btn-outline-primary <?php echo $statusFilter === 'pending' ? 'active' : ''; ?>">
                Pending
            </a>
            <a href="?status=processing" class="btn btn-outline-primary <?php echo $statusFilter === 'processing' ? 'active' : ''; ?>">
                Processing
            </a>
            <a href="?status=shipped" class="btn btn-outline-primary <?php echo $statusFilter === 'shipped' ? 'active' : ''; ?>">
                Shipped
            </a>
            <a href="?status=delivered" class="btn btn-outline-primary <?php echo $statusFilter === 'delivered' ? 'active' : ''; ?>">
                Delivered
            </a>
            <a href="?status=cancelled" class="btn btn-outline-primary <?php echo $statusFilter === 'cancelled' ? 'active' : ''; ?>">
                Cancelled
            </a>
        </div>

        <!-- Orders List -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($order = mysqli_fetch_assoc($result)): ?>
                <?php
                // Get order items
                $orderItemsQuery = "SELECT * FROM order_items WHERE order_id = " . $order['id'];
                $orderItemsResult = mysqli_query($conn, $orderItemsQuery);
                ?>
                
                <div class="order-card <?php echo $order['order_status']; ?>">
                    <div class="order-header">
                        <div>
                            <div class="order-number"><?php echo $order['order_number']; ?></div>
                            <div class="order-date">
                                <i class="far fa-calendar"></i> 
                                <?php echo date('M d, Y - h:i A', strtotime($order['created_at'])); ?>
                            </div>
                        </div>
                        <div>
                            <span class="status-badge status-<?php echo $order['order_status']; ?>">
                                <?php echo $order['order_status']; ?>
                            </span>
                        </div>
                    </div>

                    <div class="customer-info">
                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <span><strong>Name:</strong> <?php echo $order['first_name'] . ' ' . $order['last_name']; ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <span><strong>Email:</strong> <?php echo $order['email']; ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <span><strong>Phone:</strong> <?php echo $order['phone']; ?></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-credit-card"></i>
                            <span><strong>Payment:</strong> <?php echo strtoupper($order['payment_method']); ?></span>
                        </div>
                    </div>

                    <div class="customer-info">
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><strong>Address:</strong> <?php echo $order['address'] . ', ' . $order['city'] . ', ' . $order['province']; ?></span>
                        </div>
                    </div>

                    <div class="order-items">
                        <h6><i class="fas fa-book"></i> Order Items</h6>
                        <?php while ($item = mysqli_fetch_assoc($orderItemsResult)): ?>
                            <div class="item-row">
                                <div>
                                    <strong><?php echo $item['title']; ?></strong>
                                    <br>
                                    <small class="text-muted">
                                        by <?php echo $item['author']; ?> | 
                                        Format: <?php echo strtoupper($item['format']); ?> | 
                                        Qty: <?php echo $item['quantity']; ?>
                                    </small>
                                </div>
                                <div>
                                    <strong>Rs. <?php echo number_format($item['total'], 0); ?></strong>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="order-total">
                        <div>
                            <div>Subtotal: Rs. <?php echo number_format($order['subtotal'], 0); ?></div>
                            <div>Delivery: Rs. <?php echo number_format($order['delivery_charges'], 0); ?></div>
                        </div>
                        <div>
                            <strong>Total: Rs. <?php echo number_format($order['total'], 0); ?></strong>
                        </div>
                    </div>

                    <?php if (!empty($order['order_notes'])): ?>
                        <div class="alert alert-info">
                            <strong><i class="fas fa-sticky-note"></i> Order Notes:</strong><br>
                            <?php echo nl2br(htmlspecialchars($order['order_notes'])); ?>
                        </div>
                    <?php endif; ?>

                    <div class="action-buttons">
                        <?php if ($order['order_status'] === 'pending'): ?>
                            <form method="POST" style="flex: 1;">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <input type="hidden" name="status" value="processing">
                                <button type="submit" name="update_status" class="btn btn-approve btn-action w-100">
                                    <i class="fas fa-check"></i> Approve & Process
                                </button>
                            </form>
                            <form method="POST" style="flex: 1;">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" name="update_status" class="btn btn-reject btn-action w-100" 
                                        onclick="return confirm('Are you sure you want to reject this order?')">
                                    <i class="fas fa-times"></i> Reject Order
                                </button>
                            </form>
                        <?php elseif ($order['order_status'] === 'processing'): ?>
                            <form method="POST" style="flex: 1;">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <input type="hidden" name="status" value="shipped">
                                <button type="submit" name="update_status" class="btn btn-view btn-action w-100">
                                    <i class="fas fa-shipping-fast"></i> Mark as Shipped
                                </button>
                            </form>
                        <?php elseif ($order['order_status'] === 'shipped'): ?>
                            <form method="POST" style="flex: 1;">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <input type="hidden" name="status" value="delivered">
                                <button type="submit" name="update_status" class="btn btn-approve btn-action w-100">
                                    <i class="fas fa-check-double"></i> Mark as Delivered
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No orders found.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>