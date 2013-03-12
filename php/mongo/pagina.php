<?php
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
	$collection = $db->smsout;
 
$page  = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 2;
$skip  = ($page - 1) * $limit;
$next  = ($page + 1);
$prev  = ($page - 1);
$sort  = array('tiempo' => -1);
 
$cursor = $collection->find()->skip($skip)->limit($limit)->sort($sort);
foreach ($cursor as $r) {
    echo sprintf('<p>Added on %s. Last viewed on %s. Viewed %d times. </p>', $r['tiempo'], $r['mensaje'], $r['numero']);
}
 
if($page > 1){
    echo '<a href="?page=' . $prev . '">Previous</a>';
    if($page * $limit < $total) {
        echo ' <a href="?page=' . $next . '">Next</a>';
    }
} else {
    if($page * $limit < $total) {
        echo ' <a href="?page=' . $next . '">Next</a>';
    }
}
 
$mongodb->close();
?>