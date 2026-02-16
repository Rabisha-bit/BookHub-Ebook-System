<?php
$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

$id = $_POST['id'];

if(isset($cart[$id])){
    unset($cart[$id]);
}

setcookie("cart", json_encode($cart), time() + 86400, "/");

echo json_encode(['success' => true]);
?>
