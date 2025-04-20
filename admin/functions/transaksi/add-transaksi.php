<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_GET['add'])
) {
	$data = json_decode(file_get_contents("php://input"), true);
	foreach ($data as $item) {
		$id_produk = $item['id_produk'];
		$id_varian = $item['id_varian'];
		$produk = $item['produk'];
		$varian = $item['varian'];
		$price = $item['price'];
		$value = $item['value'];
		$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();
		$cart->DeleteItems($id_produk, $id_varian);
		$_SESSION['cart'] = serialize($cart);
		$transaksi = isset($_SESSION['transaksi']) ? unserialize($_SESSION['transaksi']) : new Transaksi();
		$transaksi->AddTransaksi($id_produk, $id_varian, $produk, $varian, $price, $value);
		$_SESSION['transaksi'] = serialize($transaksi);
	}

	header("Location: transaksi.php");
	exit();
}
?>