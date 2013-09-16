<?
header('Content-Type: text/html; charset=iso-8859-1');
include("../../libreria.php");
include("../../connection.php");
$tipo_estudio	= $_POST['tipo_estudio'];

?>
<TEXTAREA name='objetivos_especificos[]' class='borderBlue' style='width:99%; height:40px; padding:5px; margin-top:5px;'></TEXTAREA>
