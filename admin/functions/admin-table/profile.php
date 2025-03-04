<?php
$admin = unserialize($_SESSION['admin']);
$admin_Data = $admin->GetAdminData();
$email = $admin_Data['email'];
$username = $admin_Data['username'];
$password = $admin_Data['password'];
$gambar = $admin_Data['gambar'];
?>