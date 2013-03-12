<?php

function push($mensaje)
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

if (isset($_GET["mensaje"]))
	{
	$cadena = $_GET["mensaje"];
	$buscar = "Movistar te informa";
	$resultado = strpos($cadena, $buscar);
	if ($resultado !== FALSE)
		{
		echo push($cadena);
		}
	}
