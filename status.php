<?php
error_reporting(E_ALL);
if (isset($_GET["status"]))
	{
	$modem = $_GET["status"];
	$fp = fopen("status.txt", "w");
				fwrite($fp, $modem);
				fclose($fp);
	}