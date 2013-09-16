<?
//----
$sql = "SELECT * FROM ".tablaPropuesta." WHERE id_propuesta='$idPropuesta'";

//echo '<BR>'.$sql;
$con						= mysql_query($sql);
while($campos				= mysql_fetch_array($con)){
	$titulo					= $campos["titulo"];
	$tituloPropuesta		= $campos["titulo"];
	$nom_cliente			= $campos["nom_cliente"];
	$empresa_cliente		= $campos["empresa_cliente"];
	$cargo_cliente			= $campos["cargo_cliente"];
	$email_cliente			= $campos["email_cliente"];
	$telefono_cliente		= $campos["telefono_cliente"];
	$celular_cliente		= $campos["celular_cliente"];
	$requerimiento_cliente	= $campos["requerimiento_cliente"];
	$elaborada_por			= $campos["elaborada_por"];
	$revisada_por			= $campos["revisada_por"];
	$tipo_estudio			= $campos["id_tipo_estudio"];
	$objetivo_general		= $campos["objetivo_general"];
	$objetivos_especificos	= $campos["objetivos_especificos"];
	$tiempo_ded				= $campos["id_tiempo_ded"];
	$contexto				= $campos["contexto"];
	$vrDirEstudio			= $campos["vr_dir_estudio"];
	$vrDirEstudio_2 		= $campos["vr_dir_estudio_2"];
	
	$unidad_negocio			= $campos["id_unidad_negocio"];
	$formaPago				= $campos["forma_pago"];
	$introduccion_met		= $campos["introduccion_met"];
	$formaPago				= $campos["forma_pago"];
	$vb_productos			= $campos["vb_productos"];
}
?>