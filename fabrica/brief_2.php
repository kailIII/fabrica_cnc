<?
include("../ctl_login_admin.php");
$aleatorio	= rand(1,1000);

$paginaActual	= $_POST['cPagina'];
$idPropuesta	= $_REQUEST['idPropuesta'];

require_once dirname(__FILE__).'/classes/class.Propuesta.php';
require_once dirname(__FILE__).'/classes/class.Contenidos.php';
require_once dirname(__FILE__).'/krumo/class.krumo.php';

$fabrica_dev = explode('/', $_SERVER['PHP_SELF'] );
$fabrica_dev = $fabrica_dev[2];

$Contenidos = new Contenidos;

if( $idPropuesta != '' ): $Propuesta = new Propuesta( $idPropuesta ); endif;

//---- para el calendario
$num_semanas	= numSemanas;
$inicioSemanas	= 1;

include("funciones.php");
include("dml_insert.php");

if(empty($paginaActual)){
	$paginaActual	= 1;
}
//echo 'idPropuesta: '.$idPropuesta;
if(empty($idPropuesta) && $paginaActual > 1){
//	@header("Location: lista_propuestas.php?idMenu=2");
	@header("Location: ./?idMenu=1");
}
//----
if(!empty($_POST['btn_anterior']) && $paginaActual > 1){
	--$paginaActual;
}
if(!empty($_POST['btn_siguiente']) && $paginaActual < numPaginas){
	++$paginaActual;
}
$vbNroPagina	= "&nbsp;";
if($paginaActual <= numPaginas){
	$vbNroPagina	= "Pagina: $paginaActual de ".numPaginas;
}
$bgT	= array();
$bgT[$paginaActual]	= 'bgMenuSel';

if($paginaActual=='11' && !empty($idPropuesta)){
	@header("Location: descargar_propuesta.php?idPropuesta=$idPropuesta");
}
include("sql.php");

$numeroSemana = date("W");
//echo '<BR>numeroSemana: '.$numeroSemana;
//echo '<BR>paginaActual: '.$paginaActual;
$vbFecha		= date("d/m/Y (H:i)");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>..:: <?=tituloPag?> ::..</TITLE>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
-->
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script language="JavaScript" type="text/javascript" src="/scripts/js.js"></script>
<script language="JavaScript" type="text/javascript" src="ajax/ajax2.js?v=<?=$aleatorio?>"></script>

