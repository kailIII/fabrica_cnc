<?
//----
$sql = "SELECT * FROM ".tablaTipoEstudio." ORDER BY nom_tipo_estudio";
//echo '<BR>'.$sql;
$optionTipoEstudio		= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_tipo_estudio	= $campos["id_tipo_estudio"];
	$nom_tipo_estudio	= $campos["nom_tipo_estudio"];

	$selected_e		= NULL;
	if($id_tipo_estudio==$tipo_estudio){
		$selected_e	= "selected";
	}

	$optionTipoEstudio.= "<OPTION value='$id_tipo_estudio' $selected_e>$nom_tipo_estudio</OPTION>";
}
?>
	<TABLE width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
	 <TR>
	  <TD width="5%" align='left' class="bb" nowrap="nowrap"><div class='padding5 textLabel'><B>Tipo de estudio:</B></div></TD>
	  <TD width="95%" align='left' class="bb" colspan="2"><div class='padding5'>
<!--		<SELECT name='tipo_estudio' id='tipo_estudio' lang='1' title='' style="padding:5px;" onchange="con_objetivos();">
-->		<SELECT name='tipo_estudio' id='tipo_estudio' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionTipoEstudio?>
		</SELECT>
	  </div></TD>
	 </TR>
	 <TR>
	  <TD align='left'>&nbsp;</TD>
	  <TD align='left' colspan="2"><div id="divObjetivos">
<B>Objetivo General:</B><br />
<TEXTAREA name='objetivo_general' id='objetivo_general' lang='1' title='' class='borderBlue' style='width:99%; height:60px; padding:5px;'><?=$objetivo_general?></TEXTAREA>
<B>Objetivos espec&iacute;ficos:</B><br />
<TEXTAREA name='objetivos_especificos' id='objetivos_especificos' lang='1' title='' class='borderBlue' style='width:99%; height:120px; padding:5px;'><?=$objetivos_especificos?></TEXTAREA>
      </div></TD>
	 </TR>
	</TABLE>
