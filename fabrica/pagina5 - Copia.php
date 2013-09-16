<?
$idMetodologia		= $_POST['id_metodologia'];
$idRowMetodologia	= $_POST['idRowMetodologia']; // ---- identificador del registro de cada metodologia por propuesta
//echo '<BR>idRowMetodologia: '.$idRowMetodologia;

//----
$sqlM = "SELECT * FROM ".tablaTipoMetodologia." ORDER BY 1";
//echo '<BR>'.$sqlM;
$optionMetodologia			= NULL;
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

		$selected_e		= NULL;
		if($id_metodologia==$idMetodologia){
//			$selected_e	= "selected";
		}
		$optionMetodologia	.= "<OPTION value='$id_metodologia' $selected_e>$nom_metodologia</OPTION>";
	}
	$optionMetodologia	.= "</OPTGROUP>";
}
if(!empty($idMetodologia)){
	//---- consulta el tipo de metodología seleccionada
	$sql = "SELECT * FROM ".tablaMetodologia." WHERE id_metodologia=$idMetodologia";
	//echo '<BR>'.$sql;
	$nom_metodologia		= NULL;
	$con					= mysql_query($sql);
	while($campos			= mysql_fetch_array($con)){
		$idTipoMetodologia	= $campos["id_tipo_metodologia"];
		$nomMetodologia		= $campos["nom_metodologia"];
	}

	$sql = "INSERT INTO ".tablaMetodologiaRTA." (id_propuesta,id_metodologia)
	 VALUES (".$idPropuesta.",'$idMetodologia')";
	//echo '<BR>'.$sql;
//	$result	= eSQL($sql);
	if(mysql_query($sql)){
		$idRowMetodologia	= mysql_insert_id();
	}
	else{
		echo "<div style='color:#990000'>Atención!!! Error al guardar la información, por favor intente nuevamente</div>".mysql_error();
	}
}
$vr_titulo				= NULL;
$vr_temas				= NULL;
$vr_universo			= NULL;
$vr_marco_estadistico	= NULL;
//---- consulta las metodologías de la propuesta
$sql = "SELECT *
 FROM ".tablaMetodologia." M INNER JOIN ".tablaMetodologiaRTA." R USING(id_metodologia)
  WHERE R.id_propuesta=$idPropuesta
   ORDER BY 1";
//echo '<BR>'.$sql;
$filasMetodologias		= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_metodologia		= $campos["id_metodologia"];
	$nom_metodologia	= $campos["nom_metodologia"];
	$id_row_metodologia	= $campos["id_row_metodologia"];
	$titulo				= $campos["titulo"];
	$temas				= $campos["temas"];
	$universo			= $campos["universo"];
	$marco_estadistico	= $campos["marco_estadistico"];

	if($id_row_metodologia==$idRowMetodologia){
		$vr_titulo				= $titulo;
		$vr_temas				= $temas;
		$vr_universo			= $universo;
		$vr_marco_estadistico	= $marco_estadistico;

		$idTipoMetodologia	= $campos["id_tipo_metodologia"];
		$nomMetodologia		= $campos["nom_metodologia"];
	}

	$linkEdit			= "<a href=\"javascript:document.getElementById('idRowMetodologia').value=$id_row_metodologia;document.formulario.submit();\" title='Editar metodología'><IMG src='/imagenes/icoblg_fondo1.png' height='20' border='0'></a>";
	$linkTitulo			= "<a href=\"javascript:document.getElementById('idRowMetodologia').value=$id_row_metodologia;document.formulario.submit();\" title='Editar metodología'><span class='linkF'><B>$titulo</B></span></a>";

	$linkDelete			= "<a href=\"javascript:fxDeleteMetodologia($id_row_metodologia);\" title='Eliminar metodología'><IMG src='/imagenes/icoblg_eliminarcolor.png' height='30' border='0'></a>";

	$filasMetodologias	.= "
	 <TR>
	  <TD align='right' class='bb'><div class='padding2'>$linkEdit</div></TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$linkTitulo</div></TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$nom_metodologia</div></TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$linkDelete</div></TD>
	 </TR>";
}
?>
<INPUT type='hidden' name='idTipoMetodologia' id='idTipoMetodologia' value='<?=$idTipoMetodologia?>'>
<INPUT type='hidden' name='idMetodologia' id='idMetodologia' value='<?=$idMetodologia?>'>
<INPUT type='hidden' name='idRowMetodologia' id='idRowMetodologia' value='<?=$idRowMetodologia?>'>
<INPUT type='hidden' name='idRowMetodologiaDelete' id='idRowMetodologiaDelete' value=''>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	 <TR>
	  <TD align='left' class="bb"><div class='padding5 textLabel'><B>Introducción a la Metodolog&iacute;a:</B><br />
      <?=$instruccionBullet?>
      <TEXTAREA name='introduccion_met' id='introduccion_met' lang='1' class='borderBlue' style='width:99%; height:80px; padding:5px;'><?=$introduccion_met?></TEXTAREA></div></TD>
	 </TR>

	 <TR>
	  <TD align='left'>
        <TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>
         <TR>
          <TD align='left' width="5%" class="bb" nowrap="nowrap"><div class='padding5 textLabel'><B>Metodolog&iacute;as:</B></div></TD>
          <TD align='left' width="15%" class="bb"><div class='padding5'>
            <SELECT name='id_metodologia' id='id_metodologia' lang='1' title='' style="padding:5px;">
             <OPTION value='' selected>Seleccione...</OPTION>
             <?=$optionMetodologia?>
            </SELECT>
            <INPUT type='hidden' name='contMetodologias' id='contMetodologias' value='<?=$contMetodologias?>'>
          </div></TD>
          <TD align='left' width="85%" class="bb"><div style="padding:2px 5px;"><INPUT type='image' name='btn_add_metodologia' id='btn_add_metodologia' value='1' data-close-btn-text="cerrar" src="../add_document2.jpg" height="40" title="Adicionar metodología"></div>
          </TD>
         </TR>
        </TABLE>
      </TD>
	 </TR>
	 <TR>
	  <TD align='left'>
      <div id="divAddMetodologia">
<?
if($idTipoMetodologia==1){
	//---- Grupos
	include("data/tipo_metodologia1.php");
}
elseif($idTipoMetodologia==2){
	//---- Grupos
	include("data/tipo_metodologia2.php");
}
elseif($idTipoMetodologia==3){
	//---- Grupos
	include("data/tipo_metodologia3.php");
}
elseif($idTipoMetodologia==4){
	//---- Grupos
	include("data/tipo_metodologia4.php");
}
?>      
      </div>
      </TD>
	 </TR>
	 <TR>
	  <TD align='left'>
        <div align="left" class='padding5 textLabel'><B>Metodolog&iacute;as definidas para la actual propuesta:</B></div>
        <TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0' class="borderT">
         <TR style="background-color:#CCC">
          <TD width='1%' align='left' class='bb'>&nbsp;</TD>
          <TD width='30%' align='left' class='borderBR'><div class='padding5'><B>Título</B></div></TD>
          <TD align='left' class='borderBR'><div class='padding5'><B>Metodología</B></div></TD>
          <TD width='1%' align='left' class='borderBR'>&nbsp;</TD>
         </TR>
         <?=$filasMetodologias?>
        </TABLE>
      </TD>
	 </TR>
<!--	 <TR>
	  <TD align='left' class="bb">&nbsp;</TD>
	  <TD align='left' class="bb" colspan="2"><div id="divMetodologia"></div></TD>
	 </TR>
-->	</TABLE>

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