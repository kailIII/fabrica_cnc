<?
$colsTitSemanas	= NULL;

for($i=$inicioSemanas; $i <= $num_semanas; $i++){
	$vbSemana	= $i;
	$colsTitSemanas	.= "<TD width='1%' align='center' class='borderBR divInstruccion'><div class='padding2'><B>$vbSemana</B></div></TD>";
}
//----
$sql = "SELECT A.id_metodologia,A.nom_metodologia
 FROM ".tablaMetodologia." A INNER JOIN ".tablaMetodologiaRTA." B USING (id_metodologia)
  WHERE id_propuesta=".$idPropuesta."
   ORDER BY A.id_metodologia";
//echo '<BR>'.$sql;
$filasProcesos			= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_metodologia		= $campos["id_metodologia"];
	$nom_metodologia	= $campos["nom_metodologia"];

	$filasProcesos	.= "
	<TABLE width='98%' border='0' cellspacing='0' cellpadding='0' align='center'>
	 <TR>
	  <TD width='1%' align='right' class='bb divInstruccion'>&nbsp;</TD>
	  <TD width='30%' align='left' class='bb divInstruccion'><div class='padding5'><B>$nom_metodologia / Procesos</B></div></TD>
	  <TD width='2%' align='center' class='bb divInstruccion'><div class='padding5'><B>Responsable</B></div></TD>
	  <TD width='2%' align='center' class='borderBR divInstruccion'><div class='padding5'><B>Nro.<br />Semanas</B></div></TD>
	  $colsTitSemanas
	 </TR>";

//	$sqlP = "SELECT P.id_proceso,P.nom_proceso,R.tiempo
//	 FROM ".tablaProceso." P INNER JOIN ".tablaTiempoProcesoRTA." R USING(id_proceso)
//	WHERE id_propuesta=".$idPropuesta." AND id_metodologia=".$id_metodologia."
//	 ORDER BY P.id_proceso";
	$sqlP = "SELECT * FROM ".tablaProceso." ORDER BY id_proceso";
	//echo '<BR>'.$sqlP;
	$conP				= mysql_query($sqlP);
	while($camposP		= mysql_fetch_array($conP)){
		$id_proceso		= $camposP["id_proceso"];
		$nom_proceso	= $camposP["nom_proceso"];
		$tiempoProceso	= $camposP["tiempo"];

		//---- consulta las semanas del calendario para el proceso actual
		$sqlR = "SELECT * FROM ".tablaCalendario."
		  WHERE id_propuesta=".$idPropuesta." AND id_metodologia=".$id_metodologia." AND id_proceso=".$id_proceso;
		//echo '<BR>'.$sqlR;
		$arraySemanas			= array();
		$conR					= mysql_query($sqlR);
		while($camposR			= mysql_fetch_array($conR)){
			$arraySemanas		= explode(',',$camposR["semanas"]);
		}

		$colsSemanas	= NULL;
		$nameObjC		= 'p'.$idPropuesta.'m'.$id_metodologia.'p'.$id_proceso.'[]';
		$idContSem		= 'p'.$idPropuesta.'m'.$id_metodologia.'p'.$id_proceso;
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

			$funcion	= "fxCalendario('$id_metodologia','$id_proceso','$idCelda','$nameObjC','$idObjC','$idContSem','$i','$vbSemana','".colorBgON."','".colorBgOFF."');";
//			$celda		= "<a href=\"JavaScript:$funcion\"><div style='width:50px;'>&nbsp;</div></a>";
			$celda		= "<a href=\"JavaScript:$funcion\"><img id='$idIMG' src='../spacer.png' width='25' height='30' border='0' /></a>";
		
			$colsSemanas	.= "<TD id='$idCelda' align='center' class='borderBR' style='background-color:$colorBg'>".$celda.$objNs."</TD>";
		}

		$filasProcesos		.= "
		 <TR>
		  <TD align='right' class='bb'><IMG src='/imagenes/yes.png' height='16' border='0'></TD>
		  <TD align='left' class='bb'><div class='padding2 textLabel'>$nom_proceso</div></TD>
		  <TD align='center' class='bb'><div class='padding2 textLabel'>CNC</div></TD>
		  <TD align='center' class='borderBR'><div id='$idContSem' class='padding2'>$tiempoProceso</div></TD>
		  $colsSemanas
		 </TR>";
	}
	$filasProcesos	.= "</TABLE><BR />";
}
?>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left" style='border:1px solid #CED7EC;'>
	 <TR>
	  <TD align="center" colspan="2">
	    <div class='padding5'><?=$filasProcesos?></div>
	  </TD>
	 </TR>
	</TABLE>
