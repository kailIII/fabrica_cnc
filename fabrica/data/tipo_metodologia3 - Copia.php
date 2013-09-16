<?php
//$tipo_usuario		= $_SESSION['tipoUsuario'];
$idPropuesta		= $_REQUEST['idPropuesta'];
$idRowMetodologia	= $_REQUEST['idRowMetodologia'];
$idTipoMetodologia	= $_REQUEST['idTipoMetodologia'];
$idMetodologia		= $_REQUEST['idMetodologia'];
$idRowSegmento		= $_REQUEST['idRowSegmento'];

//echo '<BR>idRowSegmento: '.$idRowSegmento;

$cPagina			= $_REQUEST['cPagina'];

$nom_segmento			= NULL;
$universo				= NULL;
$muestra				= NULL;
$error_muestral			= NULL;
$error_muestral			= NULL;
$id_pob_objetivo_r		= NULL;
$id_duracion_r			= NULL;
$id_nivel_aceptacion_r	= NULL;
$id_cobertura_r			= NULL;
$tituloModal			= 'Adicionar Segmento';
if(!empty($idRowSegmento)){
	$tituloModal	= 'Editar Segmento';
	//---- consulta los segmentos de la metodología
	$sql = "SELECT *
	 FROM ".tablaSegmentoMetodologiaRTA." R
	  WHERE R.id_row_segmento=$idRowSegmento";
	//echo '<BR>'.$sql;
	$con						= mysql_query($sql);
	while($campos				= mysql_fetch_array($con)){
		$nom_segmento			= $campos["nom_segmento"];
		$universo				= $campos["universo"];
		$muestra				= $campos["muestra"];
		$error_muestral			= $campos["error_muestral"];
		$id_pob_objetivo_r		= $campos["id_pob_objetivo"];
		$id_duracion_r			= $campos["id_duracion"];
		$id_nivel_aceptacion_r	= $campos["id_nivel_aceptacion"];
		$id_cobertura_r			= $campos["id_cobertura"];
	}
}
//----
include("sql_tarifario.php");

$p					= 0.5;
$costante			= 1.95;
$fx_error_muestral	= "cal_error_muestral('$p','$costante','".idObjMuestra."','".idObjErrorMuestral."')";

?>
<FORM name="formulario" id="formulario" method="post" action="">
<INPUT type='hidden' name='idPropuesta' id='idPropuesta' value='<?=$idPropuesta?>'>
<INPUT type='hidden' name='idRowMetodologia' id='idRowMetodologia' value='<?=$idRowMetodologia?>'>
<INPUT type='hidden' name='idTipoMetodologia' id='idTipoMetodologia' value='<?=$idTipoMetodologia?>'>
<INPUT type='hidden' name='idMetodologia' id='idMetodologia' value='<?=$idMetodologia?>'>
<INPUT type='hidden' name='idRowSegmento' id='idRowSegmento' value='<?=$idRowSegmento?>'>
<INPUT type='hidden' name='cPagina' id='cPagina' value='<?=$cPagina?>'>
 	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#CCCCCC;">
	 <TR>
	  <TD align='left' width="95%"><div style="padding:0px 5px; color:#333333; font-size:14px;"><B><?=$tituloModal?></B></div></TD>
	  <TD align='right' width="5%"><div style="padding:4px 1px;"><a href="javascript:void(0);"><img src="/imagenes/ico3_error.png" width="22" border="0" alt="Cancelar" title="Cancelar" class="simplemodal-close" /></a></div></TD>
	 </TR>
	</TABLE>
	<div style="height:520px; padding:0px; overflow:auto; padding:2px 4px;">
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL">
     <TR>
      <TD align='left' class="bb" width="10%" nowrap="nowrap"><div class='padding5 textLabel'>Nombre del segmento:</div></TD>
      <TD align='left' class="bb" width="90%"><div class='padding5'><INPUT type='text' name='<?=idObjNomSegmento?>' id='<?=idObjNomSegmento?>' class='borderBlue userText' style='width:99%; padding:4px 5px;' value='<?=$nom_segmento?>' /></div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb" nowrap="nowrap"><div class='padding5 textLabel'>Cantidad de participantes:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='<?=idObjPobObjetivo?>' id='<?=idObjPobObjetivo?>' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionPobObjetivo?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Duración:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='<?=idObjDuracion?>' id='<?=idObjDuracion?>' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionDuracion?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Nivel de aceptación:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='<?=idObjNivelAceptacion?>' id='<?=idObjNivelAceptacion?>' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionNivelAceptacion?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Cobertura:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='<?=idObjCobertura?>' id='<?=idObjCobertura?>' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionCobertura?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Universo:</div></TD>
      <TD align='left' class="bb"><div class='padding5'><INPUT type='text' name='<?=idObjUniverso?>' id='<?=idObjUniverso?>' maxlength='5' value='<?=$universo?>' class='txt' style='width:70px; text-align:center;' onkeypress='return esNumero(event);' /></div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Muestra:</div></TD>
      <TD align='left' class="bb"><div class='padding5'><INPUT type='text' name='<?=idObjMuestra?>' id='<?=idObjMuestra?>' maxlength='5' value='<?=$muestra?>' class='txt' style='width:70px; text-align:center;' onkeyup="<?=$fx_error_muestral?>" onkeypress='return esNumero(event);' /></div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Error estimado %:</div></TD>
      <TD align='left' class="bb"><div class='padding5'><INPUT type='text' name='<?=idObjErrorMuestral?>' id='<?=idObjErrorMuestral?>' value='<?=$error_muestral?>' class='txt' style='width:70px; text-align:center; background-color:#FAFAFA;' readonly='readonly' /></div></TD>
     </TR>
     <TR>
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
     <TR>
      <TD align='left' colspan="2">&nbsp;</TD>
     </TR>
	</TABLE>
	</div>
     

	<TABLE width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
	 <TR>
	  <TD align='right' width="50%" style="border-top:1px solid #EBEBEB"><div style="padding:0px 5px;"><INPUT type='button' name='btn_cancelar' id='btn_cancelar' class='Button simplemodal-close' style="padding:3px; width:100px;" value='Cancelar' /></div></TD>
	  <TD align='left' width="50%" style="border-top:1px solid #EBEBEB"><div style="padding:0px 5px;"><INPUT type='submit' name='btn_tipo_metodologia3' id='btn_tipo_metodologia3' class='Button' style="padding:3px; width:100px;" value='Guardar' /></div></TD>
	 </TR>
	</TABLE>
</FORM>
