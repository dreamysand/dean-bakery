<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
    isset($_GET['kategori']) &&
	isset($_POST['kategori'])) {

	$kategori_name = htmlspecialchars($_POST['kategori']);
    $table = "kategori";

	if (isset($_FILES['gambar'])) {
		$dir_Separator = DIRECTORY_SEPARATOR;
        $root_Path = dirname(__DIR__, 4);
        $URL = "http://".$_SERVER['HTTP_HOST'];
        $image_Storage = [
            "dean-bakery",
            "admin",
            "assets",
            "kategori"
        ];
        $path_Image = "$root_Path$dir_Separator$image_Storage[0]$dir_Separator$image_Storage[1]$dir_Separator$image_Storage[2]$dir_Separator$image_Storage[3]$dir_Separator";
        $URL_Path = "$URL$dir_Separator$image_Storage[0]$dir_Separator$image_Storage[1]$dir_Separator$image_Storage[2]$dir_Separator$image_Storage[3]$dir_Separator";
        $image = new Image();
        $kategori = new Kategori();
        $kategori_column = $kategori->CheckKategori($kategori_name);
        if ($kategori_column > 0) {
            ?>
            <script>
                alert("Kategori sudah ada");
                window.location.href = "kategori.php";
            </script>
            <?php
        }
        $image_File = $image->ImageUpload($_FILES['gambar'], $path_Image, $URL_Path);

        if ($image_File == null) {
            ?>
            <script>
                alert("Gambar kosong");
                window.location.href = "kategori.php";
            </script>
            <?php	
        }

        if ($kategori->AddKategori($kategori_name, $image_File['url'])) {
            ?>
            <script>
                alert("Kategori berhasil ditambahkan");
                window.location.href = "kategori.php";
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Kategori gagal ditambahkan");
                window.location.href = "kategori.php";
            </script>
            <?php
        }
	}
}
?>