<?
$sql = "SELECT * FROM ".tablaEquipo." ORDER BY nombre";
//echo '<BR>'.$sql;
$cont				= 0;
$optionEquipoCNC	= NULL;
$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	++$cont;
	$id				= $campos["id"];
	$nombre			= $campos["nombre"];
	$muestra		= $campos["cargo"];

	$optionEquipoCNC.= "<OPTION value='$id'>$nombre</OPTION>";
}

//----
$sql = "SELECT * FROM ".tablaTipoEstudio." ORDER BY nom_tipo_estudio";
//echo '<BR>'.$sql;
$optionTipoEstudio		= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_tipo_estudio	= $campos["id_tipo_estudio"];
	$nom_tipo_estudio	= $campos["nom_tipo_estudio"];

	$optionTipoEstudio.= "<OPTION value='$id_tipo_estudio'>$nom_tipo_estudio</OPTION>";
}

//----
$tituloMetodologias		= NULL;
foreach($arrayTiempos as $ind => $vb){
	//echo '<BR>ind: '.$ind.' vb: '.$vb;
	$tituloMetodologias	.= "<TD align='center' class='bb divInstruccion'><div class='padding5'>$vb</div></TD>";
}
$sql = "SELECT * FROM ".tablaMetodologia." ORDER BY 1";
//echo '<BR>'.$sql;
$filasMetodologia		= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_metodologia		= $campos["id_metodologia"];
	$nom_metodologia	= $campos["nom_metodologia"];
	//---- consulta si la metodología aplica para la propuesta activa
	$sqlR = "SELECT * FROM ".tablaMetodologiaRTA." WHERE id_propuesta=".$idPropuesta." AND id_metodologia=".$id_metodologia;
	//echo '<BR>'.$sqlR;
	$chObj		= NULL;
	$conR		= mysql_query($sqlR);
	if(mysql_num_rows($conR)){
		$chObj	= "checked='checked'";
	}

//t_reunion	t_entrega_material	t_elab_instrumento	t_aprob_instrumento	t_recoleccion_info	t_procesamiento	t_resultados

	$t_reunion	= $campos["t_reunion"];

	$nameObj	= nameObjMetodologias.'[]';
	$idObj		= 'metodologia'.$id_metodologia;
	$obj		= "<INPUT type='checkbox' name='$nameObj' id='$idObj' value='$id_metodologia' $chObj />";

	$objT	= "<INPUT type='text' name='$nomObj' id='$nomObj' maxlength='5' class='borderBlue' value='' style='width:50px; padding:3px; text-align:center;' onkeypress='return esNumero(event);' />";

	$filasMetodologia	.= "
	 <TR>
	  <TD align='right' class='bb'><div class='padding5'>$obj</div></TD>
	  <TD align='left' class='bb'><div class='padding5 textLabel'>$nom_metodologia</div></TD>
	  <TD align='left' class='bb'><div class='padding5 textLabel'>$objT</div></TD>
	 </TR>";
}

//---- nombre de la metodologias seleccionadas
$sql = "SELECT A.id_metodologia,A.nom_metodologia
 FROM ".tablaMetodologia." A INNER JOIN ".tablaMetodologiaRTA." B USING (id_metodologia)
  WHERE id_propuesta=".$idPropuesta."
   ORDER BY A.id_metodologia";
//echo '<BR>'.$sql;
$colsTitMetodologia		= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$nom_metodologia	= $campos["nom_metodologia"];

	$colsTitMetodologia	.= "<TD width='15%' align='center' class='bb divInstruccion'><div class='padding5'><B>$nom_metodologia</B></div></TD>";
}

//----
$sql = "SELECT * FROM ".tablaProceso." ORDER BY 1";
//echo '<BR>'.$sql;
$filasProcesos		= NULL;
$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	$id_proceso		= $campos["id_proceso"];
	$nom_proceso	= $campos["nom_proceso"];

	//---- consulta si el proceso aplica para la propuesta activa
	$sqlR = "SELECT * FROM ".tablaProcesoRTA." WHERE id_propuesta=".$idPropuesta." AND id_proceso=".$id_proceso;
	//echo '<BR>'.$sqlR;
	$chObj		= NULL;
	$conR		= mysql_query($sqlR);
	if(mysql_num_rows($conR) || $propuestaNueva == 1){
		$chObj	= "checked='checked'";
	}

	$nameObj		= nameObjProcesos.'[]';
	$idObj			= 'proceso'.$id_proceso;
	$objCH			= "<INPUT type='checkbox' name='$nameObj' id='$idObj' value='$id_proceso' $chObj />";

	//----
	$sqlR = "SELECT * FROM ".tablaMetodologiaRTA."
			 WHERE id_propuesta=".$idPropuesta."
			  ORDER BY id_metodologia";
	//echo '<BR>'.$sql;
	$colsMetodologia		= NULL;
	$conR					= mysql_query($sqlR);
	while($camposR			= mysql_fetch_array($conR)){
		$id_metodologia		= $camposR["id_metodologia"];
		$nom_metodologia	= $camposR["nom_metodologia"];

		$obj				= "<INPUT type='text' name='$nomObj' id='$nomObj' maxlength='2' class='borderBlue' value='$t_reunion' style='width:40px; padding:3px; text-align:center;' onkeypress='return esNumero(event);' />";
		$colsMetodologia	.= "<TD align='center' class='bb'><div class='padding5'>$obj</div></TD>";
	}

	$sqlR = "SELECT * FROM ".tablaMetodologiaRTA."
	 WHERE id_propuesta=".$idPropuesta." AND id_metodologia=".$id_metodologia."
	  ORDER BY id_metodologia";

	$filasProcesos		.= "
	 <TR>
	  <TD align='right' class='bb'><div class='padding5'>$objCH</div></TD>
	  <TD align='left' class='bb'><div class='padding5 textLabel'>$nom_proceso</div></TD>
	  $colsMetodologia
	  <TD align='center' class='bb'>&nbsp;</TD>
	 </TR>";
}

//----
$sql = "SELECT * FROM ".tablaEntregable." ORDER BY 1";
//echo '<BR>'.$sql;
$filasEntregable		= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_entregable		= $campos["id_entregable"];
	$nom_entregable		= $campos["nom_entregable"];

	$nameObj			= nameObjMetodologias.'e[]';
	$idObj				= 'tiempos'.$id_entregable;
	$obj				= "<INPUT type='checkbox' name='$nameObj' id='$idObj' value='$id_metodologia' />";

	$filasEntregable	.= "
	 <TR>
	  <TD align='right' class='bb'><div class='padding5'><IMG src='/imagenes/yes.png' height='16' border='0'></div></TD>
	  <TD align='left' class='bb'><div class='padding5 textLabel'>$nom_entregable</div></TD>
	  <TD align='center' class='bb'><div class='padding5'>$obj</div></TD>
	  <TD align='center' class='bb'>&nbsp;</TD>
	 </TR>";
}

?>