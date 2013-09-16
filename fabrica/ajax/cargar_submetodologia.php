<?php

require_once dirname(__FILE__).'/../classes/class.Contenidos.php';
$Contenidos = new Contenidos;

$sub_metodologias = $Contenidos->getSubMetodologia( $_POST['id_metodologia'] );
if( count($sub_metodologias) == 0 ){
	
	echo '';
} else {
	
	$options = '';
	foreach( (array) $sub_metodologias as $smt ){
		$options.='<option value="'. $smt['id_sub_met'] .'" >'. $smt['nom_sub_met'] .'</option>';
	}
	
	echo $options;
}
