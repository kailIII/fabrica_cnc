<?php

require_once dirname(__FILE__).'/classes/class.Propuesta.php';
require_once dirname(__FILE__).'/krumo/class.krumo.php';
$Propuesta = new Propuesta( $_POST['id_propuesta'] );

switch( $_POST['opc'] ){
	
	case 'cambiar_estado_prop':
		$Propuesta->setEstadoFinal( $_POST['estado_prop'] );
		break;
		
	case 'nuevo_comentario':

		if( $_POST['leComment'] != '' ){
			$Propuesta->addComentario( $_POST['id_usuario'] , $_POST['leComment'] );
		}

		header('Location: '.$_SERVER['HTTP_REFERER'] );
		break;
}