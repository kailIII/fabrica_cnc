<?
$colsTitSemanas	= NULL;

$info_prop = $Propuesta->getProp();

for($i=$inicioSemanas; $i <= $num_semanas; $i++){
	$vbSemana	= $i;
	$colsTitSemanas	.= "<TD width='1%' align='center' class='borderBR divInstruccion'><div class='padding2'><B>$vbSemana</B></div></TD>";
}

// $colsTitSemanas.= '<TD width="1%" align="center" class="borderBR divInstruccion"><div class="padding2">&nbsp;</div></TD>';

//----
	$sqlP = "SELECT * FROM ".tablaProceso." WHERE id_propuesta = {$idPropuesta} ORDER BY id_proceso";
	//$sqlP = "SELECT * FROM ".tablaProceso."  ORDER BY id_proceso";
	//echo '<BR>'.$sqlP;
	$conP				= mysql_query($sqlP);
	while($camposP		= mysql_fetch_array($conP)){
		$id_proceso		= $camposP["id_proceso"];
		$nom_proceso	= $camposP["nom_proceso"];
		$responsable	= $camposP["responsable"];


		//---- consulta las semanas del calendario para el proceso actual
		$sqlR = "SELECT * FROM ".tablaCalendario."
		  WHERE id_propuesta=".$idPropuesta." AND id_proceso=".$id_proceso;
		//echo '<BR>'.$sqlR;
		$arraySemanas			= array();
		$conR					= mysql_query($sqlR);
		while($camposR			= mysql_fetch_array($conR)){
			$arraySemanas		= explode(',',$camposR["semanas"]);
			$id_area 			= $camposR["id_area"];
		}

		$colsSemanas	= NULL;
		$nameObjC		= 'p'.$idPropuesta.'p'.$id_proceso.'[]';
		$idContSem		= 'p'.$idPropuesta.'p'.$id_proceso;
		for($i=$inicioSemanas; $i <= $num_semanas; $i++){
			$vbSemana	= $i;

			$chObj		= NULL;
			$colorBg	= colorBgOFF;
			if(in_array($i, $arraySemanas)){
				$chObj	= "checked='checked'";
				$colorBg	= colorBgON;
			}

			$idCelda	= 'celda_m'.$id_metodologia.'p'.$id_proceso.'s'.$i;
			$idObjC		= 'sw_m'.$id_metodologia.'p'.$id_proceso.'s'.$i;
			$objNs		= "<INPUT type='checkbox' name='$nameObjC' id='$idObjC' value='$i' $chObj style='display:none' />";

			$funcion	= "fxCalendario('$id_metodologia','$id_proceso','$idCelda','$nameObjC','$idObjC','$idContSem','$i','$vbSemana','#73B649','".colorBgOFF."');";
//			$celda		= "<a href=\"JavaScript:$funcion\"><div style='width:50px;'>&nbsp;</div></a>";
			$celda		= "<a href=\"JavaScript:$funcion\"><img id='$idIMG' src='../spacer.png' width='25' height='30' border='0' /></a>";
		
			$colsSemanas	.= "<TD id='$idCelda' align='center' class='borderBR' style='background-color:$colorBg'>".$celda.$objNs."</TD>";

		}
		// $colsSemanas.= '<td width="1%" ><i title="eliminar proceso" class="icon-remove remove-proceso" id_proceso="'. $id_proceso .'" ></i></td>';

		$areas = '<option value="" >Seleccione...</option>';
		foreach( $Contenidos->getAreas() as $area ){

			$id_area == $area['id_area'] ? $selected = 'selected' : $selected = '';
			$areas.='<option ' . $selected . ' value="' . $area['id_area'] . '" >' . $area['nom_area'] . '</option>';
		}

		$filasProcesos		.= "
		 <TR>
		  <TD align='right' class='bb'><IMG src='/imagenes/yes.png' height='16' border='0'></TD>
		  <TD align='left' class='bb'><div class='padding2 textLabel'> <input class='cal-nom-proceso' type='text' value = '$nom_proceso' name='nom_proceso[$id_proceso]' placeholder='Especifique el proceso' /> </div></TD>
		  <TD align='center' class='bb'><div class='padding2 textLabel'><input class='cal-nom-proceso' type='text' value = '$responsable' name='res_proceso[$id_proceso]' placeholder='Especifique' /></div></TD>
		  <TD align='center' class='borderBR'><div id='$idContSem' class='padding2'>$tiempoProceso</div></TD>	
		  $colsSemanas
		  <TD class='borderBR requi-area-responsable' >
		  	<select name='calendario_area_responsable[" . $id_proceso . "]' >
		  		$areas
		  	</select>	
		  </TD>
		 </TR>";
	}
?>

<script src="js/page9.js?<?=time();?>" ></script>

	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	 <TR>
	  <TD align="center" colspan="2">
        <TABLE width='100%' border='0' cellspacing='0' cellpadding='0' align='center' class="borderL">
         <TR>
          <TD width='1%' align='right' class='bb divInstruccion'>&nbsp;</TD>
          <TD width='30%' align='left' class='bb divInstruccion'><div class='padding5'><B>Procesos</B></div></TD>
          <TD width='2%' align='center' class='bb divInstruccion'><div class='padding5'><B>Responsable</B></div></TD>
          <TD width='2%' align='center' class='borderBR divInstruccion'><div class='padding5'><B>Nro.<br />Semanas</B></div></TD>
          <?=$colsTitSemanas?>
          <td width="10%" class='bb divInstruccion' ><div class='padding5'><B>�rea responsable</B></div></td>
         </TR>
	     <?=$filasProcesos?>

	     <!-- <tr>
	     	<td colspan="4" > <a href="javascript:void(0);" class="btn" id="page9AddProcess" >A�adir proceso</a></td>
	     </tr> -->


        </TABLE>
	  </TD>
	 </TR>
	</TABLE>
