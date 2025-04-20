<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['id_produk']) &&
	isset($_POST['id_varian']) &&
	isset($_GET['delete'])
) {
	$id_produk = htmlspecialchars($_POST['id_produk']);
	$id_varian = htmlspecialchars($_POST['id_varian']);

	$transaksi = isset($_SESSION['transaksi']) ? unserialize($_SESSION['transaksi']) : new Transaksi();
	$transaksi->DeleteTransaksi($id_produk, $id_varian);
	$_SESSION['transaksi'] = serialize($transaksi);

	header("Location: transaksi.php");
	exit();
}
?>