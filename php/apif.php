<?php
date_default_timezone_set("America/Caracas");
require ('wapi/whatsprot.class.php');

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
		"dlt" => time(),
		"modem" => "unknow",
		"url" => $url
		
	);
	$collection->insert($obj);
	}

function sms($api, $url, $numero, $txt)
	{
	function mcredit($api, $url)
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
		$sql = "SELECT * FROM apis WHERE api='$api'";
		$count = $dbh->query($sql);
		$result = $count->fetchAll();
		if (!empty($result))
			{
			foreach($result as $row)
				{
				$resta = $row['credito'] - 1;

				// echo $resta;

				$sql = "UPDATE apis SET credito = '$resta' WHERE api='$api'";
				$count = $dbh->query($sql);
				$dbh = null;
				}
			}
		}

	function dbstore($api, $url, $destino, $mensaje)
		{
		$fecha = time();
		$modo = "sms";
		$status = "accepted";
		$services_json = json_decode(getenv("VCAP_SERVICES") , true);
		$mysql_config = $services_json["mysql-5.1"][0]["credentials"];
		$username = $mysql_config["username"];
		$password = $mysql_config["password"];
		$hostname = $mysql_config["hostname"];
		$port = $mysql_config["port"];
		$db = $mysql_config["name"];
		$dns = "mysql:host=" . $hostname . ";dbname=" . $db;
		$dbh = new PDO($dns, $username, $password);	
		//$count = $dbh->exec($query);
		// $dbh = null;
		$query2 = "INSERT INTO smsout (api,destino,fecha,modo,mensaje,url,status) VALUES ('$api','$destino','$fecha','$modo','$mensaje','$url','$status')";
		$count2 = $dbh->exec($query2);
		$dbh = null;
		}
	$id = time();
	$response = json_encode(array(
		'status' => 'aceptado',
		'id' => $id
	));
	mcredit($api, $url);
	dbstore($api, $url, $numero, $txt);
	mongo ($api, $url, $numero, $txt,"accepted");
	
	

return $response;
}

function apic($api, $url)
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
	$sql = "SELECT * FROM apis WHERE api='$api'";
	$count = $dbh->query($sql);
	$result = $count->fetchAll();
	if (!empty($result))
		{
		$status = TRUE;
		}
	  else
		{
		$status = FALSE;
		}

	return $status;
	}

function whatsapp($api, $url, $pais, $numero, $nick, $mensaje)
	{
	function dbstore($api, $url, $destino, $mensaje)
		{
		$fecha = date('dmy');
		$modo = "whatsapp";
		$services_json = json_decode(getenv("VCAP_SERVICES") , true);
		$mysql_config = $services_json["mysql-5.1"][0]["credentials"];
		$username = $mysql_config["username"];
		$password = $mysql_config["password"];
		$hostname = $mysql_config["hostname"];
		$port = $mysql_config["port"];
		$db = $mysql_config["name"];
		$dns = "mysql:host=" . $hostname . ";dbname=" . $db;
		$dbh = new PDO($dns, $username, $password);
		$query = ("SET timezone = '-4:30'");
		$count = $dbh->exec($query);
		$dbh = null;
		$query = "INSERT INTO smsout (api,destino,modo,mensaje,url) VALUES ('$api','$destino','$modo','$mensaje','$url')";
		$count = $dbh->exec($query);
		$dbh = null;
		}

	$fromMobNumber = "14073377593"; //Numero de Whatsapp
	$toMobNumber = $pais . $numero;
	$id = "pqaJLZLfqgQE8cpjB/gQbXvOMeo=";

	// $nick = "Gerswin SMS";

	$w = new WhatsProt($fromMobNumber, $id, $nick);
	$w->Connect();
	$w->Login();
	$w->sendNickname($nick);
	$w->Message($toMobNumber, $mensaje);
	sleep(1);
	$o = "OK";
	dbstore($api, $url, $numero, $mensaje);
	return $o;
	}

