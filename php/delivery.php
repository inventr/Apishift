<?php
error_reporting(E_ALL);
function ustatus($status, $numero, $mensaje)
		{
		$services_json = json_decode(getenv("VCAP_SERVICES") , true);
		$mysql_config = $services_json["mysql-5.1"][0]["credentials"];
		$username = $mysql_config["username"];
		$password = $mysql_config["password"];
		$hostname = $mysql_config["hostname"];
		$port = $mysql_config["port"];
		$db = $mysql_config["name"];
		$dns = "mysql:host=" . $hostname . ";dbname=" . $db;
		$dbh = new PDO($dns, $username, $password);
		$sql = "UPDATE smsout SET status = 'send' WHERE destino='$numero' AND mensaje='$mensaje'";
		$count = $dbh->query($sql);		
		}
if (isset($_GET["status"]))
	{
	$status = $_GET["status"];
	$mensaje = $_GET["mensaje"];
	$numero = $_GET["numero"];
	$data = $status.$mensaje.$numero."\n";	
	if ($status == "OK")
		{
		ustatus($status, $numero, $mensaje);
		}
	
	}