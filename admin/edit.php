<?php
session_start();
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."config.php";
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."class.php";
if (isset($_GET['admin'])) {
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."admin-table".DIRECTORY_SEPARATOR."edit-admin.php";
	require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."admin-table".DIRECTORY_SEPARATOR."update-admin.php";
	require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."admin-table".DIRECTORY_SEPARATOR."edit-admin.php";
}
?>