<?php
$table = "admin";
$admins = new Account();
$admins_Data = $admins->GetAdminsData();
if ($admins_Data != null) {
	?>
	<script>
		console.log("Tabel admin berhasil diambil");
	</script>
	<?php 	
} else {
	?>
	<script>
		console.log("Tabel admin gagal diambil");
	</script>
	<?php
}
?>