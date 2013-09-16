<?php

require_once dirname(__FILE__).'/classes/class.Propuesta.php';
require_once dirname(__FILE__).'/krumo/class.krumo.php';
require_once dirname(__FILE__).'/adodb5/adodb.inc.php';
require_once dirname(__FILE__).'/classes/class.Contenidos.php';

$adoDbFix = NewADOConnection('mysql');
$adoDbFix->Connect( 'localhost' , 'ab1255_cnc' , 'df7)!cnc)43()' , 'ab1255_fabrica');


$query = "SELECT * FROM prop_propuesta";
$propuestas = $adoDbFix->GetAll($query);


$Contenidos = new Contenidos();
$procesos = $Contenidos->getDefaultsProceso();

foreach( $propuestas as $prop ){
	//if( $prop['id_propuesta'] == 59 ){

	$query = "SELECT * FROM prop_proceso WHERE id_propuesta = {$prop['id_propuesta']}";
	$procesos_asignados = $adoDbFix->GetAll($query);


	krumo($procesos_asignados);

	$query = "SELECT * FROM prop_calendario WHERE id_propuesta = {$prop['id_propuesta']}";
	$procesos_calendario = $adoDbFix->GetAll($query);

	krumo($procesos_calendario);

	foreach( $procesos_asignados as $key => $val ){

		$id_proceso_mod = $key+1;
		$query = "UPDATE prop_calendario SET id_proceso = {$val['id_proceso']} WHERE id_propuesta = {$prop['id_propuesta']} AND id_proceso = {$id_proceso_mod}"	;

		// $adoDbFix->Execute($query);
	}

	//}
}