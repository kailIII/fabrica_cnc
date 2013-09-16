<?php 

//----
function eSQL($sql, $ver_msg=0, $msg=''){
	//echo '<BR>'.$sql;
	if(mysql_query($sql)){
		$result	= 1;
	}
	else{
		$result	= 0;
		if($ver_msg==1){
			echo "<div style='color:#990000'>Atención!!! Error al guardar la información, por favor intente nuevamente</div>".mysql_error();
		}
	}
	return $result;
}
//----
function crearObj($idDivNewObj, $idNewObj, $idObjContObjetos, $nameObj, $objValidacion=NULL){
	//----
	$sql = "SELECT * FROM ".tablaCobertura." ORDER BY 1";
	//echo '<BR>'.$sql;
	$optionCobertura	= NULL;
	$con				= mysql_query($sql);
	while($campos		= mysql_fetch_array($con)){
		$id_cobertura	= $campos["id_cobertura"];
		$nom_cobertura	= utf8_encode($campos["nom_cobertura"]);
	
		$selected_e		= NULL;
		if($id_cobertura==$id_origen_db_r){
			$selected_e	= "selected";
		}
		$optionCobertura	.= "<OPTION value='$id_cobertura' $selected_e>$nom_cobertura</OPTION>";
	}
	$objCobertura	= "
	<SELECT name='id_cobertura[]' id='id_cobertura[]' lang='1' title='' style='padding:1px;'>
	 <OPTION value='' selected>Seleccione...</OPTION>
	 $optionCobertura
	</SELECT>";

	$newTableObj	= "
	<TABLE width='100%' cellspacing='0' cellpadding='0' align='center' border='0' class=''>
	 <TR>
	  <TD width='4%' align='right' class='bb' valign='middle'><div class='padding5'><a href=\"JavaScript:del_Fields('$idDivNewObj','$idNewObj','$idObjContObjetos')\"><IMG src='/imagenes/no.png' width='16' border='0' alt='Eliminar' title='Eliminar' /></a></div></TD>
	  <TD width='50%' align='left' class='bb' valign='top'><div class='padding5'>
	  <INPUT type='text' name='$nameObj' id='$idNewObj' class='borderBlue userText' style='width:99%; padding:4px 5px;' value='' lang='0' title='Por favor ingrese un dato válido' /></div>$objValidacion</TD>
	  <TD width='10%' align='center' class='bb' valign='top'><div class='padding5'><INPUT type='text' name='cantidad_' id='cantidad_' maxlength='3' value='' class='txt' style='width:50px; text-align:center;' onkeypress='return esNumero(event);' /></div></TD>
	  <TD width='20%' align='left' class='bb' valign='top'><div class='padding5'>$objCobertura</div></TD>
	  <TD align='left' class='bb' valign='top'>&nbsp;</TD>
	 </TR>
	</TABLE>";
	return $newTableObj;
}

function crearObjM2($idDivNewObj, $idNewObj, $idObjContObjetos, $nameObj, $objValidacion=NULL){
	//----
	$sql = "SELECT * FROM ".tablaCobertura." ORDER BY 1";
	//echo '<BR>'.$sql;
	$optionCobertura	= NULL;
	$con				= mysql_query($sql);
	while($campos		= mysql_fetch_array($con)){
		$id_cobertura	= $campos["id_cobertura"];
		$nom_cobertura	= utf8_encode($campos["nom_cobertura"]);
	
		$selected_e		= NULL;
		if($id_cobertura==$id_origen_db_r){
			$selected_e	= "selected";
		}
		$optionCobertura	.= "<OPTION value='$id_cobertura' $selected_e>$nom_cobertura</OPTION>";
	}
	$ahora	= date('h_i_s');

	$objCobertura	= "
	<SELECT name='id_cobertura[]' id='id_cobertura[]' lang='1' title='' style='padding:1px;'>
	 <OPTION value='' selected>Seleccione...</OPTION>
	 $optionCobertura
	</SELECT>";

	$objSegmento	= "<INPUT type='text' name='$nameObj' id='$idNewObj' class='borderBlue userText' style='width:99%; padding:4px 5px;' value='' lang='0' title='Por favor ingrese un dato válido' /></div>$objValidacion";

	$idObjUniverso		= 'universo'.$ahora;
	$idObjMuestra		= 'muestra'.$ahora;
	$idObjErrorMuestral	= 'error_muestral'.$ahora;
	$p					= 0.5;
	$costante			= 1.95;
	$fx_error_muestral	= "cal_error_muestral('$p','$costante','$idObjUniverso','$idObjMuestra','$idObjErrorMuestral')";

	$objUniverso		= "<INPUT type='text' name='cantidad_' id='$idObjUniverso' maxlength='4' value='' class='txt' style='width:50px; text-align:center;' onkeyup=\"$fx_error_muestral;\" onkeypress='return esNumero(event);' />";
	$objMuestra			= "<INPUT type='text' name='cantidad_' id='$idObjMuestra' maxlength='4' value='' class='txt' style='width:50px; text-align:center;' onkeyup=\"$fx_error_muestral;\" onkeypress='return esNumero(event);' />";
	$objErrorMuestral	= "<INPUT type='text' name='cantidad_' id='$idObjErrorMuestral' maxlength='4' value='' class='txt' style='width:50px; text-align:center;' onkeypress='return esNumero(event);' readonly='readonly' />";

	$newTableObj	= "
	<TABLE width='100%' cellspacing='0' cellpadding='0' align='center' border='0' class=''>
	 <TR>
	  <TD width='4%' align='right' class='bb' valign='middle'><div class='padding5'><a href=\"JavaScript:del_Fields('$idDivNewObj','$idNewObj','$idObjContObjetos')\"><IMG src='/imagenes/no.png' width='16' border='0' alt='Eliminar' title='Eliminar' /></a></div></TD>
	  <TD width='46%' align='left' class='bb' valign='top'><div class='padding5'>$objSegmento</TD>
	  <TD width='10%' align='center' class='bb' valign='top'><div class='padding5'>$objUniverso</div></TD>
	  <TD width='10%' align='center' class='bb' valign='top'><div class='padding5'>$objMuestra</div></TD>
	  <TD width='10%' align='center' class='bb' valign='top'><div class='padding5'>$objErrorMuestral</div></TD>
	  <TD width='20%' align='left' class='bb' valign='top'><div class='padding5'>$objCobertura</div></TD>
	 </TR>
	</TABLE>";
	return $newTableObj;
}

function pr( $objVar = "" , $nombreClase = false ) {

	$estilo = 'background: #feff51; ' . 
				'border: dotted 1px; ' . 
				'width: 1800px; ' .
				'text-align: left; ' . 
				'font-family: "Courier New", Courier, monospace; ' . 
				'font-size: 11px; ' . 'padding: 4px; ' . 
				'float: left; ' . 
				'color: #606060; ' . 
				'position: relative; ';
	
	echo " <div id='debugPHP'style='$estilo'> ";
	
	if( is_array ( $objVar ) or is_object ( $objVar ) )
	{
		echo " <pre> ";
		if( $nombreClase )
		{
			$objVar = get_class ( $objVar );
		}
		$datos = print_r ( $objVar , true );
		echo " $datos </pre>" ;
	} else
	{
		echo str_replace ( "\n", "<br>", $objVar );
	}
	echo " </div><hr> ";

}

?>