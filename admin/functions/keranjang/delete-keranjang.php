<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['id_produk']) &&
	isset($_POST['id_varian']) &&
	isset($_GET['delete'])
) {
	$id_produk = htmlspecialchars($_POST['id_produk']);
	$id_varian = htmlspecialchars($_POST['id_varian']);

	$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();
	$cart->DeleteItems($id_produk, $id_varian);
	$_SESSION['cart'] = serialize($cart);

	header("Location: keranjang.php");
	exit();
}
?>