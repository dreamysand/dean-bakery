<?php
if (isset($_GET['id_produk'], $_GET['id_varian']) && 
	!empty($_GET['id_produk'] && 
	!empty($_GET['id_varian']))) {
	$id_produk = htmlspecialchars($_GET['id_produk']);
	$id_varian = htmlspecialchars($_GET['id_varian']);

	$table_produk = "produk";
	$table_varian = "detail_produk";
	$produk = new Produk();
	$produk_Data = $produk->SelectProduk($id_produk, null);
	if ($produk_Data != null) {
		$varian_Data = $produk->SelectVarian($id_varian, $id_produk, null, null);
		if ($varian_Data != null) {
			?>
			<script>
				console.log("Tabel produk dan varian berhasil diambil");
			</script>
			<?php
		} else {
			?>
			<script>
				console.log("Varian gagal diambil");
			</script>
			<?php
		}
	} else {
		?>
		<script>
			console.log("Tabel produk dan varian gagal diambil");
		</script>
		<?php
	}
}
?>