<?php

/*
* clase que instancia la conexion SQL
*/

require_once dirname(__FILE__).'/../adodb5/adodb.inc.php';
require_once dirname(__FILE__).'/../../connection.php';


Class SqlConnections{
	protected $adoDbFab;

	protected function __construct(){
		global $dbhost;
		global $dbuser;
		global $dbpass;
		global $dbname;

		$adoDbFab = NewADOConnection('mysql');
  		$adoDbFab->Connect($dbhost, $dbuser , $dbpass , $dbname);
  		$this->adoDbFab = $adoDbFab;
	}

	protected function getAdoDbFab(){
		return $this->adoDbFab;
	}

}