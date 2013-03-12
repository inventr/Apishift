<?php
date_default_timezone_set("America/Caracas");
require ('wapi/whatsprot.class.php');

function mongo($api, $url, $numero, $mensaje, $status)
	{
	$username = $_ENV['OPENSHIFT_MONGODB_DB_USERNAME'];
	$password = $_ENV['OPENSHIFT_MONGODB_DB_PASSWORD'];
	$hostname = $_ENV['OPENSHIFT_MONGODB_DB_HOST'];
	$port =  $_ENV['OPENSHIFT_MONGODB_DB_PORT'];
	$db = "api";
	$name = $mongo_config["name"];
	$connect = "mongodb://${username}:${password}@${hostname}:${port}/${db}";
	$m = new Mongo($connect);
	$db = $m->selectDB($db); 
	$modo = "sms";
	$collection = $db->smsout;
	$obj = array(
		"date" => date('dmy'),
		"tiempo" => time() ,
		"api" => $api,
		"modo" => $modo,
		"numero" => $numero,
		"mensaje" => $mensaje,
		"status" => $status,
		"dlt" => time(),
		"modem" => "unknow",
		"url" => $url
		
	);
	$collection->insert($obj);
	}

function sms($api, $url, $numero, $txt)
	{	
	
	$id = time();
	$response = json_encode(array(
		'status' => 'aceptado',
		'id' => $id
	));
	mongo ($api, $url, $numero, $txt,"accepted");
	
	

return $response;
}



