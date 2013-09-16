<?
session_start();
include("../ctl_login_admin.php");
require_once dirname(__FILE__).'/classes/class.Contenidos.php';

$Contenidos = new Contenidos;

require_once dirname(__FILE__).'/classes/class.Propuesta.php';

require_once dirname(__FILE__).'/krumo/class.krumo.php';

require_once dirname(__FILE__).'/classes/class.Usuario.php';
$Usuario = new Usuario( $_SESSION['userAdmin'] );

$info_usuario = $Usuario->getUsuario();

$fabrica_dev = explode('/', $_SERVER['PHP_SELF'] );
$fabrica_dev = $fabrica_dev[2];


$limit_usuario = " AND revisada_por = '{$Usuario->getIdEquipo()}'";
/*if( $info_usuario['super'] == 1 ){
		$limit_usuario = '';
	}*/
//---- consulta las propuestas
if( ! isset( $_SESSION['filtros'] ) ){

	$sql = "SELECT *
	 FROM ".tablaPropuesta." R WHERE 1 = 1 {$limit_usuario}
	   ORDER BY id_propuesta DESC  ";
} else {

	// aplica filtros ...	
	$cond = '';
	$fil = $_SESSION['filtros'];

	if( $fil['tipo'] != '' && count( $fil['tipo'] > 0 ) ){

		$cond.=' AND ( ';
		foreach(  (array) $fil['tipo'] as $tipo ){
			$cond.=" prp.id_tipo_prop = $tipo OR";	
		}

		$cond = substr_replace($cond, "", -2); // remueve el OR sobrante
		$cond.=' ) ';
	}

	if( $fil['estado'] != '' ){

		$cond.=' AND ( ';
		foreach(  (array) $fil['estado'] as $estado ){
			$cond.=" prp.estado_final = $estado OR";	
		}
		$cond = substr_replace($cond, "", -2); // remueve el OR sobrante
		$cond.=' ) ';

	}

	if( $fil['cargo'] != '' ){
		$cond.= " AND prc.cargo LIKE '%{$fil['cargo']}%' ";
	}

	if( $fil['presentada'] != '' ){
		$cond.= " AND prc.nombre LIKE '%{$fil['presentada']}%' ";	
	}


	$sql = "SELECT * FROM ". tablaPropuesta ." prp 
	LEFT JOIN prop_clientes prc ON prp.id_propuesta = prc.id_propuesta 
	WHERE prp.titulo LIKE '%{$fil['titulo']}%' AND 
	prp.empresa_cliente LIKE '%{$fil['cliente']}%' 
	{$cond} {$limit_usuario}
	GROUP BY prp.id_propuesta
	ORDER BY prp.id_propuesta DESC ";
}
//echo '<BR>'.$sql;
$filasPropuesta			= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_propuesta		= $campos["id_propuesta"];
	$titulo				= $campos["titulo"];
	$nom_cliente		= $campos["nom_cliente"];
	$empresa_cliente	= $campos["empresa_cliente"];
	$cargo_cliente		= $campos["cargo_cliente"];
	$codigo 			= $campos["unique_code"];
	$fecha_creacion 	= date( 'Y-m-d', strtotime( $campos['fecha_creacion'] ) );
	$estado 			= $Contenidos->getEstadoPropuesta( $campos['estado_final'] );
	$estado 			= $estado['nombre_estado'];

	$Propuesta = new Propuesta($id_propuesta);

	$clientes = '<ul class="clients-list" >';
	$cargos = '<ul class="clients-list" >';
	foreach( (array)$Propuesta->getPropClientes() as $cliente ){
		$clientes.='<li>'. $cliente["nombre"] .'</li>';
		$cargos.='<li>'. $cliente['cargo'] .'</li>';
	}
	$clientes.='</ul>';
	$cargos.='</ul>';

	$linkEdit		= "<a href='prop_por_revisar.php?idMenu=3&idPropuesta=$id_propuesta' title='Revisar propuesta'><i class='icon-eye-open' ></i></a>";
	$linkTitulo		= "<a href='prop_por_revisar.php?idMenu=3&idPropuesta=$id_propuesta'><span class='linkF'><B>$titulo</B></span></a>";
	$filasPropuesta	.= "
	 <TR>
	  <TD align='right' class='bb'><div class='padding2'>$linkEdit</div></TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$linkTitulo</div></TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$empresa_cliente</div></TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$clientes</div></TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$cargos</div></TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$estado</div></TD>
	  <TD align='center' class='borderBR'><div class='padding5'>$fecha_creacion</div></TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$codigo</div></TD>
	 </TR>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>..:: <?=tituloPag?> ::..</TITLE>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
-->
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK rel="stylesheet" href="/css/style.css" type="text/css">
<link rel="stylesheet" href="css/fabrica.css" />

