<?php

require_once dirname(__FILE__).'/../krumo/class.krumo.php';
require_once dirname(__FILE__).'/../../libreria.php';
require_once dirname(__FILE__).'/class.SqlConnections.php';

Class Usuario extends SqlConnections{
	
	private $user_name;
	
	public function __construct( $user_name, $id = false ){
		parent::__construct();

		if( $id ){
			$query = "SELECT * FROM empleado WHERE id_equipo_cnc = '{$id}' ";
			$user = $this->adoDbFab->GetRow($query);

			$this->user_name = $user['id_empleado'];
		} else {

			$this->user_name = $user_name;
		}
	}
	
	public function getUsuario(){
		
		$query = "SELECT * FROM empleado emp 
		INNER JOIN prop_equipo_cnc pec ON pec.id = emp.id_equipo_cnc
		WHERE emp.id_empleado = '{$this->user_name}' ";
		return $this->adoDbFab->getRow($query);
		
	}
	
	public function getIdEquipo(){
		$user = $this->getUsuario();
		return $user['id_equipo_cnc'];
	}
}