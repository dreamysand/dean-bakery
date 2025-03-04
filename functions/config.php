<?php
$dsn = "localhost";
$db = "kasir";
$usrname = "root";
$pass = "";

if ($config = new PDO('mysql:host='.$dsn.';dbname='.$db, $usrname, $pass)) {
	?>
	<script>
		console.log('Koneksi Berhasil');
	</script>
	<?php
} else {
	?>
	<script>
		console.log('Koneksi Gagal');
	</script>
	<?php
}
?>