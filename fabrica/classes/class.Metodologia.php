<?php

/*
* clase del objeto metodologia
*/

require_once dirname(__FILE__).'/../krumo/class.krumo.php';
require_once dirname(__FILE__).'/../../libreria.php';
require_once dirname(__FILE__).'/class.Propuesta.php';
require_once dirname(__FILE__).'/class.Contenidos.php';

class Metodologia extends Propuesta{

	public function __construct( $id_propuesta ){
		parent::__construct($id_propuesta);
	}

	// obtiene listado de metodologias
	public function getListMetodologias(){
		$query = "SELECT * FROM prop_tipo_metodologia ORDER BY id_tipo_metodologia";
		$result = array();
		

		
		foreach( $this->adoDbFab->GetAll($query) as $tipo_met ){

			$query = "SELECT * FROM prop_metodologia WHERE id_tipo_metodologia = {$tipo_met['id_tipo_metodologia']} ";
			
			
			foreach( $this->adoDbFab->GetAll($query) as $met ){
				
				$query_subnivel = "SELECT * FROM prop_metodologia_subnivel WHERE id_subnivel = {$met['id_subnivel']} ";
				$sub_nivel = $this->adoDbFab->GetRow($query_subnivel);
				
				$result[ $tipo_met['nom_tipo_metodologia'] ][$sub_nivel['nom_subnivel']][] = array(
					'value' => $met['id_metodologia'],
					'label' => $met['nom_metodologia']
				);
				
			}
		}
		
		return $result;
		
	}

	// inserta una metodologia a una propuesta en especifico
	public function insertMetodologia( $id_metodologia , $sub_metodologia = false ){
			
		$ins_submet = '';
		if( $sub_metodologia ){
			$ins_submet = ' ,id_sub_metodologia = '.$sub_metodologia;
		}
			
		$query = "INSERT INTO prop_metodologia_selected SET id_metodologia = {$id_metodologia}, id_propuesta = {$this->id_propuesta} {$ins_submet} ";
		$this->adoDbFab->Execute($query);
	}

	// obtiene las metodologias aplicadas a una propuesta
	public function getPropMetodologias(){
		$query = "SELECT * FROM prop_metodologia_selected pms 
		INNER JOIN prop_metodologia pme ON pme.id_metodologia = pms.id_metodologia 
		INNER JOIN prop_tipo_metodologia ptm ON ptm.id_tipo_metodologia = pme.id_tipo_metodologia
		WHERE pms.id_propuesta = {$this->id_propuesta}
		ORDER BY pms.id_row_metodologia";
	
		return $this->adoDbFab->GetAll($query);
	}
	
	// obtiene UNA metodologia aplicada a una propuesta
	public function getPropMetodologia( $id_row_metodologia ){
		$query = "SELECT * FROM prop_metodologia_selected pms 
		INNER JOIN prop_metodologia pme ON pme.id_metodologia = pms.id_metodologia 
		INNER JOIN prop_tipo_metodologia ptm ON ptm.id_tipo_metodologia = pme.id_tipo_metodologia
		WHERE pms.id_propuesta = {$this->id_propuesta}
		AND pms.id_row_metodologia = {$id_row_metodologia}
		ORDER BY pms.id_row_metodologia";
	
		return $this->adoDbFab->GetRow($query);
	}
	

	// obtiene metodologia propuesta
	public function getPropMet($id_row_metodologia){
		$query = "SELECT * FROM prop_metodologia_selected pms
		INNER JOIN prop_metodologia prm ON prm.id_metodologia = pms.id_metodologia 
		INNER JOIN prop_tipo_cuantitativo ptc ON ptc.id_tipo_cuantitativo = pms.id_tipo_cuantitativo
		WHERE pms.id_row_metodologia = {$id_row_metodologia}";

		return $this->adoDbFab->GetRow($query);
	}

	// determina si es es metodologia probabilistica
	public function isProbabilistico( $id_row_met ){
		$prop = $this->getPropMet($id_row_met);

		if( $prop['probabilistico'] == 1 ){
			return TRUE;
		}

		return FALSE;
	}

	// elimina metodologia propuesta
	public function deletePropMet($id_row_metodologia){
		$query = "DELETE FROM prop_metodologia_selected WHERE id_row_metodologia = {$id_row_metodologia}";
		$this->adoDbFab->Execute($query);
	}

