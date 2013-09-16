<?
//----
$sql = "SELECT * FROM ".tablaNotasCalidadRTA." WHERE id_propuesta='$idPropuesta' ORDER BY 1,2";
//echo '<BR>'.$sql;
$con					= mysql_query($sql);
if(mysql_num_rows($con)==0){
	$sql = "SELECT * FROM ".tablaNotasCalidad." ORDER BY 1";
	//echo '<BR>'.$sql;
	$con				= mysql_query($sql);
}
$filasNotas	= NULL;
while($campos			= mysql_fetch_array($con)){
	$id_nota_calidad	= $campos["id_nota_calidad"];
	$des_nota_calidad	= $campos["des_nota_calidad"];

	$nomObj	= nameObjNotasCalidad.'[]';
	$idObj	= nameObjNotasCalidad.$id_nota_calidad;

	$campos["activo_nota_calidad"] == 1 ? $checked = "checked" : $checked = "";

	$obj	= "<TEXTAREA name='$nomObj' id='$idObj' lang='1' title='' class='borderBlue' style='width:97%; height:60px; padding:5px;'>$des_nota_calidad</TEXTAREA>";
	$filasNotas	.= "
	 <TR>
	  <TD align='left' class='bb notacc-row'><div class='padding5'>$obj</div> <input type='checkbox' value='1' name='activo_nota_calidad[$id_nota_calidad]' $checked > </TD>
	 </TR>";
}
?>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	 <TR>
	  <TD align="center" class='bb divInstruccion'><div class='padding5'><B>Notas de calidad</B></div></TD>
	 </TR>
	 <TR>
	  <TD align="letf"><div class='padding5'>El Centro Nacional de Consultor&iacute;a:</div></TD>
	 </TR>
     <?=$filasNotas?>
	</TABLE>
