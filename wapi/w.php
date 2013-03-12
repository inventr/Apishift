<?php

// /$num = $_POST["numero"];
// $to = "58".$num;
// $msg = $_POST["msg"];

require "whatsprot.class.php";

$w = new WhatsProt("14073377593", "971931531931985", "Sistema gerswin.com");
$w->Connect();
$w->Login();

// $w->Message(time() . "-1", $to, $msg);
// $w->Message(time() . "-1", $to, "oro color");
$w->Message(time() . "-1", "584165745046", "oro color");

$i=1;
while($i<=10)
	{
	$w->PollMessages();
	$msgs = $w->GetMessages();	
	foreach($msgs as $m)

		{
		echo ("<pre>");
		var_dump($m->NodeString("") . "\n");
		//$b = array (($m->NodeString("") . "\n"));
	//	print_r ($b);
		echo ("</pre>");
		
		$fp = fopen("info.xml", "w");
		fwrite($fp, ($m->NodeString("") . "\n") . PHP_EOL);		
		//print_r(($m->NodeString("") . "\n"));
		fclose($fp);
		}
	$i++;	
	}
?>
