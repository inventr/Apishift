<?php
$services_json = json_decode(getenv("VCAP_SERVICES") , true);
$mysql_config = $services_json["mysql-5.1"][0]["credentials"];
$username = $mysql_config["username"];
$password = $mysql_config["password"];
$hostname = $mysql_config["hostname"];
$port = $mysql_config["port"];
$db = $mysql_config["name"];
$dns = "mysql:host=" . $hostname . ";dbname=" . $db;

$conexion=mysql_connect($hostname,$username,$password) or die("No se pudo crear la conexion con SQL.");
mysql_select_db($db,$conexion) or die("No se pudo crear la conexion con la base de datos con la base de datos.");

?>