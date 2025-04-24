<?php
session_start();
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
use Picqer\Barcode\BarcodeGeneratorHTML;
$generator = new BarcodeGeneratorHTML();
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."config.php";
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."class.php";
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."produk".DIRECTORY_SEPARATOR."detail-produk.php";
require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."produk".DIRECTORY_SEPARATOR."detail.php";
?>