	// limpia la tabla de segmentos de una metodologia
	public function cleanTable( $id_row_metodologia ){
		$query = "DELETE FROM prop_metselected_segmentos WHERE id_row_metodologia = {$id_row_metodologia}";
		$this->adoDbFab->Execute($query);

		$query = "DELETE FROM prop_metselected_varianzas WHERE id_row_metodologia = {$id_row_metodologia}";
		$this->adoDbFab->Execute($query);

		$query = "DELETE FROM prop_metselected_total WHERE id_row_metodologia = {$id_row_metodologia}";
		$this->adoDbFab->Execute($query);

		$query = "DELETE FROM prop_selected_error WHERE id_row_metodologia = {$id_row_metodologia}";
		$this->adoDbFab->Execute($query);

		// limia bd antigua -- condicion: new_id_row_metodologia IS NOT NULL asegura que solo se borren registros asociados al nuevo metodo de ingreso de metodologia
		$query = "DELETE FROM prop_metodologia_rta WHERE id_propuesta = {$this->id_propuesta} AND old_register = 0";
		$this->adoDbFab->Execute($query);
	}

	// insert de data base
	public function updatePropMetData( $id_row_met, $base_data ){
		foreach( $base_data as $field => $value ){

			if( $value == '' || empty($value)  || is_null($value) ){
				$query = "UPDATE prop_metodologia_selected SET ". $field ." = NULL WHERE id_row_metodologia = {$id_row_met}";
			} else {
				$query = "UPDATE prop_metodologia_selected SET ". $field ." = '{$value}' WHERE id_row_metodologia = {$id_row_met}";
			}

			$this->adoDbFab->Execute($query);
		}
	}

	// almacena las varianzas de la tabla
	public function tableSetVarianzas( $id_row_met, $varianzas ){

		foreach( (array) $varianzas as $order => $varianza ){
			$query = "INSERT INTO prop_metselected_varianzas SET 
			id_row_metodologia = {$id_row_met},
			nombre_var = '{$varianza}',
			order_var = {$order}";

			$this->adoDbFab->Execute($query);
		}
	}



	// almacena los segmentos de la tabla
	public function tableSetSegmentos( $id_row_met, $segmento ){


		$query = "INSERT INTO prop_metselected_segmentos SET 
		nombre_segmento = '{$segmento['nombre_segmento']}',
		total_segmento = '{$segmento['total_segmento']}',
		error_segmento = '{$segmento['error_segmento']}',
		id_row_metodologia = {$id_row_met}";

		// previene null fk error

		isset( $segmento['id_cobertura'] ) ? $query.= " ,id_cobertura = {$segmento['id_cobertura']} " : $query.= " ,id_cobertura = NULL ";
		$query.=" ,order_seg = {$segmento['order_seg']} ";
		$this->adoDbFab->Execute($query);

		$id_segmento = $this->adoDbFab->Insert_ID();

		foreach( (array) $segmento['values'] as $key_sv => $seg_value ){
			$query = "INSERT INTO prop_segmentos_values SET value = '{$seg_value}', id_segmento = {$id_segmento}, order_seg_val = {$key_sv} ";
			$this->adoDbFab->Execute($query);
		}
	}

	// almacena los totales de la tabla
	public function tableSetTotales( $id_row_met, $total ){

		$query = "INSERT INTO prop_metselected_total SET 
		total = '{$total['total']}', 
		error = '{$total['error']}',
		id_row_metodologia = {$id_row_met}";

		$this->adoDbFab->Execute($query);
		$id_total = $this->adoDbFab->Insert_ID();

		foreach( (array) $total['values'] as $key_tot => $tot_val )  {
			$query = "INSERT INTO prop_totales_values SET 
			value = '{$tot_val}', 
			order_tot_val = {$key_tot}, 
			id_total = {$id_total} ";

			$this->adoDbFab->Execute($query);
		}
	}

	// almacena 
	public function tableSetErrores( $id_row_met, $total, $error_values ){
		$query = "INSERT INTO prop_selected_error SET total = '{$total}', id_row_metodologia = {$id_row_met}";
		$this->adoDbFab->Execute($query);

		$id_error = $this->adoDbFab->Insert_ID();
		

		foreach( (array) $error_values as $key => $val ){
			$query = "INSERT INTO prop_errores_values SET id_error = {$id_error}, value = '{$val}', order_error_val = {$key}";
			$this->adoDbFab->Execute($query);
		}
	}

