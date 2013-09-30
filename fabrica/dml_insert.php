<?
//foreach($_REQUEST as $i => $j){
//	echo '<BR>campo: '.$i.' valor: '.$j;
//}

// die(krumo($_POST));

require_once dirname(__FILE__).'/classes/class.Metodologia.php';

//---- si debe eliminar una metodología
if(!empty($_POST['idRowMetodologiaDelete'])){
	$id_row_metodologia_del	= $_POST['idRowMetodologiaDelete'];
	$sql = "DELETE FROM ".tablaMetodologiaRTA." WHERE id_propuesta=".$idPropuesta."	AND id_row_metodologia=$id_row_metodologia_del";
	//echo '<BR>'.$sql;
	$result	= eSQL( $sql );
}
if(!empty($_POST['btn_tipo_metodologia1'])){
	$idRowMetodologia	= $_POST['idRowMetodologia'];
	$idTipoMetodologia	= $_POST['idTipoMetodologia'];
	$idMetodologia		= $_POST['idMetodologia'];
	$idRowSegmento		= $_POST['idRowSegmento'];

	$nomSegmento		= $_POST[idObjNomSegmento];
	$idOrigenDB			= $_POST[idObjOrigenDB];
	$idPobObjetivo		= $_POST[idObjPobObjetivo];
	$idNivelAceptacion	= $_POST[idObjNivelAceptacion];
	$idCobertura		= $_POST[idObjCobertura];
	$vrMuestra			= $_POST[idObjMuestra];
	$vrLugar			= $_POST[idObjLugar];
	$vrDuracion			= $_POST[idObjDuracion];

	if(empty($idRowSegmento)){
		$sql = "INSERT INTO ".tablaSegmentoMetodologiaRTA." (id_propuesta,
		id_row_metodologia,
		id_tipo_metodologia,
		id_metodologia,
		nom_segmento,
		id_pob_objetivo,
		id_origen_db,
		id_nivel_aceptacion,
		id_cobertura,
		muestra,
		lugar,
		duracion)
		 VALUES (".$idPropuesta.",
		 '$idRowMetodologia',
		 '$idTipoMetodologia',
		 '$idMetodologia',
		 '$nomSegmento',
		 '$idPobObjetivo',
		 '$idOrigenDB',
		 '$idNivelAceptacion',
		 '$idCobertura',
		 '$vrMuestra',
		 '$vrLugar',
		 '$vrDuracion')";
	}
	else{
		$sql = "UPDATE ".tablaSegmentoMetodologiaRTA." SET
		nom_segmento='$nomSegmento',
		id_pob_objetivo='$idPobObjetivo',
		id_origen_db='$idOrigenDB',
		id_nivel_aceptacion='$idNivelAceptacion',
		id_cobertura='$idCobertura',
		muestra='$vrMuestra',
		lugar='$vrLugar',
		duracion='$vrDuracion'
		 WHERE id_propuesta=".$idPropuesta." AND id_row_metodologia=".$idRowMetodologia." AND id_row_segmento=".$idRowSegmento;
	}
	//echo '<BR>'.$sql;
	$result	= eSQL( $sql );
}
elseif(!empty($_POST['btn_tipo_metodologia2'])){
	$idRowMetodologia	= $_POST['idRowMetodologia'];
	$idTipoMetodologia	= $_POST['idTipoMetodologia'];
	$idMetodologia		= $_POST['idMetodologia'];
	$idRowSegmento		= $_POST['idRowSegmento'];

	$nomSegmento		= $_POST[idObjNomSegmento];
	$idOrigenDB			= $_POST[idObjOrigenDB];
	$idPobObjetivo		= $_POST[idObjPobObjetivo];
	$idNivelAceptacion	= $_POST[idObjNivelAceptacion];
	$idCobertura		= $_POST[idObjCobertura];
	$vrMuestra			= $_POST[idObjMuestra];

	if(empty($idRowSegmento)){
		$sql = "INSERT INTO ".tablaSegmentoMetodologiaRTA." (id_propuesta,
		id_row_metodologia,
		id_tipo_metodologia,
		id_metodologia,
		nom_segmento,
		id_pob_objetivo,
		id_origen_db,
		id_nivel_aceptacion,
		id_cobertura,
		muestra)
		 VALUES (".$idPropuesta.",
		 '$idRowMetodologia',
		 '$idTipoMetodologia',
		 '$idMetodologia',
		 '$nomSegmento',
		 '$idPobObjetivo',
		 '$idOrigenDB',
		 '$idNivelAceptacion',
		 '$idCobertura',
		 '$vrMuestra')";
	}
	else{
		$sql = "UPDATE ".tablaSegmentoMetodologiaRTA." SET
		nom_segmento='$nomSegmento',
		id_pob_objetivo='$idPobObjetivo',
		id_origen_db='$idOrigenDB',
		id_nivel_aceptacion='$idNivelAceptacion',
		id_cobertura='$idCobertura',
		muestra='$vrMuestra'
		 WHERE id_propuesta=".$idPropuesta." AND id_row_metodologia=".$idRowMetodologia." AND id_row_segmento=".$idRowSegmento;
	}
	//echo '<BR>'.$sql;
	$result	= eSQL( $sql );
}
elseif(!empty($_POST['btn_tipo_metodologia3'])){
	$idRowMetodologia	= $_POST['idRowMetodologia'];
	$idTipoMetodologia	= $_POST['idTipoMetodologia'];
	$idMetodologia		= $_POST['idMetodologia'];
	$idRowSegmento		= $_POST['idRowSegmento'];

	$nomSegmento		= $_POST[idObjNomSegmento];
	$idPobObjetivo		= $_POST[idObjPobObjetivo];
	$idDuracion			= $_POST[idObjDuracion];
	$idNivelAceptacion	= $_POST[idObjNivelAceptacion];
	$idCobertura		= $_POST[idObjCobertura];
	$vrUniverso			= $_POST[idObjUniverso];
	$vrMuestra			= $_POST[idObjMuestra];
	$vrErrorMuestral	= $_POST[idObjErrorMuestral];

	if(empty($idRowSegmento)){
		$sql = "INSERT INTO ".tablaSegmentoMetodologiaRTA." (id_propuesta,
		id_row_metodologia,
		id_tipo_metodologia,
		id_metodologia,
		nom_segmento,
		id_pob_objetivo,
		id_duracion,
		id_nivel_aceptacion,
		id_cobertura,
		universo,
		muestra,
		error_muestral)
		 VALUES (".$idPropuesta.",
		 '$idRowMetodologia',
		 '$idTipoMetodologia',
		 '$idMetodologia',
		 '$nomSegmento',
		 '$idPobObjetivo',
		 '$idDuracion',
		 '$idNivelAceptacion',
		 '$idCobertura',
		 '$vrUniverso',
		 '$vrMuestra',
		 '$vrErrorMuestral')";
	}
	else{
		$sql = "UPDATE ".tablaSegmentoMetodologiaRTA." SET
		nom_segmento='$nomSegmento',
		id_pob_objetivo='$idPobObjetivo',
		id_duracion='$idDuracion',
		id_nivel_aceptacion='$idNivelAceptacion',
		id_cobertura='$idCobertura',
		universo='$vrUniverso',
		muestra='$vrMuestra',
		error_muestral='$vrErrorMuestral'
		 WHERE id_propuesta=".$idPropuesta." AND id_row_metodologia=".$idRowMetodologia." AND id_row_segmento=".$idRowSegmento;
	}
	//echo '<BR>'.$sql;
	$result	= eSQL( $sql );
}
elseif(!empty($_POST['btn_tipo_metodologia4'])){
	$idRowMetodologia	= $_POST['idRowMetodologia'];
	$idTipoMetodologia	= $_POST['idTipoMetodologia'];
	$idMetodologia		= $_POST['idMetodologia'];
	$idRowSegmento		= $_POST['idRowSegmento'];

	$nomSegmento		= $_POST[idObjNomSegmento];
	$idPobObjetivo		= $_POST[idObjPobObjetivo];
	$idDuracion			= $_POST[idObjDuracion];
	$idNivelAceptacion	= $_POST[idObjNivelAceptacion];
	$idCobertura		= $_POST[idObjCobertura];
	$vrMuestra			= $_POST[idObjMuestra];

	if(empty($idRowSegmento)){
		$sql = "INSERT INTO ".tablaSegmentoMetodologiaRTA." (id_propuesta,
		id_row_metodologia,
		id_tipo_metodologia,
		id_metodologia,
		nom_segmento,
		id_pob_objetivo,
		id_duracion,
		id_nivel_aceptacion,
		id_cobertura,
		muestra)
		 VALUES (".$idPropuesta.",
		 '$idRowMetodologia',
		 '$idTipoMetodologia',
		 '$idMetodologia',
		 '$nomSegmento',
		 '$idPobObjetivo',
		 '$idDuracion',
		 '$idNivelAceptacion',
		 '$idCobertura',
		 '$vrMuestra')";
	}
	else{
		$sql = "UPDATE ".tablaSegmentoMetodologiaRTA." SET
		nom_segmento='$nomSegmento',
		id_pob_objetivo='$idPobObjetivo',
		id_duracion='$idDuracion',
		id_nivel_aceptacion='$idNivelAceptacion',
		id_cobertura='$idCobertura',
		muestra='$vrMuestra'
		 WHERE id_propuesta=".$idPropuesta." AND id_row_metodologia=".$idRowMetodologia." AND id_row_segmento=".$idRowSegmento;
	}
	//echo '<BR>'.$sql;
	$result	= eSQL( $sql );
}
// esto para guardar la pagina 5 cuando hace clic en nueva metodología y tiene datos pendientes de guardar
$id_row_metodologia_new_seg	= $_POST['id_row_metodologia_new_seg'];
$id_new_metodologia			= $_POST['id_new_metodologia'];
$idMetodologia				= $_POST['id_metodologia'];
$savePage5	= 0;
if(!empty($id_row_metodologia_new_seg) || !empty($id_new_metodologia) || !empty($idMetodologia)){
	$savePage5	= 1;
}
//if(!empty($_POST['btn_anterior']) || !empty($_POST['btn_siguiente'])){
if(!empty($_POST['btn_anterior']) || !empty($_POST['btn_siguiente']) || $savePage5==1){
	//----
	if($paginaActual=='1'){
		$titulo					= $_POST['titulo'];
		$nom_cliente			= $_POST['nom_cliente'];
		$empresa_cliente		= $_POST['empresa_cliente'];
		$cargo_cliente			= $_POST['cargo_cliente'];
		$email_cliente			= $_POST['email_cliente'];
		$telefono_cliente		= $_POST['telefono_cliente'];
		$celular_cliente		= $_POST['celular_cliente'];
		$elaborada_por			= $_POST['elaborada_por'];
		$revisada_por			= $_POST['revisada_por'];
		$id_unidad_negocio		= $_POST['id_unidad_negocio'];
		$requerimiento_cliente	= $_POST['requerimiento_cliente'];

		if(empty($idPropuesta)){
			$sql = "INSERT INTO ".tablaPropuesta." (titulo,
			nom_cliente,
			empresa_cliente,
			cargo_cliente,
			email_cliente,
			telefono_cliente,
			celular_cliente,
			elaborada_por,
			revisada_por,
			id_unidad_negocio)
			 VALUES ('$titulo',
			 '$nom_cliente',
			 '$empresa_cliente',
			 '$cargo_cliente',
			 '$email_cliente',
			 '$telefono_cliente',
			 '$celular_cliente',
			 '$elaborada_por',
			 '$revisada_por',
			 '$id_unidad_negocio')";
			//echo '<BR>'.$sql;
			if(mysql_query($sql)){
				$idPropuesta	= mysql_insert_id();

				$PropuestaDml = new Propuesta( $idPropuesta );
				
				$PropuestaDml->setDefaultProductos(); 
				$PropuestaDml->setUniqueCode();
				$PropuestaDml->setProcesos();
				$PropuestaDml->setRutaCritica();
				$PropuestaDml->setIdoneidades();
				$PropuestaDml->setValidez();
				$PropuestaDml->setFechaCreacion();
				$PropuestaDml->setNotasCalidad();
			}
			else{
				echo "<div style='color:#990000'>Atención!!! Error al guardar la información, por favor intente nuevamente</div>".mysql_error();
			}
		}
		else{
			$sql = "UPDATE ".tablaPropuesta." SET
			titulo='$titulo',
			nom_cliente='$nom_cliente',
			empresa_cliente='$empresa_cliente',
			cargo_cliente='$cargo_cliente',
			email_cliente='$email_cliente',
			telefono_cliente='$telefono_cliente',
			celular_cliente='$celular_cliente',
			elaborada_por='$elaborada_por',
			revisada_por='$revisada_por',
			id_unidad_negocio='$id_unidad_negocio'
			 WHERE id_propuesta=".$idPropuesta;
			$result	= eSQL( $sql );
		}

		$PropuestaDml = new Propuesta( $idPropuesta );
		$PropuestaDml->cleanPropClientes();

		foreach( $_POST['cli_nombre'] as $cli_key => $cli_nom ){

			if( $_POST['cli_nombre'][$cli_key] != '' ){
				$cli_data = array(
					'nombre' 	=> $cli_nom,
					// 'empresa' 	=> $_POST['cli_empresa'][$cli_key],
					'cargo' 	=> $_POST['cli_cargo'][$cli_key],
					'email' 	=> $_POST['cli_email'][$cli_key],
					'telefono'  => $_POST['cli_telefono'][$cli_key],
					'celular' 	=> $_POST['cli_celular'][$cli_key],
					'id_propuesta' =>$idPropuesta 
				);

				$PropuestaDml->addCliente($cli_data);
			}
		}

		header('Location: ?idPropuesta='.$idPropuesta.'&gotopage=2');
	}
	elseif($paginaActual=='2'){

		foreach( $_POST['idoneidad'] as $key=>$value ){

			if( $value == 1 ) : $Propuesta->setIdoneidad( $key ); endif;
			if( $value == 0 ) : $Propuesta->unsetIndoneidad( $key ); endif;
		}

		if( $_POST['tipo_prop'] != '' ){

			$sql = "UPDATE ".tablaPropuesta." SET id_tipo_prop = {$_POST['tipo_prop']}  WHERE id_propuesta = {$idPropuesta} ";
			$result	= eSQL( $sql );
		} else {
			$sql = "UPDATE ".tablaPropuesta." SET id_tipo_prop = NULL WHERE id_propuesta = {$idPropuesta} ";
			$result	= eSQL( $sql );
		}

		$requerimiento_cliente	= $_POST['requerimiento_cliente'];
		$c_tiempo_ded			= $_POST['c_tiempo_ded'];
		$sql = "UPDATE ".tablaPropuesta." SET
		requerimiento_cliente='$requerimiento_cliente',id_tiempo_ded='$c_tiempo_ded'
		 WHERE id_propuesta=".$idPropuesta;
		//echo '<BR>'.$sql;
		$result	= eSQL( $sql );

		//---- consulta el valor del estudio
		$sql = "SELECT * FROM ".tablaTiempoDedicado." WHERE id_tiempo_ded='$c_tiempo_ded'";
		//echo '<BR>'.$sql;
		$vr_dir_estudio			= '';
		$con					= mysql_query($sql);
		while($campos			= mysql_fetch_array($con)){
			$vr_dir_estudio		= $campos["vr_dir_estudio"];
		}
		//---- unicamente actualiza el valor si aún no se ha confirmado en la página de inversión
		$sql = "UPDATE ".tablaPropuesta." SET vr_dir_estudio='$vr_dir_estudio'
		 WHERE id_propuesta=".$idPropuesta." AND conf_vr_dir_estudio=0";
		//echo '<BR>'.$sql;
		$result	= eSQL( $sql );
	}
	elseif($paginaActual=='3'){
		$c_contexto		= $_POST['c_contexto'];

		$sql = "UPDATE ".tablaPropuesta." SET contexto='$c_contexto' WHERE id_propuesta=".$idPropuesta;
		//echo '<BR>'.$sql;
		$result	= eSQL( $sql );
	}
	elseif($paginaActual=='4'){
		//---- actualiza el tipo de estudio
		$tipo_estudio			= $_POST['tipo_estudio'];
		$objetivo_general		= $_POST['objetivo_general'];
		$objetivos_especificos	= $_POST['objetivos_especificos'];
		@$objetivos_especificos	= implode('||',$objetivos_especificos);
		
		$sql = "UPDATE ".tablaPropuesta." SET
		 id_tipo_estudio='$tipo_estudio',
		 objetivo_general='$objetivo_general',
		 objetivos_especificos='$objetivos_especificos'
		  WHERE id_propuesta=".$idPropuesta;
		//echo '<BR>'.$sql;
		$result	= eSQL( $sql );
	}
	elseif($paginaActual=='5_v1'){
		//----
		$metodologias_sel	= $_POST[nameObjMetodologias];
		if(count($metodologias_sel)>0){
			foreach($metodologias_sel as $ind => $id_metodologia){
				//echo '<BR>ind: '.$ind.' id_metodologia: '.$id_metodologia;
				$nameObj	= 'm'.$id_metodologia.'cantidad';
				$cantidad	= $_POST[$nameObj];

				$sql = "INSERT INTO ".tablaMetodologiaRTA." (id_propuesta,id_metodologia,cantidad)
				 VALUES (".$idPropuesta.",'$id_metodologia','$cantidad')";
				$sql = "REPLACE INTO ".tablaMetodologiaRTA." (id_propuesta,id_metodologia,cantidad)
				 VALUES (".$idPropuesta.",'$id_metodologia','$cantidad')";
				//echo '<BR>'.$sql;
				$result	= eSQL( $sql );
			}
			//----
			$sql = "DELETE FROM ".tablaMetodologiaRTA." WHERE id_propuesta=".$idPropuesta." AND id_metodologia NOT IN(".implode(',',$metodologias_sel).")";
			//echo '<BR>'.$sql;
			$result	= eSQL( $sql );
		}
	}
	elseif($paginaActual=='5_v1'){

		//----
		$introduccion_met			= $_POST['introduccion_met'];
		//---- actualiza el valor del campo introducción a la metodología
		$sql = "UPDATE ".tablaPropuesta." SET introduccion_met='$introduccion_met' WHERE id_propuesta=".$idPropuesta;
		//echo '<BR>'.$sql;
		$result	= eSQL( $sql );

		//----
		$metodologias_sel	= $_POST[nameObjMetodologias];
		if(count($metodologias_sel)>0){
			foreach($metodologias_sel as $ind => $id_metodologia){
				//echo '<BR>ind: '.$ind.' id_metodologia: '.$id_metodologia;
				$objTitulo				= $_POST['titulo'];
				$titulo					= $objTitulo[ $ind ];
				$objTemas				= $_POST['temas'];
				$temas					= $objTemas[ $ind ];
				$objId_origen_db		= $_POST['id_origen_db'];
				$id_origen_db			= $objId_origen_db[ $ind ];
				$objId_muestra			= $_POST['id_muestra'];
				$id_muestra				= $objId_muestra[ $ind ];
				$objId_nivel_aceptacion	= $_POST['id_nivel_aceptacion'];
				$id_nivel_aceptacion	= $objId_nivel_aceptacion[ $ind ];
				$objId_pob_objetivo		= $_POST['id_pob_objetivo'];
				$id_pob_objetivo		= $objId_pob_objetivo[ $ind ];
				$objCantidad_ciu_ppal	= $_POST['cantidad_ciu_ppal'];
				$cantidad_ciu_ppal		= $objCantidad_ciu_ppal[ $ind ];
				$objCantidad_otras_ciu	= $_POST['cantidad_otras_ciu'];
				$cantidad_otras_ciu		= $objCantidad_otras_ciu[ $ind ];
				$objDuracion			= $_POST['duracion'];
				$duracion				= $objDuracion[ $ind ];
				$objLugar				= $_POST['lugar'];
				$lugar					= $objLugar[ $ind ];

				$sql = "INSERT INTO ".tablaMetodologiaRTA." (id_propuesta,id_metodologia,cantidad)
				 VALUES (".$idPropuesta.",'$id_metodologia','$cantidad')";
				$sql = "REPLACE INTO ".tablaMetodologiaRTA." (id_propuesta,id_metodologia,titulo,temas,id_origen_db,id_muestra,id_nivel_aceptacion,id_pob_objetivo,cantidad_ciu_ppal,cantidad_otras_ciu,duracion,lugar)
				 VALUES (".$idPropuesta.",'$id_metodologia','$titulo','$temas','$id_origen_db','$id_muestra','$id_nivel_aceptacion','$id_pob_objetivo','$cantidad_ciu_ppal','$cantidad_otras_ciu','$duracion','$lugar')";

				$sql = "REPLACE INTO ".tablaMetodologiaRTA." (id_propuesta,id_metodologia,titulo,temas,id_origen_db,id_nivel_aceptacion,id_pob_objetivo,duracion,lugar)
				 VALUES (".$idPropuesta.",'$id_metodologia','$titulo','$temas','$id_origen_db','$id_nivel_aceptacion','$id_pob_objetivo','$duracion','$lugar')";

				//echo '<BR>'.$sql;
				$result	= eSQL( $sql );
			}
			//----
			$sql = "DELETE FROM ".tablaMetodologiaRTA." WHERE id_propuesta=".$idPropuesta." AND id_metodologia NOT IN(".implode(',',$metodologias_sel).")";
			//echo '<BR>'.$sql;
			//$result	= eSQL( $sql );
		}
	}
	elseif($paginaActual=='5'){
		
		$MetodologiaDml = new Metodologia( $idPropuesta );

		sleep(2); // por alguna razon necesario para que no se salte el guardado en ciertas ocasiones

		if( $_POST['add_metodologia'] == 1 ){

			if( isset( $_POST['sub_metodologia'] ) ){
				$MetodologiaDml->insertMetodologia($_POST['id_metodologia'], $_POST['sub_metodologia'] );
			} else {
				$MetodologiaDml->insertMetodologia($_POST['id_metodologia']);
			}
		}

		//----
		$introduccion_met = $_POST['introduccion_met'];
		//---- actualiza el valor del campo introducción a la metodología
		$sql = "UPDATE ".tablaPropuesta." SET introduccion_met='$introduccion_met' WHERE id_propuesta=".$idPropuesta;
		//echo '<BR>'.$sql;
		$result	= eSQL( $sql );

		// ---- Metodologias ----- //

		if( isset( $_POST['met_ids'] ) )
		foreach( (array) $_POST['met_ids'] as $id_row_met ){
			// Limpieza
				
			$MetodologiaDml->cleanTable($id_row_met);

			$base_data = array(
				'titulo' 				=> $_POST['met_titulo'][$id_row_met],
				'temas' 				=> $_POST['met_temas'][$id_row_met],
				'universo' 				=> $_POST['met_universo'][$id_row_met],
				'poblacion' 			=> $_POST['met_poblacion'][$id_row_met],
				'tamano_poblacion' 		=> $_POST['met_tamanio'][$id_row_met],
				'marco_custom' 			=> $_POST['met_other_marco'][$id_row_met],
				'id_tipo_cuantitativo'	=> $_POST['met_tipo'][$id_row_met],
				'id_nivel_confianza' 	=> $_POST['met_nivel_confianza'][$id_row_met],
				'id_duracion' 			=> $_POST['met_tiempo'][$id_row_met],
				'if_incidencia' 		=> $_POST['met_if_incidencia'][$id_row_met],
				'incidencia' 			=> $_POST['met_incidencia'][$id_row_met],
				'cols' 					=> $_POST['met_cols'][$id_row_met],
				'rows' 					=> $_POST['met_filas'][$id_row_met],
				'id_origen_db'			=> $_POST['met_marco'][$id_row_met],
				'id_pob_objetivo' 		=> $_POST['met_poblacion'][$id_row_met],
				'id_nivel_aceptacion' 	=> $_POST['nivel_aceptacion'][$id_row_met],
				'tipo_cuantitativo_custom' => $_POST['tipo_cuantitativo_custom'][$id_row_met]
			);

			if( isset( $_POST['met_submetodologia'][$id_row_met] )){
				$base_data['id_sub_metodologia'] = $_POST['met_submetodologia'][$id_row_met];
			}


			$MetodologiaDml->updatePropMetData( $id_row_met, $base_data);

			// operaciones de guardado de tabla generada

			// guarda las varianzas
			if( isset($_POST['varianza'][$id_row_met]) )
				$MetodologiaDml->tableSetVarianzas( $id_row_met, $_POST['varianza'][$id_row_met] );
			
			// guarda los segmentos
			foreach( (array) $_POST['segmento'][$id_row_met] as $key_seg => $segmento ){

				$data_segmento = array(
					'nombre_segmento' 	=> $segmento,
					'total_segmento'	=> $_POST['seg_total'][$id_row_met][$key_seg],
					'order_seg' 			=> $key_seg
				);

				if( isset( $_POST['seg_error'][$id_row_met] )){
					$data_segmento['error_segmento'] = $_POST['seg_error'][$id_row_met][$key_seg];
				}

				if( isset( $_POST['seg_cobertura'][$id_row_met] )){
					$data_segmento['id_cobertura'] = $_POST['seg_cobertura'][$id_row_met][$key_seg];
				} /*else {
					$MetodologiaDml->getAvailableCobertura( $id_row_met, $_POST['met_poblacion'][$id_row_met], $_POST['met_marco'][$id_row_met], $_POST['met_tiempo'][$id_row_met], $_POST['nivel_aceptacion'][$id_row_met] );
				}*/

				$data_segmento['values'] = $_POST['seg_val'][$id_row_met][$key_seg];

				$MetodologiaDml->tableSetSegmentos($id_row_met, $data_segmento);
			}

			// guarda totales
			$data_total = array(
				'total' 	=> $_POST['final_var_tot'][$id_row_met],
				'values' 	=> $_POST['total_val'][$id_row_met]
			);

			if( isset( $_POST['final_error_tot'][$id_row_met] ) ){
				$data_total['error'] = $_POST['final_error_tot'][$id_row_met];
			}

			$MetodologiaDml->tableSetTotales($id_row_met, $data_total);

			// data de error
			if( isset( $_POST['final_total_error'][$id_row_met] ) ){
				$MetodologiaDml->tableSetErrores($id_row_met, $_POST['final_total_error'][$id_row_met], $_POST['error_val'][$id_row_met] );
			}

			// configura valores de segmento
			/*if( isset( $_POST['segmento'][$id_row_met] ) ){
				$MetodologiaDml->setInversion( $id_row_met );
			}*/
		}


		// realiza miagracion de datos a bd antigua
		if( isset( $_POST['met_ids'] ) )
		$MetodologiaDml->makeMigration();

		// ---- Metodologias ----- //
		

		if( $_POST['set_default_inv'] == 1 ){
			$Propuesta->setInversionToDefault();
		}
	}
	elseif($paginaActual=='6'){

		$vr_dir_estudio		= $_POST[ nameObjVrDirEstudio ];
		$forma_pago			= $_POST[ 'forma_pago' ];
		$vr_dir_estudio		= str_replace( ',' , '' , $vr_dir_estudio );
		$vr_dir_estudio		= str_replace( '.' , '' , $vr_dir_estudio );
		$validez_prop 		= $_POST[ 'validez_propuesta' ];
		
		
		$vr_dir_estudio_2 	= $_POST[ "vr_dir_estudio_2" ];
		$vr_dir_estudio_2	= str_replace( ',' , '' , $vr_dir_estudio_2 );
		$vr_dir_estudio_2	= str_replace( '.' , '' , $vr_dir_estudio_2 );

		//---- actualiza el valor de la dirección de estudios
		$sql = "UPDATE " . tablaPropuesta . " 
			SET vr_dir_estudio 		= '$vr_dir_estudio' , 
				vr_dir_estudio_2 	= '$vr_dir_estudio_2' , 
				conf_vr_dir_estudio = 1 , 
				forma_pago 			= '$forma_pago' , 
				validez_propuesta 	= '$validez_prop' 
			WHERE id_propuesta = $idPropuesta ";
		$result	= eSQL( $sql );
		
		//---- consulta los segmentos de la propuesta
		$sqlR = "SELECT * FROM " . tablaSegmentoMetodologiaRTA . " R 
				WHERE id_propuesta = $idPropuesta 
				ORDER BY 1 ";
		
		$filasSegmentos	= NULL;
		$conR			= mysql_query( $sqlR );
		
		while( $camposR = mysql_fetch_array( $conR ) ){
			
			$id_row_segmento 	= $camposR[ "id_row_segmento" ];
			$idObjVrUnit 		= nameObjVrUnitario . $id_row_segmento;
			$vr_unitario 		= $_POST[ $idObjVrUnit ];
			$vr_unitario 		= str_replace( ',' , '' , $vr_unitario );
			$vr_unitario 		= str_replace( '.' , '' , $vr_unitario );

			$sql = "UPDATE " . tablaSegmentoMetodologiaRTA . " 
					SET precio_unitario = '$vr_unitario' 
				WHERE id_propuesta = $idPropuesta 
					AND id_row_segmento = $id_row_segmento ";
			$result	= eSQL( $sql );
		
		}
		
		for( $k = 1 ; $k <= 2 ; $k++ ){
			
			$j = ( $k === 1 ) ? "" : "_$k"; 
			
			$arrayProductos 	= $_POST[ 'productos' 	. $j ];
			$arrayVrUnit 		= $_POST[ 'vrUnit' 		. $j ];
			$arrayCantidad 		= $_POST[ 'cantidad' 	. $j ];
			$arrayTabla 		= $_POST[ 'tabla' 		. $j ];
			$arrayIdProducto 	= $_POST[ 'IdProducto' 	. $j ]; 
			
			foreach( ( array ) $arrayProductos as $ind => $producto ){
				
				$cantidad 		= $arrayCantidad[ $ind ];
				$vr_unitario	= $arrayVrUnit[ $ind ];
				$id_producto	= $arrayIdProducto[ $ind ];
				$tabla 			= $arrayTabla[ $ind ];
				
				$cantidad		= str_replace( ',' , '' , $cantidad);
				$cantidad		= str_replace( '.' , '' , $cantidad);
				$cantidad 		= ( $cantidad == "" ) ? 0 : $cantidad;
				
				$vr_unitario	= str_replace( ',' , '' , $vr_unitario);
				$vr_unitario	= str_replace( '.' , '' , $vr_unitario);
				
				
				if( !empty( $id_producto ) ){
					$sql = "UPDATE ".tablaInversion." SET id_propuesta = $idPropuesta ,
								producto 	= '$producto' , 
								cantidad 	= '$cantidad' ,
								vr_unitario = '$vr_unitario' , 
								tabla 		= $tabla
							WHERE id_producto = " . $id_producto;
				}
				else{
					$sql = "INSERT INTO " . tablaInversion . " 
							( id_propuesta , producto , cantidad , vr_unitario , tabla ) 
						VALUES ( $idPropuesta , '$producto' , '$cantidad' , '$vr_unitario' , $tabla )";
				}
				$result	= eSQL( $sql );
			}
		
		}
			
	}
	elseif($paginaActual=='7'){
		$vb_productos	= $_POST['vb_productos'];
		//---- actualiza el vb_productos
		$sql = "UPDATE ".tablaPropuesta."
		 SET vb_productos='$vb_productos'
		 WHERE id_propuesta=".$idPropuesta;
		//echo '<BR>'.$sql;
		$result	= eSQL( $sql );
		/*
		//----
		$nameObj	= $nameObj	= nameObjEntregables;
		$entregable_sel	= $_POST[$nameObj];
		if(count($entregable_sel)>0){
			foreach($entregable_sel as $ind => $valor){
				//echo '<BR>ind: '.$ind.' valor: '.$valor;
				$sql = "INSERT INTO ".tablaEntregableRTA." (id_propuesta,id_entregable)
				 VALUES (".$idPropuesta.",'$valor')";
				//echo '<BR>'.$sql;
				$result	= eSQL( $sql );
			}
			//----
			$sql = "DELETE FROM ".tablaEntregableRTA."
			 WHERE id_propuesta=".$idPropuesta." AND id_entregable NOT IN(".implode(',',$entregable_sel).")";
			//echo '<BR>'.$sql;
			$result	= eSQL( $sql );
		}
		else{
			$sql = "DELETE FROM ".tablaEntregableRTA." WHERE id_propuesta=".$idPropuesta;
			//echo '<BR>'.$sql;
			$result	= eSQL( $sql );
		}*/

		foreach( $_POST['prod_id'] as $key => $id ){
			$Propuesta->updateProdProduct( $id, $_POST['prod_nom'][$key], $_POST['prod_act'][$id] );
		}

		if( isset( $_POST['new_prod_nom'] ) ):
			foreach( (array) $_POST['new_prod_nom'] as $key => $prod_nom ){
				$Propuesta->insertProdProduct( $prod_nom, $_POST['new_prod_act'][$key] );
			}
		endif;
	}
	elseif($paginaActual=='8'){
		//---- equipo de trabajo
		$equipoTrabajo_sel	= $_POST[nameObjEquipoTrabajo];
		if(count($equipoTrabajo_sel)>0){
			foreach($equipoTrabajo_sel as $ind => $id_persona){
				//echo '<BR>ind: '.$ind.' id_persona: '.$id_persona;
				$rolPersona	= 'rol_persona'.$id_persona;
				$id_rol		= $_POST[$rolPersona];

				$sql = "REPLACE INTO ".tablaEquipoTrabajoRTA." (id_propuesta,id_persona,id_rol)
				 VALUES (".$idPropuesta.",'$id_persona','$id_rol')";
				//echo '<BR>'.$sql;
				$result	= eSQL( $sql );
			}
			//----
			$sql = "DELETE FROM ".tablaEquipoTrabajoRTA." WHERE id_propuesta=".$idPropuesta." AND id_persona NOT IN(".implode(',',$equipoTrabajo_sel).")";
			//echo '<BR>'.$sql;
			$result	= eSQL( $sql );
		}
	}
	elseif($paginaActual=='9'){
		// $sqlP = "SELECT * FROM ".tablaProceso." ORDER BY id_proceso";
		$sqlP = "SELECT * FROM ".tablaProceso." WHERE id_propuesta = {$idPropuesta} ORDER BY id_proceso";
		//echo '<BR>'.$sqlP;
		$conP				= mysql_query($sqlP);
		while($camposP		= mysql_fetch_array($conP)){
			$id_proceso		= $camposP["id_proceso"];
	
			$nameObjC		= 'p'.$idPropuesta.'p'.$id_proceso;
			$arraySemProceso= $_POST[$nameObjC];
			if(empty($arraySemProceso)){
				$arraySemProceso= array();
			}
			$sql = "REPLACE INTO ".tablaCalendario." (id_propuesta,id_proceso,semanas)
			 VALUES (".$idPropuesta.",'$id_proceso','".implode(',',$arraySemProceso)."')";
			//echo '<BR>'.$sql;
			$result	= eSQL( $sql );

			$PropuestaDml = new Propuesta( $idPropuesta );
			$PropuestaDml->setFechasCalendario();

			foreach( $_POST['calendario_area_responsable'] as $id_proceso => $id_area ){
	
				$sql = "UPDATE prop_calendario SET id_area = '{$id_area}' WHERE id_propuesta = '{$idPropuesta}' AND id_proceso = '{$id_proceso}'";
				$result	= eSQL( $sql );
				
			}

		}

		foreach( $_POST['nom_proceso'] as $id_proceso => $value ){
			$sql = "UPDATE prop_proceso SET nom_proceso = '{$value}' WHERE id_proceso = {$id_proceso} AND id_propuesta = {$idPropuesta} ";
			$result	= eSQL( $sql );
		}

		foreach( $_POST['res_proceso'] as $id_proceso => $value ){
			$sql = "UPDATE prop_proceso SET responsable = '{$value}' WHERE id_proceso = {$id_proceso} AND id_propuesta = {$idPropuesta} ";
			$result	= eSQL( $sql );
		}

		$sql = "UPDATE prop_propuesta set ruta_critica = '{$_POST['ruta_critica']}' WHERE id_propuesta = {$idPropuesta} ";
		$result	= eSQL( $sql );

		$sql = "UPDATE prop_propuesta set fecha_inicio = '{$_POST['fecha_inicio']}' WHERE id_propuesta = {$idPropuesta} ";
		$result	= eSQL( $sql );
	}
	elseif($paginaActual=='10'){
		//---- Notas de calidad
		//----
		$sql = "DELETE FROM ".tablaNotasCalidadRTA." WHERE id_propuesta=".$idPropuesta;
		//echo '<BR>'.$sql;
		$result	= eSQL( $sql );

		$notasCalidad	= $_POST[nameObjNotasCalidad];
		if(count($notasCalidad)>0){
			foreach($notasCalidad as $ind => $des_nota_calidad){
				//echo '<BR>ind: '.$ind.' id_persona: '.$id_persona;
				$rolPersona	= 'rol_persona'.$id_persona;
				$id_rol		= $_POST[$rolPersona];

				$activo_nota = $_POST['activo_nota_calidad'][$ind];

				// krumo( $activo_nota );

				$sql = "INSERT INTO ".tablaNotasCalidadRTA." (id_propuesta,id_nota_calidad,des_nota_calidad, activo_nota_calidad )
				 VALUES (".$idPropuesta.",'$ind','$des_nota_calidad', '$activo_nota' )";
				//echo '<BR>'.$sql;
				$result	= eSQL( $sql );
			}
		}
	}
}	
?>