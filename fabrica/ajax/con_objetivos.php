<?
// header('Content-Type: text/html; charset=iso-8859-1');
include("../../libreria.php");
include("../../connection.php");
$tipo_estudio	= $_POST['tipo_estudio'];

$result = array();

//----
$sql = "SELECT * FROM ".tablaObjetivoGeneral." WHERE id_tipo_estudio='$tipo_estudio' ORDER BY 1";
//echo '<BR>'.$sql;
$vbObjetivoGeneral			= NULL;
$con						= mysql_query($sql);
while($campos				= mysql_fetch_array($con)){
	$vbObjetivoGeneral		= $campos["objetivo_general"];
}
//----
$sql = "SELECT * FROM ".tablaObjetivoEspecifico." WHERE id_tipo_estudio='$tipo_estudio' ORDER BY 1";
//echo '<BR>'.$sql;
$objetivosEspecificos	= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	// $objetivosEspecificos	.= $campos["objetivo_especifico"];
	$result['objetivo_especifico'].= '<textarea name="objetivos_especificos[]" class="borderBlue" style="width:99%; height:40px; padding:5px; margin-top:5px;">'. trim($campos["objetivo_especifico"]) .'</textarea>';
}


$result['objetivo_general'] =  "<B>Objetivo General:</B><br /><TEXTAREA name='objetivo_general' id='objetivo_general' lang='1' title='' class='borderBlue' style='width:99%; height:60px; padding:5px;'>". $vbObjetivoGeneral ."</TEXTAREA>";

$result['objetivo_general'] = utf8_encode($result['objetivo_general']);
$result['objetivo_especifico'] = utf8_encode($result['objetivo_especifico']);

echo json_encode($result);