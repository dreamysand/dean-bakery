<?php
$laporan = new Laporan();
$table_transaksi = "transaksi";
$table_produk = "detail_produk";

$total_modal = 0;
$total_penjualan = 0;
$total_keuntungan = 0;

if (isset($_GET['tahun'], $_GET['bulan'], $_GET['tanggal']) && 
	(!empty($_GET['tahun']) ||
	!empty($_GET['bulan']) ||
	!empty($_GET['tanggal']))) {
	$tahun = !empty($_GET['tahun']) ? $_GET['tahun'] : null;
	$bulan = !empty($_GET['bulan']) ? $_GET['bulan'] : null;
	$tanggal = !empty($_GET['tanggal']) ? $_GET['tanggal'] : null;

	$result_transaksi = $laporan->SelectLaporan($tahun, $bulan, $tanggal);
	$result_modal = $laporan->SelectModalProduk();
} else {
	$result_transaksi = $laporan->SelectAllLaporan();
	$result_modal = $laporan->SelectModalProduk();
}

foreach ($result_transaksi as $row_transaksi) {
	$total_penjualan += $row_transaksi['total'];
	foreach ($result_modal as $row_modal) {
		$total_modal += $row_modal['modal'];
	}
}
echo $total_modal;

$total_keuntungan = $total_penjualan - $total_modal;
?>