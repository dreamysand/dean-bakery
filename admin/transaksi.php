<?php
session_start();

require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."config.php";
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."class.php";
$transaksi = isset($_SESSION['transaksi']) ? unserialize($_SESSION['transaksi']) : new Transaksi();
$_SESSION['transaksi'] = serialize($transaksi);
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."transaksi".DIRECTORY_SEPARATOR."add-transaksi.php";
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."transaksi".DIRECTORY_SEPARATOR."get-transaksi.php";
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."transaksi".DIRECTORY_SEPARATOR."delete-transaksi.php";
require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."transaksi".DIRECTORY_SEPARATOR."page.php";
?>