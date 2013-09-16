<?
//----
$sqlM = "SELECT * FROM ".tablaTipoMetodologia." ORDER BY 1";
//echo '<BR>'.$sqlM;
$optionMetodologia			= NULL;
$filasMetodologia			= NULL;
$contMetodologias			= 0;
$conM						= mysql_query($sqlM);
while($camposM				= mysql_fetch_array($conM)){
	$id_tipo_metodologia	= $camposM["id_tipo_metodologia"];
	$nom_tipo_metodologia	= $camposM["nom_tipo_metodologia"];

	$optionMetodologia		.= "<OPTGROUP label='$nom_tipo_metodologia'>";
	
	$sql = "SELECT * FROM ".tablaMetodologia." WHERE id_tipo_metodologia=$id_tipo_metodologia ORDER BY 1";
	//echo '<BR>'.$sql;
	$con					= mysql_query($sql);
	while($campos			= mysql_fetch_array($con)){
		$id_metodologia		= $campos["id_metodologia"];
		$nom_metodologia	= $campos["nom_metodologia"];
		//---- consulta si la metodología aplica para la propuesta activa
		$sqlR = "SELECT * FROM ".tablaMetodologiaRTA." WHERE id_propuesta=".$idPropuesta." AND id_metodologia=".$id_metodologia;
		//echo '<BR>'.$sqlR;
		$selected_e		= NULL;
		$chObj		= NULL;
		$cantidadM	= NULL;
		$conR		= mysql_query($sqlR);
		while($camposR	= mysql_fetch_array($conR)){
			++$contMetodologias;
			$cantidadM	= $camposR["cantidad"];
			$chObj		= "checked='checked'";
	
			$selected_e	= "selected";
		}
	
		$optionMetodologia	.= "<OPTION value='$id_metodologia' $selected_e>$nom_metodologia</OPTION>";
	
	
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
	$optionMetodologia	.= "</OPTGROUP>";
}
?>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	 <TR>
	  <TD align='left' width="5%" class="bb" nowrap="nowrap"><div class='padding5 textLabel'><B>Metodolog&iacute;as:</B></div></TD>
	  <TD align='left' width="15%" class="bb"><div class='padding5'>
		<SELECT name='id_metodologia' id='id_metodologia' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionMetodologia?>
		</SELECT>
        <INPUT type='hidden' name='contMetodologias' id='contMetodologias' value='<?=$contMetodologias?>'>
	  </div></TD>
	  <TD align='left' width="80%" class="bb"><div style="padding:2px 5px;"><a href="javascript:add_metodologia();"><img src="../add_document2.jpg" alt="Adicionar Metodolagía" title="Adicionar Metodolagía" height="40" border='0'></a></div></TD>
	 </TR>
	 <TR>
	  <TD align='left' class="bb">&nbsp;</TD>
	  <TD align='left' class="bb" colspan="2"><div id="divMetodologia"></div></TD>
	 </TR>
	</TABLE>
