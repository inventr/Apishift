<?php
require "whatsprot.class.php";

// phone number, IMEI, and name, the IMEI is reversed
// and hashed in whatsprot.class.php so just put your
// IMEI here as it is!
// $options = getopt("d::", array("debug::"));
// $debug = (array_key_exists("debug", $options) || array_key_exists("d", $options)) ? true : false;

$w = new WhatsProt("14073377593", "971931531931985", "John Doe");
$w->Connect();
$w->Login();

// $w->Message(time() . "-1", "584165745046", "yürp");

$R = "1";

while ($R <= 5)
	{
	$w->PollMessages();
	$msgs = $w->GetMessages();
	foreach($msgs as $m)
		{
		$fp = fopen("data.xml", "w");
		fwrite($fp, ($m->NodeString("") . "\n") . PHP_EOL);
		fclose($fp);
		if (file_exists('data.xml'))
			{
			$xml = simplexml_load_file('data.xml');
			$simple = simplexml_load_string($xml);
			$arr = json_decode(json_encode($xml) , 1);

			//	echo $arr['@attributes']['from'];

			echo '<pre>';
			print_r($arr);
			//echo $arr['@attributes']['from'];
			//echo $arr['body'];
			echo '</pre>';

			// Esto Compara el Numero con el de Whastapp
			// $from = "04165745046";

		//	$numero = substr($from, -14);

			// $cadena = ;

			
			//$buscar = $numero;
			//$resultado = strpos($cadena, $buscar);

			// Si es igual entonces

			if (empty($arr['body']))
				{
				//echo '$var es o bien 0, vacía, o no se encuentra definida en absoluto';
				}
			  else
				{
				$conexion = mysql_connect("dbone.gerswin.com", "sandbox", "16745665");
				mysql_select_db("whastapp", $conexion);

				// Revisar Duplicados
			
				$fromsql = substr($arr['@attributes']['from'],0, -15);
				$to = "14073377593";
				$dup = $arr['@attributes']['t'];
				$msgql = $arr['body'];
				$consulta = "select * from entrantes where tiempo='$dup' or msg= '$msgql' ";				
				$resultado = mysql_query($consulta) or die(mysql_error());
				if (mysql_num_rows($resultado) == 0)
					{
					$query = " INSERT INTO entrantes (idw, de, para, tiempo, msg, fromname)";
					$query.= " VALUES ('" . $arr['@attributes']['id'] . "','" . $fromsql . "','" . $to . "','" . $arr['@attributes']['t'] . "','" . $arr['body'] . "','" . $arr['notify']['@attributes']['name'] . "')";
				//	echo '<br />';
				//	echo $query;
				//	echo '<br/>';
					$res = mysql_query($query, $conexion) or die(mysql_error());

					// mostramos el ID del registro

				//	echo mysql_insert_id();
					}


				}
			}
		  else
			{
			exit('Error abriendo test.xml.');
			}
		}

	$R++;
	}
?>

