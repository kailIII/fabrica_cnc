<?php
function diaespanol($valor){
$valor = strtotime($valor);
switch (date('w', $valor)){
case 0: $nombreDia ="Domingo"; break;
case 1: $nombreDia ="Lunes"; break;
case 2: $nombreDia ="Marates"; break;
case 3: $nombreDia ="Miercoles"; break;
case 4: $nombreDia ="Jueves"; break;
case 5: $nombreDia ="Viernes"; break;
case 6: $nombreDia ="Sabado"; break;
}
return $nombreDia;
}
//el dia desde el q comienzo a mostrar es recibido por get, en caso de no venir tomo como base el dia actual.
$dia = $_GET['dia'];
if($_GET['dia'] == ""){
$dia = date('Y-n-d');
}
//con este switch saco la fecha del dia inicial del calendario de la semana de 7 dias de domingo a sabado
$diaRecibido = $dia;
switch (date('w', strtotime($dia))){
case 0: $titleday = "Domingo"; $menos=0;
$iniciosemana = date("Y-m-d", strtotime("$diaRecibido -$menos day"));
//$iniciosemana = $diaRecibido;
break;
case 1: $titleday ="Lunes"; $menos=1;
$iniciosemana = date("Y-m-d", strtotime("$diaRecibido -$menos day"));
break;
case 2: $titleday ="Martes"; $menos=2;
$iniciosemana = date("Y-m-d", strtotime("$diaRecibido -$menos day"));
break;
case 3: $titleday ="Miercoles"; $menos=3;
$iniciosemana = date("Y-m-d", strtotime("$diaRecibido -$menos day"));
break;
case 4: $titleday ="Jueves"; $menos=4;
$iniciosemana = date("Y-m-d", strtotime("$diaRecibido -$menos day"));
break;
case 5: $titleday ="Viernes"; $menos=5;
$iniciosemana = date("Y-m-d", strtotime("$diaRecibido -$menos day"));
break;
case 6: $titleday ="Sabado"; $menos=6;
$iniciosemana = date("Y-m-d", strtotime("$diaRecibido -$menos day"));
break;
}
//creo los link de siguiente y anterior
$linkanterior = date("Y-m-d", strtotime("$iniciosemana -1 day"));
$linksiguiente = date("Y-m-d", strtotime("$iniciosemana +8 day"));
echo "Anterior $linkanterior – Siguiente $linksiguiente";
echo 'Dia recibido: '.$dia.', '.$titleday.' y el inicio de semana es : '.$iniciosemana.'';
//creo calendario
?>

<a href="?dia=">Semana Anterior
<a href="">Semana Actual
<a href="?dia=">Semana Siguiente

 
<?php
for($i=0; $i<7; $i++){
$mostrable = date("Y-m-d", strtotime("$iniciosemana +$i day"));
$titleday = diaespanol($mostrable);
echo ''.$titleday.".$mostrable.";
}
echo'

06:00Hrs
 
 
 
 
 
 
 

07:00Hrs
 
 
 
 
 
 
 

08:00Hrs
 
 
 
 
 
 
 

09:00Hrs
 
 
 
 
 
 
 

10:00Hrs
 
 
 
 
 
 
 

11:00Hrs
 
 
 
 
 
 
 

12:00Hrs
 
 
 
 
 
 
 

13:00Hrs
 
 
 
 
 
 
 

14:00Hrs
 
 
 
 
 
 
 

15:00Hrs
 
 
 
 
 
 
 

16:00Hrs
 
 
 
 
 
 
 

17:00Hrs
 
 
 
 
 
 
 

18:00Hrs
 
 
 
 
 
 
 

19:00Hrs
 
 
 
 
 
 
 

20:00Hrs
 
 
 
 
 
 
 

21:00Hrs
 
 
 
 
 
 
 

22:00Hrs
 
 
 
 
 
 
 

';
?>