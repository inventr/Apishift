<?phpdate_default_timezone_set("America/Caracas");$host = $_ENV["OPENSHIFT_MONGODB_DB_HOST"];$user = $_ENV["OPENSHIFT_MONGODB_DB_USERNAME"];$passwd = $_ENV["OPENSHIFT_MONGODB_DB_PASSWORD"];$port = $_ENV["OPENSHIFT_MONGODB_DB_PORT"];$db = "api";$connect = "mongodb://" . $user . ":" . $passwd . "@" . $host . ":" . $port;$m = new Mongo($connect);$db = $m->selectDB($db);$modo = "sms";$collection = $db->smsin;$cursor = $collection->find();if (isset($_GET["limit"]))	{	$limit = $_GET["limit"];	}  else	{	$limit = 25;	}$cursor = $collection->find()->limit($limit);$cursor->sort(array(	'tiempo' => - 1));echo "<table border='1'><tr><th>API Origen</th><th>Fecha</th><th>Prefijo</th><th>Numero</th><th>Mensaje</th><th>Completo</th></tr>";foreach($cursor as $obj)	{	echo "<tr>";	echo "<td>" . $obj['api'] . "</td>";	echo "<td>" . date('Y-m-d H:i:s', $obj['tiempo']) . "</td>";	echo "<td>" . $obj['codigo'] . "</td>";	echo "<td>" . $obj['numero'] . "</td>";	echo "<td>" . $obj['mensaje'] . "</td>";	echo "<td>" . $obj['full'] . "</td>";	echo "</tr>";	}echo "</table>";?>