	// obtiene un metodo seleccionado en especifico
	public function getMetSelected($id_row_met){
		$query = "SELECT * FROM prop_metodologia_selected pms 
		INNER JOIN prop_metodologia pme ON pme.id_metodologia = pms.id_metodologia
		INNER JOIN prop_tipo_metodologia ptm ON ptm.id_tipo_metodologia = pme.id_tipo_metodologia
		WHERE pms.id_row_metodologia = {$id_row_met}";

		return $this->adoDbFab->GetRow($query);
	}



	//-------------- Funciones de tabla ----------------//

	// construye la tabla
	public function makeTable( $id_row_met ){

		$met_selected = $this->getMetSelected($id_row_met); // krumo($met_selected);
		$is_presencial = $met_selected['is_presencial'];

		$query = "SELECT * FROM prop_tipo_cuantitativo WHERE id_tipo_cuantitativo = {$met_selected['id_tipo_cuantitativo']}";
		$tipo_cuant = $this->adoDbFab->GetRow($query);

		$is_probabilistico = $tipo_cuant['probabilistico'];

		// fase 1 header//
		$html = '<table class="metTable" id="metTable_'. $id_row_met .'" >';
		$html.='<tr>';
		$html.='<td>Segmento</td>';
		foreach(  $this->getTableVarianzas($id_row_met) as $varianza ){
			$html.='<td><input type="text" name="varianza['. $id_row_met .'][]" value="'. $varianza['nombre_var'] .'" ></td>';
		}
		$html.='<td>Total</td>';

		if( $is_probabilistico == 1 ){
			$html.='<td>Error</td>';
		}
		
		if( $is_presencial == 1 ){
			$html.='<td class="met_zonas_wraper" >&nbsp;</td>';
		}

		$html.='</tr>';

		// fase 2 body -- segmentos // 

		$i = 1; // represntando las filas		
		foreach( $this->getTableSegmentos($id_row_met) as $seg_info ){
			$j = 1; // representado las columnas
			$html.='<tr>';
			$html.='<td><input type="text" id_met="'. $id_row_met .'" name="segmento['. $id_row_met .'][]" value="'. $seg_info['nombre_segmento'] .'" ></td>';


			foreach( $seg_info['values'] as $seg_val ){
				$html.='<td><input value="'. $seg_val['value'] .'" type="text" row="'. $i .'" class="varianza" col="'. $j .'" id_met="'. $id_row_met .'" name="seg_val['. $id_row_met .']['. ($i-1) .'][]" ></td>';
				$j++;
			}

			$html.='<td><input type="text" class="total" col="'. $j .'" row="'. $i .'" id_met="'. $id_row_met .'" id="total_'. $i .'_'. $id_row_met .'" readonly name="seg_total['. $id_row_met .']['. ($i-1) .']" value="'. $seg_info['total_segmento'] .'" /></td>';
			if( $this->isProbabilistico($id_row_met) ){
				$html.='<td><input type="text" class="error" col="'. $j .'" row="'. $i .'" id_met="'. $id_row_met .'" id="error_'. $i .'_'. $id_row_met .'" value="'. $seg_info['error_segmento'] .'" readonly name="seg_error['. $id_row_met .']['. ($i-1) .']"></td>';
			}

			if( $is_presencial == 1 ){
				$html.='<td class="met_zonas_wraper" >';
				$html.='<select name="seg_cobertura['. $id_row_met .']['. ($i-1) .']" >';

				$Contenidos = new Contenidos();
				// ciclo cobertura
				foreach( $Contenidos->getCoberturaConstrained( $met_selected['ids_cobertura'] ) as $cobertura ){

					$seg_info['id_cobertura'] == $cobertura['id_cobertura'] ? $selected = 'selected' : $selected = '';
					$html.='<option value="'. $cobertura['id_cobertura'] .'" '. $selected .' >'. $cobertura['nom_cobertura'] .'</option>';
				}
				$html.='</select>';
				$html.='</td>';
			}

			$html.='</tr>';

			$i++;
		}

		// krumo( $this->getTableTotales($id_row_met) );

		// fase 3 resultados //
		$html.='<tr>';
		$html.='<td>Total</td>';
		$j = 1;
		$totales = $this->getTableTotales($id_row_met);
		foreach( $totales as $tot_val ){
			$html.='<td><input type="text" value="'. $tot_val['value'] .'" class="total_col" name="total_val['. $id_row_met .'][]" readonly id_met="'. $id_row_met .'" col="'. $j .'" id="total_col_'. $j .'_'. $id_row_met .'" /></td>';
			$j++;
		}

		$html.='<td><input type="text" readonly id_met="'. $id_row_met .'"  name="final_var_tot['. $id_row_met .']" id="final_var_tot_'. $id_row_met .'" value="'. $totales[0]['total'] .'" /></td>';
		if( $this->isProbabilistico($id_row_met) ){
			$html.='<td><input value="'. $totales[0]['error'] .'" type="text" readonly id_met="'. $id_row_met .'" id="final_error_tot_'. $id_row_met .'" name="final_error_tot['. $id_row_met .']" /></td>';
		}

		if( $is_presencial == 1 ){
			$html.='<td class="met_zonas_wraper" >&nbsp;</td>';
		}
		$html.='</tr>';

		// opcional conteo de error

		if( $this->isProbabilistico($id_row_met) ){
			$html.='<tr>';
			$html.='<td>Error</td>';
			$errores = $this->getTableErrores($id_row_met);
			$j = 1;

			foreach( $errores as $error ){
				$html.='<td><input type="text" value="'. $error['value'] .'" class="error_col" readonly="" name="error_val['. $id_row_met .'][]" id_met="'. $id_row_met .'" col="'. $j .'" id="error_col_'. $j .'_'. $id_row_met .'"></td>';
				$j++;
			}
			
			$html.='<td><input value="'. $error['total'] .'" type="text" id="final_total_error_col_'. $id_row_met .'" id_met="'. $id_row_met .'"  name="final_total_error['. $id_row_met .']" /></td>';
			
			$html.='<td>&nbsp;</td>';// no hay total de errores
			if( $is_presencial == 1 ){
				$html.='<td class="met_zonas_wraper" >&nbsp;</td>';	
			}
			$html.='</tr>';
		}

		// end

		$html.='</table>'; // closure

		return $html;

	}


