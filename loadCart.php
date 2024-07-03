<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
echo json_encode($cart);
?>
