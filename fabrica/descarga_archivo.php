<?php

	include_once( "funciones.php" );
	include_once( "../ctl_login_admin.php" );
	require_once dirname(__FILE__) . '/classes/class.Contenidos.php';
	require_once dirname(__FILE__) . '/classes/class.Propuesta.php';
	
	$contenidos 		= new Contenidos;
	$crypt_archivo 		= $_GET[ "crypt_archivo" ]; 
	$codigo_validacion 	= $_GET[ "codigo_validacion" ]; 
	$email 				= $contenidos->decryptData( $_GET[ "email" ] );
	$id_propuesta 		= $contenidos->decryptData( $_GET[ "propuesta" ] );
	
	if( md5( $contenidos->decryptData( $crypt_archivo ) ) == $codigo_validacion ){
		
		$nombre_archivo = $contenidos->decryptData( $crypt_archivo );
		$nombre_archivo = explode( "::" , $nombre_archivo );
		$nombre_archivo = ( is_array( $nombre_archivo ) and isset( $nombre_archivo[ 1 ] ) ) ? $nombre_archivo[ 1 ] : "";
		
		if( $nombre_archivo != "" ){
			
			$tmp = "Propuesta_Id" . $id_propuesta;
			if( trim ( $nombre_archivo ) == trim( $tmp ) ){
				
				if( file_exists( pathPropuestas_docx . '/registros/' . $crypt_archivo ) ){
					
					$propuesta = new Propuesta( $id_propuesta );
					$propuesta->descarga_propuesta( );
					
				} else {
					die( "El archivo no existe" );
				}
				
			} else {
				die( "link no valido" );
			}
			
		} else {
			die( "link no valido" );
		}
		
	} else {
		die( "link no valido" );
	}
	