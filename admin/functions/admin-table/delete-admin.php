<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['id_admin'])) {

	$id_admin = htmlspecialchars($_POST['id_admin']);
    $table = "admin";
	$admin = new Account();
	$image = new Image();
	$admin_Data = $admin->SelectAdmin($id_admin);
	if ($admin_Data != null) {
		$image_URL = $admin_Data['gambar'];
		$root_Path = dirname(__DIR__, 4);
        $URL = "http://".$_SERVER['HTTP_HOST'];
        $final_Image_Path = str_replace($URL, $root_Path, $image_URL);
        $admin_Status = $admin->CheckStatusAdmin($id_admin);
        if (!($admin_Status['value'])) {
        	?>
	    	<script>
	    		alert("<?= $admin_Status['msg'] ?>");
	    		window.location.href = "admin-table.php";
	    	</script>
	    	<?php
        } else {
	        if ($image->DeleteImage($final_Image_Path)) {
	        	?>
		    	<script>
		    		alert("Gambar berhasil dihapus");
		    	</script>
		    	<?php
	        } else {
	        	?>
		    	<script>
		    		alert("Gambar gagal dihapus");
		    		window.location.href = "admin-table.php";
		    	</script>
		    	<?php
	        }

	        if ($admin->DeleteAdmin($id_admin)) {
		    	?>
		    	<script>
		    		alert("Admin berhasil dihapus");
		    		window.location.href = "admin-table.php";
		    	</script>
		    	<?php
		    } else {
		    	?>
		    	<script>
		    		alert("Admin gagal dihapus");
		    		window.location.href = "admin-table.php";
		    	</script>
		    	<?php
		    }
        }

	}
}
?>