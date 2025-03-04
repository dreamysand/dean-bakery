<?php
session_start();
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."config.php";
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."class.php";
if (isset($_GET['kategori'])) {
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."kategori".DIRECTORY_SEPARATOR."add-kategori.php";
	require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."kategori".DIRECTORY_SEPARATOR."add-kategori.php";
} elseif (isset($_GET['produk'])) {
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."kategori".DIRECTORY_SEPARATOR."add-kategori.php";
	require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."kategori".DIRECTORY_SEPARATOR."add-kategori.php";
}
?>