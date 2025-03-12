<?php
session_start();

require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."config.php";
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."class.php";
$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();
$_SESSION['cart'] = serialize($cart);
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."keranjang".DIRECTORY_SEPARATOR."add-keranjang.php";
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."keranjang".DIRECTORY_SEPARATOR."select-keranjang.php";
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."keranjang".DIRECTORY_SEPARATOR."delete-keranjang.php";
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."keranjang".DIRECTORY_SEPARATOR."delete-all-keranjang.php";
require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."keranjang".DIRECTORY_SEPARATOR."page.php";
?>