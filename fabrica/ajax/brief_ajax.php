<?php

require_once dirname(__FILE__).'/../classes/class.Brief.php';
$Brief = new Brief;

switch( $_POST['opc']  ){
	
	case 'cambiar-proceso-completado':
		
		$data = $_POST['data'];
		$Brief->setProcesoCompletado( $data['id_propuesta'], $data['id_proceso'], $data['val'] );

		break;
	
	case 'cambiar-razon-incu-proceso':
		
		$data = $_POST['data'];
		$Brief->setRazonIncuProceso( $data['id_propuesta'], $data['id_proceso'], $data['val'] );
		
		break;
	
	case 'set-completado-productos':
		
		$data = $_POST['data'];
		$Brief->setCompletadoProductos( $data['id_row_segmento'] , $data['val'] );
		
		break;
	
	case 'set-completado-productos-c':
			
		$data = $_POST['data'];
		$Brief->setCompletadoProductosC($data['id_producto'], $data['val']);
			
		break;
	
	case 'set-tipo-captura':
			
		$data=$_POST['data'];
		$Brief->setTipoCaptura( $data['id_propuesta'], $data['val'] );
		
		break;
	
	case 'set-critica-y-cod':
		
		$data = $_POST['data'];
		$Brief->setCriticaYCod($data['id_propuesta'], $data['val'] );
		
		break;
	
	case 'set-digitacion':
		
		$data = $_POST['data'];
		$Brief->setDigitacion($data['id_propuesta'], $data['val'] );
		
		break;
	
	case 'set-entrega-tabulados':
		
		$data = $_POST['data'];
		$Brief->setEntregaTabulados( $data['id_propuesta'], $data['val'] );
		
		break;
	
	case 'set-entregado-productos':
		
		$data = $_POST['data'];
		$Brief->setEntregadoProductos( $data['id_row_segmento'], $data['val'] );
		
		break;
	
	case 'set-entregado-producto-custom':
		
		$data = $_POST['data'];
		$Brief->setEntregadoProductoCustom( $data['id_producto'], $data['val'] );
		
		break;
}
