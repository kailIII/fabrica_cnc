<?php
session_start();
require_once dirname(__FILE__).'/krumo/class.krumo.php';

$_SESSION['filtros'] = array(
	'titulo' 		=> $_POST['filter_titulo'],
	'cliente'		=> $_POST['filter_cliente'],
	'presentada' 	=> $_POST['filter_presentada'],
	'cargo' 		=> $_POST['filter_cargo'],
	'tipo' 			=> $_POST['filter_tipo'],
	'estado' 		=> $_POST['filter_estado']
);

header('Location: '.$_SERVER['HTTP_REFERER'] );