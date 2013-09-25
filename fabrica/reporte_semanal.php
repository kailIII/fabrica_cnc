<?php

require_once dirname(__FILE__).'/classes/class.ReporteSemanal.php';
require_once dirname(__FILE__).'/classes/class.Metodologia.php';
require_once dirname(__FILE__).'/PHPExcel_1.7.9/Classes/PHPExcel.php';
require_once dirname(__FILE__).'/classes/class.Usuario.php';

session_start();

$Usuario = new Usuario( $_SESSION['userAdmin'] );
$info_usuario = $Usuario->getUsuario();

if( $info_usuario['super'] != 1 ){ exit('Acceso limitado a super usuarios');  } 

$Reporte = new ReporteSemanal;

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("CNC")
							 ->setLastModifiedBy("CNC")
							 ->setTitle("Reporte")
							 ->setSubject("Reporte")
							 ->setDescription("Reporte")
							 ->setKeywords("Reporte")
							 ->setCategory("Reporte");

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Propuesta')
			->setCellValue('B1', 'Cliente')
            ->setCellValue('C1', 'Tipo')
            ->setCellValue('D1', 'Contexto')
            ->setCellValue('E1', 'Objetivo General')
			->setCellValue('F1', 'Objetivos Especificos')
			->setCellValue('G1', 'Metodologías' );


$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);



$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);			
			

if( isset($_POST["fecha_desde"]) ){
	$propuestas 	= $Reporte->getPropuestas( $_POST["fecha_desde"], $_POST["fecha_hasta"] );
	$nombre_archivo = 'reporte_propuestas_'.$_POST["fecha_desde"].'_'.$_POST["fecha_hasta"];
} else {
	$propuestas 	= $Reporte->getPropuestas();
	$nombre_archivo = 'reporte_propuestas';
}


foreach( $propuestas as $key_p => $prop ){
	
	$current_row 	= $key_p+2;
	
	$nom_prop 		= $prop["titulo"];
	$cliente 		= $prop["empresa_cliente"];
	$tipo 			= $prop["descripcion"];
	$contexto 		= $prop["contexto"];
	$obj_gral 		= $prop["objetivo_general"];
	$obj_espc 		= explode( "||", $prop["objetivos_especificos"] );
	$id_propuesta 	= $prop["id_propuesta"];
	
	$Metodologia 	= new Metodologia( $id_propuesta );
	$metodologias 	= $Metodologia->getPropMetodologias();
	
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue( 'A'.$current_row, utf8_encode( $nom_prop ) )
				->setCellValue( 'B'.$current_row, utf8_encode( $cliente ) )
				->setCellValue( 'C'.$current_row, utf8_encode( $tipo ) )
				->setCellValue( 'D'.$current_row, utf8_encode( $contexto ) )
				->setCellValue( 'E'.$current_row , utf8_encode( $obj_gral ) );
	
	foreach( $obj_espc as $obj ){
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue( 'F'.$current_row, $objPHPExcel->setActiveSheetIndex(0)->getCell( 'F'.$current_row )->getValue().utf8_encode( $obj )."\n" );
	}
	
	foreach( $metodologias as $met ){
		$nom_metodologia = $met["nom_metodologia"];
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue( 'G'.$current_row, $objPHPExcel->setActiveSheetIndex(0)->getCell( 'G'.$current_row )->getValue().utf8_encode( $nom_metodologia )."\n" );
	}
}

$objPHPExcel->setActiveSheetIndex(0)->setTitle('Propuestas');

// HOJA DE INVERSION
$objPHPExcel->createSheet(1);

$objPHPExcel->setActiveSheetIndex(1)->setTitle('Inversión');

$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('A')->setWidth(50);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);


$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);


$objPHPExcel->getActiveSheet()
            ->setCellValue('A1', 'Propuesta')
			->setCellValue('B1', 'Metodologías' )
			->setCellValue('C1', 'Descripción')
            ->setCellValue('D1', 'Cantidad')
            ->setCellValue('E1', 'Valor unitario')
            ->setCellValue('F1', 'Valor total')
			->setCellValue('G1', 'Resumen' );


$current_row 	= 2; // Datos inician en fila 2 
$total_vendido 	= 0;

