<?php
// realiza acciones automaticas
session_start();

require_once dirname(__FILE__).'/classes/class.Contenidos.php';
$Contenidos = new Contenidos;

require_once dirname(__FILE__).'/classes/class.Usuario.php';
require_once dirname(__FILE__).'/krumo/class.krumo.php';

// auto logeo
if( isset($_GET['autoAuth']) && $_GET['autoAuth'] != '' ){

	$id = $Contenidos->decryptData( $_GET['autoAuth'] );
	$User = new Usuario( false, $id );

	$user = $User->getUsuario();
	$_SESSION = array(
		'tipoUsuario ' 	=> NULL,
		'userAdmin' 	=> $user['id_empleado'],
		'usuarioAdmin' 	=> $user['id_empleado'],
		'nomUsuario' 	=>  $user['nombres'].' '.$user['apellidos'],
		'claveAdmin' 	=> $user['clave'],
		'is_robot' 		=> TRUE
	);
}

// redireccion
if( isset( $_GET['redirect'] ) && $_GET['redirect'] != '' ){

	$redirect = base64_decode(strtr($_GET['redirect'], '-_', '+/'));

	header( 'Location: '.$redirect );
}
