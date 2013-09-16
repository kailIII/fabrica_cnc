<?php
//session_start();
header('Content-Type: text/html; charset=iso-8859-1');
include("../../connection.php");
include("../../libreria.php");
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
?>
<div class='contact-content div_radius8'>
<FORM name="formulario" id="formulario" method="post" action="">
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
      <TD align='left' class="bb" width="10%" nowrap="nowrap"><div class='padding5 textLabel'>Nombre del segmento:</div></TD>
      <TD align='left' class="bb" width="90%"><div class='padding5'><INPUT type='text' name='<?=idObjNomSegmento?>' id='<?=idObjNomSegmento?>' class='borderBlue userText' style='width:95%; padding:4px 5px;' value='<?=$nom_segmento?>' /></div></TD>
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
      <TD align='left' class="bb"><div class='padding5 textLabel'>Muestra:</div></TD>
      <TD align='left' class="bb"><div class='padding5'><INPUT type='text' name='<?=idObjMuestra?>' id='<?=idObjMuestra?>' maxlength='5' value='<?=$muestra?>' class='txt' style='width:70px; text-align:center;' onkeypress='return esNumero(event);' /></div></TD>
     </TR>
	</TABLE>
	</div>
	<TABLE width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
	 <TR>
	  <TD align='right' width="50%" style="border-top:1px solid #EBEBEB"><div style="padding:0px 5px;"><INPUT type='button' name='btn_cancelar' id='btn_cancelar' class='Button simplemodal-close' style="padding:3px; width:100px;" value='Cancelar' /></div></TD>
	  <TD align='left' width="50%" style="border-top:1px solid #EBEBEB"><div style="padding:0px 5px;"><INPUT type='submit' name='btn_tipo_metodologia4' id='btn_tipo_metodologia4' class='Button' style="padding:3px; width:100px;" value='Guardar' /></div></TD>
	 </TR>
	</TABLE>
</FORM>
</div>
