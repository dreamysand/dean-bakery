<?php
session_start();
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."config.php";
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."class.php";
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."laporan".DIRECTORY_SEPARATOR."select-laporan.php";
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."laporan".DIRECTORY_SEPARATOR."laporan-this-day.php";
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."laporan".DIRECTORY_SEPARATOR."laporan-this-week.php";
require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."laporan".DIRECTORY_SEPARATOR."chart.php";
?>