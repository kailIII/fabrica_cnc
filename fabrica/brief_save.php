<?php

session_start();

require_once dirname(__FILE__).'/classes/class.Metodologia.php';
require_once dirname(__FILE__).'/krumo/class.krumo.php';
require_once dirname(__FILE__).'/classes/class.SqlQuery.php';
require_once dirname(__FILE__).'/classes/class.Usuario.php';

$Usuario 	= new Usuario( $_SESSION['userAdmin'] );
$this_user 	= $Usuario->getUsuario();

$SqlQuery = new SqlQuery;
$idPropuesta = $_POST['idPropuesta'];

// CALENDARIO

// $sqlP = "SELECT * FROM ".tablaProceso." ORDER BY id_proceso";
$sqlP = "SELECT * FROM ".tablaProceso." WHERE id_propuesta = {$idPropuesta} ORDER BY id_proceso";
		//echo '<BR>'.$sqlP;
$conP				= mysql_query($sqlP);
while($camposP		= mysql_fetch_array($conP)){
	$id_proceso		= $camposP["id_proceso"];
	
	$nameObjC		= 'p'.$idPropuesta.'p'.$id_proceso;
	$arraySemProceso= $_POST[$nameObjC];
	if(empty($arraySemProceso)){
		$arraySemProceso= array();
	}
	$sql = "REPLACE INTO ".tablaCalendario." (id_propuesta,id_proceso,semanas)
	VALUES (".$idPropuesta.",'$id_proceso','".implode(',',$arraySemProceso)."')";
			//echo '<BR>'.$sql;
	$SqlQuery->Execute( $sql );

}

foreach( $_POST['nom_proceso'] as $id_proceso => $value ){
	$sql = "UPDATE prop_proceso SET nom_proceso = '{$value}' WHERE id_proceso = {$id_proceso} AND id_propuesta = {$idPropuesta} ";
	$SqlQuery->Execute( $sql );
}

foreach( $_POST['res_proceso'] as $id_proceso => $value ){
	$sql = "UPDATE prop_proceso SET responsable = '{$value}' WHERE id_proceso = {$id_proceso} AND id_propuesta = {$idPropuesta} ";
	$SqlQuery->Execute( $sql );
}

$sql = "UPDATE prop_propuesta set ruta_critica = '{$_POST['ruta_critica']}' WHERE id_propuesta = {$idPropuesta} ";
$SqlQuery->Execute( $sql );

foreach( $_POST['calendario_area_responsable'] as $id_proceso => $id_area ){
	
	$sql = "UPDATE prop_calendario SET id_area = '{$id_area}' WHERE id_propuesta = '{$idPropuesta}' AND id_proceso = '{$id_proceso}'";
	$SqlQuery->Execute($sql);
	
}


// PRODUCTOS (INVERSION)



$vr_dir_estudio		= $_POST[ nameObjVrDirEstudio ];
$forma_pago			= $_POST[ 'forma_pago' ];
$vr_dir_estudio		= str_replace( ',' , '' , $vr_dir_estudio );
$vr_dir_estudio		= str_replace( '.' , '' , $vr_dir_estudio );
$validez_prop 		= $_POST[ 'validez_propuesta' ];


$vr_dir_estudio_2 	= $_POST[ "vr_dir_estudio_2" ];
$vr_dir_estudio_2	= str_replace( ',' , '' , $vr_dir_estudio_2 );
$vr_dir_estudio_2	= str_replace( '.' , '' , $vr_dir_estudio_2 );

		//---- actualiza el valor de la dirección de estudios
$sql = "UPDATE " . tablaPropuesta . " 
SET vr_dir_estudio 		= '$vr_dir_estudio' , 
vr_dir_estudio_2 	= '$vr_dir_estudio_2' , 
conf_vr_dir_estudio = 1 , 
forma_pago 			= '$forma_pago' , 
validez_propuesta 	= '$validez_prop' 
WHERE id_propuesta = $idPropuesta ";

$SqlQuery->Execute( $sql );

		//---- consulta los segmentos de la propuesta
$sqlR = "SELECT * FROM " . tablaSegmentoMetodologiaRTA . " R 
WHERE id_propuesta = $idPropuesta 
ORDER BY 1 ";

