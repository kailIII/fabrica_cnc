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
<!DOCTYPE HTML>
<html>
<HEAD>
<TITLE>..:: <?php echo tituloPag?> ::..</TITLE>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
-->
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />


<script language="JavaScript" type="text/javascript" src="ajax/ajax2.js?v=<?php echo $aleatorio?>"></script>
<LINK rel="stylesheet" href="/css/style.css" type="text/css">
<LINK rel="stylesheet" href="./css/fabrica.css?<?php echo time(); ?>" type="text/css">
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

</style>
<!-- Contact Form CSS files -->
<link type='text/css' href='css/contact.css?v=<?php echo $aleatorio?>' rel='stylesheet' media='screen' />

<link rel="stylesheet" href="bootstrap/css/bootstrap.css?<?php echo time();?>" />

<script src="js/jquery-1.10.2.min.js" ></script>

</HEAD>
<BODY style="margin-top:0px !important; padding-top:0px; background-color:#FFFFFF;">
<div id='container' style="margin:0px; padding:0px;">

	<form action='' id="mainForm" method='post' name='formulario'>
		
		<input id='idPropuesta' name='idPropuesta' type='hidden' value='<?php echo $idPropuesta?>'> 
		<input id='cPagina' name='cPagina' type='hidden' value='<?php echo $paginaActual?>'>
		
			<?php 
				if( $fabrica_dev == 'fabrica_dev' ){ 
					include("../menu_admin_dev.php"); 
				} else { 
					include("../menu_admin.php"); 
				}  
			?>

		<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF" width="98%">
			<tr>
				<td>
					<table align='center' border="0" cellpadding="2" cellspacing="0" width="100%">
						<tr>
							<td align="left" width="10%">
								<img border='0' height="81" src="/imagenes/logo_cnc.gif" title="Centro Nacional de consultorï¿½a">
							</td>

							<td align="left" nowrap="nowrap" valign="bottom" width="40%">
								<div class="padding5 subtitulos_azules">
									<?php echo $vbNroPagina?>
								</div>
							</td>

							<td align='left' valign='middle'>
								<!--<div style='font-family: Arial, Helvetica, sans-serif; font-size: 20px; color:#336666; font-weight: bold; padding-left:40px;'>F&aacute;brica de Propuestas</div>-->
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td>
					<table align='center' border='0' cellpadding='0' cellspacing='0' width='100%'>
						<tr>
							<td nowrap="nowrap" width="10">
								<img border="0" height='8' src='/imagenes/spacer.gif' width= '10'>
							</td>

							<td nowrap="nowrap">
								<div class="padding5"><img height='8' src='/imagenes/barra_colores.jpg' width='100%'></div>
							</td>

							<td nowrap="nowrap" width="10">
								<img border="0"height='8' src='/imagenes/spacer.gif' width='10'></td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td height="20" style="background-color:#F5F5F5">
					<table align='center' border='0' cellpadding='0' cellspacing='0' width='100%'>
						<tr>
							<td class="<?php echo $bgT[1]?>" nowrap="nowrap" width="9%">
								<div class="padding5 menuF">
									<a class="link_pagina" href="#" style= "font-weight: bold">Página 1</a>
								</div>
							</td>

							<td class="<?php echo $bgT[2]?>" nowrap="nowrap" width="9%">
								<div class="padding5 menuF">
									<a class="link_pagina" href="#" style="font-weight: bold">Página 2</a>
								</div>
							</td>

							<td class="<?php echo $bgT[3]?>" nowrap="nowrap" width="9%">
								<div class="padding5 menuF">
									<a class="link_pagina" href="#" style="font-weight: bold">Contexto</a>
								</div>
							</td>

							<td class="<?php echo $bgT[4]?>" nowrap="nowrap" width="9%">
								<div class="padding5 menuF">
									<a class="link_pagina" href="#" style="font-weight: bold">Objetivos</a>
								</div>
							</td>

							<td class="<?php echo $bgT[5]?>" nowrap="nowrap" width="9%">
								<div class="padding5 menuF">
									<a class="link_pagina" href="#" style="font-weight: bold">Metodologías</a>
								</div>
							</td>

							<td class="<?php echo $bgT[6]?>" nowrap="nowrap" width="9%">
								<div class="padding5 menuF">
									<a class="link_pagina" href="#" style="font-weight: bold">Inversión</a>
								</div>
							</td>

							<td class="<?php echo $bgT[7]?>" nowrap="nowrap" width="9%">
								<div class="padding5 menuF">
									<a class="link_pagina" href="#" style="font-weight: bold">Productos</a>
								</div>
							</td>

							<td class="<?php echo $bgT[8]?>" nowrap="nowrap" width="9%">
								<div class="padding5 menuF">
									<a class="link_pagina" href="#" style="font-weight: bold">Equipo</a>
								</div>
							</td>

							<td class="<?php echo $bgT[9]?>" nowrap="nowrap" width="9%">
								<div class="padding5 menuF">
									<a class="link_pagina" href="#" style="font-weight: bold">Calendario</a>
								</div>
							</td>

							<td class="<?php echo $bgT[10]?>" nowrap="nowrap" width="9%">
								<div class="padding5 menuF">
									<a class="link_pagina" href="#" style="font-weight: bold">Notas de calidad</a>
								</div>
							</td>

							<td class="<?php echo $bgT[11]?>" nowrap="nowrap" width="9%">
								<div class="padding5 menuF">
									<a class="link_pagina" href="#" style="font-weight: bold; text-decoration: underline">Descargar</a>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td>
					<table align="left" border="0" cellpadding="0" cellspacing="0" style='border:1px solid #CED7EC;' width="100%">
						<tr>
							<td align="center" colspan="2" valign="top">
								<?php
								
									switch ( $paginaActual ){
										case "1":
										case "2":
										case "3":
										case "4":
										case "5":
										case "6":
										case "7":
										case "8":
										case "9":
										case "10":
											include("pagina" . $paginaActual . ".php");
											break;		
									} 
								?>
							</td>
						</tr>

						<tr>
							<td align="center" colspan="2">
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">

									<tr>
										<td align='right' width="50%">
											<div class='padding5'>
												<input class='Button' id='btn_anterior' name='btn_anterior' style="padding:5px 8px;" type='submit' value='Anterior'>
											</div>
										</td>

										<td align='left' width="50%">
											<div class='padding5'>
												<input class='Button' id='btn_siguiente' name='btn_siguiente' style="padding:5px 8px;" type='submit' value='Siguiente'>
											</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td align="right" colspan="2">
								<img border="0" height='10' src='/imagenes/spacer.gif' width= '1'>
							</td>
						</tr>
					</table>
				</td>
			</tr> 
		</table>
	</form>
	
	<script>

		$.each( $("a.link_pagina" ) , function( key , value ) { 
	
			$( this ).click( function( ){
				
				var pagina = key + 1;
				$( "#cPagina" ).val( pagina );
				$( "#mainForm" ).submit( ); 
				
			});
			
		});
	
	</script>
	
	<script language="JavaScript" type="text/javascript" src="/scripts/js.js"></script>
	<script src="js/funciones.js" ></script>
	
</BODY>
</HTML>
