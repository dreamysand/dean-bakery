<?php
$laporan = new Laporan();
$table_transaksi = "transaksi";
$table_produk = "detail_produk";

$result_transaksi = $laporan->SelectLaporanThisWeek();
$result_modal = $laporan->SelectModalProduk();

$total_modal_minggu_ini = 0;

$nama_hari = ["Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis", "Friday" => "Jumat", "Saturday" => "Sabtu", "Sunday" => "Minggu"];
$dataPoints = [];

foreach ($nama_hari as $eng => $indo) {
    $dataPoints[$indo] = ["a" => 0, "y" => 0, "label" => $indo];
}


foreach ($result_modal as $row_modal) {
	$total_modal_minggu_ini += $row_modal['modal'];
}
foreach ($result_transaksi as $row_transaksi) {
	$day = $row_transaksi['hari'];
	$hari = $nama_hari[$day];
	$dataPoints[$hari]["y"] = $total_modal_minggu_ini;
	$dataPoints[$hari]["a"] = $row_transaksi['total'];   
}

// Pisahkan menjadi 2 array: modal (y) dan keuntungan (a)
$modalPoints = [];
$keuntunganPoints = [];

foreach ($dataPoints as $day => $point) {
    $modalPoints[] = ["y" => $point["y"], "label" => $day];
    $keuntunganPoints[] = ["y" => $point["a"], "label" => $day];
}
?>