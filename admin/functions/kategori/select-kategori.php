<?php
$table = "kategori";
$kategoris = new Kategori();
$kategoris_Data = $kategoris->SelectKategoris();
if ($kategoris_Data != null) {
	?>
	<script>
		console.log("Tabel kategori berhasil diambil");
	</script>
	<?php 	
} else {
	?>
	<script>
		console.log("Tabel kategori gagal diambil");
	</script>
	<?php
}
?>