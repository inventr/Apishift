<?php
date_default_timezone_set("America/Caracas");  
include("conexion.php");

$consulta_cantidad=mysql_query("SELECT * FROM smsout",$conexion);
$resultados_cantidad=mysql_num_rows($consulta_cantidad);

 if ($resultados_cantidad>0)
 {
    $filas_pagina=25;
    $numero_pagina=1;

    if(isset($_GET["pagina"]))
    {
        sleep(1);
        $numero_pagina=$_GET["pagina"];
    }

    $campo_de_inicio=($numero_pagina-1)*$filas_pagina;
    $total_registros=ceil($resultados_cantidad/$filas_pagina);

    echo "<table align='center'>";
    echo "<tr>";
        echo "<th>API</th>";
        echo "<th>Numero</th>";
        echo "<th>Mensaje</th>";
		echo "<th>Fecha</th>";
		echo "<th>Status</th>";
    echo "</tr>";

    $consulta=mysql_query("SELECT * FROM smsout ORDER BY id DESC LIMIT $campo_de_inicio, $filas_pagina",$conexion);
    while ($resultados=mysql_fetch_array($consulta))
    {
        echo "<tr>";
			echo "<td>" . $resultados['api'] . "</td>"; 
			echo "<td>" . $resultados['destino'] . "</td>";
			echo "<td>" . date('Y-m-d H:i:s', $resultados['fecha']). "</td>";
			echo "<td>" . $resultados['mensaje'] . "</td>";
			echo "<td>" . $resultados['status'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";

    echo "<br/>";

    if ($total_registros>1)
    {
        echo "<div align='center'>";

        if ($numero_pagina!=1)
            echo "<a id='paginar' data='".($numero_pagina-1)."'>Anterior</a> ";

            for ($i=1;$i<=$total_registros;$i++)
            {
                if($numero_pagina==$i)
                {
                    echo "<a>".$i."</a> ";
                }
                else
                {
                    echo "<a id='paginar' data='".$i."'>".$i."</a> ";
                }
            }
        
        if($numero_pagina!=$total_registros)
        {
            echo "<a id='paginar' data='".($numero_pagina+1)."'>Siguiente</a>";
        }

        echo "</div>";
    }
}

?>