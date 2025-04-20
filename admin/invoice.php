<?php
session_start();
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
use Dompdf\Dompdf;
$dompdf = new Dompdf();
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."config.php";
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."class.php";
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."transaksi".DIRECTORY_SEPARATOR."invoice-and-send-to-db.php";
require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."transaksi".DIRECTORY_SEPARATOR."invoice.php";
?>