$filasSegmentos	= NULL;
$conR			= mysql_query( $sqlR );

while( $camposR = mysql_fetch_array( $conR ) ){
	
	$id_row_segmento 	= $camposR[ "id_row_segmento" ];
	$idObjVrUnit 		= nameObjVrUnitario . $id_row_segmento;
	$vr_unitario 		= $_POST[ $idObjVrUnit ];
	$vr_unitario 		= str_replace( ',' , '' , $vr_unitario );
	$vr_unitario 		= str_replace( '.' , '' , $vr_unitario );

	$sql = "UPDATE " . tablaSegmentoMetodologiaRTA . " 
	SET precio_unitario = '$vr_unitario' 
	WHERE id_propuesta = $idPropuesta 
	AND id_row_segmento = $id_row_segmento ";
	
	
	$SqlQuery->Execute( $sql );
	
}

for( $k = 1 ; $k <= 2 ; $k++ ){
	
	$j = ( $k === 1 ) ? "" : "_$k"; 
	
	$arrayProductos 	= $_POST[ 'productos' 	. $j ];
	$arrayVrUnit 		= $_POST[ 'vrUnit' 		. $j ];
	$arrayCantidad 		= $_POST[ 'cantidad' 	. $j ];
	$arrayTabla 		= $_POST[ 'tabla' 		. $j ];
	$arrayIdProducto 	= $_POST[ 'IdProducto' 	. $j ]; 
	
	foreach( ( array ) $arrayProductos as $ind => $producto ){
		
		$cantidad 		= $arrayCantidad[ $ind ];
		$vr_unitario	= $arrayVrUnit[ $ind ];
		$id_producto	= $arrayIdProducto[ $ind ];
		$tabla 			= $arrayTabla[ $ind ];
		
		$cantidad		= str_replace( ',' , '' , $cantidad);
		$cantidad		= str_replace( '.' , '' , $cantidad);
		$cantidad 		= ( $cantidad == "" ) ? 0 : $cantidad;
		
		$vr_unitario	= str_replace( ',' , '' , $vr_unitario);
		$vr_unitario	= str_replace( '.' , '' , $vr_unitario);
		
		
		if( !empty( $id_producto ) ){
			$sql = "UPDATE ".tablaInversion." SET id_propuesta = $idPropuesta ,
			producto 	= '$producto' , 
			cantidad 	= '$cantidad' ,
			vr_unitario = '$vr_unitario' , 
			tabla 		= $tabla
			WHERE id_producto = " . $id_producto;
		}
		else{
			$sql = "INSERT INTO " . tablaInversion . " 
			( id_propuesta , producto , cantidad , vr_unitario , tabla ) 
			VALUES ( $idPropuesta , '$producto' , '$cantidad' , '$vr_unitario' , $tabla )";
		}
				
		
		$SqlQuery->Execute( $sql );
	}
	
	foreach( $_POST['cantidad_met'] as $id_row_segmento => $cantidad ){
		$sql = "UPDATE prop_seg_metodologia_rta SET  muestra = '{$cantidad}' WHERE id_row_segmento = '{$id_row_segmento}' ";
		$SqlQuery->Execute($sql);
	}

	foreach( $_POST['area_metodologia'] as $id_row_segmento => $id_area ){
		$sql = "UPDATE prop_seg_metodologia_rta SET  id_area = '{$id_area}' WHERE id_row_segmento = '{$id_row_segmento}' ";
		$SqlQuery->Execute($sql);	
	}

	foreach( $_POST['area_inversion'] as $id_producto => $id_area ){
		$sql = "UPDATE prop_inversion SET  id_area = '{$id_area}' WHERE id_producto = '{$id_producto}' ";
		$SqlQuery->Execute($sql);		
	}

}

// registra el cambio en BD
$sql = "INSERT INTO prop_reg_cambios SET
			id_propuesta 		= '{$_POST['idPropuesta']}',
			motivos_cambio 		= '{$_POST['motivo_cambio']}',
			id_equipo_cnc 		= '{$this_user['id_equipo_cnc']}',
			nombre_responsable 	= '{$this_user['nombre']}' ";

$SqlQuery->Execute($sql);

header('Location: '.$_SERVER['HTTP_REFERER']  );