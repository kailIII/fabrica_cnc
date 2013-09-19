<?
//----
$sql = "SELECT P.*, DATE_FORMAT(last_modify, '%d/%m/%Y') AS fechaP,
DATE_FORMAT(last_modify, '%Y-%m-%d') AS fechaPropuesta
 FROM ".tablaPropuesta." P WHERE id_propuesta='$idPropuesta'";
//echo '<BR>'.$sql;
$con						= mysql_query($sql);
while($campos				= mysql_fetch_array($con)){
	$titulo					= $campos["titulo"];
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
	$contexto				= $campos["contexto"];
	$vrDirEstudio			= $campos["vr_dir_estudio"];
	$vrDirEstudio_2			= $campos["vr_dir_estudio_2"];
	$unidad_negocio			= $campos["id_unidad_negocio"];
	$formaPago				= $campos["forma_pago"];
	$introduccion_met		= $campos["introduccion_met"];
	$vb_productos			= $campos["vb_productos"];
	$fechaP					= $campos["fechaP"];
	$fechaPropuesta			= $campos["fechaPropuesta"];
	
}


//----
$sql = "SELECT * FROM ".tablaEquipo." WHERE id=$elaborada_por";
//echo '<BR>'.$sql;
$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	$id				= $campos["id"];
	$nombreE		= $campos["nombre"];
	$cargoE			= $campos["cargo"];
	$emailE			= $campos["email"];

	// si la ciudad es diferente a bogota se incluye el telefono, de lo contrario solo la extension
	if( $campos["id_ciudad"] != 1 ){
		$telefonoE	= $campos["telefono"].' Ext. '.$campos["ext"];
	} else {
		$telefonoE	= 'Ext. '.$campos["ext"];
	}

	$celularE		= $campos["celular"];
}

//----
$sql = "SELECT * FROM ".tablaEquipo." WHERE id=$revisada_por";
//echo '<BR>'.$sql;
$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	$id				= $campos["id"];
	$nombreR		= $campos["nombre"];
	$cargoR			= $campos["cargo"];
	$emailR			= $campos["email"];

	// si la ciudad es diferente a bogota se incluye el telefono, de lo contrario solo la extension
	if( $campos["id_ciudad"] != 1 ){
		$telefonoR	= $campos["telefono"].' Ext. '.$campos["ext"];
	} else {
		$telefonoR	= 'Ext. '.$campos["ext"];
	}

	$celularE		= $campos["celular"];
	$celularR		= $campos["celular"];
}

//---- consulta las metodologias
$sql = "SELECT *
 FROM ".tablaMetodologia." INNER JOIN ".tablaMetodologiaRTA." USING(id_metodologia)
  WHERE id_propuesta=".$idPropuesta;
//echo '<BR>'.$sql;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_metodologia		= $campos["id_metodologia"];
	$nom_metodologia	= $campos["nom_metodologia"];

	$titulo_m			= $campos["titulo"];
	$temas_m			= $campos["temas"];
//	//----
//	$sqlR = "SELECT * FROM ".tablaOrigenDB." WHERE id_origen_db=$id_origen_db";
//	echo '<BR>'.$sqlR;
//	$nom_origen_db		= NULL;
//	$conR				= mysql_query($sqlR);
//	while($camposR		= mysql_fetch_array($conR)){
//		$nom_origen_db	= ($camposR["nom_origen_db"]);
//	}
//	//----
//	$sqlR = "SELECT * FROM ".tablaPobObjetivo." WHERE id_pob_objetivo=$id_pob_objetivo";
//	//echo '<BR>'.$sqlR;
//	$des_pob_objetivo		= NULL;
//	$conR				= mysql_query($sqlR);
//	while($camposR		= mysql_fetch_array($conR)){
//		$des_pob_objetivo	= ($camposR["des_pob_objetivo"]);
//	}
//	//----
//	$sqlR = "SELECT * FROM ".tablaNivelAceptacion." WHERE id_nivel_aceptacion=$id_nivel_aceptacion";
//	//echo '<BR>'.$sqlR;
//	$des_nivel_aceptacion		= NULL;
//	$conR				= mysql_query($sqlR);
//	while($camposR		= mysql_fetch_array($conR)){
//		$des_nivel_aceptacion	= ($camposR["des_nivel_aceptacion"]);
//	}

}

?>