	public function getTableVarianzas( $id_row_met ){
		
		$query = "SELECT * FROM prop_metselected_varianzas WHERE id_row_metodologia = {$id_row_met} ORDER BY order_var";
		return $this->adoDbFab->GetAll($query);
	}

	// obtiene segmentos - valores y cobertura si la hay
	public function getTableSegmentos( $id_row_met ){

		$query = "SELECT * FROM prop_metselected_segmentos pms 
		LEFT JOIN prop_cobertura pco ON pms.`id_cobertura` = pco.`id_cobertura` 
		WHERE pms.id_row_metodologia = {$id_row_met} 
		ORDER BY pms.order_seg ";
		$segmentos = $this->adoDbFab->GetAll($query);


		foreach( $segmentos as $key => $segmento ){
			$query = "SELECT * FROM prop_segmentos_values WHERE id_segmento = {$segmento['id_segmento']} ORDER BY order_seg_val ";
			$segmentos[$key]['values'] = $this->adoDbFab->GetAll($query);
		}

		return $segmentos;
	}

	// obtien totales 
	public function getTableTotales( $id_row_met ){
		$query = "SELECT * FROM prop_metselected_total pmt
		INNER JOIN prop_totales_values ptv ON pmt.id_total = ptv.id_total 
		WHERE pmt.id_row_metodologia = {$id_row_met} ORDER BY  ptv.order_tot_val";

		return $this->adoDbFab->GetAll($query);
	}

	// obtienbe errores
	public function getTableErrores( $id_row_met ){

		$query = "SELECT * FROM prop_selected_error pse
		INNER JOIN prop_errores_values pev ON pse.id_error = pev.id_error 
		WHERE id_row_metodologia = {$id_row_met} ORDER BY pev.order_error_val";

		return $this->adoDbFab->GetAll($query);
	}


