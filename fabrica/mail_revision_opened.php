<?php

require_once dirname(__FILE__).'/classes/class.Propuesta.php';

$Propuesta = new Propuesta( $_GET['id_propuesta'] );
$Propuesta->setEstadoFinal( 2 );