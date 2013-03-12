<?php
error_reporting(E_ALL);

function ustatus($status, $numero, $mensaje)
	{
	$services_json = json_decode(getenv("VCAP_SERVICES") , true);
	$mongo_config = $services_json["mongodb-1.8"][0]["credentials"];
	$username = $mongo_config["username"];
	$password = $mongo_config["password"];
	$hostname = $mongo_config["hostname"];
	$port = $mongo_config["port"];
	$db = $mongo_config["db"];
	$name = $mongo_config["name"];
	$connect = "mongodb://${username}:${password}@${hostname}:${port}/${db}";
	$m = new Mongo($connect);
	$db = $m->selectDB($db);
	$collection = $db->smsout;	
	$collection->update(
    array("numero" => $numero,"mensaje" => $mensaje),	
    array('$set' => array("status" => "send","dlt" => time())),
    array("multiple" => true));
	return "quiza";
	}

if (isset($_GET["status"]))
	{
	$status = $_GET["status"];
	$mensaje = $_GET["mensaje"];
	$numero = $_GET["numero"];
	$data = $status . $mensaje . $numero . "\n";
	if ($status == "OK")
		{
		echo ustatus($status, $numero, $mensaje);
		}
	}