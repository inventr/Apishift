<?phpdate_default_timezone_set("America/Caracas");  session_start();$services_json = json_decode(getenv("VCAP_SERVICES") , true);$mysql_config = $services_json["mysql-5.1"][0]["credentials"];$username = $mysql_config["username"];$password = $mysql_config["password"];$hostname = $mysql_config["hostname"];$port = $mysql_config["port"];$db = $mysql_config["name"];$dns = "mysql:host=" . $hostname . ";dbname=" . $db;session_start();$con = mysql_connect($hostname, $username, $password);if (!$con)  {  die('Could not connect: ' . mysql_error());  }mysql_select_db($db, $con);$sql="SELECT * FROM smsout ORDER BY id DESC LIMIT 25";//print_r ($sql);$result = mysql_query($sql);echo "<table border='1'><tr><th>API</th><th>Numero</th><th>Fecha</th><th>Mensaje</th><th>Status</th></tr>";while($row = mysql_fetch_array($result))  {  echo "<tr>";  echo "<td>" . $row['api'] . "</td>";   echo "<td>" . $row['destino'] . "</td>";  echo "<td>" . date('Y-m-d H:i:s', $row['fecha']). "</td>";  echo "<td>" . $row['mensaje'] . "</td>";  echo "<td>" . $row['status'] . "</td>";  echo "</tr>";  }echo "</table>";//$idw = substr($row['idw'],10);//$_SESSION["idw"] = $idw;//print_r ($_SESSION["numero"]);mysql_close($con);?>