<LINK rel="stylesheet" href="/css/style.css" type="text/css">
<LINK rel="stylesheet" href="./css/fabrica.css?<?=time(); ?>" type="text/css">
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
.colorBlanco	{ color:#FFF; }

.linkF	{
	color:#036;
}

.tituloSeccion	{
	background-color:#CCC;	
}
.bgMenuSel	{
	background-color:#C0E3F1;	
}
.instruccionBullet	{
	color:#39F;
	font-size:12px;
	font-weight:bold;
}

.cursorPointer	{
	cursor:pointer;
}
.bgBlue	{
	background-image:url(bg_blue.png);
}

/*a {
  text-decoration: none;
}
a:hover {
  text-decoration: underline;
}*/
</style>
<!-- Contact Form CSS files -->
<link type='text/css' href='css/contact.css?v=<?=$aleatorio?>' rel='stylesheet' media='screen' />

<link rel="stylesheet" href="bootstrap/css/bootstrap.css?<?=time();?>" />

<!-- jquery library  -->
<script src="js/jquery-1.10.2.min.js" ></script>

<link rel="stylesheet" href="js/colorbox-master/example4/colorbox.css" type="text/css" media="screen" title="no title" charset="utf-8"/>
<script src="js/colorbox-master/jquery.colorbox-min.js" type="text/javascript" charset="utf-8"></script>

<!-- jQuery UI -->
<link rel="stylesheet" href="js/jquery-ui-1.10.3/themes/base/jquery-ui.css" />
<script src="js/jquery-ui-1.10.3/ui/jquery-ui.js" ></script>

<link rel="stylesheet" href="js/tooltipster-master/css/tooltipster.css" />
<link rel="stylesheet" href="js/tooltipster-master/css/themes/tooltipster-light.css" />
<script src="js/tooltipster-master/js/jquery.tooltipster.min.js" ></script>

<script src="js/brief.js" ></script>

</HEAD>
<BODY style="margin-top:0px !important; padding-top:0px; background-color:#FFFFFF;">

<div id="brief2pageLoader" class="brief2AjaxLoader" >
	<div class="brief2AjaxLoaderWraper" >
		<span>Cargando...</span>
		<div><img src="../imagenes/loader-transparent.gif"  /></div>
	</div>
</div>

<div id='container' style="margin:0px; padding:0px;">
<FORM name='formulario' action='brief_save.php' method='post' id="mainForm" >
<input type='hidden' name='idPropuesta' id='idPropuesta' value='<?=$idPropuesta?>'>
<input type='hidden' name='cPagina' id='cPagina' value='<?=$paginaActual?>'>

	<?php if( $fabrica_dev == 'fabrica_dev' ){
		include("../menu_admin_dev.php"); 
	} else {
		include("../menu_admin.php"); 
	} ?>
<TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#FFFFFF">
 <TR>
  <TD>
   <TABLE width="100%" cellspacing="0" cellpadding="2" align='center' border="0">
    <TR>
	 <TD width="10%" align="left"><img src="/imagenes/logo_cnc.gif" title="Centro Nacional de consultoría" height="81" border='0'></TD>
     <TD align="left" width="40%" nowrap="nowrap" valign="bottom"><div class="padding5 subtitulos_azules"><b>Brief</b></div></TD>
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
  <TD>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left" style='border:1px solid #CED7EC;'>
	 <TR>
	  <TD align="center" colspan="2" valign="top">

		<div class="requi-item"><?php require_once dirname(__FILE__).'/brief2_tabla.php' ?></div>

		<input type="hidden" id="refreshOnClose" value="0" />

	  </TD>
	 </TR>

	 <TR>
	  <TD align="center" colspan="2">
		<TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
<!--		 <TR>
		  <TD width="50%" align='right'><div class='padding5'><input type='submit' name='btn_anterior' id='btn_anterior' class='Button' style="padding:5px 8px;" value='Anterior' onclick="fxAvance('-',<?=numPaginas?>);" /></div></TD>
		  <TD width="50%" align='left'><div class='padding5'><input type='submit' name='btn_siguiente' id='btn_siguiente' class='Button' style="padding:5px 8px;" value='Siguiente' onclick="fxAvance('+',<?=numPaginas?>);" /></div></TD>
		 </TR>
-->
		 <TR>
		  
		 </TR>
		</TABLE>
	  </TD>
	 </TR>

	 <TR>
	  <TD align="right" colspan="2"><IMG src='/imagenes/spacer.gif' width='1' height='10' border="0"></TD>
	 </TR>
	</TABLE>
  </TD>
 </TR>

<!-- <TR>
  <TD align="right"><IMG src='/imagenes/spacer.gif' width='1' height='10' border="0"></TD>
 </TR>
-->
</TABLE>
</FORM>

<div id="toolTipProceso" class="tooltipster-base tooltipster-light tooltipster-fade tooltipster-fade-show" style="pointer-events: auto; -webkit-animation: 350ms; transition: 350ms; -webkit-transition: 350ms; width: 251px; padding-left: 0px; padding-right: 0px;">
	<div class="tooltipster-content">
		Fecha inicio: <input class="le-datepciker" id="procesoFechaIni" type="text">
		Fecha Final: <input class="le-datepciker" id="procesoFechaFin" type="text">
		<!-- <a href="javascript:void(0);" class="btn btn-mini">Guardar</a> --> 
	</div><div class="tooltipster-arrow-top tooltipster-arrow" style=""><span class="tooltipster-arrow-border" style="margin-bottom: -1px; border-color: rgb(204, 204, 204);;"></span><span style="border-color:rgb(237, 237, 237);"></span></div></div>

<div id="brief2AjaxLoader" class="brief2AjaxLoader" >
	<div class="brief2AjaxLoaderWraper" >
		<span>Guardando...</span>
		<div><img src="../imagenes/loader-transparent.gif"  /></div>
	</div>
</div>



</BODY>
</HTML>