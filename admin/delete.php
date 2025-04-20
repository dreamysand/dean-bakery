<?php
session_start();
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."config.php";
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."class.php";
if (isset($_GET['admin'])) {
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."admin-table".DIRECTORY_SEPARATOR."delete-admin.php";
} elseif (isset($_GET['member'])) {
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."member".DIRECTORY_SEPARATOR."delete-member.php";
} elseif (isset($_GET['kategori'])) {
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."kategori".DIRECTORY_SEPARATOR."delete-kategori.php";
}
?>