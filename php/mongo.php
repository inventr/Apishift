<?php
date_default_timezone_set("America/Caracas"); 	
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
		"url" => $url
	);
	$collection->insert($obj);
	}
	
echo mongo ("testapi","343242343432","041256589","ola ke ase como va todo2","delivered");
echo "algo";

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
$cursor = $collection->find()->limit(2);

foreach($cursor as $obj)
	{
	echo $obj["date"]."  " . $obj["tiempo"]."  " . $obj["api"]."  " . $obj["modo"]."  " . $obj["numero"]."  " . $obj["mensaje"]."  " . $obj["url"] . "</br>"; 
	}

?>
