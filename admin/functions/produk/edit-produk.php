<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['id_admin'])) {

	$id_admin = htmlspecialchars($_POST['id_admin']);
    $table = "admin";
	$admin = new Account();
    $admin_Data = $admin->SelectAdmin($id_admin);
    if ($admin_Data != null) {
        ?>
        <script>
            console.log("Data admin berhasil diambil");
        </script>
        <?php   
    } else {
        ?>
        <script>
            console.log("Data admin gagal diambil");
        </script>
        <?php
    }
}
?>