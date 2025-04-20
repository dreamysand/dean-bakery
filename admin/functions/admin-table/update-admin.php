<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['username'])) {

	$username = htmlspecialchars($_POST['username']);
	$id_Admin = htmlspecialchars($_POST['id_Admin']);
    $table = "admin";
    $account = new Account();
    if ($account->UpdateAdmin($id_Admin, $username)) {
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
?>