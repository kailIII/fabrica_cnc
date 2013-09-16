<?php

require_once dirname(__FILE__).'/../classes/class.Propuesta.php';

$Propuesta = new Propuesta( $_POST['id_propuesta'] );

switch( $_POST['opc'] ){
	
	case 'add_proceso':
		$Propuesta->addProceso();
		break;
	
	case 'delete_proceso':
		$Propuesta->deleteProceso( $_POST['id_proceso'] );
		break;
	
}
