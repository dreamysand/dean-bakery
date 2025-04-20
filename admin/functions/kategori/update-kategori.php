<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['kategori']) &&
	isset($_POST['id_kategori']) &&
	isset($_POST['image_Old'])) {

	$kategori_name = htmlspecialchars($_POST['kategori']);
    $image_Old = htmlspecialchars($_POST['image_Old']);
	$id_kategori = htmlspecialchars($_POST['id_kategori']);
    $table = "kategori";

	if (isset($_FILES['gambar'])) {
		$dir_Separator = DIRECTORY_SEPARATOR;
        $root_Path = dirname(__DIR__, 4);
        $URL = "http://".$_SERVER['HTTP_HOST'];
        $path_Image_Old = str_replace($URL, $root_Path, $image_Old);
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
        $email_Column = $kategori->CheckKategoriUpdate($kategori_name, $id_kategori);
        if ($email_Column > 0) {
            ?>
            <script>
                alert("Akun sudah ada");
                window.location.href = "kategori.php";
            </script>
            <?php
        }
        $image_File = $image->UpdateImage($_FILES['gambar'], $path_Image, $URL_Path, $path_Image_Old, $image_Old);
        if ($image_File == null) {
            ?>
            <script>
                alert("Gambar kosong");
                window.location.href = "kategori.php";
            </script>
            <?php	
        }

        if ($kategori->UpdateKategori($kategori_name, $image_File['url'], $id_kategori)) {
            ?>
            <script>
                alert("Kategori berhasil diperbarui");
                window.location.href = "kategori.php";
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Kategori gagal diperbarui");
                window.location.href = "kategori.php";
            </script>
            <?php
        }
    }
}
?>