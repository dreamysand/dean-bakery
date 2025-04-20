<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['id_kategori'])) {

	$id_kategori = htmlspecialchars($_POST['id_kategori']);
    $table = "kategori";
	$kategori = new Kategori();
    $kategori_Data = $kategori->SelectKategori($id_kategori);
    if ($kategori_Data != null) {
        ?>
        <script>
            console.log("Data kategori berhasil diambil");
        </script>
        <?php   
    } else {
        ?>
        <script>
            console.log("Data kategori gagal diambil");
        </script>
        <?php
    }
}
?>