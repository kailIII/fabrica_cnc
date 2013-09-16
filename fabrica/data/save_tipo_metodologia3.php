<?
header('Content-Type: text/html; charset=iso-8859-1');
include("../../libreria.php");
include("../../connection.php");

$idRowMetodologia	= $_POST['idRowMetodologia'];
$idPropuesta		= $_POST['idPropuesta'];
$vr_titulo			= utf8_decode($_POST['vr_titulo']);
$vr_temas			= utf8_decode($_POST['vr_temas']);
$vr_universo		= utf8_decode($_POST['vr_universo']);
$vr_marco			= utf8_decode($_POST['vr_marco']);

//---- guarda el diagnóstico
$sql_upload = "UPDATE ".tablaMetodologiaRTA."
	SET titulo='$vr_titulo',temas='$vr_temas',universo='$vr_universo',marco_estadistico='$vr_marco'
	 WHERE id_row_metodologia='$idRowMetodologia'";
//echo '<BR>'.$sql_upload;
if(mysql_query($sql_upload)){
//	$registrosCargados	= mysqli_affected_rows($linkdb);
}
else{
	echo "<div align='center' style='color:#CC3300;'>Atención!!! Error al guardar el diagnóstico, por favor intente nuevamente</div>".mysql_error();
}	
?>
