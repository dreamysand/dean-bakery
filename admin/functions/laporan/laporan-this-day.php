<?php
$laporan = new Laporan();
$table_transaksi = "transaksi";
$table_produk = "detail_produk";

$total_modal_hari_ini = 0;
$total_penjualan_hari_ini = 0;
$total_keuntungan_hari_ini = 0;

$result_transaksi = $laporan->SelectLaporanThisDay();
$result_modal = $laporan->SelectModalProduk();

foreach ($result_transaksi as $row_transaksi) {
	$total_penjualan_hari_ini += $row_transaksi['total_harga'];
}

foreach ($result_modal as $row_modal) {
	$total_modal_hari_ini += $row_modal['modal'];
}

$total_keuntungan_hari_ini = $total_penjualan_hari_ini - $total_modal_hari_ini;
?>