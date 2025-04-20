<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['username']) &&
    isset($_POST['email']) &&
	isset($_POST['id_Admin']) &&
	isset($_POST['image_Old'])) {

	$username = htmlspecialchars($_POST['username']);
	$email = htmlspecialchars($_POST['email']);
    $image_Old = htmlspecialchars($_POST['image_Old']);
	$id_Admin = htmlspecialchars($_POST['id_Admin']);
    $table = "admin";

	if (isset($_FILES['gambar'])) {
		$dir_Separator = DIRECTORY_SEPARATOR;
        $root_Path = dirname(__DIR__, 4);
        $URL = "http://".$_SERVER['HTTP_HOST'];
        $path_Image_Old = str_replace($URL, $root_Path, $image_Old);
        $image_Storage = [
            "dean-bakery",
            "admin",
            "assets",
            "admins"
        ];
        $path_Image = "$root_Path$dir_Separator$image_Storage[0]$dir_Separator$image_Storage[1]$dir_Separator$image_Storage[2]$dir_Separator$image_Storage[3]$dir_Separator";
        $URL_Path = "$URL$dir_Separator$image_Storage[0]$dir_Separator$image_Storage[1]$dir_Separator$image_Storage[2]$dir_Separator$image_Storage[3]$dir_Separator";
        $image = new Image();
        $account = new Account();
        $email_Column = $account->CheckAdminDuplicationUpdate($email, $id_Admin);
        if ($email_Column > 0) {
            ?>
            <script>
                alert("Akun sudah ada");
                window.location.href = "admin-table.php";
            </script>
            <?php
        }
        $image_File = $image->UpdateImage($_FILES['gambar'], $path_Image, $URL_Path, $path_Image_Old, $image_Old);
        if ($image_File == null) {
            ?>
            <script>
                alert("Gambar kosong");
                window.location.href = "admin-table.php";
            </script>
            <?php	
        }

        if ($account->UpdateProfile($id_Admin, $email, $username, $image_File['url'])) {
            ?>
            <script>
                alert("Admin berhasil diperbarui");
                window.location.href = "admin-table.php";
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Admin gagal diperbarui");
                window.location.href = "admin-table.php";
            </script>
            <?php
        }
    }
}
?>