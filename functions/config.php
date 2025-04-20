<?php
$dsn = "localhost";
$db = "kasir";
$usrname = "root";
$pass = "";

$config = new PDO('mysql:host='.$dsn.';dbname='.$db, $usrname, $pass);
?>