<?php
date_default_timezone_set("America/Caracas");
require ('wapi/whatsprot.class.php');

function mongo($api, $url, $numero, $mensaje, $status)
	{
	$host   = $_ENV["OPENSHIFT_MONGODB_DB_HOST"];
     $user   = $_ENV["OPENSHIFT_MONGODB_DB_USERNAME"];
     $passwd = $_ENV["OPENSHIFT_MONGODB_DB_PASSWORD"];
     $port   = $_ENV["OPENSHIFT_MONGODB_DB_PORT"];    
	$db = "api";
	$connect = "mongodb://" . $user . ":" . $passwd . "@" . $host . ":" . $port;
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



