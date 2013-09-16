<?
@header('Content-Type: text/html; charset=iso-8859-1');
include("../../libreria.php");
include("../../connection.php");
include("../funciones.php");
$nameObj			= $_POST['nameObj'];
$idObjContObjetos	= $_POST['idObjContObjetos'];
$idPreg				= $_POST['idPreg'];
$idDivNewObj		= $_POST['idDivNewObj'];
$nroObjetos			= $_POST['nroObjetos'];
$contObjetos		= $_POST['contObjetos'];
$newObj				= $_POST['newObj'];

//echo '<BR>nameObj: '.$nameObj;
$idNewObj			= 'obj'.$idPreg.'_'.$nroObjetos;

$idObjValidacion	= 'objValDirector'.$nroObjetos;
//$msj_validacion		= "Por favor ingrese su opinión del directivo";
//$objValidacion		= "<INPUT type='hidden' name='$idObjValidacion' id='$idObjValidacion' value='0' lang='$msj_validacion'>";
$objValidacion		= NULL;
echo crearObj($idDivNewObj, $idNewObj, $idObjContObjetos, $nameObj, $objValidacion=NULL);
?>
    <TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="center" style="padding-bottom:10px;">
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Población Objetivo:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='id_pob_objetivo[<?=$ind?>]' id='id_pob_objetivo[<?=$ind?>]' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionPobObjetivo?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Duración:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='id_duracion[<?=$ind?>]' id='id_duracion[<?=$ind?>]' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionDuracion?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Nivel de aceptación:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='id_nivel_aceptacion[<?=$ind?>]' id='id_nivel_aceptacion[<?=$ind?>]' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionNivelAceptacion?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb" colspan="2"><div class='padding5 textLabel'><B>Definición de segmentos:</B></div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb" nowrap="nowrap" valign="top"><div class='padding5 textLabel'>Cantidad por segmento:</div></TD>
      <TD align='left' class="bb">
       <TABLE width='100%' border='0' cellspacing='0' cellpadding='0' align='center' style='padding:0px; background-color:#FAFAFA'>
         <TR style="background-color:#CCC">
          <TD width='4%' align='left' class='borderBR'>&nbsp;</TD>
          <TD width='46%' align='left' class='borderBR'><div class='padding5'><B>Segmento</B></div></TD>
          <TD width='10%' align='center' class='borderBR'><div class='padding5'><B>Universo</B></div></TD>
          <TD width='10%' align='center' class='borderBR'><div class='padding5'><B>Muestra</B></div></TD>
          <TD width='10%' align='center' class='borderBR'><div class='padding5'><B>Error estimado %</B></div></TD>
          <TD width='20%' align='left' class='borderBR'><div class='padding5'><B>Cobertura</B></div></TD>
         </TR>
        <?=$filasCiudad?>
       </TABLE>
      </TD>
     </TR>
	</TABLE>
