<?php

require_once dirname(__FILE__).'/classes/class.Metodologia.php';
require_once dirname(__FILE__).'/krumo/class.krumo.php';
$idPropuesta = $_POST['idPropuesta'];

$MetodologiaDml = new Metodologia( $idPropuesta );
sleep(2); // por alguna razon necesario para que no se salte el guardado en ciertas ocasiones

if( $_POST['add_metodologia'] == 1 ){

	if( isset( $_POST['sub_metodologia'] ) ){
		$MetodologiaDml->insertMetodologia($_POST['id_metodologia'], $_POST['sub_metodologia'] );
	} else {
		$MetodologiaDml->insertMetodologia($_POST['id_metodologia']);
	}
}

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
		

		/*if( $_POST['set_default_inv'] == 1 ){
			$Propuesta->setInversionToDefault();
		}*/
		
header('Location: '. $_SERVER['HTTP_REFERER'].'&refresh' );