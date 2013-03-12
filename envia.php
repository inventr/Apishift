<?php

// FUNCIÓN DE CONEXIÓN CON LA BASE DE DATOS MYSQL

function conectaDb()
	{
	try
		{
		$con = new PDO('mysql:host=199.96.156.125;dbname=gerswinc_smsgerswin', 'gerswinc_smsg', '3e4nmh590luk'); < ? phpclassDBConnection
			{
			private $_db = array();
			/* Nuestro */
			public

			function setDB($key, $dns, $username, $password)
				{
				try
					{
					if (!isset($this->_db[$key]))
						{
						$this->_db[$key] = new PDO($dns, $username, $password, array(
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
						) /* EXPECIFICA QUE PDO NO VA A TRABAJAR EN MODO SILENCIOSO */);
						}
					  else
						{
						throw new Exception("Esta conexion ya ha sido tomada <i>$key</i>");
						}
					}

				catch(Exception $e)
					{ /* RETORNA UN ERROR DICIENDO QUE LA CONEXION YA EXISTE */
					die("ERROR: " . $e->getMessage());
					}

				catch(PDOException $e)
					{ /* RETORNA UN ERROR AL INSTANCIAR PDO */
					die("ERROR: " . $e->getMessage());
					}
				}

			public

			function getDB($key)
				{
				try
					{
					if (isset($this->_db[$key]))
						{
						return $this->_db[$key];
						}
					  else
						{
						throw new Exception("Esta conexion no existe");
						}
					}

				catch(Exception $e)
					{
					die("ERROR: " . $e->getMessage());
					}
				}
			}
		}
	}
$db = new DBConnection();

		// Abastacemos nuestra con la cantidad de conexiones a trabajar usando una CLAVE

$db->setDB('base1', 'mysql:host=199.96.156.125;dbname=gerswinc_smsgerswin', 'gerswinc_smsg', '3e4nmh590luk');

// Recuperamos nuestra conexion usando la CLAVE que especificamos

$db1 = $db->getDB('base1');

// Para cerrar una conexion liberamos el objeto haciendo un NULL
$sql = 'SELECT *  FROM transmitidos ORDER BY RAND()'; 
$nb = $db1->exec($sql); 
echo = $nb;


$db1 = null;