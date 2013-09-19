<?php

require_once dirname(__FILE__).'/class.SqlConnections.php';


class SqlQuery extends SqlConnections{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function GetAll( $query ){
		return $this->adoDbFab->GetAll( $query );
	}
	
	public function GetRow( $query ){
		return $this->adoDbFab->GetRow( $query );
	}
	
	public function Execute( $query ){
		$this->adoDbFab->Execute( $query );
	}
}