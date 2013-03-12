<?php
date_default_timezone_set("America/Caracas");

// ////////////////// Actualiza Mongo

function statusd($numero, $mensaje, $modem)
	{
	$host = $_ENV["OPENSHIFT_MONGODB_DB_HOST"];
	$user = $_ENV["OPENSHIFT_MONGODB_DB_USERNAME"];
	$passwd = $_ENV["OPENSHIFT_MONGODB_DB_PASSWORD"];
	$port = $_ENV["OPENSHIFT_MONGODB_DB_PORT"];
	$db = "api";
	$connect = "mongodb://" . $user . ":" . $passwd . "@" . $host . ":" . $port;
	$m = new Mongo($connect);
	$db = $m->selectDB($db);
	$modo = "sms";
	$collection = $db->smsout;
	$collection->update(array(
		"numero" => $numero,
		"mensaje" => $mensaje
	) , array(
		'$set' => array(
			"status" => "delivered",
			"modem" => $modem
		)
	) , array(
		"multiple" => true
	));
	}

// /////////////// Push

function pushover($mensaje)
	{
	curl_setopt_array($ch = curl_init() , array(
		CURLOPT_URL => "https://api.pushover.net/1/messages.json",
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_POSTFIELDS => array(
			"token" => "bziHoGmCt1dcSxSgvpOtpVMOXkzuKm",
			"user" => "qDwFKeHeeeIcFxoGvkHJDBmqgW7r80",
			"title" => "Server Status:",
			"message" => $mensaje,
			"priority " => "1",
		)
	));
	curl_exec($ch);
	curl_close($ch);
	}

//////// Revisa si esta en linea

function online($url)
	{
	if ($url == "http://smsdroid.dyndns.tv:9999/")
		{
		$timeout = 30;
		}
		else
		{
		$timeout = 3;
		}
		
	$handle = curl_init(urldecode($url));
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $timeout);
	$response = curl_exec($handle);
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	if ($httpCode >= 200 && $httpCode < 400)
		{
		return true;
		}
	  else
		{
		return false;
		}

	curl_close($handle);
	}

// ///////////// Funciones para los Modem

function nueve900($numero, $txt)
	{
	$server = "http://home.gerswin.com:9900";
	$mensaje = urlencode($txt);
	$str = "?PhoneNumber=" . $numero . "&Text=" . $mensaje;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $server . $str);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 3);
	$retorno = curl_exec($ch);
	curl_close($ch);
	return $retorno;
	}

function nueve901($numero, $txt)
	{
	$server = "http://home.gerswin.com:9901";
	$mensaje = urlencode($txt);
	$str = "?PhoneNumber=" . $numero . "&Text=" . $mensaje;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $server . $str);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 3);
	$retorno = curl_exec($ch);
	curl_close($ch);
	return $retorno;;
	}

function android($numero, $txt)
	{
	$server = "http://smsdroid.dyndns.tv:9999/sendsms?";
	$mensaje = urlencode($txt);
	$str = "password=1234&phone=" . $numero . "&text=" . $mensaje;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $server . $str);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 20);
	$retorno = curl_exec($ch);
	curl_close($ch);
	return $retorno;
	}

////////////////////////////////// Esta Corriendo?
function runing($status)
	{	
	$fp = fopen("daemon.run", "w");
	fwrite($fp, $status);
	fclose($fp);
	}

// ///////////// Seleccionamos la Funcion para el Modem

function enviasms($numero, $mensaje)
	{
	if (online("http://home.gerswin.com:9900/") == true)
		{
		$modem = "nueve900";
		}
	elseif (online("http://home.gerswin.com:9901/") == true)
		{
		$modem = "nueve901";
		}
	elseif (online("http://smsdroid.dyndns.tv:9999/") == true)
		{
		$modem = "android";
		}
	  else
		{
		pushover("Ningun Modem Disponible");
		runing("NO");
		exit();
		}

	$todo = $modem($numero, $mensaje);
	echo $todo;
	$sucess = "Message Submitted";
	$sucessa = "Mesage SENT!";
	$status = strpos($todo, $sucess);
	$statusa = strpos($todo, $sucessa);
	if ($status !== FALSE)
		{
		statusd($numero, $mensaje, $modem);
		return true;
		}
	elseif ($statusa !== FALSE)
		{
		statusd($numero, $mensaje, $modem);
		return true;
		}
	else
		{
		return false;
		}
	}
runing("SI");
$cuenta = 0;
while ($cuenta <= 10)
	{
	$cuenta++;
	$host = $_ENV["OPENSHIFT_MONGODB_DB_HOST"];
	$user = $_ENV["OPENSHIFT_MONGODB_DB_USERNAME"];
	$passwd = $_ENV["OPENSHIFT_MONGODB_DB_PASSWORD"];
	$port = $_ENV["OPENSHIFT_MONGODB_DB_PORT"];
	$db = "api";
	$connect = "mongodb://" . $user . ":" . $passwd . "@" . $host . ":" . $port;
	$m = new Mongo($connect);
	$db = $m->selectDB($db);
	$modo = "sms";
	$collection = $db->smsout;
	$cursor = $collection->find(array(
		'status' => 'accepted'
	))->limit(5);
	foreach($cursor as $obj)
		{
		enviasms($obj['numero'], $obj['mensaje']);
		sleep(3);
		}
	}
runing("NO");
exit();
