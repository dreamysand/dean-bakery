<?php
session_start();
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."config.php";
require dirname(__DIR__, 1).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."class.php";
require __DIR__.DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."member".DIRECTORY_SEPARATOR."select-member.php";
require __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."member".DIRECTORY_SEPARATOR."table.php";
?>