<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] == 1) {
    header("Location: index.php");
}

?>