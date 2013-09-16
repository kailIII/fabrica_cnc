<?
include("../ctl_login_admin.php");
$idPropuesta	= $_REQUEST['idPropuesta'];
$nomFile		= 'Propuesta_Id'.$idPropuesta.'.docx';
$pathPropuesta	= pathPropuestas_docx.'/'.$nomFile;

$pathPropuestaPpt = pathPropuestas_docx.'/propuesta_Id'.$idPropuesta.'.pptx';

require_once dirname(__FILE__).'/classes/class.Propuesta.php';
require_once dirname(__FILE__).'/krumo/class.krumo.php';
require_once dirname(__FILE__).'/classes/class.PropuestaPpt.php';

$Propuesta = new Propuesta( $idPropuesta );
$info_prop = $Propuesta->getProp();

require_once dirname(__FILE__).'/classes/class.Usuario.php';
$Usuario = new Usuario(false, $info_prop['revisada_por'] );

include("funciones.php");

$usr_revisa = $Usuario->getUsuario();

$fabrica_dev = explode('/', $_SERVER['PHP_SELF'] );
$fabrica_dev = $fabrica_dev[2];


$PropPpt = new PropuestaPpt( $idPropuesta );
$PropPpt->makePpt();

//include("sql_vista_previa.php");
include("propuesta_docx.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>..:: <?=tituloPag?> ::..</TITLE>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" type="text/javascript" src="/scripts/js.js"></script>
<LINK rel="stylesheet" href="/css/style.css" type="text/css">

<LINK rel="stylesheet" href="./css/fabrica.css?<?=time(); ?>" type="text/css">

<script src="js/jquery-1.10.2.min.js" ></script>
<script src="js/descargar.js?<?=time();?>" ></script>

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
	<TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>
	  <TR>
	   <TD align='right' width="49%"><div style="padding-top:20px;"><a href="<?=$pathPropuesta?>" title="Descargar la propuesta" id="downloadProp" ><IMG src='../word_icono.jpg' height='100' border="0"></a></div></TD>
	   <!-- <TD align="left" width="10%"><div style="padding-top:20px; text-align: center; "><a href="<?=$pathPropuestaPpt?>" title="Descargar la propuesta" ><IMG src='../imagenes/logo_powerpoint.png' height='100' width="100" border="0"></a></div></TD> -->
	   <TD align="left" width="49%"><div style="padding-top:20px;"><a href="./?idPropuesta=<?=$idPropuesta?>" title="Editar la propuesta"><IMG src='/imagenes/icoblg_blogs.png' height='120' border="0"></a></div></TD>
	  </TR>
	  <TR>
	   <TD align='right'><div><a href="<?=$pathPropuesta?>" title="Descargar la propuesta"><span style="color:#36C"><B>Descargar la propuesta</B></span></a></div></TD>
	   <!-- <TD align="left"> <div id="pptDownload" ><a href="<?=$pathPropuestaPpt?>" title="Descargar la propuesta"><span style="color:#36C"><B>Descargar la propuesta</B></span></a></div> </TD> -->
	   <TD align="left"><div><a href="./?idPropuesta=<?=$idPropuesta?>" title="Editar la propuesta"><span style="color:#36C"><B>Editar la propuesta</B></span></a></div></TD>
	  </TR>
	</TABLE>
  </TD>
 </TR>
 <TR>
  <TD align="right"><IMG src='/imagenes/spacer.gif' width='1' height='10' border="0"></TD>
 </TR>
</TABLE>

<input type="hidden" id="path_propuesta" value="<?=$pathPropuesta?>" />
<input type="hidden" id="titulo_prop" value="<?=$info_prop['titulo']?>"  />
<input type="hidden" id="id_propuesta" value="<?=$idPropuesta?>"  />

<div class="OptionsContainer">

	<h3>Al Descargar el documento...</h3>
	
	<div class="colOpt">
		<div class="col1"> <label for="no_send_docx_mail">Solamente visualizar</label> </div>
		<div class="col2"> <input type="radio" name="send_docx_mail" id="no_send_docx_mail" value="0"  /> </div>
	</div>

	<div class="colOpt">
		<div class="col1"> <label for="send_docx_mail">Envíar a revisión</label> </div>
		<div class="col2"> <input type="radio" name="send_docx_mail" id="send_docx_mail" value="1" checked /> </div>
	</div>

	<div class="colOpt" id="docxRecipentWraper" >
		<div class="col1"> <label for="docxRecipent">Email de revision: </label> </div>
		<div class="col2"> <input type="hidden" id="docxRecipent" value="<?=$usr_revisa['email'] ?>" /> </div>
	</div>

</div>

</FORM>
</BODY>
</HTML>
