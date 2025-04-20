<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['id_kategori'])) {

	$id_kategori = htmlspecialchars($_POST['id_kategori']);
    $table = "kategori";
	$kategori = new Kategori();
	$image = new Image();
	$kategori_Data = $kategori->SelectKategori($id_kategori);
	if ($kategori_Data != null) {
		$image_URL = $kategori_Data['gambar'];
		$root_Path = dirname(__DIR__, 4);
        $URL = "http://".$_SERVER['HTTP_HOST'];
        $final_Image_Path = str_replace($URL, $root_Path, $image_URL);
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
	    		window.location.href = "kategori.php";
	    	</script>
	    	<?php
        }

        if ($kategori->DeleteKategori($id_kategori)) {
	    	?>
	    	<script>
	    		alert("kategori berhasil dihapus");
	    		window.location.href = "kategori.php";
	    	</script>
	    	<?php
	    } else {
	    	?>
	    	<script>
	    		alert("kategori gagal dihapus");
	    		window.location.href = "kategori.php";
	    	</script>
	    	<?php
	    }

	}
}
?>