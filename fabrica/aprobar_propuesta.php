<?
include("../ctl_login_admin.php");
include("funciones.php");
$idPropuesta	= $_REQUEST['idPropuesta'];
// ---- 
$sql = "UPDATE ".tablaPropuesta." SET
	id_estado=".idEstadoAprobada.",
	fecha_aprobacion=NOW()
	 WHERE id_propuesta=".$idPropuesta;
$result	= eSQL($sql);
// ---- 
$nomFile		= 'Propuesta_Id'.$idPropuesta.'.docx';
$pathPropuesta	= pathPropuestas_docx.'/'.$nomFile;

include("sql.php");
include("propuesta_docx.php");

include("send_mail_contabilidad.php");
//----
$destinatario	= "fabricacnc@gmail.com"; 
$asunto			= "Propuesta aprobada"; 
sendMail($idPropuesta,$destinatario,$asunto,$tituloPropuesta,$empresa_cliente);

//----
$sql = "SELECT * FROM ".tablaEquipo." WHERE id=$elaborada_por";
//echo '<BR>'.$sql;
$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	$id				= $campos["id"];
	$nombreE		= $campos["nombre"];
	$cargoE			= $campos["cargo"];
	$emailE			= $campos["email"];
	$telefonoE		= $campos["telefono"].' Ext. '.$campos["ext"];
	$celularE		= $campos["celular"];
}
$destinatario	= $emailE; 
$asunto			= "Propuesta aprobada"; 
sendMail($idPropuesta,$destinatario,$asunto,$tituloPropuesta,$empresa_cliente);

//----
$sql = "SELECT * FROM ".tablaEquipo." WHERE id=$revisada_por";
//echo '<BR>'.$sql;
$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	$id				= $campos["id"];
	$nombreR		= $campos["nombre"];
	$cargoR			= $campos["cargo"];
	$emailR			= $campos["email"];
	$telefonoR		= $campos["telefono"].' Ext. '.$campos["ext"];
	$celularR		= $campos["celular"];
}
$destinatario	= $emailR; 
$asunto			= "Propuesta aprobada"; 
sendMail($idPropuesta,$destinatario,$asunto,$tituloPropuesta,$empresa_cliente);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>..:: <?=tituloPag?> ::..</TITLE>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" type="text/javascript" src="/scripts/js.js"></script>
<LINK rel="stylesheet" href="/css/style.css" type="text/css">
<style>
.textLabel	{
	color:#5F5F5F;
	font-size:14px;
}
.txt	{
	padding:3px 5px;
}
.divInstruccion{
	background-color:#F0F0F0;
	color:#333366;
}
</style>
</HEAD>
<BODY style="margin-top:0px !important; padding-top:0px; background-color:#FFFFFF;">
<FORM name='formulario' action='' method='post'>
<INPUT type='hidden' name='cPagina' id='cPagina' value='<?=$paginaActual?>'>
<? include("../menu_admin.php"); ?>
<TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#FFFFFF">
 <TR>
  <TD>
   <TABLE width="100%" cellspacing="0" cellpadding="2" align='center' border="0">
    <TR>
	 <TD width="10%" align="left"><img src="/imagenes/logo_cnc.gif" title="Centro Nacional de consultoría" height="81" border='0'></TD>
	 <TD align='left' valign='middle'><!--<div style='font-family: Arial, Helvetica, sans-serif; font-size: 20px; color:#336666; font-weight: bold; padding-left:40px;'>F&aacute;brica de Propuestas</div>--></TD>
	</TR>
   </TABLE>
  </TD>
 </TR>
 <TR>
  <TD>
	<TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>
	  <TR>
	   <TD width="10" nowrap="nowrap"><IMG src='/imagenes/spacer.gif' width='10' height='8' border="0"></TD>
	   <TD nowrap="nowrap"><div class="padding5"><IMG src='/imagenes/barra_colores.jpg' width='100%' height='8'></div></TD>
	   <TD width="10" nowrap="nowrap"><IMG src='/imagenes/spacer.gif' width='10' height='8' border="0"></TD>
	  </TR>
	</TABLE>
  </TD>
 </TR>
 <TR>
  <TD align="left"><div style="font-size:14px; padding:30px 10px;">Se envió un mail notificando la aprobación de la actual propuesta al departamento de contabilidad y sistemas.</div>
 </TR>
 <TR>
 <TR>
  <TD>
	<TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>
	  <TR>
	   <TD align='right' width="49%"><div style="padding-top:20px;"><a href="<?=$pathPropuesta?>" title="Descargar la propuesta"><IMG src='../word_icono.jpg' height='100' border="0"></a></div></TD>
	   <TD align="left" width="2%">&nbsp;</TD>
	   <TD align="left" width="49%"><div style="padding-top:20px;"><a href="./?idPropuesta=<?=$idPropuesta?>" title="Editar la propuesta"><IMG src='/imagenes/icoblg_blogs.png' height='120' border="0"></a></div></TD>
	  </TR>
	  <TR>
	   <TD align='right'><div><a href="<?=$pathPropuesta?>" title="Descargar la propuesta"><span style="color:#36C"><B>Descargar la propuesta</B></span></a></div></TD>
	   <TD align="left">&nbsp;</TD>
	   <TD align="left"><div><a href="./?idPropuesta=<?=$idPropuesta?>" title="Editar la propuesta"><span style="color:#36C"><B>Editar la propuesta</B></span></a></div></TD>
	  </TR>
	</TABLE>
  </TD>
 </TR>
 <TR>
  <TD align="right"><IMG src='/imagenes/spacer.gif' width='1' height='10' border="0"></TD>
 </TR>
</TABLE>
</FORM>
</BODY>
</HTML>