foreach( $propuestas as $key_p => $prop ){
	
	$id_propuesta 	= $prop["id_propuesta"];
	$nom_prop 		= $prop["titulo"];
	$Metodologia 	= new Metodologia( $id_propuesta );
	$metodologias 	= $Metodologia->getPropMetodologias();
	$valor_estudio 	= $prop["vr_dir_estudio"];
	
	$subTotal 		= $valor_estudio;
	
	
	$objPHPExcel->setActiveSheetIndex(1)
				->setCellValue( 'A'.$current_row, utf8_encode( $nom_prop ) );
	
	$met_aplicadas = array();
	
	// evita nombres de metodologias repetidas				
	foreach( $metodologias as $met ){
		
		if(! in_array($met['nom_metodologia'], $met_aplicadas ) ){
			$met_aplicadas[] = $met['nom_metodologia'];
		}
		
	}
	
	$objPHPExcel->setActiveSheetIndex(1)
		->setCellValue( 'B'.$current_row, $objPHPExcel->setActiveSheetIndex(1)->getCell( 'B'.$current_row )->getValue().utf8_encode( implode("\n\n" , $met_aplicadas ) ));
	
	$init_row = $current_row;
	
	
	$objPHPExcel->setActiveSheetIndex(1)
	->setCellValue( 'C'.$current_row, 'Dirección de estudios' )
	->setCellValue( 'D'.$current_row, 1 )
	->setCellValue( 'E'.$current_row, $valor_estudio )
	->setCellValue( 'F'.$current_row, $valor_estudio );
	
	$objPHPExcel->getActiveSheet()->getStyle( 'E'.$current_row )->getNumberFormat()
	->setFormatCode( '#,##' );
			
	$objPHPExcel->getActiveSheet()->getStyle( 'F'.$current_row )->getNumberFormat()
	->setFormatCode( '#,##' );
	
	
	foreach( $Metodologia->getMetodologiaRta() as $campos ){
		$id_metodologia		= $campos["id_metodologia"];
		$nom_metodologia	= $campos["nom_metodologia"];
		$idTipoMetodologia	= $campos["id_tipo_metodologia"];
		$idRowMetodologia	= $campos["id_row_metodologia"];
		$titulo				= $campos["titulo"];
		$temas				= $campos["temas"];
		$universo			= $campos["universo"];
		$marco_estadistico	= $campos["marco_estadistico"];
		
		if(!empty($idTipoMetodologia)){
			
			foreach( $Metodologia->getMetologiaSegmentoRta($idRowMetodologia) as $camposR ){
				
				$current_row++;
				
				$id_row_segmento	= $camposR["id_row_segmento"];
				$id_pob_objetivo	= $camposR["id_pob_objetivo"];
				$id_duracion		= $camposR["id_duracion"];
				$id_nivel_aceptacion= $camposR["id_nivel_aceptacion"];
				$id_cobertura		= $camposR["id_cobertura"];
				$id_origen_db		= $camposR["id_origen_db"];
				$nom_segmento		= $camposR["nom_segmento"];
				$universo			= $camposR["universo"];
				$muestra			= $camposR["muestra"];
				$vrUnitario			= $camposR["precio_unitario"];
				
			/**
			 * Fix Valor unitario en 0
			 * Cuando no existen valores en la BD, se calcula el valor original en vez de mostrar un valor NULL proveniente de la BD ...
			 * ...Que da por resultado 0
			 */

				if( empty($camposR["precio_unitario"]) || trim( $camposR['precio_unitario'] == '' ) ){
					$values 	= $Metodologia->calcInversion( $idRowMetodologia );
					$vrUnitario = $values['vrUnitario'];
				}
			/*
			 * EOF
			 */
			 
			$vrTotal			= '-';
			if(!empty($muestra)){
				if($muestra*$vrUnitario){
					$vrTotal	= $muestra*$vrUnitario;
					$subTotal	+= $vrTotal;
				}
				//echo '<BR>vrUnitario: '.$vrUnitario;
			}//---- Si tiene definido muestra
			@$vbMuestra		= $muestra;
			@$vbVrUnitario	= $vrUnitario;

			$descripcion	= "$nom_metodologia - $nom_segmento";
			
			$objPHPExcel->setActiveSheetIndex(1)
				->setCellValue( 'C'.$current_row, utf8_encode( $descripcion ) )
				->setCellValue( 'D'.$current_row, $vbMuestra )
				->setCellValue( 'E'.$current_row, $vbVrUnitario )
				->setCellValue( 'F'.$current_row, $vrTotal );
			
			$objPHPExcel->getActiveSheet()->getStyle( 'D'.$current_row )->getNumberFormat()
			->setFormatCode( '#,##' );
			
			$objPHPExcel->getActiveSheet()->getStyle( 'E'.$current_row )->getNumberFormat()
			->setFormatCode( '#,##' );
			
			$objPHPExcel->getActiveSheet()->getStyle( 'F'.$current_row )->getNumberFormat()
			->setFormatCode( '#,##' );
			
			// RESUMEN DE LA METODOLOGIA
			$resumen_mets[$id_metodologia]['nombre'] 	=  utf8_encode($nom_metodologia);
			$resumen_mets[$id_metodologia]['cantidad'] 	+= $vbMuestra;
			$resumen_mets[$id_metodologia]['total'] 	+= $vbVrUnitario;
			
			
			} // fin each segmento rta
			
		} 
		
	
	}// fin each metodologia rta
	
	// marca subtotal
	$current_row++;
	$objPHPExcel->getActiveSheet()
						->setCellValue( 'C'.$current_row, 'Subtotal' )
						->setCellValue( 'G'.$current_row, $subTotal  );
						
	$row_subtotal = 'G'.$current_row;
	
	$objPHPExcel->getActiveSheet()->getStyle( 'C'.$current_row )->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle( $row_subtotal )->getNumberFormat()
	->setFormatCode( '#,##' );
	
	// marca iva
	$iva = $subTotal * 0.16;
	$current_row++;
	
	$objPHPExcel->getActiveSheet()
						->setCellValue( 'C'.$current_row, 'Iva' )
						->setCellValue( 'G'.$current_row, $iva  );
	
	$row_iva = 'G'.$current_row;
						
	$objPHPExcel->getActiveSheet()->getStyle( 'C'.$current_row )->getFont()->setBold(true);						
	$objPHPExcel->getActiveSheet()->getStyle( $row_iva )->getNumberFormat()
	->setFormatCode( '#,##' );
	
	// marca total
	$current_row++;
	$granTotal 		= $subTotal + $iva; // calculo gran total manual
	$total_vendido 	+= $granTotal;
	
	
	// implementacion de formula suma de celdas para obtener el gral total
	$objPHPExcel->getActiveSheet()
						->setCellValue( 'C'.$current_row, 'Total' )
						->setCellValue( 'G'.$current_row, '=SUM(' . $row_subtotal . ':' . $row_iva . ')'  );
	
	$objPHPExcel->getActiveSheet()->getStyle( 'C'.$current_row )->getFont()->setBold(true);						
	$objPHPExcel->getActiveSheet()->getStyle( 'G'.$current_row )->getNumberFormat()
	->setFormatCode( '#,##' );
	
	// $objPHPExcel->getActiveSheet()->mergeCells('A18:E22');
	
	// une celdas de propuesta y metodologias
	if( $init_row != $current_row ){
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$init_row.':A'.($current_row));
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$init_row.':B'.($current_row));
	}
		
	// krumo( 'A'.$init_row.':A'.$current_row );
	
	$current_row+=2;
} // fin each propuestas

