<?php

require_once dirname(__FILE__).'/../krumo/class.krumo.php';
require_once dirname(__FILE__).'/../../libreria.php';
require_once dirname(__FILE__).'/class.SqlConnections.php';

class ReporteSemanal extends SqlConnections{
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function getPropuestas(){
		
		$query ="SELECT * FROM prop_propuesta prop
		LEFT JOIN prop_tipo_prop ptp ON ptp.id_tipo_prop = prop.id_tipo_prop 
		WHERE prop.fecha_creacion >= NOW() - INTERVAL 7 DAY 
		ORDER BY prop.id_propuesta DESC ";
		return $this->adoDbFab->GetAll($query);
	}

}
