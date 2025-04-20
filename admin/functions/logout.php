<?php
$table = "admin";
$admin = unserialize($_SESSION['admin']);
$admin_Data = $admin->GetAdminData();
$id_admin = $admin_Data['id'];
$status = $admin->UpdateStatusAdmin($id_admin);
if (!$status['value']) {
	?>
    <script>
        alert("<?= $status['msg']; ?>");
        window.location.href = "dashboard.php";
    </script>
    <?php
}
session_unset();
session_destroy();

header("Location: ../dashboard.php");
exit();
?>