<?php
$table_produk = "produk";
$table_varian = "detail_produk";
$produks = new Produk();
if (isset($_GET['id_kategori']) && !empty($_GET['id_kategori'])) {
	$produks_Data = $produks->SelectProduksByKategori($_GET['id_kategori']);
} else {
	$produks_Data = $produks->SelectProduks();
}
if ($produks_Data != null) {
	?>
	<script>
		console.log("Tabel produk dan varian berhasil diambil");
	</script>
	<?php 	
} else {
	?>
	<script>
		console.log("Tabel produk dan varian gagal diambil");
	</script>
	<?php
}
?>