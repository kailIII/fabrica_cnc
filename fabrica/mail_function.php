<?php

require_once dirname(__FILE__)."/PHPMailer_v5.1/class.phpmailer.php";
require_once dirname(__FILE__).'/classes/class.Propuesta.php';

function sendMail( $emails = array() , $subject, $content, $from_name, $from_email, $adjuntos = false ){

	$content = stripslashes($content);
	$subject = utf8_encode( $subject );
	
	$propuesta = new Propuesta( $_POST[ 'id_propuesta' ] );
	
	foreach( $emails as $mailAddr ){

//		$mailAddr = "felipe.gaitan.81@gmail.com";
		$mail = new PHPMailer();

		if( true or $_SERVER['SERVER_ADDR'] == "127.0.0.1" || trim(strtolower($_SERVER['SERVER_NAME'])) == 'servidor' || trim(strtolower($_SERVER['SERVER_NAME'])) == 'localhost' ){
			$mail->IsSMTP();
			$mail->SMTPAuth 	= true;
			$mail->Host 		= "smtp.office365.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
			$mail->Username 	= "comercial@cnccol.com"; // Correo completo a utilizar
			$mail->Password 	= "%CNC2013$"; // Contraseña
			$mail->SMTPSecure 	= "tls";
			$mail->Port 		= 587; // Puerto a utilizar
		}

		if( $adjuntos ){
			foreach( (array)$adjuntos as $file_info ){
				$mail->AddAttachment( $file_info['fuente'] , $file_info['nombre'] );
			}
		}

		
	  	$mail->AddAddress( $mailAddr );
	  	$mail->IsHTML( true );
	  	
	  	$mail->From 	= $from_email;
	  	$mail->FromName = $from_name;
	  	$mail->CharSet 	= "UTF-8";
	  	$mail->Subject 	= $subject;
	  	$mail->Body 	= $content;
	  	$mail->AltBody 	= "";
	  	
	  	$exito = $mail->Send( );

	  	$intentos = 1;
		while ((!$exito) && ($intentos < 4)) {
			sleep(1);
			//echo $mail->ErrorInfo;
			$exito = $mail->Send();
			$intentos++;
		}
		
		if( $exito === true ){
			
			$crypt_archivo 		= $_POST[ "crypt_archivo" ];
			$codigo_validacion 	= $_POST[ "codigo_validacion" ];
			
			$propuesta->propuesta_enviada( $crypt_archivo , $codigo_validacion , $mailAddr );
				
		}
		
		echo $exito;
	}

}