<link rel="stylesheet" href="bootstrap/css/bootstrap.css" />

<!-- jquery library  -->
<script src="js/jquery-1.10.2.min.js" ></script>
<script src="js/lista_prop.js?<?=time();?>" ></script>

<link rel="stylesheet" href="js/chosen_v1.0.0/chosen.css" />
<script src="js/chosen_v1.0.0/chosen.jquery.min.js" ></script>

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

/*a {
  text-decoration: none;
}
a:hover {
  text-decoration: underline;
}*/
</style>
</HEAD>
<BODY style="margin-top:0px !important; padding-top:0px; background-color:#FFFFFF;">
<div id='container' style="margin:0px; padding:0px;">


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
     <TD align="left" width="40%" nowrap="nowrap" valign="bottom"><div class="padding5 subtitulos_azules"><?=$vbNroPagina?></div></TD>
	 <TD align='left' valign='middle'><!--<div style='font-family: Arial, Helvetica, sans-serif; font-size: 20px; color:#336666; font-weight: bold; padding-left:40px;'>F&aacute;brica de Propuestas</div>--></TD>
	</TR>
   </TABLE>
  </TD>
 </TR>
 
 <tr>
 	<td>
 		<div id="filtersWraper">
 			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" >
 				<form action="aplicar_filtros_listadoprop.php" id="filtersForm" method="POST" >
 				<tr>
 					<td>Titulo: <input type="text" name="filter_titulo" id="filter_titulo" value="<?=$_SESSION['filtros']['titulo']?>" /> </td>
 					<td>Cliente: <input type="text" name="filter_cliente" value="<?=$_SESSION['filtros']['cliente']?>" /> </td>
 					<td>Presentada a: <input type="text" name="filter_presentada" value="<?=$_SESSION['filtros']['presentada']?>" /> </td>
 					<td>Cargo: <input type="text" name="filter_cargo" value="<?=$_SESSION['filtros']['cargo']?>" /> </td>
 					<td>Tipo: 
 						<select data-placeholder="Cualquiera" name="filter_tipo[]" multiple class="makemeAwesome"  >
 							<?php foreach( $Contenidos->getTipoProp() as $tipo ){ ?>
 							<option <?php if( in_array($tipo['id_tipo_prop'], (array) $_SESSION['filtros']['tipo']) ){ ?> selected <?php } ?> value="<?=$tipo['id_tipo_prop']?>"><?=$tipo['descripcion']?></option>
 							<?php } ?>
 						</select>
 					</td>
 					<td>Estado: 
 						<select data-placeholder="Cualquiera" name="filter_estado[]" multiple class="makemeAwesome"  >
 							<?php foreach( $Contenidos->getEstadosPropuesta() as $est_prop ){ ?>
 							<option value="<?=$est_prop['id_est_prop']?>" <?php if( in_array( $est_prop['id_est_prop'] , (array)$_SESSION['filtros']['estado']) ){ ?> selected <?php } ?> ><?=$est_prop['nombre_estado']?></option>
 							<?php } ?>
 						</select>
 					</td>
 					<td>
 						<button type="submit" class="btn" >Filtrar</button>
 					</td>
 				</form>
 					<td> <a href="limpiar_filtros_listado.php" class="btn">Limpiar filtros</a> </td>
 				</tr>
 			</table>
 		</div>
 	</td>
 </tr>

<?php if( mysql_num_rows($con) > 0 ){ ?>
 <TR>
  <TD>
	<TABLE cellSpacing='0' cellPadding='0' width='100%'  border='0'>
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
    <TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0' class="borderTL">
     <TR style="background-color:#CCC">
      <TD width='1%' align='left' class='bb'>&nbsp;</TD>
      <TD align='left' class='borderBR'><div class='padding5'><B>T&iacute;tulo</B></div></TD>
      <TD width='18%' align='left' class='borderBR'><div class='padding5'><B>Cliente</B></div></TD>
      <TD width='18%' align='left' class='borderBR'><div class='padding5'><B>Presentada a:</B></div></TD>
      <TD width='15%' align='left' class='borderBR'><div class='padding5'><B>Cargo</B></div></TD>
      <td width="8%" align="left" ><b>Estado</b></td>
      <td width="8%" align="left" ><b>Fecha de creación</b></td>
      <TD width='4%' align='left' class='borderBR'><div class='padding5'><B>Código</B></div></TD>
     </TR>
     <?=$filasPropuesta?>
    </TABLE>
  </TD>
 </TR>

<?php } else { ?>
	
	<tr>
		<td colspan="6" >
			<div id="noResult" >Ningún Resultado</div>
		</td>
	</tr>

<?php } ?>
</TABLE>
</BODY>
</HTML>