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
	$error_muestral			= $camposS["error_muestral"];
	$id_pob_objetivo_r		= $camposS["id_pob_objetivo"];
	$id_duracion_r			= $camposS["id_duracion"];
	$id_nivel_aceptacion_r	= $camposS["id_nivel_aceptacion"];
	$id_cobertura_r			= $camposS["id_cobertura"];
	$idRowSeg				= $camposS["id_row_segmento"];
	$optionPobObjetivo		= getPobObjetivo($idTipoMetodologia,$id_pob_objetivo_r);
	$optionNivelAceptacion	= getNivelAceptacion($idTipoMetodologia,$id_nivel_aceptacion_r);
	$optionCobertura		= getCobertura($idTipoMetodologia,$id_cobertura_r);
	$optionDuracion			= getDuracion($idTipoMetodologia,$id_duracion_r);
	
	$idObjMuestra			= idObjMuestra.$idRowSeg;
	$idObjErrorMuestral		= idObjErrorMuestral.$idRowSeg;
	//----
	$p					= 0.5;
	$costante			= 1.95;
	$fx_error_muestral	= "cal_error_muestral('$p','$costante','".$idObjMuestra."','".$idObjErrorMuestral."')";

?>
	<INPUT type='hidden' name='idRowSeg[<?=$idRowSeg?>]' value='<?=$idRowSeg?>'>
 	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#CCCCCC;">
	 <TR>
	  <TD align='left' width="95%"><div style="padding:0px 5px; color:#333333; font-size:14px;"><B><?=$tituloModal?></B></div></TD>
	  <TD align='right' width="5%"><div style="padding:4px 1px;"><a href="javascript:void(0);"><img src="/imagenes/ico3_error.png" width="22" border="0" alt="Cancelar" title="Cancelar" class="simplemodal-close" /></a></div></TD>
	 </TR>
	</TABLE>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL">
     <TR>
      <TD align='left' class="bb" width="10%" nowrap="nowrap"><div class='padding5 textLabel'>Nombre del segmento:</div></TD>
      <TD align='left' class="bb" width="90%"><div class='padding5'><INPUT type='text' name='s_nom_segmento[<?=$idRowSeg?>]' class='borderBlue userText' style='width:99%; padding:4px 5px;' value='<?=$nom_segmento?>' /></div></TD>
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
      <TD align='left' class="bb"><div class='padding5 textLabel'>Duración:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='s_duracion[<?=$idRowSeg?>]' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionDuracion?>
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
      <TD align='left' class="bb"><div class='padding5 textLabel'>Universo:</div></TD>
      <TD align='left' class="bb"><div class='padding5'><INPUT type='text' name='s_universo[<?=$idRowSeg?>]' maxlength='5' value='<?=$universo?>' class='txt' style='width:70px; text-align:center;' onkeypress='return esNumero(event);' /></div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Muestra:</div></TD>
      <TD align='left' class="bb"><div class='padding5'><INPUT type='text' name='s_muestra[<?=$idRowSeg?>]' id="<?=$idObjMuestra?>" maxlength='5' value='<?=$muestra?>' class='txt' style='width:70px; text-align:center;' onkeyup="<?=$fx_error_muestral?>" onkeypress='return esNumero(event);' /></div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Error estimado %:</div></TD>
      <TD align='left' class="bb"><div class='padding5'><INPUT type='text' name='s_error_muestral[<?=$idRowSeg?>]' id="<?=$idObjErrorMuestral?>" value='<?=$error_muestral?>' class='txt' style='width:70px; text-align:center; background-color:#FAFAFA;' readonly='readonly' /></div></TD>
     </TR>
<!--     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Muestras pequeñas:</div></TD>
      <TD align='left' class="bb">
        <TABLE width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
         <TR>
          <TD align='right' width="5%"><div class='padding5 textLabel'>Filas</div></TD>
          <TD align='left' width="5%">
          <div style="padding:0px 5px;">
            <SELECT name='nro_rows' id='nro_rows' style="padding:5px;">
             <OPTION value='1' selected="selected">1</OPTION>
             <OPTION value='2'>2</OPTION>
             <OPTION value='3'>3</OPTION>
             <OPTION value='4'>4</OPTION>
             <OPTION value='5'>5</OPTION>
             <OPTION value='6'>6</OPTION>
             <OPTION value='7'>7</OPTION>
             <OPTION value='8'>8</OPTION>
             <OPTION value='9'>9</OPTION>
             <OPTION value='10'>10</OPTION>
            </SELECT>
          </div></TD>
          <TD align='right' width="5%"><div class='padding5 textLabel'>Columnas</div></TD>
          <TD align='left' width="5%">
          <div style="padding:0px 5px;">
            <SELECT name='nro_cols' id='nro_cols' style="padding:5px;">
             <OPTION value='1' selected="selected">1</OPTION>
             <OPTION value='2'>2</OPTION>
             <OPTION value='3'>3</OPTION>
             <OPTION value='4'>4</OPTION>
             <OPTION value='5'>5</OPTION>
             <OPTION value='6'>6</OPTION>
            </SELECT>
          </div></TD>
		  <TD align='left'><div class='padding5'><INPUT type='button' name='btn_add_table' id='btn_add_table' class='Button' style="padding:3px; width:100px;" value='Crear tabla' onclick="add_table_segmentos();" /></div></TD>
         </TR>
        </TABLE>
      </TD>
     </TR>
     <TR>
      <TD align='left' colspan="2"><div id="divTrabla"></div></TD>
     </TR>
-->     <TR>
      <TD align='left' colspan="2">&nbsp;</TD>
     </TR>
	</TABLE>
<?php
}
?>
