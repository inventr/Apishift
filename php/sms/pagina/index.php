<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mensajes Salientes.</title>
<link href="css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="css/tablecloth.js"></script>
<script language="javascript" type="text/javascript" src="funciones/jquery-1.7.2.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Nova+Round' rel='stylesheet' type='text/css'>

<style>

body{
	margin:0;
	padding:0;
	background:#f1f1f1;
	font:70% Arial, Helvetica, sans-serif; 
	color:#555;
	line-height:150%;
	text-align:left;
}
a{
	text-decoration:none;
	color:#057fac;
}
a:hover{
	text-decoration:none;
	color:#999;
}
h1{
	font-size:140%;
	margin:0 20px;
	line-height:80px;	
}
h2{
	font-size:120%;
}
#container{
	margin:0 auto;
	width:800px;
	background:#fff;
	padding-bottom:20px;
}
#content{margin:0 20px;}
p.sig{	
	margin:0 auto;
	width:680px;
	padding:1em 0;
}
form{
	margin:1em 0;
	padding:.2em 20px;
	background:#eee;
}

.top {
	background-color: #1d5d89;
	font-family: 'Nova Round', cursive;
	font-size: 24px;
	color: #FFF;
	height: 40px;
	padding-top: 15px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 0px;
	margin-bottom: 40px;
}
</style>
<script type="text/javascript">
	$(document).ready(function() {    
    		$("#paginar").live("click", function(){
		$("#timediv").html("<div align='center'><img src='imagenes/cargando.gif'/></div>");
			var pagina=$(this).attr("data");
			var cadena="pagina="+pagina;

			$.ajax({
            			type:"GET",
            			url:"listar_busqueda.php",
            			data:cadena,
            			success:function(data)
            			{
                				$("#timediv").fadeIn(1000).html(data);
            			}
        			});
    		});
	});  
</script>
</head>

<body>

<div align="center" class="top" id="nav">
  API SMS
</div>
<div id="container">
	<div id="content">
		<h1>Mensajes Salientes</h1>	
		<div id="timediv">
		<?php require("listar_busqueda.php"); ?>
		</div>
	</div>
</div>
<p class="sig">API STATUS <a href="http://www.gerswin.com"> Gerswin Lee</a></p>
	
	
</body>
</html>
