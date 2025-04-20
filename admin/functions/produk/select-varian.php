<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['id_produk']) &&
	isset($_GET['varian_produk'])
) {
	$id_produk = htmlspecialchars($_POST['id_produk']);
	$table_varian = "detail_produk";
	$produk = new Produk();

	$varians_Data = $produks->SelectVarians($id_produk);
	if ($varians_Data != null) {
		?>
		<script>
			console.log("Varian berhasil diambil");
		</script>
		<?php 	
	} else {
		?>
		<script>
			console.log("Varian gagal diambil");
		</script>
		<?php 	
	}
}
?>