<?php

require_once dirname(__FILE__).'/class.SqlConnections.php';
require_once dirname(__FILE__).'/../krumo/class.krumo.php';
require_once dirname(__FILE__).'/../../libreria.php';

Class Brief extends SqlConnections{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getPropuestas(){
		$query = "SELECT * FROM prop_propuesta ORDER BY id_propuesta DESC ";
		return $this->adoDbFab->GetAll( $query );
	}
	
	// obtiene los procesos de un area especifica
	public function getProcesosArea( $id_area, $id_propuesta ){
		$query = "SELECT * FROM prop_calendario prc
				INNER JOIN prop_proceso pro ON pro.id_proceso = prc.id_proceso
				WHERE prc.id_area = '{$id_area}' 
				AND prc.id_propuesta = '{$id_propuesta}'";
		return $this->adoDbFab->GetAll( $query );
	}
	
	// obtiene los procesos que no tienen area designada
	public function getProcesosNoArea( $id_propuesta ){
		$query = "SELECT * FROM prop_calendario prc
				INNER JOIN prop_proceso pro ON pro.id_proceso = prc.id_proceso
				WHERE (id_area IS NULL OR id_area = '')
				AND prc.id_propuesta = '{$id_propuesta}'";
		return $this->adoDbFab->GetAll( $query );
	}
	
	// obtiene los productos de un area especifica
	public function getProductosArea( $id_area, $id_propuesta ){
		
		$query = "SELECT * FROM prop_seg_metodologia_rta psmr 
					INNER JOIN prop_metodologia_rta pmr ON pmr.id_row_metodologia = psmr.id_row_metodologia
					INNER JOIN prop_metodologia prm ON prm.id_metodologia = pmr.id_metodologia
					WHERE psmr.id_area = '{$id_area}' AND pmr.id_propuesta = '{$id_propuesta}' ";
		
		return $this->adoDbFab->GetAll( $query );
	}
	
	// obtiene inversion de un area especifica (productos personalizados)
	public function getProductosCustomArea( $id_area, $id_propuesta ){
		$query = "SELECT * FROM prop_inversion WHERE id_area = '{$id_area}' AND id_propuesta = '{$id_propuesta}' ";
		return $this->adoDbFab->GetAll( $query );
	}
	
	// obtiene productos de una propuesta especifica
	public function getProductosPropuesta( $id_propuesta ){
		$query = "SELECT * FROM prop_seg_metodologia_rta psmr 
					INNER JOIN prop_metodologia_rta pmr ON pmr.id_row_metodologia = psmr.id_row_metodologia
					INNER JOIN prop_metodologia prm ON prm.id_metodologia = pmr.id_metodologia
					WHERE pmr.id_propuesta = '{$id_propuesta}' ";
		
		return $this->adoDbFab->GetAll( $query );
	}
	
	// obtiene inversion de una propuesta especifica (productos personalizados)
	public function getProductosCustomPropuesta( $id_propuesta ){
		$query = "SELECT * FROM prop_inversion WHERE id_propuesta = '{$id_propuesta}' ";
		return $this->adoDbFab->GetAll( $query );
	}
	
	// obtiene los productos sin area especifica
	public function getProductosNoArea( $id_propuesta ){
		$query = "SELECT * FROM prop_seg_metodologia_rta psmr 
					INNER JOIN prop_metodologia_rta pmr ON pmr.id_row_metodologia = psmr.id_row_metodologia
					INNER JOIN prop_metodologia prm ON prm.id_metodologia = pmr.id_metodologia
					WHERE (psmr.id_area IS NULL OR psmr.id_area = '')  AND pmr.id_propuesta = '{$id_propuesta}' ";
		
		return $this->adoDbFab->GetAll( $query );
	}
	
	// obtiene inversion de un area especifica (productos personalizados) SIN AREA
	public function getProductosCustomNoArea( $id_propuesta ){
		$query = "SELECT * FROM prop_inversion WHERE (id_area IS NULL OR id_area = '') AND id_propuesta = '{$id_propuesta}' ";
		return $this->adoDbFab->GetAll( $query );
	}
	
	// cambia estado completado de un proceso
	public function setProcesoCompletado( $id_propuesta, $id_proceso, $val ){
			
		$query = "UPDATE prop_calendario SET completado = '{$val}' WHERE id_propuesta = '{$id_propuesta}' AND id_proceso = '{$id_proceso}'";
		$this->adoDbFab->Execute( $query );
	}
	
	// cambia razon incumplimiento de proceso
	public function setRazonIncuProceso( $id_propuesta, $id_proceso, $val ){
		
			
		if( $val == '' ){
			$query = "UPDATE prop_calendario SET id_incu = NULL WHERE id_propuesta = '{$id_propuesta}' AND id_proceso = '{$id_proceso}'";
		} else {
			$query = "UPDATE prop_calendario SET id_incu = '{$val}' WHERE id_propuesta = '{$id_propuesta}' AND id_proceso = '{$id_proceso}'";
		}
		
		$this->adoDbFab->Execute( $query );
	}
	
	public function setCompletadoProductos( $id_row_segmento, $val ){
		
		$query = "UPDATE prop_seg_metodologia_rta SET completado = '{$val}' WHERE id_row_segmento = '{$id_row_segmento}'";
		$this->adoDbFab->Execute( $query );
		
	}
	
	public function setCompletadoProductosC( $id_producto, $val ){
		
		$query = "UPDATE prop_inversion SET completado = '{$val}' WHERE id_producto = '{$id_producto}'";
		$this->adoDbFab->Execute( $query );
		
	}
	
	public function setTipoCaptura( $id_propuesta, $val ){
		
		$query = "UPDATE prop_propuesta SET id_pob_objetivo = '{$val}' WHERE id_propuesta = '{$id_propuesta}' ";
		$this->adoDbFab->Execute( $query);
		
	}
	
	public function setCriticaYCod( $id_propuesta, $val ){
		$query = "UPDATE prop_propuesta SET critica_codificacion = '{$val}'  WHERE id_propuesta = '{$id_propuesta}' ";
		$this->adoDbFab->Execute( $query );
	}
	
	
	public function setDigitacion( $id_propuesta, $val ){
		$query = "UPDATE prop_propuesta SET digitacion = '{$val}'  WHERE id_propuesta = '{$id_propuesta}' ";
		$this->adoDbFab->Execute( $query );
	}
	
	public function setEntregaTabulados( $id_propuesta, $val ){
		$query = "UPDATE prop_propuesta SET entrega_tabulados = '{$val}'  WHERE id_propuesta = '{$id_propuesta}' ";
		$this->adoDbFab->Execute( $query );
	}
	
	public function setEntregadoProductos( $id_row_segmento, $val ){
		$query = "UPDATE prop_seg_metodologia_rta SET entregado = '{$val}' WHERE id_row_segmento = '{$id_row_segmento}' ";
		$this->adoDbFab->Execute( $query );
	}
	
	public function setEntregadoProductoCustom( $id_producto, $val ){
		
		$query = "UPDATE prop_inversion SET entregado = '{$val}' WHERE id_producto = '{$id_producto}' ";
		$this->adoDbFab->Execute( $query );
		
	}
}