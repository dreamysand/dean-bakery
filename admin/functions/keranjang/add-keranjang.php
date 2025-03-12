<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['id_produk']) &&
	isset($_POST['id_varian']) &&
	isset($_POST['nama_produk']) &&
	isset($_POST['varian']) &&
	isset($_POST['harga_jual']) &&
	isset($_POST['tanggal_expired']) &&
	isset($_POST['gambar'])
) {
	$id_produk = htmlspecialchars($_POST['id_produk']);
	$id_varian = htmlspecialchars($_POST['id_varian']);
	$nama_produk = htmlspecialchars($_POST['nama_produk']);
	$varian = htmlspecialchars($_POST['varian']);
	$harga_jual = htmlspecialchars($_POST['harga_jual']);
	$jumlah = 1;
	$tanggal_expired = htmlspecialchars($_POST['tanggal_expired']);
	$gambar = htmlspecialchars($_POST['gambar']);

	$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();
	$cart->AddItems($id_produk, $id_varian, $nama_produk, $varian, $harga_jual, $jumlah, $tanggal_expired, $gambar);
	$_SESSION['cart'] = serialize($cart);

	header("Location: keranjang.php");
	exit();
}
?>