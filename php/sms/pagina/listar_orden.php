<html>
<head>
	<title>Pagina</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script language="javascript" type="text/javascript" src="funciones/jquery-1.7.2.min.js"></script>
	<link href="css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="css/tablecloth.js"></script>
</head>
<body>

<script type="text/javascript">
	$(document).ready(function() {    
    		$("#paginar").live("click", function(){
		$("#contenido").html("<div align='center'><img src='imagenes/cargando.gif'/></div>");
			var pagina=$(this).attr("data");
			var cadena="pagina="+pagina;

			$.ajax({
            			type:"GET",
            			url:"listar_busqueda.php",
            			data:cadena,
            			success:function(data)
            			{
                				$("#contenido").fadeIn(1000).html(data);
            			}
        			});
    		});
	});  
</script>

<div id="contenido"><?php require("listar_busqueda.php"); ?></div>

</body>
</html>