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
	
	$Propuesta = new Propuesta( $prop['id_propuesta'] );
	$Propuesta->setFechasCalendario();
}