$objPHPExcel->getActiveSheet()
						->setCellValue( 'C'.$current_row, 'Total Vendido' )
						->setCellValue( 'G'.$current_row, $total_vendido );

$objPHPExcel->getActiveSheet()->getStyle( 'C'.$current_row )->getFont()->setBold(true);						
$objPHPExcel->getActiveSheet()->getStyle( 'G'.$current_row )->getNumberFormat()
->setFormatCode( '#,##' );

// HOJA DE TOTALES
$objPHPExcel->createSheet(2);
$objPHPExcel->setActiveSheetIndex(2)->setTitle('Resumen Totales');

$objPHPExcel->getActiveSheet()->getStyle('A')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$objPHPExcel->getActiveSheet()
            ->setCellValue('A1', 'Metodología')
			->setCellValue('B1', 'Cantidad' )
			->setCellValue('C1', 'Monto');

$current_row = 2;
foreach( $resumen_mets as $rmet ){
	
	$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$current_row , $rmet['nombre'] )
			->setCellValue('B'.$current_row , $rmet['cantidad'] )
			->setCellValue('C'.$current_row , $rmet['total'] );
			
	
	// si se formatea como numero no muestra el num 0...
	if( $rmet['cantidad'] != 0 ){
		$objPHPExcel->getActiveSheet()->getStyle( 'B'.$current_row )->getNumberFormat()
					->setFormatCode( '#,##' );
	}
	
	if( $rmet['total'] != 0 ){
		$objPHPExcel->getActiveSheet()->getStyle( 'C'.$current_row )->getNumberFormat()
					->setFormatCode( '#,##' );
	}
				
	$current_row++;
	
}

$objPHPExcel->setActiveSheetIndex(1);


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombre_archivo . '.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

