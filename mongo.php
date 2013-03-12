<?php
date_default_timezone_set("America/Caracas"); 	
function mongo($api, $url, $numero, $mensaje, $status)
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
		"url" => $url
	);
	$collection->insert($obj);
	}
	
mongo ("testapi","343242343432","041256589","ola ke ase como va todo2","delivered");


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
$modo = "sms";
$collection = $db->smsout;
$cursor = $collection->find()->limit(2);

foreach($cursor as $obj)
	{
	echo $obj["date"]."  " . $obj["tiempo"]."  " . $obj["api"]."  " . $obj["modo"]."  " . $obj["numero"]."  " . $obj["mensaje"]."  " . $obj["url"] . "</br>"; 
	}

?>
