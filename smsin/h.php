<?
function fecha(){
$mes = date('n');
$mesArray = array(
1 => 'Enero',
2 => 'Febrero',
3 => 'Marzo',
4 => 'Abril',
5 => 'Mayo',
6 => 'Junio',
7 => 'Julio',
8 => 'Agosto',
9 => 'Septiembre',
10 => 'Octubre',
11 => 'Noviembre',
12 => 'Diciembre'
);
$semana = date('D');
$semanaArray = array(
'Mon' => 'Lunes',
'Tue' => 'Martes',
'Wed' => 'Miercoles',
'Thu' => 'Jueves',
'Fri' => 'Viernes',
'Sat' => 'Sábado',
'Sun' => 'Domingo',
);
$mesReturn = $mesArray[$mes];
$semanaReturn = $semanaArray[$semana];
$dia = date('d');
$anio = date ('Y');
return $dia.' de '.$mesReturn.' del '.$anio;
}
echo date('h:i:s A');