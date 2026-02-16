<?php
session_start();
include("database/config.php");



$user_id = $_SESSION["user_id"];
$book_id = $_GET["id"];
$format = $_GET["format"];
$price = $_GET["price"];

// Insert order
$query = "INSERT INTO orders (user_id, book_id, format_type, price) 
          VALUES ('$user_id', '$book_id', '$format', '$price')";

if (mysqli_query($conn, $query)) {
    header("Location: order-success.php");
    exit;
} else {
    echo "Failed to place order.";
}
?>
