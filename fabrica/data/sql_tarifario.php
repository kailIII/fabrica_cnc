<?
//----
function getOrigenDB($id_origen_db_r){
	$sql = "SELECT * FROM ".tablaOrigenDB." ORDER BY 1";
	//echo '<BR>'.$sql;
	$optionOrigenDB		= NULL;
	$con				= mysql_query($sql);
	while($campos		= mysql_fetch_array($con)){
		$id_origen_db	= $campos["id_origen_db"];
		$nom_origen_db	= $campos["nom_origen_db"];
	
		$selected_e		= NULL;
		if($id_origen_db==$id_origen_db_r){
			$selected_e	= "selected";
		}
		$optionOrigenDB	.= "<OPTION value='$id_origen_db' $selected_e>$nom_origen_db</OPTION>";
	}
	return $optionOrigenDB;
}

//---- descripción de la muestra
$sql = "SELECT * FROM ".tablaDesMuestra."
 WHERE id_muestra IN
 (SELECT DISTINCT(T.id_muestra) FROM ".tablaTarifario." T WHERE id_tipo_metodologia='$idTipoMetodologia')
 ORDER BY 1";
//echo '<BR>'.$sql;
$optionDesMuestra	= NULL;
$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	$id_muestra		= $campos["id_muestra"];
	$des_muestra	= $campos["des_muestra"];

	$selected_e		= NULL;
	if($id_muestra==$id_origen_db_r){
		$selected_e	= "selected";
	}
	$optionDesMuestra	.= "<OPTION value='$id_muestra' $selected_e>$des_muestra</OPTION>";
}

//---- población objetivo
function getPobObjetivo($idTipoMetodologia,$id_pob_objetivo_r){
	$sql = "SELECT * FROM ".tablaPobObjetivo."
	 WHERE id_pob_objetivo IN
	 (SELECT DISTINCT(T.id_pob_objetivo) FROM ".tablaTarifario." T WHERE id_tipo_metodologia='$idTipoMetodologia')
	 ORDER BY 1";
	//echo '<BR>'.$sql;
	$optionPobObjetivo	= NULL;
	$con				= mysql_query($sql);
	while($campos		= mysql_fetch_array($con)){
		$id_pob_objetivo	= $campos["id_pob_objetivo"];
		$des_pob_objetivo	= $campos["des_pob_objetivo"];
	
		$selected_e		= NULL;
		if($id_pob_objetivo==$id_pob_objetivo_r){
			$selected_e	= "selected";
		}
		$optionPobObjetivo	.= "<OPTION value='$id_pob_objetivo' $selected_e>$des_pob_objetivo</OPTION>";
	}
	return $optionPobObjetivo;
}
//---- nivel de aceptación
function getNivelAceptacion($idTipoMetodologia,$id_nivel_aceptacion_r){
	$sql = "SELECT * FROM ".tablaNivelAceptacion."
	 WHERE id_nivel_aceptacion IN
	 (SELECT DISTINCT(T.id_nivel_aceptacion) FROM ".tablaTarifario." T WHERE id_tipo_metodologia='$idTipoMetodologia')
	 ORDER BY 1";
	//echo '<BR>'.$sql;
	$optionNivelAceptacion	= NULL;
	$con					= mysql_query($sql);
	while($campos			= mysql_fetch_array($con)){
		$id_nivel_aceptacion	= $campos["id_nivel_aceptacion"];
		$des_nivel_aceptacion	= $campos["des_nivel_aceptacion"];
	
		$selected_e		= NULL;
		if($id_nivel_aceptacion==$id_nivel_aceptacion_r){
			$selected_e	= "selected";
		}
		$optionNivelAceptacion	.= "<OPTION value='$id_nivel_aceptacion' $selected_e>$des_nivel_aceptacion</OPTION>";
	}
	return $optionNivelAceptacion;
}
//---- duracion
function getDuracion($idTipoMetodologia,$id_duracion_r){
	$sql = "SELECT * FROM ".tablaDuracion."
	 WHERE id_duracion IN
	 (SELECT DISTINCT(T.id_duracion) FROM ".tablaTarifario." T WHERE id_tipo_metodologia='$idTipoMetodologia')
	 ORDER BY 1";
	//echo '<BR>'.$sql;
	$optionDuracion	= NULL;
	$con				= mysql_query($sql);
	while($campos		= mysql_fetch_array($con)){
		$id_duracion	= $campos["id_duracion"];
		$duracion		= $campos["duracion"];
	
		$selected_e		= NULL;
		if($id_duracion==$id_duracion_r){
			$selected_e	= "selected";
		}
		$optionDuracion	.= "<OPTION value='$id_duracion' $selected_e>$duracion</OPTION>";
	}
	return $optionDuracion;
}

//---- cobertura
function getCobertura($idTipoMetodologia,$id_cobertura_r){
	$sql = "SELECT * FROM ".tablaCobertura."
	 WHERE id_cobertura IN
	 (SELECT DISTINCT(T.id_cobertura) FROM ".tablaTarifario." T WHERE id_tipo_metodologia='$idTipoMetodologia')
	 ORDER BY 1";
	//echo '<BR>'.$sql;
	$optionCobertura	= NULL;
	$con				= mysql_query($sql);
	while($campos		= mysql_fetch_array($con)){
		$id_cobertura	= $campos["id_cobertura"];
		$nom_cobertura	= $campos["nom_cobertura"];
	
		$selected_e		= NULL;
		if($id_cobertura==$id_cobertura_r){
			$selected_e	= "selected";
		}
		$optionCobertura	.= "<OPTION value='$id_cobertura' $selected_e>$nom_cobertura</OPTION>";
	}
	return $optionCobertura;
}
?>