<?php

require_once dirname(__FILE__).'/krumo/class.krumo.php';
require_once dirname(__FILE__).'/classes/class.SqlQuery.php';

$SqlQuery = new SqlQuery;

$query 			= "SELECT * FROM prop_tarifario";
$reg_afectados 	= 0;

foreach( $SqlQuery->GetAll($query) as $trf ){

	$precio 		= $trf['precio'];
	$ultima_cifra 	= $precio[strlen($precio)-1];

	if( $ultima_cifra != 0 ){
		krumo($precio);
		$precio_redondeado = redondearCentena($precio);

		krumo($precio_redondeado);

		echo $query_upd = "UPDATE prop_tarifario SET precio = '{$precio_redondeado}' WHERE id_tarifario = '{$trf['id_tarifario']}' ";
		$SqlQuery->Execute($query_upd);

		$reg_afectados++;
	}



}

echo $reg_afectados;

function redondearCentena($number){

	$length	= strlen($number);

	if( $number[$length-3] < 9 ){

		$number[$length-3] = $number[$length-3] + 1;
		$number[$length-2] = 0;
		$number[$length-1] = 0;
	} else {

		$number[$length-4] = $number[$length-4] + 1;
		$number[$length-3] = 0;
		$number[$length-2] = 0;
		$number[$length-1] = 0;
	}


	return $number;

}
