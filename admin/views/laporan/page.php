<?php
$dataPoints = array(
	array("a" => 20, "y" => 25, "label" => "Januari"),
	array("a" => 20, "y" => 15, "label" => "Februari"),
	array("a" => 20, "y" => 25, "label" => "Maret"),
	array("a" => 20, "y" => 5,  "label" => "April"),
	array("a" => 20, "y" => 10, "label" => "Mei"),
	array("a" => 20, "y" => 0,  "label" => "Juni"),
	array("a" => 20, "y" => 20, "label" => "Saturday")
);

// Pisahkan menjadi 2 array: modal (y) dan keuntungan (a)
$modalPoints = [];
$keuntunganPoints = [];

foreach ($dataPoints as $point) {
    $modalPoints[] = ["y" => $point["y"], "label" => $point["label"]];
    $keuntunganPoints[] = ["y" => $point["a"], "label" => $point["label"]];
}
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Grafik Modal & Keuntungan Harian"
	},
	axisY: {
		title: "Jumlah (Rp)"
	},
	toolTip: {
		shared: true
	},
	data: [
		{
			type: "line",
			name: "Modal",
			showInLegend: true,
			dataPoints: <?php echo json_encode($modalPoints, JSON_NUMERIC_CHECK); ?>
		},
		{
			type: "line",
			name: "Keuntungan",
			showInLegend: true,
			dataPoints: <?php echo json_encode($keuntunganPoints, JSON_NUMERIC_CHECK); ?>
		}
	]
});
chart.render();
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>
