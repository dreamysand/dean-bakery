<?php
$table = "admin";
$admin = unserialize($_SESSION['admin']);
$admin_Data = $admin->GetAdminData();
$admins = new Account();
$admins_Data = $admins->GetAdminsData($admin_Data['id']);

if ($admins_Data != null) {
	?>
	<script>
		console.log("Tabel admin berhasil diambil");
	</script>
	<?php 	
	foreach ($admins_Data as $admin_data) {
		$last_login_verify = $admins->CheckActiveTime($admin_data['id']);

		if ($last_login_verify) {
			?>
			<script>
				fetch("delete.php?admin", {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					body: new URLSearchParams({
				        id_admin: '<?= $admin_data['id'] ?>'
				    })
				})
				.then(response => response.text())
			    .then(() => {
			    	alert("Admin <?= $admin_data['username'] ?> sudah terlalu lama offline")
			        window.location.reload();
			    })
			    .catch(error => console.error("Error:", error));
			</script>
			<?php 	
		} else {
			?>
			<script>
				console.log("Ara Ara");
			</script>
			<?php 	
		}
	}
} else {
	?>
	<script>
		console.log("Tabel admin gagal diambil");
	</script>
	<?php
}
?>