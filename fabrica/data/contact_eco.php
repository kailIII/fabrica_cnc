<?php
$tipo_usuario	= $_SESSION['tipoUsuario'];

$ver_agrupado	= $_REQUEST['ver_agrupado'];
$idCliente		= $_REQUEST['id_cliente'];
$filtroPor		= $_REQUEST['filtro_por'];


//$arraySegmentos	= $_REQUEST['idSegmento'];
$arraySegmentos	= explode(',',$_REQUEST['idSegmento']);
$arrayRegional	= explode(',',$_REQUEST['idRegional']);
$idRegionalS	= $_REQUEST['idRegionalS'];

$checked_verAgrupado	= NULL;
$colorVerAg				= colorOFF;
if(!empty($ver_agrupado)){
	$checked_verAgrupado	= "checked='checked'";
	$colorVerAg		= "#336699";
}
$chFiltroPor1	= NULL;
$chFiltroPor2	= NULL;
$display1		= 'none';
$display2		= 'none';
$titChAgrupar	= 'Ver segmentos agrupados';
if($filtroPor=='1'){
	$chFiltroPor1	= "checked='checked'";
	$display1		= 'block';
}
elseif($filtroPor=='2'){
	$chFiltroPor2	= "checked='checked'";
	$display2		= 'block';
	$titChAgrupar	= 'Ver regionales agrupadas';
}
elseif(empty($filtroPor)){
	$chFiltroPor1	= "checked='checked'";
	$display1		= 'block';
}
//echo '<BR>display1: '.$display1;
//echo '<BR>display2: '.$display2;

$condReporte	= NULL;

$filasRegional	= NULL;
$filasRegionalS	= NULL;
//---- filtro por regionales
$sql = "SELECT *
	 FROM ".cubo_regional."
	  WHERE id_cliente=".$idCliente."
		ORDER BY id_regional";
//echo '<BR>'.$sql;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_regional		= $campos['id_regional'];
	$nom_regional		= $campos['nom_regional'];
	
	if($tipo_usuario=='DEMO'){
		$nom_regional	= $nom_servicio_demo;
	}
	//----
	$nomObj			= "idRegional[]";
	$idObj			= "idRegional".$id_regional;

	$idDivVb	= "divRegional".$id_regional;
	$funcionCH	= "select_ch('$idObj','$idDivVb','".colorON."','".colorOFF."')";
	$funcionVB	= "marcar_ch('$idObj','$idDivVb','".colorON."','".colorOFF."')";

	$colorNomSeg	= colorOFF;
	$checked		= NULL;
	if(is_array($arrayRegional) && in_array($id_regional, $arrayRegional)){
		$checked		= "checked='checked'";
		$colorNomSeg	= colorON;
	}
	$objSeg			= "<INPUT type='checkbox' name='$nomObj' id='$idObj' value='$id_regional' lang='$idDivVb' $checked onClick=\"$funcionCH\" />";

	$filasRegional	.= "
	 <TR>
	  <TD width='2%' class='borderBR' align='right' valign='top'>$objSeg</TD>
	  <TD width='98%' class='borderBR' align='left' valign='top'><a href=\"javascript:$funcionVB\"><div id='$idDivVb' style='color:$colorNomSeg; padding:0px 2px;'>$id_regional - $nom_regional</div></a></TD>
	 </TR>";
	$nomObj			= "idRegionalS";
	$idObj			= "idRegionalS".$id_regional;
	$idDivVb	= "divRegionalS".$id_regional;
	$funcionCH	= "select_ch('$idObj','$idDivVb','".colorOFF."','".colorOFF."')";
	$funcionVB	= "marcar_ch('$idObj','$idDivVb','".colorOFF."','".colorOFF."')";

	$colorNomSeg	= colorOFF;
	$checked		= NULL;
	if($id_regional == $idRegionalS){
		$checked		= "checked='checked'";
		$colorNomSeg	= colorON;
	}
	$objSeg			= "<INPUT type='radio' name='$nomObj' id='$idObj' value='$id_regional' lang='$idDivVb' $checked onClick=\"$funcionCH\" />";
	$filasRegionalS	.= "
	 <TR>
	  <TD width='2%' class='borderBR' align='right' valign='top'>$objSeg</TD>
	  <TD width='98%' class='borderBR' align='left' valign='top'><a href=\"javascript:$funcionVB\"><div id='$idDivVb' style='color:$colorNomSeg; padding:0px 2px;'>$id_regional - $nom_regional</div></a></TD>
	 </TR>";
}

//---- para segmentos
$sql = "SELECT *
	 FROM ".tablaSegmento."
	  WHERE id_cliente=".$idCliente."
		ORDER BY id_cliente,id_grupo,id_servicio";
