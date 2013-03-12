<?php
require "whatsapp.class.php";

// DEMO OF USAGE
$wa = new WhatsApp("14073377593", md5(strrev ("971931531931985")), "Gerswin SMS");
$wa->Connect();
sleep(3);
$wa->Login();

//$wa->Message(time()."-1","584165745046","$bbcode");
 //$wa->RequestLastSeen("9733110772");
	
echo "<script language='javascript'>window.location='example.php'</script>"; 
?>




