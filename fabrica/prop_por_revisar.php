<?
include("../ctl_login_admin.php");
$idPropuesta	= $_REQUEST['idPropuesta'];

$fabrica_dev = explode('/', $_SERVER['PHP_SELF'] );
$fabrica_dev = $fabrica_dev[2];


require_once dirname(__FILE__).'/classes/class.Propuesta.php';
require_once dirname(__FILE__).'/krumo/class.krumo.php';

$Propuesta = new Propuesta( $idPropuesta );
$info_prop = $Propuesta->getProp();

require_once dirname(__FILE__).'/classes/class.Usuario.php';

$Usuario = new Usuario(false, $info_prop['revisada_por'] );
$usr_revisa = $Usuario->getUsuario();

$Usuario = new Usuario(false, $info_prop['elaborada_por'] );
$usr_elabora = $Usuario->getUsuario();

$Usuario = new Usuario( $_SESSION['userAdmin'] );
$usr_current = $Usuario->getUsuario();

if( $usr_current['super'] != 1 )
if( $info_prop['revisada_por'] != $usr_current['id_equipo_cnc'] && $info_prop['elaborada_por'] != $usr_current['id_equipo_cnc'] )
	die('No tienes acceso a esta página');

$nomFile		= 'Propuesta_Id'.$idPropuesta.'.docx';
$pathPropuesta	= pathPropuestas_docx.'/'.$nomFile;

require_once dirname(__FILE__).'/classes/class.Contenidos.php';
$Contenidos = new Contenidos;
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
<link rel="stylesheet" href="bootstrap/css/bootstrap.css?<?=time();?>" />

<script src="js/jquery-1.10.2.min.js" ></script>
<script src="js/prop_por_revisar.js?<?=time();?>" ></script>

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
  <TD align="right"><IMG src='/imagenes/spacer.gif' width='1' height='10' border="0"></TD>
 </TR>
</TABLE>

<div id="revisionWrapper">
	
	<h1><?=$info_prop['titulo']?></h1>
	<div class="downloadProp">
		<a href="<?=$pathPropuesta?>"><img src="../word_icono.jpg" height="100" border="0"><div>Descargar Propuesta</div></a>
	</div>
	
	
	<input type="hidden" id="id_propuesta_review" value="<?=$info_prop['id_propuesta']?>" />

	<div class="OptionsContainer">
		<h3>Elaborada por: <?=$usr_elabora['nombres'].' '.$usr_elabora['apellidos'] ?></h3>
		<h3>Revisada por: <?=$usr_revisa['nombres'].' '.$usr_revisa['apellidos'] ?></h3>
	</div>
	<div class="OptionsContainer">

		<h3>Cambiar estado de la propuesta <img src="/propuesta/imagenes/loader_new.gif" id="loader_est_prop" /> <i id="ok_est_prop" class="icon-ok-sign"></i> </h3>
		<?php foreach( $Contenidos->getEstadosPropuesta() as $est_prop ){ ?>
		<div class="colOpt">
			<div class="col1"> <label for="prop_est_<?=$est_prop['id_est_prop']?>"><?=$est_prop['nombre_estado']?></label> </div>
			<div class="col2"> <input type="radio" name="estado_prop" id="prop_est_<?=$est_prop['id_est_prop']?>" value="<?=$est_prop['id_est_prop']?>"  <?php if( $info_prop['estado_final'] == $est_prop['id_est_prop'] ){ ?> checked <?php } ?> /> </div>
		</div>
		<?php } ?>
	</div>
	

	<div class="OptionsContainer">
		<h3>Observaciones</h3>

		<div id="newComment">
			<form action="acciones_revision_propuesta.php" method="POST" >
				<textarea name="leComment" required ></textarea>
				<input type="hidden" name="id_usuario" value="<?=$usr_current['id_equipo_cnc']?>"  />
				<input type="hidden" name="opc"  value="nuevo_comentario" />
				<input type="hidden" name="id_propuesta" value="<?=$info_prop['id_propuesta']?>" />
				<button type="submit" class="btn btn-primary" >Añadir Observación</button>
			</form>
		</div>
		
		<?php foreach( $Propuesta->getComentarios() as $com ){ ?>
		<div class="commentWrapper">
			
			<div class="who"><?=$com['nombres'].' '.$com['apellidos'] ?></div>
			<div class="date"><?=$com['fecha_com']?></div>
			<div class="comment"><?=$com['comentario']?></div>
		</div>
		<?php } ?>	
	</div>

</div>

</BODY>
</HTML>
