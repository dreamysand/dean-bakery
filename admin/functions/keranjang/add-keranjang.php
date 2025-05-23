<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['id_produk']) &&
	isset($_POST['id_varian']) &&
	isset($_POST['nama_produk']) &&
	isset($_POST['varian']) &&
	isset($_POST['harga_jual']) &&
	isset($_POST['tanggal_expired']) &&
	isset($_POST['gambar']) &&
	isset($_POST['stok'])) {
	$id_produk = htmlspecialchars($_POST['id_produk']);
	$id_varian = htmlspecialchars($_POST['id_varian']);
	$nama_produk = htmlspecialchars($_POST['nama_produk']);
	$varian = htmlspecialchars($_POST['varian']);
	$harga_jual = htmlspecialchars($_POST['harga_jual']);
	$jumlah = 1;
	$tanggal_expired = htmlspecialchars($_POST['tanggal_expired']);
	$gambar = htmlspecialchars($_POST['gambar']);
	$stok = htmlspecialchars($_POST['stok']);

	$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();

	if (count($cart) <= 10) {
		$cart->AddItems($id_produk, $id_varian, $nama_produk, $varian, $harga_jual, $jumlah, $tanggal_expired, $gambar, $stok);
		$_SESSION['cart'] = serialize($cart);

		header("Location: keranjang.php");
		exit();		
	} else {
		?>
		<script>
			alert("Keranjang sudah penuh");
		</script>
		<?php
	}
}
?>