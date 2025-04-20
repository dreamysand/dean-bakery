<?php
session_start();
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."config.php";
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."class.php";

$array_time = [
	"2025-03-19 20:00:00",
	"2025-03-19 10:00:00",
	"2025-03-19 19:00:00",
];
date_default_timezone_set("Asia/Jakarta");
$now_time = new DateTime();

$two_minute_ago = $now_time->modify("-1 hour");

echo $now_time->format("Y-m-d H:i:s");
echo "<br>";

for ($i=0; $i < count($array_time) ; $i++) { 
	$spec_time = new DateTime($array_time[$i]);

	if ($now_time->format("Y-m-d H:i:s") > $spec_time->format("Y-m-d H:i:s")) {
		echo "Gacor <br>";
	} else {
		echo "Gak gaor <br>";
	}
}
?>