<?
//header('Content-Type: text/html; charset=iso-8859-1');
header('Content-Type: text/html; charset=utf-8');
include("../../libreria.php");
include("../../connection.php");
include("../funciones.php");

$idMetodologia		= $_POST['idMetodologia'];
$contMetodologias	= $_POST['contMetodologias'];
$idDiv				= $_POST['idDivM'];

$sql = "SELECT * FROM ".tablaMetodologia." WHERE id_metodologia=$idMetodologia";
//echo '<BR>'.$sql;
$nom_metodologia		= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_tipo_metodologia= $campos["id_tipo_metodologia"];
	$nom_metodologia	= utf8_encode($campos["nom_metodologia"]);
}
$ind		= $contMetodologias;
$nameObjM	= nameObjMetodologias."[$ind]";
$idObjM		= 'metodologia'.$idMetodologia;
$obj		= "<INPUT type='checkbox' name='$nameObjM' id='$idObjM' value='$idMetodologia' checked='checked' style='display:none' />";
echo $obj;

include("sql_tarifario.php");

if($id_tipo_metodologia==1){
	//---- Grupos
	include("id_metodologia1.php");
}
elseif($id_tipo_metodologia==22){
	//---- Grupos
	include("id_metodologia2.php");
}
elseif($id_tipo_metodologia==3){
	//---- Grupos
	include("id_metodologia3.php");
}
?>
<div><img src="/imagenes/spacer.gif" border="0" height="10"></div>
