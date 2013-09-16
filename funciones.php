<?
$color_pie_c	= '336699';
$color_pie_c	= '6699CC';
function pie3d($pct, $labels, $color, $borde){
	//$color_t2b = '339933';
	//$color_b2b = 'CC0000';
	$color_t2b = '0099FF';
	$color_b2b = 'FF6633';
	$img = "<img src='http://chart.apis.google.com/chart?cht=p3&chco=$color&chd=t:$pct&chs=690x120&chl=$labels' border=$borde>";
//	$img = "<img src='http://chart.apis.google.com/chart?cht=p3&chco=$color_t2b,$color_b2b&chd=t:$pct&chs=380x100&chl=$labels' border=$borde>";
	return $img;
}

function porcentaje($t_base, $t_evaluado, $ndecimales=1){
	$porcentaje_t = 0;
	if($t_base > 0){
		$porcentaje_t = round((($t_evaluado/$t_base)*100),$ndecimales);
	}else{
		$porcentaje_t = 0;
	}
	return $porcentaje_t;
}

function crearObj($idDivNewObj, $idNewObj, $idObjContObjetos, $nameObj, $objValidacion=NULL){
	$newTableObj	= "
	<TABLE width='99%' cellspacing='0' cellpadding='0' align='center' border='0' class=''>
	 <TR>
	  <TD width='1%' align='right' class='bb' valign='middle'><div class='padding5'><a href=\"JavaScript:del_Fields('$idDivNewObj','$idNewObj','$idObjContObjetos')\"><IMG src='/imagenes/no.png' width='16' border='0' alt='Eliminar' title='Eliminar' /></a></div></TD>
	  <TD width='99%' align='left' class='bb' valign='top'><div class='padding5'>
	  <INPUT type='text' name='$nameObj' id='$idNewObj' class='borderBlue userText' style='width:99%; padding:4px 5px;' value='' lang='0' title='Por favor ingrese un dato válido' /></div>$objValidacion</TD>
	 </TR>
	</TABLE>";
	return $newTableObj;
}

?>