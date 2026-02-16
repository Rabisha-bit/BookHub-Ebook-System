<?php
session_start();

$cartKey = $_GET["id"];

unset($_SESSION['cart'][$cartKey]);
header ('Location: cart.php');

?>