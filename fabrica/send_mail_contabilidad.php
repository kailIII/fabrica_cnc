<?php
//----
function sendMail($idPropuesta,$destinatario,$asunto,$tituloPropuesta,$empresa_cliente){
	$cuerpo = " 
	<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
	<html xmlns='http://www.w3.org/1999/xhtml'>
	<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<title>Propuesta aprobada</title> 
	</head> 
	<body> 
	<h1>F&aacute;brica de propuestas</h1> 
	<p><span style='font-size:14px'> 
	La Propuesta <em>$tituloPropuesta</em> para el cliente <em>$empresa_cliente</em>, ha sido aprobada, se solicita centro de costos y carpetas en la red.</span>
	<BR />
	<BR />
	<a href='http://herramientascnc.com/propuesta/fabrica/propuestas/Propuesta_Id".$idPropuesta.".docx'><span style='font-size:14px'>Haga clic aqu&iacute; para descargar la propuesta</span>
	</p> 
	<body>
	</body>
	</html>"; 
	
	//Envío en formato HTML 
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
	
	//Dirección del remitente 
	$headers .= "From: Fábrica de propuestras <fabricacnc@gmail.com>\r\n"; 
	
	//Dirección de respuesta (Puede ser una diferente a la de pepito@mydomain.com)
	$headers .= "Reply-To: fabricacnc@gmail.com\r\n"; 
	
	//Ruta del mensaje desde origen a destino 
	$headers .= "Return-path: fabricacnc@gmail.com\r\n"; 
	
	//direcciones que recibián copia 
	//$headers .= "Cc: maria@mydomain.com\r\n"; 
	
	//Direcciones que recibirán copia oculta 
	//$headers .= "Bcc: pepe@pepe.com, juan@juan.com\r\n"; 
	
	mail($destinatario,$asunto,$cuerpo,$headers); 
}
?>