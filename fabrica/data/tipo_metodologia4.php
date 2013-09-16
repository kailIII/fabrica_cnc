<?
$idObjTitulo	= 'titulo'.$idRowMetodologia;
$idObjTemas		= 'temas'.$idRowMetodologia;
$idObjUniverso	= 'universo'.$idRowMetodologia;
$idObjMarco		= 'marco'.$idRowMetodologia;
$idDivS			= 'divSave'.$idRowMetodologia;

$funcion_save	= "save_tipo_metodologia1('$idRowMetodologia','$idPropuesta','$idObjTitulo','$idObjTemas','$idObjUniverso','$idObjMarco','$idDivS');";

//---- consulta los segmentos de la metodología
$sql = "SELECT *
 FROM ".tablaSegmentoMetodologiaRTA." R
  WHERE R.id_row_metodologia=$idRowMetodologia
   ORDER BY 1";
//echo '<BR>'.$sql;
$filasSegmentos			= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_row_segmento	= $campos["id_row_segmento"];
	$nom_segmento		= $campos["nom_segmento"];
	$universo			= $campos["universo"];
	$muestra			= $campos["muestra"];

//	$linkSegmento		= "<a href=\"javascript:document.getElementById('idRowSegmento').value=$id_row_segmento;\" class='contact'><span style='color:#036'>$nom_segmento</span></a>";
	$linkEdit		= "<a href='#' onmouseover=\"javascript:document.getElementById('idRowSegmento').value=$id_row_segmento;\" class='contact' title='Editar el segmento'><IMG src='/imagenes/icoblg_fondo1.png' height='18' border='0'></a>";
	$linkSegmento		= "<a href='#' onmouseover=\"javascript:document.getElementById('idRowSegmento').value=$id_row_segmento;\" class='contact' title='Editar el segmento'><span class='linkF'><B>$nom_segmento</B></span></a>";
	$filasSegmentos	.= "
	 <TR>
	  <TD align='right' class='bb'><div class='padding2'>$linkEdit</div></TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$linkSegmento</div></TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$universo</div></TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$muestra</div></TD>
	 </TR>";
}
?>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<div style="padding:5px 5px 20px 5px;">
<INPUT type='hidden' name='idRowSegmento' id='idRowSegmento' value=''>
<TABLE width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderALL">
 <TR>
  <TD width="80%" align='left' class="bb" style="background-color:#333"><div class='padding5' style="color:#FFF;"><B><?=$nomMetodologia?></B></div></TD>
  <TD width="10%" align='right' class="bb" style="background-color:#333"><div id="<?=$idDivS?>"></div></TD>
  <TD width="10%" align='right' class="bb" style="background-color:#333"><div style="padding:5px;"><a href="javascript:delete_metodologia('divAddMetodologia');"><img src="/imagenes/ico3_error.png" alt="Minimizar" title="Minimizar" height="22" border='0'></a></div></TD>
 </TR>
 <TR>
  <TD align='left' colspan="3">
    <TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="center" style="padding-bottom:10px;">
     <TR>
      <TD width="10%" align='left' class="bb"><div class='padding5 textLabel'>T&iacute;tulo:</div></TD>
      <TD width="90%" align='left' class="bb"><div class='padding5'><INPUT type="text" name="<?=$idObjTitulo?>" id="<?=$idObjTitulo?>" value="<?=$vr_titulo?>" class="txt" style="width:800px;" onchange="<?=$funcion_save?>" /></div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb" valign="top"><div class='padding5 textLabel'>Temas a tratar o objetivos tem&aacute;ticos a cubrir:</div></TD>
      <TD align='left' class="bb"><div class='padding5'><TEXTAREA name='<?=$idObjTemas?>' id='<?=$idObjTemas?>' class='borderBlue_' style='width:99%; height:80px; padding:5px;' onchange="<?=$funcion_save?>"><?=$vr_temas?></TEXTAREA></div></TD>
     </TR>
     <TR>
      <TD align='left' colspan="2" valign="bottom"><hr color='#1AA8FF' size='2'></TD>
     </TR>
	 <TR>
	  <TD align='left' colspan="2">
        <div align="left" class='padding5 textLabel'><B>Definici&oacute;n de segmentos:</B></div>
        <TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0' class="borderTL">
         <TR style="background-color:#CCC">
          <TD width='1%' align='left' class='bb'>&nbsp;</TD>
          <TD align='left' class='borderBR'><div class='padding5'><B>Segmento</B></div></TD>
          <TD width='15%' align='left' class='borderBR'><div class='padding5'><B>Universo</B></div></TD>
          <TD width='15%' align='left' class='borderBR'><div class='padding5'><B>Muestra</B></div></TD>
         </TR>
         <?=$filasSegmentos?>
        </TABLE>
      </TD>
	 </TR>
     <TR>
      <TD align='left' colspan="2">
       <div id='content' style="margin:0px; padding:4px 0px;">
        <div id='contact-form' style="margin:0px; padding:padding:2px 5px;">
        <!-- <input type='button' name='contact' value='Demo' class='contact demo'/> or <a href='#' class='contact'>Demo</a> -->
        <a href='#' onmouseover="javascript:document.getElementById('idRowSegmento').value='';" class='contact'><span class='linkF'><img src='/imagenes/ico-feedback.png' height='32' border='0' alt='Adicionar segmento' title='Adicionar segmento' /> <B>Adicionar segmento</B></span></a>
        </div>
        <!-- preload the images -->
        <div style='display:none'><img src='../img/contact/loading.gif' alt='' /></div>
       </div>
      </TD>
     </TR>
	</TABLE>
  </TD>
 </TR>
</TABLE>
</div>