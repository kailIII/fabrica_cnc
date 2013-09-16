<?
//----
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
	$cantidadM	= NULL;
	$conR		= mysql_query($sqlR);
	while($camposR		= mysql_fetch_array($conR)){
		$cantidadM	= $camposR["cantidad"];
		$chObj	= "checked='checked'";
	}

	$nameObj	= nameObjMetodologias."[$id_metodologia]";
	$idObj		= 'metodologia'.$id_metodologia;
	$obj		= "<INPUT type='checkbox' name='$nameObj' id='$idObj' value='$id_metodologia' $chObj />";

	$nameObj	= 'm'.$id_metodologia.'cantidad';
	$idObj		= $nameObj;

	$objT		= "<INPUT type='text' name='$nameObj' id='$idObj' maxlength='5' class='borderBlue' value='$cantidadM' style='width:50px; padding:3px; text-align:center;' onkeypress='return esNumero(event);' />";

	$filasMetodologia	.= "
	 <TR>
	  <TD align='right' class='bb'><div class='padding5'>$obj</div></TD>
	  <TD align='left' class='bb'><div class='padding5 textLabel'>$nom_metodologia</div></TD>
	  <TD align='left' class='bb'><div class='padding5 textLabel'>$objT</div></TD>
	 </TR>";
}
?>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left" style='border:1px solid #CED7EC;'>
	 <TR>
	  <TD align='left' class="bb" width="5%" nowrap="nowrap"><div class='padding5 textLabel'><B>Tipo de estudio:</B></div></TD>
	  <TD align='left' class="bb" width="95%"><div class='padding5'>
		<SELECT name='tipo_estudio' id='tipo_estudio' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionTipoEstudio?>
		</SELECT>
	  </div></TD>
	 </TR>
	 <TR>
	  <TD align="center" colspan="2">
	    <div class='padding5'>
		<TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
		 <TR>
		  <TD width="1%" align='right' class="bb divInstruccion">&nbsp;</TD>
		  <TD width="40%" align='left' class="bb divInstruccion"><div class='padding5'><B>Metodologías</B></div></TD>
		  <TD align='left' class="bb divInstruccion"><div class='padding5'><B>Cantidad</B></div></TD>
		 </TR>
		 <?=$filasMetodologia?>
		</TABLE>
		</div>
	  </TD>
	 </TR>
	</TABLE>
