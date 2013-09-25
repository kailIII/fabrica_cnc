<?php

require_once dirname(__FILE__).'/../mail_function.php';
require_once dirname(__FILE__).'/../classes/class.Propuesta.php';
require_once dirname(__FILE__).'/../classes/class.Contenidos.php';


$Propuesta = new Propuesta( $_POST['id_propuesta'] );
$Contenidos = new Contenidos;

$info_prop = $Propuesta->getProp();

$fabrica_dev = explode('/', $_SERVER['PHP_SELF'] );
$fabrica_dev = $fabrica_dev[2];



$emails[] 			= $_POST[ "recipent" ];
$subject 			= utf8_decode("Propuesta envíada para revisión");
$crypt_archivo 		= $_POST[ "crypt_archivo" ];
$codigo_validacion 	= $_POST[ "codigo_validacion" ];

$mailBody = file_get_contents( dirname(__FILE__).'/../email_templates/mail_revision.html' );
$mailBody = str_replace( "{titulo_propuesta}" , $_POST['titulo_propuesta'] , $mailBody );


$redirect = 'prop_por_revisar.php?idMenu=3&idPropuesta='.$info_prop['id_propuesta'];
$redirect = rtrim(strtr(base64_encode($redirect), '+/', '-_'), '=');

$link_revision = 'http://herramientascnc.com/propuesta/fabrica/robot.php?autoAuth='.$Contenidos->encryptData( $info_prop['revisada_por'] ).'&redirect='.$redirect;
//$link_revision = 'http://localhost/fabrica_cnc/'. $fabrica_dev .'/robot.php?autoAuth='.$Contenidos->encryptData( $info_prop['revisada_por'] ).'&redirect='.$redirect;
$mailBody = str_replace( "{link_revision}" , $link_revision , $mailBody );

$link_descarga = 'http://herramientascnc.com/propuesta/fabrica/descarga_archivo.php?crypt_archivo=' . $crypt_archivo  . '&codigo_validacion=' . $codigo_validacion . '&propuesta=' . $Contenidos->encryptData( $_POST['id_propuesta'] ) . '&email=' . $Contenidos->encryptData( $_POST[ "recipent" ] );
//$link_descarga = 'http://localhost/fabrica_cnc/'. $fabrica_dev .'/descarga_archivo.php?crypt_archivo=' . $crypt_archivo  . '&codigo_validacion=' . $codigo_validacion . '&propuesta=' . $Contenidos->encryptData( $_POST['id_propuesta'] ) . '&email=' . $Contenidos->encryptData( $_POST[ "recipent" ] );
$mailBody = str_replace( "{link_descarga}" , $link_descarga , $mailBody );

$mailBody = str_replace( "{id_propuesta}" , $_POST['id_propuesta'] , $mailBody );


$from_name = "CNC - Fábrica";
$from_email = "comercial@cnccol.com";
//$from_email = "noreply@cnc.com";

$adjuntos = array(
	array(
		'fuente' =>  dirname(__FILE__).'/../'.$_POST['path_propuesta'],
		'nombre' => end( explode('/', $_POST['path_propuesta'] ))
	)
);
echo sendMail( $emails , $subject , $mailBody , $from_name , $from_email , false, true );

// si hay no en idoneidad envia mails a las vps
if( $Propuesta->noEnIdoneidad() ){
	
	$Propuesta->sendEmailNoIdoneidad();
}
