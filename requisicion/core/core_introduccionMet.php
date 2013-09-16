<?
include("connection.php");
function introduccionMet(){

$conexion = dbConnect();
$consulta=mysql_query("SELECT p.introduccion_met FROM prop_propuesta p WHERE p.id_propuesta=1") or die(mysql_error());

while($campos			= mysql_fetch_array($consulta)){
	$introduccion_met= $campos["introduccion_met"];
	}
	mysql_close($conexion);
	return $introduccion_met;
}

	?>