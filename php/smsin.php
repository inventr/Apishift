<?php
error_reporting(E_ALL);
date_default_timezone_set("America/Caracas");

function mongo($codigo, $numero, $mensaje, $full)
	{
	function cualapi($numero, $full)
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
		$cursor = $collection->find();
		$cursor = $collection->find(array(
			'numero' => $numero
		))->limit(1);
		$cursor->sort(array(
			'tiempo' => - 1
		));
		foreach($cursor as $obj)
			{
			return $obj['api'];
			}
		}

	$qapi = cualapi($numero, $full);
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
	$collection = $db->smsin;
	$obj = array(
		"date" => date('dmy') ,
		"tiempo" => time() ,
		"codigo" => $codigo,
		"numero" => $numero,
		"mensaje" => $mensaje,
		"full" => $full,
		"api" => $qapi
	);
	$collection->insert($obj);
	}

if (isset($_GET["numero"]))
	{
	$codigo = $_GET["codigo"];
	$mensaje = $_GET["mensaje"];
	$full = $_GET["full"];
	$rawn = substr($_GET["numero"], 0, -9);
	if ($rawn == "+584")
		{
		$numero = "0" . substr($_GET["numero"], -10);
		}
	  else
		{
		if ($_GET["numero"][1] == "0")
		{
		$numero = substr($_GET["numero"],1 );
		}
		else
		{
		$numero = $_GET["numero"];
		}
		}

	$cadena = $_GET["full"];
	$buscar = "Mensaje Entregado";
	$buscar2 = "Mensaje No Entregado";
	$entregado = strpos($cadena, $buscar);
	$noentregado = strpos($cadena, $buscar2);
	if ($entregado === FALSE AND $noentregado === FALSE)
		{
		echo mongo($codigo, $numero, $mensaje, $full);
		}
	}

