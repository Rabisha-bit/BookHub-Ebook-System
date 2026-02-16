<?php
session_start();
include "database/config.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user info (adjust table/column names as per your database)
$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$userId'");
$user = mysqli_fetch_assoc($userQuery);

// Fetch all orders
$ordersQuery = mysqli_query($conn, "SELECT * FROM orders WHERE user_id='$userId' ORDER BY created_at DESC");

// Get order statistics
$totalOrders = mysqli_num_rows($ordersQuery);
$pendingOrders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE user_id='$userId' AND order_status='pending'"));
$processingOrders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE user_id='$userId' AND order_status IN ('processing', 'shipped')"));
$deliveredOrders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE user_id='$userId' AND order_status='delivered'"));

// Get total amount spent
$totalSpentQuery = mysqli_query($conn, "SELECT SUM(total) as total_spent FROM orders WHERE user_id='$userId' AND order_status != 'cancelled'");
$totalSpentRow = mysqli_fetch_assoc($totalSpentQuery);
$totalSpent = $totalSpentRow['total_spent'] ?? 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - BOOKHUB</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --body-font: "Inter", sans-serif;
            --heading-font: "Boldonse", system-ui;
            --primary-color: #531f96ff;
            --text-dark: #252525ff;
            --text-light: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--body-font);
            background: #f7fafc;
            color: #333;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, var(--primary-color), #7c3aed);
            color: white;
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 40px;
            font-size: 28px;
            font-weight: 700;
            font-family: var(--heading-font);
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin-bottom: 15px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 14px 18px;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background: rgba(255,255,255,0.2);
            transform: translateX(5px);
        }

        .sidebar ul li a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .header h1 {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.8rem;
        }

        .header .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header .user-icon {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 22px;
        }

        .user-details h4 {
            margin: 0;
            color: #2d3748;
            font-weight: 600;
        }

        .user-details small {
            color: #718096;
        }

        /* Sections */
        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border-left: 4px solid var(--primary-color);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .stat-card.total .stat-icon {
            background: #dbeafe;
            color: #1e40af;
        }

        .stat-card.pending .stat-icon {
            background: #fef3c7;
            color: #92400e;
        }

        .stat-card.processing .stat-icon {
            background: #e0e7ff;
            color: #3730a3;
        }

        .stat-card.delivered .stat-icon {
            background: #d1fae5;
            color: #065f46;
        }

        .stat-card.spent .stat-icon {
            background: #fce7f3;
            color: #9f1239;
        }

        .stat-card h3 {
            font-size: 2rem;
            color: #2d3748;
            margin: 0;
            font-weight: 700;
        }

        .stat-card p {
            margin: 5px 0 0;
            color: #718096;
            font-size: 0.9rem;
        }

        /* Card */
        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .card h4 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            font-size: 1.3rem;
        }

        .card h4 i {
            margin-right: 12px;
        }

        /* Orders Table */
        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th,
        .orders-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .orders-table th {
            background: #f7fafc;
            color: #2d3748;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .orders-table td {
            color: #4a5568;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
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

        .view-btn {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            border: 2px solid var(--primary-color);
            display: inline-block;
            transition: all 0.3s ease;
        }

        .view-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .detail-item {
            padding: 15px;
            background: #f7fafc;
            border-radius: 10px;
            border-left: 3px solid var(--primary-color);
        }

        .detail-item strong {
            color: #2d3748;
            display: block;
            margin-bottom: 5px;
            font-size: 0.85rem;
        }

        .detail-item span {
            color: #4a5568;
            font-size: 0.95rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #4a5568;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #718096;
            margin-bottom: 25px;
        }

        .empty-state a {
            display: inline-block;
            padding: 12px 30px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .empty-state a:hover {
            background: #7c3aed;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }
            .main-content {
                margin-left: 220px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            .dashboard {
                flex-direction: column;
            }
            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .orders-table {
                font-size: 0.85rem;
            }
            .orders-table th,
            .orders-table td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>

<div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">BOOKHUB</div>
        <ul>
            <li><a href="#" data-section="overview" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#" data-section="profile"><i class="fas fa-user"></i> My Profile</a></li>
            <li><a href="#" data-section="orders"><i class="fas fa-shopping-cart"></i> My Orders</a></li>
            <li><a href="#" data-section="addresses"><i class="fas fa-map-marker-alt"></i> Addresses</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1 id="page-title">Welcome back, <?php echo htmlspecialchars($user['user_name'] ?? $user['user_name'] ?? 'User'); ?>!</h1>
            <div class="user-info">
                <div class="user-icon"><i class="fas fa-user"></i></div>
                <div class="user-details">
                    <h4><?php echo htmlspecialchars($user['user_name'] ?? $user['user_name'] ?? 'User'); ?></h4>
                    <small><?php echo htmlspecialchars($user['user_email']); ?></small>
                </div>
            </div>
        </div>

        <!-- Overview Section -->
        <div id="overview" class="section active">
            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card total">
                    <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
                    <h3><?php echo $totalOrders; ?></h3>
                    <p>Total Orders</p>
                </div>
                <div class="stat-card pending">
                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                    <h3><?php echo $pendingOrders; ?></h3>
                    <p>Pending Orders</p>
                </div>
                <div class="stat-card processing">
                    <div class="stat-icon"><i class="fas fa-shipping-fast"></i></div>
                    <h3><?php echo $processingOrders; ?></h3>
                    <p>In Transit</p>
                </div>
                <div class="stat-card delivered">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <h3><?php echo $deliveredOrders; ?></h3>
                    <p>Delivered</p>
                </div>
                <div class="stat-card spent">
                    <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <h3>Rs. <?php echo number_format($totalSpent, 0); ?></h3>
                    <p>Total Spent</p>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card">
                <h4><i class="fas fa-history"></i> Recent Orders</h4>
                <?php
                mysqli_data_seek($ordersQuery, 0); // Reset pointer
                $recentOrders = [];
                $count = 0;
                while ($order = mysqli_fetch_assoc($ordersQuery)) {
                    if ($count >= 5) break;
                    $recentOrders[] = $order;
                    $count++;
                }
                ?>
                
                <?php if (!empty($recentOrders)): ?>
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $order): ?>
                                <?php
                                $orderId = $order['id'];
                                $itemsQuery = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id='$orderId'");
                                $itemCount = mysqli_num_rows($itemsQuery);
                                ?>
                                <tr>
                                    <td><strong><?php echo $order['order_number']; ?></strong></td>
                                    <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                    <td><?php echo $itemCount; ?> item(s)</td>
                                    <td><strong>Rs. <?php echo number_format($order['total'], 0); ?></strong></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $order['order_status']; ?>">
                                            <?php echo ucfirst($order['order_status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="order-details.php?id=<?php echo $order['id']; ?>" class="view-btn">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>No orders yet</h3>
                        <p>Start shopping to see your orders here</p>
                        <a href="booklist.php">Browse Books</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Profile Section -->
        <div id="profile" class="section">
            <div class="card">
                <h4><i class="fas fa-user-circle"></i> Personal Information</h4>
                <div class="details-grid">
                    <div class="detail-item">
                        <strong>Full Name</strong>
                        <span><?php echo htmlspecialchars($user['user_name'] ?? $user['user_name'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="detail-item">
                        <strong>Email Address</strong>
                        <span><?php echo htmlspecialchars($user['user_email']); ?></span>
                    </div>
                    <div class="detail-item">
                        <strong>Phone Number</strong>
                        <span><?php echo htmlspecialchars($user['phone'] ?? 'Not provided'); ?></span>
                    </div>
                    <div class="detail-item">
                        <strong>Member Since</strong>
                        <span><?php echo date('M d, Y', strtotime($user['created_at'] ?? 'now')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Section -->
        <div id="orders" class="section">
            <div class="card">
                <h4><i class="fas fa-list"></i> All Orders</h4>
                
                <?php
                mysqli_data_seek($ordersQuery, 0); // Reset pointer
                ?>
                
                <?php if (mysqli_num_rows($ordersQuery) > 0): ?>
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = mysqli_fetch_assoc($ordersQuery)): ?>
                                <?php
                                $orderId = $order['id'];
                                $itemsQuery = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id='$orderId'");
                                $itemCount = mysqli_num_rows($itemsQuery);
                                ?>
                                <tr>
                                    <td><strong><?php echo $order['order_number']; ?></strong></td>
                                    <td><?php echo date('M d, Y - h:i A', strtotime($order['created_at'])); ?></td>
                                    <td><?php echo $itemCount; ?> item(s)</td>
                                    <td><?php echo strtoupper($order['payment_method']); ?></td>
                                    <td><strong>Rs. <?php echo number_format($order['total'], 0); ?></strong></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $order['order_status']; ?>">
                                            <?php echo ucfirst($order['order_status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="order-details.php?id=<?php echo $order['id']; ?>" class="view-btn">View Details</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>No orders yet</h3>
                        <p>You haven't placed any orders yet</p>
                        <a href="booklist.php">Start Shopping</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Addresses Section -->
        <div id="addresses" class="section">
            <div class="card">
                <h4><i class="fas fa-map-marker-alt"></i> Saved Addresses</h4>
                
                <?php
                $addressesQuery = mysqli_query($conn, "
                    SELECT DISTINCT address, city, postal_code, province 
                    FROM orders 
                    WHERE user_id='$userId'
                    ORDER BY created_at DESC
                ");
                ?>
                
                <?php if (mysqli_num_rows($addressesQuery) > 0): ?>
                    <div class="details-grid">
                        <?php while ($address = mysqli_fetch_assoc($addressesQuery)): ?>
                            <div class="detail-item">
                                <strong><i class="fas fa-home"></i> Delivery Address</strong>
                                <span>
                                    <?php echo htmlspecialchars($address['address']); ?><br>
                                    <?php echo htmlspecialchars($address['city']); ?>, <?php echo htmlspecialchars($address['province']); ?><br>
                                    <?php echo htmlspecialchars($address['postal_code']); ?>
                                </span>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>No addresses saved</h3>
                        <p>Your delivery addresses will appear here after your first order</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    const sidebarLinks = document.querySelectorAll('.sidebar a[data-section]');
    const sections = document.querySelectorAll('.section');
    const pageTitle = document.getElementById('page-title');

    function showSection(sectionId) {
        sections.forEach(section => section.classList.remove('active'));
        document.getElementById(sectionId).classList.add('active');

        sidebarLinks.forEach(link => link.classList.remove('active'));
        document.querySelector(`[data-section="${sectionId}"]`).classList.add('active');

        const titles = {
            overview: 'Welcome back, <?php echo htmlspecialchars($user["name"] ?? $user["username"] ?? "User"); ?>!',
            profile: 'My Profile',
            orders: 'My Orders',
            addresses: 'My Addresses'
        };
        pageTitle.textContent = titles[sectionId] || 'Dashboard';
    }

    sidebarLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const sectionId = link.getAttribute('data-section');
            showSection(sectionId);
        });
    });
</script>

</body>
</html>

<?php mysqli_close($conn); ?>