	/**
	 * Calcula la invesrion en sus valores por defecto
	 * @var id_row_metodologia references PK table prop_metologia_rta
	 * SELECT * FROM prop_metodologia M INNER JOIN prop_metodologia_rta R USING(id_metodologia) WHERE R.id_propuesta=59 ORDER BY 1
	 */
	public function setInversion ( $id_row_metodologia ){

		$segmento_rta = $this->getMetSelected($id_row_metodologia);
		$camposR = $segmento_rta;

		$id_pob_objetivo	= $camposR["id_pob_objetivo"];
		$id_duracion		= $camposR["id_duracion"];
		$id_nivel_aceptacion= $camposR["id_nivel_aceptacion"];
		$id_origen_db		= $camposR["id_origen_db"];
		

		$cond				= NULL;
		$vrUnitario			= 0;
		$vrTotal			= 0;

		$segmentos = $this->getTableSegmentos($id_row_metodologia);

		foreach( $segmentos as $segmento ){

			$cond = '';
			$muestra = $segmento['total_segmento'];
			$id_cobertura = $segmento["id_cobertura"];


			// if(!empty($muestra) && empty($precioUnitario)){
			if(!empty($muestra) ){
				if(!empty($id_pob_objetivo)){
					$cond	.= " AND id_pob_objetivo='$id_pob_objetivo'";
				}
				if(!empty($id_duracion)){
					$cond	.= " AND id_duracion='$id_duracion'";
				}
				if(!empty($id_nivel_aceptacion)){
					$cond	.= " AND id_nivel_aceptacion='$id_nivel_aceptacion'";
				}
				if(!empty($id_cobertura)){
					$cond	.= " AND id_cobertura='$id_cobertura'";
				}
				if(!empty($id_origen_db)){
					$cond	.= " AND id_origen_db='$id_origen_db'";
				}
			}

			if( $muestra > 0 ){

				$query = "SELECT * FROM ". tablaTarifario ." WHERE id_tipo_metodologia = '{$segmento_rta['id_tipo_metodologia']}' {$cond} ";
				$camposTarifario = $this->adoDbFab->GetAll($query);

				foreach( $camposTarifario as $camposT ){
					$precio				= $camposT["precio"];
					$operador_muestra	= $camposT["operador_muestra"];
					$valor_muestra		= $camposT["valor_muestra"];
							//echo '<BR>cond: '.$operador_muestra.$valor_muestra;
					if($operador_muestra=='<'){
						if($muestra < $valor_muestra){
							$vrUnitario	= $precio;
							//echo "<BR>menor que: $muestra < $valor_muestra";
						}
					}
					elseif($operador_muestra=='<='){
						if($muestra <= $valor_muestra){
							$vrUnitario	= $precio;
							//echo "<BR>menor que: $muestra < $valor_muestra";
						}
					}
					elseif($operador_muestra=='>'){
						if($muestra > $valor_muestra){
							$vrUnitario	= $precio;
							//echo "<BR>mayor que: $muestra > $valor_muestra";
						}
					}
					elseif($operador_muestra=='BETWEEN'){
						$arrayValor	= explode(',',$valor_muestra);
						if($muestra >= $arrayValor[0] && $muestra <= $arrayValor[1]){
							$vrUnitario	= $precio;
							//echo "<BR>BETWEEN: $muestra BETWEEN $arrayValor[0] AND $arrayValor[1]";
						}
					}
				} // end foreach

				

			} 

			$query = "UPDATE prop_metselected_segmentos SET valor_unitario = '{$vrUnitario}' WHERE id_segmento = {$segmento['id_segmento']} ";
			$this->adoDbFab->Execute($query);


		} // fin each
		return $result;
	}

	// migracion a base de datos antigua
	public function makeMigration(){

		$metodologias = $this->getPropMetodologias();

		foreach( $metodologias as $met ){

			$query = "INSERT INTO prop_metodologia_rta SET 
			id_propuesta = {$this->id_propuesta},
			id_metodologia = {$met['id_metodologia']},
			titulo = '{$met['titulo']}',
			temas = '{$met['temas']}',
			universo = '{$met['universo']}',
			marco_estadistico = '{$met['marco_custom']}',
			new_id_row_metodologia = {$met['id_row_metodologia']}";

			$this->adoDbFab->Execute($query);
			$id_row_metodologia = $this->adoDbFab->Insert_ID();

			$segmentos = $this->getTableSegmentos($met['id_row_metodologia']);

			foreach( $segmentos as $seg ){
				$query = "INSERT INTO prop_seg_metodologia_rta SET 
				id_propuesta = '{$this->id_propuesta}',
				id_row_metodologia = '{$id_row_metodologia}',
				id_tipo_metodologia =  '{$met['id_tipo_metodologia']}',
				id_metodologia = '{$met['id_metodologia']}',
				nom_segmento = '{$seg['nombre_segmento']}',
				id_pob_objetivo = '{$met['id_pob_objetivo']}',
				id_duracion = '{$met['id_duracion']}',
				id_nivel_aceptacion = '{$met['id_nivel_aceptacion']}',
				id_cobertura = '{$seg['id_cobertura']}',
				id_origen_db = '{$met['id_origen_db']}',
				universo = '{$met['universo']}',
				muestra = '{$seg['total_segmento']}',
				error_muestral = '{$seg['error_segmento']}',
				precio_unitario = '{$seg['valor_unitario']}'";

				$this->adoDbFab->Execute($query);
			}
		}
	}
	
	
	// obtiene los origines db disponibles segun el tipo de metodologia y la pob objetivo
	public function getAvailableOrigenDb( $id_row_met, $id_pob_objetivo ){
		$met_selected = $this->getMetSelected($id_row_met);
		
		$query = "SELECT *  FROM  prop_tarifario 
		WHERE  id_metodologia = '{$met_selected['id_metodologia']}' AND  id_pob_objetivo = '{$id_pob_objetivo}'";
		
		$ids = array();
		foreach( $this->adoDbFab->GetAll($query) as $result ){
			if( !in_array( $result['id_origen_db'], $ids ) ){
				$ids[] = $result['id_origen_db'];
			}
		}
		
		$cons = '';
		foreach( (array) $ids as $id ){
			$cons.= " id_origen_db = {$id} OR ";
		}
		
		$cons = substr_replace($cons, "", -3);
		
		$query = "SELECT * FROM prop_origen_db WHERE {$cons} ";
		$result = $this->adoDbFab->GetAll($query);	
		
		return $result;	
		
	}
	
