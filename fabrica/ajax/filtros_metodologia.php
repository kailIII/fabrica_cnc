<?php

require_once dirname(__FILE__).'/../classes/class.Metodologia.php';
$Metodologia = new Metodologia( $_POST['id_propuesta'] );

switch( $_POST['opc'] ){
	
	case 'get_origen_db':
		$origen_db = $Metodologia->getAvailableOrigenDb( $_POST['id_met'], $_POST['id_pob_objetivo'] );

		$options = '<option value="" >Selecione...</option>';
		foreach( $origen_db as $odb ){
			$options.='<option value="'. $odb['id_origen_db'] .'" >'. $odb['nom_origen_db'] .'</option>';
		}
		
		echo utf8_encode($options);

		break;
	
	case 'get_duracion':
		$duracion = $Metodologia->getAvailableDuracion($_POST['id_met'], $_POST['id_pob_objetivo'], $_POST['id_origen_db'] );
		$options = '<option value="" >Selecione...</option>';
		foreach( $duracion as $dur ){
			$options.='<option value="'. $dur['id_duracion'] .'" >'. $dur['duracion'] .'</option>';
		}
		
		echo utf8_encode($options);
		break;
	
	case 'get_dificultad':
		$dificultad = $Metodologia->getAvailableDificultad($_POST['id_met'], $_POST['id_pob_objetivo'], $_POST['id_origen_db'], $_POST['id_duracion'] );
		$options = '<option value="" >Selecione...</option>';
		foreach( $dificultad as $dif ){
			$options.='<option value="'. $dif['id_nivel_aceptacion'] .'" >'. $dif['des_nivel_aceptacion'] .'</option>';
		}
		
		echo utf8_encode($options);
		break;
}