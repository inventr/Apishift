<?php
$dest = "04125345865";
$numero = "58".substr($dest, -10);
echo $numero;
echo "<pre>";
echo getenv("VCAP_SERVICES");

$dir = dirname(__FILE__);
echo "<p>Full path to this dir: " . $dir . "</p>";
echo "<p>Full path to a .htpasswd file in this dir: " . $dir . "/.htpasswd" . "</p>";

function dbstore($api, $url, $destino, $mensaje)
		{
		$fecha = date('dmy');
		$modo = "sms";
		$services_json = json_decode(getenv("VCAP_SERVICES") , true);
		$mysql_config = $services_json["mysql-5.1"][0]["credentials"];
		$username = $mysql_config["username"];
		$password = $mysql_config["password"];
		$hostname = $mysql_config["hostname"];
		$port = $mysql_config["port"];
		$db = $mysql_config["name"];
		$dns = "mysql:host=" . $hostname .";dbname=" . $db;
		$dbh = new PDO($dns, $username, $password);
		$query = "INSERT INTO smsout (api,url,destino,fecha,modo,mensaje) VALUES ('$api','$url','$destino','$fecha','$modo','$mensaje')";
		$count = $dbh->exec($query);
		$dbh = null;
		
		return $query;
		}
		
echo dbstore ("estaapi","gerswin.com","04125345765","hola k ase");
?>