	public function getAvailableDuracion( $id_row_met, $id_pob_objetivo, $id_origen_db ){
		$met_selected = $this->getMetSelected($id_row_met);
		
		$query = "SELECT *  FROM  prop_tarifario 
		WHERE  id_metodologia = '{$met_selected['id_metodologia']}' AND  id_pob_objetivo = '{$id_pob_objetivo}'
		AND id_origen_db = '{$id_origen_db}' ";
		
		$ids = array();
		foreach( $this->adoDbFab->GetAll($query) as $result ){
			if( !in_array( $result['id_duracion'], $ids ) ){
				$ids[] = $result['id_duracion'];
			}
		}
		
		$cons = '';
		foreach( (array) $ids as $id ){
			$cons.= " id_duracion = {$id} OR ";
		}
		
		$cons = substr_replace($cons, "", -3);
		
		$query = "SELECT * FROM prop_duracion WHERE {$cons} ";
		$result = $this->adoDbFab->GetAll($query);
		
		return $result;	
		
	}
	
	public function getAvailableDificultad( $id_row_met, $id_pob_objetivo, $id_origen_db, $id_duracion ){
		$met_selected = $this->getMetSelected($id_row_met);
		
		$query = "SELECT *  FROM  prop_tarifario 
		WHERE  id_metodologia = '{$met_selected['id_metodologia']}' AND  id_pob_objetivo = '{$id_pob_objetivo}'
		AND id_origen_db = '{$id_origen_db}' AND id_duracion = '{$id_duracion}' ";
		
		$ids = array();
		foreach( $this->adoDbFab->GetAll($query) as $result ){
			if( !in_array( $result['id_nivel_aceptacion'], $ids ) ){
				$ids[] = $result['id_nivel_aceptacion'];
			}
		}
		
		$cons = '';
		foreach( (array) $ids as $id ){
			$cons.= " id_nivel_aceptacion = {$id} OR ";
		}
		
		$cons = substr_replace($cons, "", -3);
		
		$query = "SELECT * FROM prop_nivel_aceptacion WHERE {$cons} ";
		$result = $this->adoDbFab->GetAll($query);
		
		return $result;	
		
	}
	
	/* Consultas respuesta metodologia (tabla inverson) */
	public function getMetodologiaRta(){
		
		$idPropuesta = $this->id_propuesta;
		
		$sql = "SELECT *
		 FROM ".tablaMetodologia." M INNER JOIN ".tablaMetodologiaRTA." R USING(id_metodologia)
		  WHERE R.id_propuesta=$idPropuesta
		   ORDER BY 1";
		
		return $this->adoDbFab->GetAll($sql);
	}
	
	public function getMetologiaSegmentoRta($idRowMetodologia){
		$sqlR = "SELECT *
		 FROM ".tablaSegmentoMetodologiaRTA." R
		  WHERE R.id_row_metodologia=$idRowMetodologia
		   ORDER BY 1";
		   
		return $this->adoDbFab->GetAll($sqlR);
	}
}