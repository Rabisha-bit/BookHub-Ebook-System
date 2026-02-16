<?php
session_start();
include "database/config.php"; // Your database connection file

// Check if cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: checkout.php");
    exit();
}

// Get user_id from session (if logged in)
$userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

// Get form data
$firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
$lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$city = mysqli_real_escape_string($conn, $_POST['city']);
$postalCode = mysqli_real_escape_string($conn, $_POST['postal_code']);
$province = mysqli_real_escape_string($conn, $_POST['province']);
$orderNotes = mysqli_real_escape_string($conn, $_POST['order_notes']);
$paymentMethod = mysqli_real_escape_string($conn, $_POST['payment_method']);

// Calculate totals
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$deliveryCharges = 200;
$total = $subtotal + $deliveryCharges;

// Generate unique order number
$orderNumber = 'ORD' . date('Ymd') . rand(1000, 9999);

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Insert into orders table
    $insertOrderQuery = "INSERT INTO orders (
        user_id,
        order_number, 
        first_name, 
        last_name, 
        email, 
        phone, 
        address, 
        city, 
        postal_code, 
        province, 
        order_notes, 
        payment_method, 
        subtotal, 
        delivery_charges, 
        total, 
        order_status, 
        created_at
    ) VALUES (
        " . ($userId ? $userId : 'NULL') . ",
        '$orderNumber',
        '$firstName',
        '$lastName',
        '$email',
        '$phone',
        '$address',
        '$city',
        '$postalCode',
        '$province',
        '$orderNotes',
        '$paymentMethod',
        $subtotal,
        $deliveryCharges,
        $total,
        'pending',
        NOW()
    )";

    if (!mysqli_query($conn, $insertOrderQuery)) {
        throw new Exception("Error creating order");
    }

    $orderId = mysqli_insert_id($conn);

    // Insert order items
    foreach ($_SESSION['cart'] as $item) {
        $bookId = (int)$item['book_id'];
        $title = mysqli_real_escape_string($conn, $item['title']);
        $author = mysqli_real_escape_string($conn, $item['author']);
        $format = mysqli_real_escape_string($conn, $item['format']);
        $price = (float)$item['price'];
        $quantity = (int)$item['quantity'];
        $itemTotal = $price * $quantity;

        $insertItemQuery = "INSERT INTO order_items (
            order_id,
            book_id,
            title,
            author,
            format,
            price,
            quantity,
            total
        ) VALUES (
            $orderId,
            $bookId,
            '$title',
            '$author',
            '$format',
            $price,
            $quantity,
            $itemTotal
        )";

        if (!mysqli_query($conn, $insertItemQuery)) {
            throw new Exception("Error adding order items");
        }
    }

    // Commit transaction
    mysqli_commit($conn);

    // Clear cart
    unset($_SESSION['cart']);

    // Redirect to success page
    header("Location: order-success.php?order=" . $orderNumber);
    exit();

} catch (Exception $e) {
    // Rollback on error
    mysqli_rollback($conn);
    
    // Redirect to checkout with error
    $_SESSION['error'] = "Failed to place order. Please try again.";
    header("Location: checkout.php");
    exit();
}

mysqli_close($conn);
?>