<?php

require_once dirname(__FILE__).'/../mail_function.php';
require_once dirname(__FILE__).'/../classes/class.Propuesta.php';
require_once dirname(__FILE__).'/../classes/class.Contenidos.php';


$Propuesta = new Propuesta( $_POST['id_propuesta'] );
$Contenidos = new Contenidos;

$info_prop = $Propuesta->getProp();

$fabrica_dev = explode('/', $_SERVER['PHP_SELF'] );
$fabrica_dev = $fabrica_dev[2];



$emails[] = $_POST['recipent'];
$subject = utf8_decode("Propuesta envíada para revisión");

$mailBody = file_get_contents( dirname(__FILE__).'/../email_templates/mail_revision.html' );
$mailBody = str_replace( "{titulo_propuesta}" , $_POST['titulo_propuesta'] , $mailBody );


$redirect = 'prop_por_revisar.php?idMenu=3&idPropuesta='.$info_prop['id_propuesta'];
$redirect = rtrim(strtr(base64_encode($redirect), '+/', '-_'), '=');

$link_revision = 'http://herramientascnc.com/propuesta/'. $fabrica_dev .'/robot.php?autoAuth='.$Contenidos->encryptData( $info_prop['revisada_por'] ).'&redirect='.$redirect;
$mailBody = str_replace( "{link_revision}" , $link_revision , $mailBody );

$mailBody = str_replace( "{id_propuesta}" , $_POST['id_propuesta'] , $mailBody );


$from_name = "CNC - Fábrica";
$from_email = "noreply@cnc.com";

$adjuntos = array(
	array(
		'fuente' =>  dirname(__FILE__).'/../'.$_POST['path_propuesta'],
		'nombre' => end( explode('/', $_POST['path_propuesta'] ))
	)
);

sendMail( $emails, $subject, $mailBody, $from_name, $from_email, $adjuntos);

// si hay no en idoneidad envia mails a las vps
if( $Propuesta->noEnIdoneidad() ){
	
	$Propuesta->sendEmailNoIdoneidad();
}
