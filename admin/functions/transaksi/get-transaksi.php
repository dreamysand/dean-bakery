<?php 
$transaksi = isset($_SESSION['transaksi']) ? unserialize($_SESSION['transaksi']) : new Transaksi();
$transaksi_Data = $transaksi->GetTransaksi();
?>