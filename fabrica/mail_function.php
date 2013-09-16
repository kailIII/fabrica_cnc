<?php

require_once dirname(__FILE__)."/PHPMailer_v5.1/class.phpmailer.php";

function sendMail( $emails = array() , $subject, $content, $from_name, $from_email, $adjuntos = false ){

	$content = stripslashes($content);
	$subject = utf8_encode( $subject );

	foreach( $emails as $mailAddr ){

		$mail = new PHPMailer();

		/*if( $_SERVER['SERVER_ADDR'] == "127.0.0.1" || trim(strtolower($_SERVER['SERVER_NAME'])) == 'servidor' || trim(strtolower($_SERVER['SERVER_NAME'])) == 'localhost' ){
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host = "smtp.gmail.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
			$mail->Username = "ingenieria@mipagina.net"; // Correo completo a utilizar
			$mail->Password = "cambio123"; // Contraseña
			$mail->SMTPSecure = "ssl";
			$mail->Port = 465; // Puerto a utilizar
		}*/

		if( $adjuntos ){
			foreach( (array)$adjuntos as $file_info ){
				$mail->AddAttachment( $file_info['fuente'] , $file_info['nombre'] );
			}
		}

		$mail->From = $from_email;
	  	$mail->FromName = $from_name;
	  	$mail->AddAddress( $mailAddr );
	  	$mail->CharSet = "UTF-8";
	 	$mail->IsHTML(true);
	  	$mail->Subject = $subject;
	  	$mail->Body = $content;
	  	$mail->AltBody = "";
	  	$exito = $mail->Send();

	  	$intentos=1;
		while ((!$exito) && ($intentos < 4)) {
			sleep(1);
			//echo $mail->ErrorInfo;
			$exito = $mail->Send();
			$intentos++;
		}
	}

}


// ejemplo uso

/*
$email = array('email1@mail.com', 'email2@mail.com');
$subject = "asunto";
$contenido "hola mundo";
$from_name = "Alguien ...";
$adjuntos = array(
	array(
		'fuente' => 'carpeta/nombre_archivo.ext',
		'nombre' => 'archivo 1'
	),
	array(
		'fuente' => 'carpeta/nombre_archivo2.ext',
		'nombre' => 'archivo 2'
	)
);
*/