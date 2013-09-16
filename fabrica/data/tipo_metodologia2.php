<?php
//$tituloModal			= 'Adicionar';
$tituloModal			= '';
//---- consulta los segmentos de la metodología
$sqlS = "SELECT *
 FROM ".tablaSegmentoMetodologiaRTA." R
  WHERE R.id_propuesta=$idPropuesta AND R.id_row_metodologia=$id_row_metodologia
  ORDER BY id_row_segmento";
//echo '<BR>'.$sqlS;
$conS						= mysql_query($sqlS);
while($camposS				= mysql_fetch_array($conS)){
	$nom_segmento			= $camposS["nom_segmento"];
	$universo				= $camposS["universo"];
	$muestra				= $camposS["muestra"];
	$lugar					= $camposS["lugar"];
	$vrDuracion				= $camposS["duracion"];
	$error_muestral			= $camposS["error_muestral"];
	$id_pob_objetivo_r		= $camposS["id_pob_objetivo"];
	$id_duracion_r			= $camposS["id_duracion"];
	$id_nivel_aceptacion_r	= $camposS["id_nivel_aceptacion"];
	$id_cobertura_r			= $camposS["id_cobertura"];
	$id_origen_db_r			= $camposS["id_origen_db"];
	$idRowSeg				= $camposS["id_row_segmento"];
	$optionOrigenDB			= getOrigenDB($id_origen_db_r);
	$optionPobObjetivo		= getPobObjetivo($idTipoMetodologia,$id_pob_objetivo_r);
	$optionNivelAceptacion	= getNivelAceptacion($idTipoMetodologia,$id_nivel_aceptacion_r);
	$optionCobertura		= getCobertura($idTipoMetodologia,$id_cobertura_r);
//----
?>
	<INPUT type='hidden' name='idRowSeg[<?=$idRowSeg?>]' value='<?=$idRowSeg?>'>
 	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#CCCCCC;">
	 <TR>
	  <TD align='left' width="95%"><div style="padding:0px 5px; color:#FFFFFF; font-size:14px;"><B><?=$tituloModal?></B></div></TD>
	  <TD align='right' width="5%"><div style="padding:4px 1px;"><a href="javascript:void(0);"><img src="/imagenes/ico3_error.png" width="22" border="0" alt="Cancelar" title="Cancelar" class="simplemodal-close" /></a></div></TD>
	 </TR>
	</TABLE>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL">
     <TR>
      <TD align='left' class="bb" width="10%" nowrap="nowrap"><div class='padding5 textLabel'>Nombre del segmento:</div></TD>
      <TD align='left' class="bb" width="90%"><div class='padding5'><INPUT type='text' name='s_nom_segmento[<?=$idRowSeg?>]' class='borderBlue userText' style='width:95%; padding:4px 5px;' value='<?=$nom_segmento?>' /></div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Mecanismo de captaci&oacute;n de los participantes:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='s_origen_db[<?=$idRowSeg?>]' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionOrigenDB?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb" nowrap="nowrap"><div class='padding5 textLabel'>Cantidad de participantes:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='s_pob_objetivo[<?=$idRowSeg?>]' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionPobObjetivo?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Nivel de aceptación:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='s_nivel_aceptacion[<?=$idRowSeg?>]' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionNivelAceptacion?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Cobertura:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='s_cobertura[<?=$idRowSeg?>]' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionCobertura?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Muestra:</div></TD>
      <TD align='left' class="bb"><div class='padding5'><INPUT type='text' name='s_muestra[<?=$idRowSeg?>]' maxlength='5' value='<?=$muestra?>' class='txt' style='width:70px; text-align:center;' onkeypress='return esNumero(event);' /></div></TD>
     </TR>
	</TABLE>
<?php
}
?>
