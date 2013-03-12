<?php
function sms($numero, $txt)
	{
	$id = time();
	$mensaje = urlencode($txt);
	$str = "http://api.clickatell.com/http/sendmsg?user=gerswin&password=T8BGREl2&api_id=3396601&from=17862692587&mo=1&to=". $numero . "&text=" . $mensaje;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$str);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
	$retorno = curl_exec($ch);
	curl_close($ch);
	/*$buscar = "successnmessage";
	$status = strpos($retorno, $buscar);
	if ($status !== FALSE)
		{
		$response = json_encode(array(
			'status' => 'enviado',
			'id' => $id
		));
		}
	  else
		{
		$response = json_encode(array(
			"status" => "fallo el envio"
		));
		}

	return $response; */
	}
if (isset($_GET["PhoneNumber"]))
	{
	$numero = "58".substr($_GET["PhoneNumber"], -10);
	$mensaje= $_GET["Text"];
	echo sms($numero, $mensaje);
	}
	
?>
 