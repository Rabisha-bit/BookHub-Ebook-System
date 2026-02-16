<?php
session_start();

$cartKey = $_GET["key"];
$action = $_GET["action"];

if(isset($_SESSION['cart'][$cartKey])) {
    if($action == 'increase') {
        $_SESSION['cart'][$cartKey]['quantity']++;
    } 
    elseif($action == 'decrease') {
        $_SESSION['cart'][$cartKey]['quantity']--;
        
        // Agar quantity 0 ho jaye to item remove kar do
        if($_SESSION['cart'][$cartKey]['quantity'] <= 0) {
            unset($_SESSION['cart'][$cartKey]);
        }
    }
}

header('Location: cart.php');
exit();
?>
