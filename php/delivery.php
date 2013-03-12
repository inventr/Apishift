<?php
error_reporting(E_ALL);

function ustatus($status, $numero, $mensaje)
	{
	$host = $_ENV["OPENSHIFT_MONGODB_DB_HOST"];
	$user = $_ENV["OPENSHIFT_MONGODB_DB_USERNAME"];
	$passwd = $_ENV["OPENSHIFT_MONGODB_DB_PASSWORD"];
	$port = $_ENV["OPENSHIFT_MONGODB_DB_PORT"];
	$db = "api";
	$connect = "mongodb://" . $user . ":" . $passwd . "@" . $host . ":" . $port;
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