function dbstorw($api, $url, $destino, $mensaje, $modo)
	{
	$fecha = date('dmy');
	$services_json = json_decode(getenv("VCAP_SERVICES") , true);
	$mysql_config = $services_json["mysql-5.1"][0]["credentials"];
	$username = $mysql_config["username"];
	$password = $mysql_config["password"];
	$hostname = $mysql_config["hostname"];
	$port = $mysql_config["port"];
	$db = $mysql_config["name"];
	$dns = "mysql:host=" . $hostname . ";dbname=" . $db;
	$dbh = new PDO($dns, $username, $password);
	$query = "INSERT INTO bulkout (api,destino,modo,mensaje) VALUES ('$api','$url','$destino','$modo','$mensaje')";
	$count = $dbh->exec($query);
	$dbh = null;
	}

function getIP()
	{
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	  else
	if (isset($_SERVER['HTTP_VIA'])) $ip = $_SERVER['HTTP_VIA'];
	  else
	if (isset($_SERVER['REMOTE_ADDR'])) $ip = $_SERVER['REMOTE_ADDR'];
	  else $ip = null;
	return $ip;
	}

function saldo($api, $url)
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
	$sql = "SELECT * FROM apis WHERE api='$api'";
	$count = $dbh->query($sql);
	$result = $count->fetchAll();
	if (!empty($result))
		{
		foreach($result as $row)
			{
			$saldo = json_encode(array(
				"saldo" => $row['credito']
			));
			$dbh = null;
			}
		}

	return $saldo;
	}

function enviados($api, $url)
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
	$sql = "SELECT COUNT(*) FROM smsout WHERE api='$api'";
	$count = $dbh->query($sql);
	$result = $count->fetchColumn();
	if (!empty($result))
		{
		$saldo = json_encode(array(
			"enviados" => $result
		));
		$dbh = null;
		}
	  else
		{
		$saldo = json_encode(array(
			'enviados' => 'error'
		));
		}

	return $saldo;
	}

function status()
	{
	function urlUP($url)
		{
		$handle = curl_init(urldecode($url));
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 3);
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

	function pushn($mensaje)
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

	if (urlUP("http://home.gerswin.com:90"))
		{
		if (urlUP("http://home.gerswin.com:9900"))
			{
			$xml = simplexml_load_file('http://home.gerswin.com:9900/admin/xmlstatus?user=gerswin&password=16745665');
			$status = $xml->SMSCStatus->Status;
			if ($status != "OK")
				{
				pushn("Modem Principal Error, Probando Server 2");
				if (urlUP("http://home.gerswin.com:9901"))
					{
					$xml1 = simplexml_load_file('http://home.gerswin.com:9901/admin/xmlstatus?user=gerswin&password=16745665');
					$status1 = $xml1->SMSCStatus->Status;
					if ($status1 = "OK")
						{
						$fp = fopen("status.txt", "w");
						fwrite($fp, "2");
						fclose($fp);
						}
					  else
						{
						$statusr = json_encode(array(
							'server' => '2FAIL'
						));
						}
					}
				  else
					{
					$statusr = json_encode(array(
						'server' => '3FAIL'
					));
					}
				}
			  else
				{
				$statusr = json_encode(array(
					'server' => 'OK'
				));
				$fp = fopen("status.txt", "w");
				fwrite($fp, "OK");
				fclose($fp);
				}
			}
		  else
			{
			if (urlUP("http://home.gerswin.com:9901"))
				{
				$xml1 = simplexml_load_file('http://home.gerswin.com:9901/admin/xmlstatus?user=gerswin&password=16745665');
				$status1 = $xml1->SMSCStatus->Status;
				if ($status1 = "OK")
					{
					$fp = fopen("status.txt", "w");
					fwrite($fp, "2");
					fclose($fp);
					}
				  else
					{
					$statusr = json_encode(array(
						'server' => 'TOO FAIL'
					));
					}
				}
			}
		}
	  else
		{
		pushn("Server Down");
		$statusr = json_encode(array(
			'server' => 'FAIL'
		));
		}

	return $statusr;
	}