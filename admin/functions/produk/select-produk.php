<?php
$table_produk = "produk";
$table_varian = "detail_produk";
$produks = new Produk();
$produks_Data = $produks->SelectProduks();
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