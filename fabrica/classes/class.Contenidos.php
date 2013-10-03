<?php

/*
 * clase para el manejo de los contenidos provenientes de Base de datos
*/

require_once dirname(__FILE__).'/class.SqlConnections.php';
require_once dirname(__FILE__).'/../krumo/class.krumo.php';
require_once dirname(__FILE__).'/../../libreria.php';

Class Contenidos extends SqlConnections {

	private $enc_key = 'S4d7p4224A4c6EAe1Bn4q16r89s9h9ha';

	public function __construct(){

		parent::__construct();
	}

	// obtiene el listado de idoneidad
	public function getIdoneidades(){
		$query = "SELECT * FROM ". tablaIdoneidad ." ORDER BY orden";
		return $this->adoDbFab->GetAll($query);
	}

	// obtiene listado de marco muestral
	public function getMarcoMuestral(){
		$query = "SELECT * FROM prop_marco_muestral";
		return $this->adoDbFab->GetAll($query);
	}

	// obtiene los tipos de metodologia cuantativiva
	public function getTiposMetCuant( $exclude = '' ){
		
		$exclude = explode(",", $exclude );  
		
		foreach( (array)$exclude as $id ){
			$cond.= " id_tipo_cuantitativo != '{$id}' AND ";
		}
		
		 if( count($exclude) > 0 ){
		 	$cond = " WHERE ".$cond;
			$cond = substr_replace($cond, "", -4);
		 } else {
		 	$cond = '';
		 }
		
		$query = "SELECT * FROM prop_tipo_cuantitativo ptc {$cond}  ORDER BY orden";
		return $this->adoDbFab->GetAll($query);
	}

	// obtiene los niveles de confianza
	public function getNivelConfianza(){
		$query = "SELECT * FROM prop_nivel_confianza ORDER BY orden";
		return $this->adoDbFab->GetAll($query);
	}

	//obtiene los tiempos de duracion de metodologia
	public function getDuracionMet(){
		$query = "SELECT * FROM prop_duracion WHERE activo = 1";
		return $this->adoDbFab->GetAll($query);
	}

	public function getCobertura(){
		$query = "SELECT * FROM prop_cobertura WHERE activo = 1";
		return $this->adoDbFab->GetAll($query);
	}
	
	public function getCoberturaById( $id_cobertura ){
		$query = "SELECT * FROM prop_cobertura WHERE id_cobertura = '{$id_cobertura}' ";
		return $this->adoDbFab->GetRow( $query );
	}

	public function getPobOjetivo(){
		$query  = "SELECT * FROM prop_pob_objetivo WHERE activo = 1";
		return $this->adoDbFab->GetAll($query);
	}

	public function getNvAceptacion(){
		$query  = "SELECT * FROM prop_nivel_aceptacion WHERE activo = 1";
		return $this->adoDbFab->GetAll($query);
	}

	// mecanismo captacion aka: origen db
	public function getOrigenDb(){
		$query = "SELECT * FROM prop_origen_db";
		return $this->adoDbFab->GetAll($query);
	}

	public function getTipoProp(){
		$query = "SELECT * FROM prop_tipo_prop";
		return $this->adoDbFab->GetAll($query);
	}

	public function getDefaultsProceso(){
		$query = "SELECT * FROM prop_defaults_proceso";
		return $this->adoDbFab->GetAll($query);
	}
	
	// equivalente a poblacion objetivo en BD
	public function getTecnicasRecoleccion( $ids ){
		$ids = explode(",",$ids);
		$cons = '';
		
		foreach( $ids as $id ){
			$cons.=" id_pob_objetivo = $id OR ";
		}
		$cons = substr_replace($cons, "", -3);
		
		$query = "SELECT * FROM prop_pob_objetivo WHERE $cons ";
		
		return $this->adoDbFab->GetAll($query);
	}
	
	// equivalente a origen_bd en BD
	public function origenDbConstrained( $ids ){
		$ids = explode(",",$ids);
		$cons = '';
		
		foreach( $ids as $id ){
			$cons.=" id_origen_db = $id OR ";
		}
		$cons = substr_replace($cons, "", -3);
		
		$query = "SELECT * FROM prop_origen_db WHERE $cons ";
		
		return $this->adoDbFab->GetAll($query);
	}
	
	public function getDuracionMetConstrained( $ids ){
		$ids = explode(",",$ids);
		$cons = '';
		
		foreach( $ids as $id ){
			$cons.=" id_duracion = $id OR ";
		}
		$cons = substr_replace($cons, "", -3);
		
		$query = "SELECT * FROM prop_duracion WHERE $cons ";
		
		return $this->adoDbFab->GetAll($query);
	}
	
	public function getNivelAceptacion( $ids ){
		$ids = explode(",",$ids);
		$cons = '';
		
		foreach( $ids as $id ){
			$cons.=" id_nivel_aceptacion = $id OR ";
		}
		$cons = substr_replace($cons, "", -3);
		
		$query = "SELECT * FROM prop_nivel_aceptacion WHERE $cons ";
		
		return $this->adoDbFab->GetAll($query);
	}
	
	public function getCoberturaConstrained( $ids ){
		$ids = explode(",",$ids);
		$cons = '';
		
		foreach( $ids as $id ){
			$cons.=" id_cobertura = $id OR ";
		}
		$cons = substr_replace($cons, "", -3);
		
		$query = "SELECT * FROM prop_cobertura WHERE $cons ";
		
		return $this->adoDbFab->GetAll($query);
	}
	
	public function getSubMetodologia( $id_metodologia ){
		$query = "SELECT * FROM prop_sub_metodologias WHERE id_metodologia = $id_metodologia ";
		return $this->adoDbFab->GetAll($query);
	}
	

	public function getEstadosPropuesta(){
		$query = "SELECT * FROM prop_estados_propuesta";
		return $this->adoDbFab->GetAll($query);
	}

	public function getEstadoPropuesta($id_est){
		$query = "SELECT * FROM prop_estados_propuesta WHERE id_est_prop = '{$id_est}' ";
		return $this->adoDbFab->GetRow($query);
	}

	public function encryptData( $content ){
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

    	$encrypted_string = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->enc_key, $content, MCRYPT_MODE_ECB, $iv);
    	return rtrim(strtr(base64_encode($encrypted_string), '+/', '-_'), '=');


	}

	public function decryptData( $content ){
		$content = base64_decode(strtr($content, '-_', '+/'));
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

    	return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->enc_key, $content, MCRYPT_MODE_ECB, $iv);
    	
	}
	
	public function getMetodologia( $id_metodologia ){
		$query = "SELECT * FROM prop_metodologia WHERE id_metodologia = '{$id_metodologia}' ";
		return $this->adoDbFab->GetRow( $query );
	}
	
	public function getDuracion( $id_duracion ) {
		$query = "SELECT * FROM prop_duracion WHERE id_duracion = '{$id_duracion}' ";
		return $this->adoDbFab->GetRow( $query );
	}
	
	public function getPobObjetivo( $id_pob_objetivo ){
		$query = "SELECT * FROM prop_pob_objetivo WHERE id_pob_objetivo = '{$id_pob_objetivo}'";
		return $this->adoDbFab->GetRow( $query );
	}
	
	public function getOrigenDbById( $id_origen_db ){
		$query = "SELECT * FROM prop_origen_db WHERE id_origen_db = '{$id_origen_db}'";
		return $this->adoDbFab->GetRow( $query );
	}
	
	public function getNivelAceptacionById( $id_nivel_aceptacion ){
		$query = "SELECT * FROM prop_nivel_aceptacion WHERE id_nivel_aceptacion = '{$id_nivel_aceptacion}' ";
		return $this->adoDbFab->GetRow($query);
	}
	
	public function getAreas(){
		$query = "SELECT * FROM prop_areas";
		return $this->adoDbFab->GetAll( $query );
	}
	
	public function getIncumplimientoArea( $id_area ){
		$query = "SELECT * FROM prop_incumplimiento WHERE id_area = '{$id_area}' ";
		return $this->adoDbFab->GetAll( $query );
	}
	
	public function getIncumplimiento(){
		$query = "SELECT * FROM prop_incumplimiento GROUP BY des_incu ";
		return $this->adoDbFab->GetAll( $query );
	}
	
	public function getPobsOjetivo(){
		$query  = "SELECT * FROM prop_pob_objetivo";
		return $this->adoDbFab->GetAll($query);
	}
	

}