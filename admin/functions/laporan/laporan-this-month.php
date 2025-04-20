<?php
$laporan = new Laporan();
$table_transaksi = "transaksi";
$table_produk = "detail_produk";

$result_transaksi = $laporan->SelectLaporanThisWeek();
$result_modal = $laporan->SelectModalProduk();

$total_modal_minggu_ini = 0;

$weeks = [];
$tahun = date("Y");
$bulan = date("m");
$start = new DateTime("$tahun-$bulan-01");
$end = new DateTime("Y-m-t");

while ($start <= $end) {
	$week_start = $start->format("Y-m-d");
	$week_end = $start->modify("+6 days")->format("Y-m-d");

	if ($week_end > $end->format("Y-m-d")) {
		$week_end = $end->format("Y-m-d");
	}

	$weeks[] = [
		"start" => $week_start,
		"start" => $week_start,
	];
}

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