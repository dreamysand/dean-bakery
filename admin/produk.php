<?php
session_start();
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."config.php";
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."class.php";
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."produk".DIRECTORY_SEPARATOR."select-produk.php";
require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."produk".DIRECTORY_SEPARATOR."page.php";
?>