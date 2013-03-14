<?php
error_reporting(E_ALL);
include ('apif.php');

$url = getIP();

if (isset($_GET["nick"]))
	{
	$nick = $_GET["nick"];
	}
  else
	{
	$nick = "Gerswin SMS";
	}

if (isset($_GET["api"]))
	{
	$api = $_GET["api"];
	//$apicheck = apic($api, $url);
	$apicheck = TRUE;
	if ($apicheck == TRUE)
		{
		if (isset($_GET["modo"]))
			{
			$modo = $_GET["modo"];
			if (isset($_GET["numero"]))
				{
				$numero = $_GET["numero"];
				$mensaje = $_GET["mensaje"];
				}

			if (isset($_GET["pais"]))
				{
				$pais = $_GET["pais"];
				}

			switch ($modo)
				{
			case "sms":
				$codigos = array(
					"0416",
					"0426",
					"0414",
					"0424",
					"0412"
				);
				$numero=str_replace(array('/','*','-','+','.'),'',$numero);
				$codigo = substr($numero, 0, 4);
				if (strlen($numero) == 11)
					{
					if (in_array($codigo, $codigos))
						{						
						print sms($api, $url, $numero, $mensaje);
						}
					  else
						{
						$response = json_encode(array(
							'status' => 'enviado',
							'id' => "0"
						));
						echo $response;
						}
					}
				  else
					{
					$response = json_encode(array(
						'status' => 'enviado',
						'id' => "0"
					));
					echo $response;
					}

				break;

			case "whatsapp":
				echo whatsapp($api, $url, $pais, $numero, $nick, $mensaje);
				break;

			case "saldo":
				echo saldo($api, $url);
				break;

			case "enviados":
				echo enviados($api, $url);
				break;

			case "repuestas":
				echo "replys";
				break;
				}
			}
		}
	  else
		{
		$response = json_encode(array(
			'status' => 'API mal llamada.'
		));
		echo $response;
		}
	}
elseif (isset($_GET["server"]))
	{
	$server = $_GET["server"];
	if ($server = "status")
		{
		echo status();
		}
	}
	else
	{
echo "Ola ke ase, kiere sms o ke ase?";
	}