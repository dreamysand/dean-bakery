<?php
$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();
$cart_Data = $cart->GetItems();
?>