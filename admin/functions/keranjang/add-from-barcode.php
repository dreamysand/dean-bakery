<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['barcode'])) {
	$produk = new Produk();
	$barcode = htmlspecialchars($_POST['barcode']);
	$table_produk = "produk";
	$table_varian = "detail_produk";
	$result_varian = $produk->SelectFromBarcode($barcode);
	$result_produk = $produk->SelectProduk($result_varian['fid_produk'], null);

	$id_produk = $result_varian['fid_produk'];
	$id_varian = $result_varian['id'];
	$nama_produk = $result_produk['nama_produk'];
	$varian = $result_varian['varian'];
	$jumlah = 1;
	$tanggal_expired = $result_varian['tanggal_expired'];
	$gambar = $result_varian['gambar'];
	$stok = $result_varian['stok'];
	$harga_jual = $result_varian['harga_jual'];

	$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();
	$cart->AddItems($id_produk, $id_varian, $nama_produk, $varian, $harga_jual, $jumlah, $tanggal_expired, $gambar, $stok);
	$_SESSION['cart'] = serialize($cart);

	header("Location: keranjang.php");
	exit();
}
?>