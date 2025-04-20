<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['username']) &&
	isset($_POST['email']) &&
	isset($_POST['password'])) {

	$username = htmlspecialchars($_POST['username']);
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
    $table = "admin";

	if (isset($_FILES['gambar'])) {
		$dir_Separator = DIRECTORY_SEPARATOR;
        $root_Path = dirname(__DIR__, 4);
        $URL = "http://".$_SERVER['HTTP_HOST'];
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
        $email_Column = $account->CheckAdminDuplication($email);
        if ($email_Column > 0) {
            ?>
            <script>
                alert("Akun sudah ada");
                window.location.href = "register-admin.php";
            </script>
            <?php
        }
        $image_File = $image->ImageUpload($_FILES['gambar'], $path_Image, $URL_Path);

        if ($image_File == null) {
            ?>
            <script>
                alert("Gambar kosong");
                window.location.href = "register-admin.php";
            </script>
            <?php	
        }

        if ($hashed_Password = $account->HashPassword($password)) {
            if ($account->AddAdmin($email, $username, $hashed_Password, $image_File['url'])) {
                ?>
                <script>
                    alert("Registrasi berhasil");
                    window.location.href = "admin-table.php";
                </script>
                <?php
            } else {
                ?>
                <script>
                    alert("Registrasi gagal");
                    window.location.href = "admin-table.php";
                </script>
                <?php
            }
        }
	}
}
?>