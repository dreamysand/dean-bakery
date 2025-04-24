<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && 
	isset($_POST['id_produk']) && 
	isset($_POST['id_varian']) && 
	isset($_POST['stok'])) {
	
	$produk = new Produk();
	$id_varian = $_POST['id_varian'];
	$id_produk = $_POST['id_produk'];
	$stok = $_POST['stok'];

	$table_varian = "detail_produk";

	if ($produk->UpdateStok($id_varian, $id_produk, $stok)) {
		echo "success";
	} else {
		echo "fail";
	}
}
?>