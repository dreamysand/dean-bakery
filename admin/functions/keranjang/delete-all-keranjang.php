<?php
if (isset($_GET['delete_all'])) {
	$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();
	$cart->DeleteAllItems();
	$_SESSION['cart'] = serialize($cart);

	header("Location: keranjang.php");
	exit();
}
?>