<?
$sql = "SELECT * FROM ".tablaEquipoTrabajo." WHERE estado=1 ORDER BY orden";
//echo '<BR>'.$sql;
$filasEquipoTrabajo	= NULL;
$arrayEquipoW		= array();
$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	$id_persona		= $campos["id_persona"];
	$nombre			= $campos["nombre"];
	$cargo			= $campos["cargo"];
	$des_cv			= $campos["des_cv"];
	$nomFoto		= $campos["nom_foto"];

	//---- consulta si la metodología aplica para la propuesta activa
	$sqlR = "SELECT * FROM ".tablaEquipoTrabajoRTA." WHERE id_propuesta=".$idPropuesta." AND id_persona=".$id_persona;
	//echo '<BR>'.$sqlR;
	$idRol			= NULL;
	$estadoObjRol	= " disabled='disabled'";
	$chObj			= NULL;
	$nom_persona_s	= NULL;
	$colorBorde		= colorBordeOFF;
	$conR			= mysql_query($sqlR);
	while($camposR	= mysql_fetch_array($conR)){
		$idRol		= $camposR["id_rol"];
		$chObj			= "checked='checked'";
		$estadoObjRol	= NULL;
		$nom_persona_s	= $nombre;
		$colorBorde		= colorBordeON;
		$arrayEquipoW[]	= $nombre;
	}
	$nameObj	= nameObjEquipoTrabajo."[]";
	$idObj		= 'persona'.$id_persona;
	$idIMG		= 'imgPersona'.$id_persona;
	$obj		= "<INPUT type='checkbox' name='$nameObj' id='$idObj' value='$id_persona' $chObj style='display:none' />";

	$idObjRol	= 'rol_persona'.$id_persona;

	$nameObjE	= nameObjEquipoTrabajo."s[]";
	$idObjE		= 'nom_persona'.$id_persona;
	$objNs		= "<INPUT type='hidden' name='$nameObjE' id='$idObjE' value='$nom_persona_s' />";

	$funcion	= "fxSelEquipo('$idObj','$nameObjE','$idObjE','$idIMG','$idObjRol','$id_persona','$nombre','".colorBordeON."','".colorBordeOFF."');";
	$foto		= "<a href=\"JavaScript:$funcion\"><img id='$idIMG' src='../fotos_equipo/$nomFoto.jpg' width='190' border='0' style='border:5px solid $colorBorde;' /></a>";
//	$vbPerfil	= "$nombre $obj <br />
//					<SPAN class='enlace_titulo_noticia1'><B>$cargo</B></SPAN><br /><br />
//					<span class='body13G'>$des_cv</span> $objNs";

	//---- consulta el rol
	$sqlRol = "SELECT * FROM ".tablaRol." ORDER BY 1";
	//echo '<BR>'.$sqlRol;
	$optionRol			= NULL;
	$conRol				= mysql_query($sqlRol);
	while($camposRol	= mysql_fetch_array($conRol)){
		$id_rol			= $camposRol["id_rol"];
		$nom_rol		= $camposRol["nom_rol"];
		$selected_e		= NULL;
		if($id_rol==$idRol){
			$selected_e	= "selected";
		}
		$optionRol		.= "<OPTION value='$id_rol' $selected_e>$nom_rol</OPTION>";
	}
	$objRol		= "
	<SELECT name='$idObjRol' id='$idObjRol' lang='1' title='' style='padding:1px;' $estadoObjRol>
	 <OPTION value='0' selected>Seleccione...</OPTION>
	 $optionRol
	</SELECT>";

	$vbPerfil	= "<B>$nombre</B> $obj <br />
					<SPAN class='enlace_titulo_noticia1'>Rol: </SPAN>$objRol<br /><br />
					<span class='body13G'>$des_cv</span> $objNs";

	$filasEquipoTrabajo	.= "
	 <TR>
	  <TD align='left' class='bb' valign='top' width='1%'><div class='padding2'>$foto</div></TD>
	  <TD align='left' class='bb' valign='top'><div class='padding5 textLabel'>$vbPerfil</div></TD>
	 </TR>";
}
$nombreEquipoW	= implode(', ',$arrayEquipoW);
?>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	 <TR>
	  <TD align='left' class="bb divInstruccion" valign="top"><div id='divListaEquipoTrabajo' class='padding5'><B><u>Equipo de trabajo:</u> <?=$nombreEquipoW?></B></div></TD>
	 </TR>
	 <TR>
	  <TD align="left" valign="top">
		<div style="height:550px; overflow:auto; margin-bottom:0.5em;">
		<TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
		 <?=$filasEquipoTrabajo?>
		</TABLE>
		</div>
	  </TD>
	 </TR>
	</TABLE>
