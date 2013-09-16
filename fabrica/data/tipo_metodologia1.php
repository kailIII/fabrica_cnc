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
$lugar					= NULL;
$vrDuracion				= NULL;
$error_muestral			= NULL;
$error_muestral			= NULL;
$id_pob_objetivo_r		= NULL;
$id_duracion_r			= NULL;
$id_nivel_aceptacion_r	= NULL;
$id_cobertura_r			= NULL;
$tituloModal			= 'Adicionar';
if(!empty($idRowSegmento)){
	$tituloModal	= 'Editar';
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
		$lugar					= $campos["lugar"];
		$vrDuracion				= $campos["duracion"];
		$error_muestral			= $campos["error_muestral"];
		$id_pob_objetivo_r		= $campos["id_pob_objetivo"];
		$id_duracion_r			= $campos["id_duracion"];
		$id_nivel_aceptacion_r	= $campos["id_nivel_aceptacion"];
		$id_cobertura_r			= $campos["id_cobertura"];
		$id_origen_db_r			= $campos["id_origen_db"];
	}
}
//----
include("sql_tarifario.php");
?>
<INPUT type='hidden' name='idPropuesta' id='idPropuesta' value='<?=$idPropuesta?>'>
<INPUT type='hidden' name='idRowMetodologia' id='idRowMetodologia' value='<?=$idRowMetodologia?>'>
<INPUT type='hidden' name='idTipoMetodologia' id='idTipoMetodologia' value='<?=$idTipoMetodologia?>'>
<INPUT type='hidden' name='idMetodologia' id='idMetodologia' value='<?=$idMetodologia?>'>
<INPUT type='hidden' name='idRowSegmento' id='idRowSegmento' value='<?=$idRowSegmento?>'>
<INPUT type='hidden' name='cPagina' id='cPagina' value='<?=$cPagina?>'>
 	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#333333;">
	 <TR>
	  <TD align='left' width="95%"><div style="padding:0px 5px; color:#FFFFFF; font-size:14px;"><B><?=$tituloModal?></B></div></TD>
	  <TD align='right' width="5%"><div style="padding:4px 1px;"><a href="javascript:void(0);"><img src="/imagenes/ico3_error.png" width="22" border="0" alt="Cancelar" title="Cancelar" class="simplemodal-close" /></a></div></TD>
	 </TR>
	</TABLE>
	<div style="height:400px; padding:0px; overflow:auto; padding:2px 4px;">
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL">
     <TR>
      <TD align='left' class="bb" width="10%" nowrap="nowrap"><div class='padding5 textLabel'>Nombre del segmento o ciudad:</div></TD>
      <TD align='left' class="bb" width="90%"><div class='padding5'><INPUT type='text' name='<?=idObjNomSegmento?>' id='<?=idObjNomSegmento?>' class='borderBlue' style='width:95%; padding:4px 5px;' value='<?=$nom_segmento?>' /></div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Mecanismo de captaci&oacute;n de los participantes:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='<?=idObjOrigenDB?>' id='<?=idObjOrigenDB?>' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionOrigenDB?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb" nowrap="nowrap"><div class='padding5 textLabel'>Cantidad de participantes :</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='<?=idObjPobObjetivo?>' id='<?=idObjPobObjetivo?>' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionPobObjetivo?>
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
      <TD align='left' class="bb"><div class='padding5 textLabel'>Muestra o n&uacute;mero de sesiones:</div></TD>
      <TD align='left' class="bb"><div class='padding5'><INPUT type='text' name='<?=idObjMuestra?>' id='<?=idObjMuestra?>' maxlength='5' value='<?=$muestra?>' class='txt' style='width:70px; text-align:center;' onkeypress='return esNumero(event);' /></div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb" nowrap="nowrap" valign="top"><div class='padding5 textLabel'>Lugar donde se va a realizar:</div></TD>
      <TD align='left' class="bb">
      <div class='padding5'>
      <span style="color:#000000; background-color:#6CF; padding:2px 10px; margin-bottom:2px;">Que tenga implicación en los precios</span>
      <INPUT type='text' name='<?=idObjLugar?>' id='<?=idObjLugar?>' class='borderBlue' style='width:95%; padding:4px 5px;' value='<?=$lugar?>' onfocus="verLugares('');" ondblclick="verLugares(1);" autocomplete="off" />
       <div id="listLugares" style="width:96%; display:none; border:1px solid #000">
      	<a href="javascript:selLugar('divLugar1');"><div id="divLugar1" style="padding:5px;">Sede del CNC</div></a>
      	<a href="javascript:selLugar('divLugar2');"><div id="divLugar2" style="padding:5px;">Alquiler salón</div></a>
       </div>      
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb" nowrap="nowrap"><div class='padding5 textLabel'>Duraci&oacute;n:</div></TD>
      <TD align='left' class="bb"><div class='padding5'><INPUT type='text' name='<?=idObjDuracion?>' id='<?=idObjDuracion?>' class='borderBlue' style='width:95%; padding:4px 5px;' value='<?=$vrDuracion?>' /></div></TD>
     </TR>
	</TABLE>
	</div>
	<TABLE width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
	 <TR>
	  <TD align='right' width="50%" style="border-top:1px solid #EBEBEB"><div style="padding:0px 5px;"><INPUT type='button' name='btn_cancelar' id='btn_cancelar' class='Button simplemodal-close' style="padding:3px; width:100px;" value='Cancelar' /></div></TD>
	  <TD align='left' width="50%" style="border-top:1px solid #EBEBEB"><div style="padding:0px 5px;"><INPUT type='submit' name='btn_tipo_metodologia1' id='btn_tipo_metodologia1' class='Button' style="padding:3px; width:100px;" value='Guardar' /></div></TD>
	 </TR>
	</TABLE>