//echo '<BR>'.$sql;
$nomServicio			= NULL;
$filasSegmento			= NULL;
$contGrupo				= 0;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_servicio		= $campos['id_servicio'];
	$nom_corto			= $campos['nom_corto'];
	$nom_servicio		= $campos['nom_servicio'];
	$nom_servicio_demo	= $campos['nom_servicio_demo'];
	$id_cliente			= $campos['id_cliente'];
	$id_grupo			= $campos['id_grupo'];
	
	if($tipo_usuario=='DEMO'){
		$nom_servicio	= $nom_servicio_demo;
	}
	//----
	$nomObj			= "idSegmento[]";
	$idObj			= "idSegmento".$id_servicio;

	$idDivVb	= "divSegmento".$id_servicio;
	$funcionCH	= "select_ch('$idObj','$idDivVb','".colorON."','".colorOFF."')";
	$funcionVB	= "marcar_ch('$idObj','$idDivVb','".colorON."','".colorOFF."')";

	$colorNomSeg	= colorOFF;
	$checked		= NULL;
	if(is_array($arraySegmentos) && in_array($id_servicio, $arraySegmentos)){
		$checked		= "checked='checked'";
		$colorNomSeg	= colorON;
	}
	$objSeg			= "<INPUT type='checkbox' name='$nomObj' id='$idObj' value='$id_servicio' lang='$idDivVb' $checked onClick=\"$funcionCH\" />";

	if(!empty($nom_corto)){
		$nom_servicio	= $nom_corto.'-'.$nom_servicio;
	}
	if($id_grupo==2 && $contGrupo==0){
		++$contGrupo;
//		$nom_servicio	= "<span style='color:#006400'>$nom_servicio</span>";
//		$colorNomSeg	= "#006400";
		$filasSegmento	.= "
		 <TR>
		  <TD class='bb' align='right' valign='top'>&nbsp;</TD>
		  <TD class='borderBR' align='left' valign='top'><div class='padding2' style='color:#000000'><B>".$arrayTitListaSeg[$idCliente]."</B></div></TD>
		 </TR>";
	}
	$filasSegmento	.= "
	 <TR>
	  <TD width='2%' class='borderBR' align='right' valign='top'>$objSeg</TD>
	  <TD width='98%' class='borderBR' align='left' valign='top'><a href=\"javascript:$funcionVB\"><div id='$idDivVb' class='padding2' style='color:$colorNomSeg'>$id_servicio - $nom_servicio</div></a></TD>
	 </TR>";
}
//---- registra el tiempo cuando cargó el formulario
$id_segmentos	= "";
if(!empty($arraySegmentos)){
	$id_segmentos	= implode(",",$arraySegmentos);
}
//echo '<BR>id_segmentos: '.$id_segmentos;
$fx1	= "fxfiltro_por('idRegional[]','div_lista_segmentos','Ver segmentos agrupados');";
$fx2	= "fxfiltro_por('idSegmento[]','div_lista_regional','Ver regionales agrupadas');";
?>
 <div class='contact-content div_radius8'>
 <FORM name="formulario2" id="formulario2" method="post" action="">
 	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#333333;">
	 <TR>
	  <TD align='left' width="10%" nowrap="nowrap"><div style="padding:0px 5px;"><INPUT type='radio' name='filtro_por' id='filtro_por' value='1' <?=$chFiltroPor1?> onClick="<?=$fx1?>" /><a href="javascript:marcar_filtro('fxfiltro_por',0);<?=$fx1?>"><span style="color:#FFFFFF; font-size:14px;"><B>Segmento</B></span></a></div></TD>
	  <TD align='left' width="10%" nowrap="nowrap"><div style="padding:0px 5px;"><INPUT type='radio' name='filtro_por' id='filtro_por' value='2' <?=$chFiltroPor2?> onClick="<?=$fx2?>" /><a href="javascript:marcar_filtro('fxfiltro_por',1);<?=$fx2?>"><span style="color:#FFFFFF; font-size:14px;"><B>Regional</B></span></a></div></TD>
	  <TD align='right'><div style="padding:4px 1px;"><a href="javascript:void(0);"><img src="/imagenes/ico3_error.png" width="22" border="0" alt="Cancelar" title="Cancelar" class="simplemodal-close" /></a></div></TD>
	 </TR>
	</TABLE>
	<div id="div_lista_segmentos" style="display:<?=$display1?>;">
		<div style="height:400px; padding:0px; overflow:auto; padding:2px 4px;">
		<div align="left" style="color:#000000"><B>Regional</B></div>
		<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL">
		 <?=$filasRegionalS?>
		</TABLE>
		<div align="left" style="color:#000000"><B>Segmentos</B></div>
		<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL">
		 <?=$filasSegmento?>
		</TABLE>
		</div>
	</div>
	<div id="div_lista_regional" style="display:<?=$display2?>;">
		<div style="height:300px; padding:0px; overflow:auto; padding:2px 4px;">
		<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL">
		 <?=$filasRegional?>
		</TABLE>
		</div>
	</div>
	<TABLE width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
	 <TR>
	  <TD align='center' colspan="2" style="border-top:1px solid #EBEBEB; background-color:#FFCC66;" nowrap="nowrap"><INPUT type='checkbox' name='ver_agrupado' id='ver_agrupado' value='1' <?=$checked_verAgrupado?> onClick="select_ch('ver_agrupado','divAg','#336699','#000000');" /><a href="javascript:marcar_ch('ver_agrupado','divAg','#336699','#000000');"><span id='divAg' class='padding2' style='color:<?=$colorVerAg?>'><B><?=$titChAgrupar?></B></span></a><!--<div><a href="./"><B>Quitar comparativo</B></a></div>--></TD>
	 </TR>
	 <TR>
	  <TD align='right' width="50%" style="border-top:1px solid #EBEBEB"><div style="padding:0px 5px;"><INPUT type='button' name='btn_cancelar' id='btn_cancelar' class='Button simplemodal-close' style="padding:3px 10px;" value='Cancelar' /></div></TD>
	  <TD align='left' width="50%" style="border-top:1px solid #EBEBEB"><div style="padding:0px 5px;"><INPUT type='submit' name='btn_enviar' id='btn_enviar' class='Button' style="padding:3px 2px;" value='Ver Informe' /></div></TD>
	 </TR>
	</TABLE>
 </FORM>
 </div>
