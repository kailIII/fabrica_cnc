<?php

session_start();

require_once dirname(__FILE__).'/krumo/class.krumo.php';
require_once dirname(__FILE__).'/classes/class.Propuesta.php';
require_once dirname(__FILE__).'/classes/class.Usuario.php';
require_once dirname(__FILE__).'/classes/class.ClonePropuesta.php';


$Usuario = new Usuario( $_SESSION['userAdmin'] );
$Clon = new ClonePropuesta( 144 );

$data = array(
	'titulo' 		=> 'prueba clon',
	'id_usuario' 	=> $Usuario->getIdEquipo()
);


$Clon->makeClone( $data );


