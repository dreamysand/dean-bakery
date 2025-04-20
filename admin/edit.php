<?php
session_start();
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."config.php";
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."class.php";
if (isset($_GET['admin'])) {
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."admin-table".DIRECTORY_SEPARATOR."edit-admin.php";
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."admin-table".DIRECTORY_SEPARATOR."update-admin.php";
	require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."admin-table".DIRECTORY_SEPARATOR."edit-admin.php";
} elseif (isset($_GET['produk'])) {
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."produk".DIRECTORY_SEPARATOR."edit-produk.php";
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."produk".DIRECTORY_SEPARATOR."update-produk.php";
	require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."produk".DIRECTORY_SEPARATOR."edit-produk.php";
} elseif (isset($_GET['member'])) {
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."member".DIRECTORY_SEPARATOR."edit-member.php";
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."member".DIRECTORY_SEPARATOR."update-member.php";
	require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."member".DIRECTORY_SEPARATOR."edit-member.php";
}  elseif (isset($_GET['kategori'])) {
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."kategori".DIRECTORY_SEPARATOR."edit-kategori.php";
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."kategori".DIRECTORY_SEPARATOR."update-kategori.php";
	require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."kategori".DIRECTORY_SEPARATOR."edit-kategori.php";
}
?>