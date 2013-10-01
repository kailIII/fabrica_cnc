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
<TITLE>..:: <?php echo tituloPag?> ::..</TITLE>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
-->
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script language="JavaScript" type="text/javascript" src="/scripts/js.js"></script>
<script src="js/jquery-1.10.2.min.js" ></script>
<script language="JavaScript" type="text/javascript" src="ajax/ajax2.js?v=<?php echo $aleatorio?>"></script>
<script language="JavaScript">
var formatNumber = {
	separador: ",", // separador para los miles
	sepDecimal: '.', // separador para los decimales
	formatear:function (num){
		num +='';
		var splitStr = num.split('.');
		var splitLeft = splitStr[0];
		var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
		var regx = /(\d+)(\d{3})/;
		while (regx.test(splitLeft)) {
			splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
		}
		return this.simbol + splitLeft  +splitRight;
	},
	new:function(num, simbol){
		this.simbol = simbol ||'';
		return this.formatear(num);
	}
}
//---- Función para mostrar y ocultar DIVISIONES
function switchdivM(divid){
	var div = document.getElementById(divid);
	if(div != null){
		if(div.style.visibility == 'visible' || div.style.display == 'block'){
			div.style.visibility	= 'hidden';
			div.style.display		= 'none';
		}
		else{
			div.style.visibility	= 'visible';
			div.style.display		= 'block';
		}
	}
}

/*
function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = (25+o.scrollHeight)+"px";
}
window.onload = function() {
    var t = document.getElementsByTagName('textarea')[0];
    var offset= !window.opera ? (t.offsetHeight - t.clientHeight) : (t.offsetHeight + parseInt(window.getComputedStyle(t, null).getPropertyValue('border-top-width'))) ;
 
    var resize  = function(t) {
        t.style.height = 'auto';
        t.style.height = (t.scrollHeight  + offset ) + 'px';   
    }
 
    t.addEventListener && t.addEventListener('input', function(event) {
        resize(t);
    });
 
    t['attachEvent']  && t.attachEvent('onkeyup', function() {
        resize(t);
    });
}
*/

function add_table_factura( div ){
	showdiv( div );
}

function add_item_factura(porcentajeIVA,nomObjVrTotalItem,idDivSubTotal,idDivIVA,idDivGranTotal, tabla){
	var tableID = 'tabla_inversion' + tabla;

	tabla = ( tabla != 2 ) ? 1 : 2;
	
	var contItems = parseInt(document.getElementById('contItems').value);
	++contItems;
	document.getElementById('contItems').value=contItems;
	//----	
	var table = document.getElementById(tableID);
	
	var rowCount = table.rows.length;
//	var row = table.insertRow(rowCount);
	var indFila	= rowCount-3;
	var row = table.insertRow(indFila);
	
	var cell1 = row.insertCell(0);
	cell1.className	= 'borderBR padding5';
	cell1.align		= 'center';
	var nroItem		= rowCount-4;
	cell1.innerHTML = nroItem;
	//----
	//----
	var nameObj		= 'productos[]';
	var idObj		= 'producto'+contItems;
	var obj			= "<input type='text' name='"+nameObj+"' id='"+idObj+"' value='' class='txt' style='width:96%;' />";			

	var cell1 = row.insertCell(1);
	cell1.className	= 'borderBR padding5';
	cell1.align		= 'left';
	cell1.innerHTML = obj;

	//----
	var nameObjVrUnit	= 'vrUnit[]';
	var idObjVrUnit		= 'vrUnit'+contItems;
	//----
	var idObjVrTotalItem	= 'vrTotalItem'+contItems;
	//----
	var nameObjCant	= 'cantidad[]';
	var idObjCant	= 'item'+contItems;
	var fxVrUnit	= "fxInversion('"+idObjCant+"','"+porcentajeIVA+"','"+idObjVrUnit+"','"+nomObjVrTotalItem+"','"+idObjVrTotalItem+"','"+idDivSubTotal+"','"+idDivIVA+"','"+idDivGranTotal+"')";

	var objCantidad	= "<input type='text' name='"+nameObjCant+"' id='"+idObjCant+"' maxlength='10' value='' class='txt' style='width:60px; text-align:center;' onkeypress='return esNumero(event);' onkeyup=\""+fxVrUnit+"\" onchange=\""+fxVrUnit+"\" />";			
	//----
	var cell1 = row.insertCell(2);
	cell1.className	= 'borderBR padding5';
	cell1.align		= 'center';
	cell1.innerHTML = objCantidad;

	var objPrecioUnit	= "<input type='text' name='"+nameObjVrUnit+"' id='"+idObjVrUnit+"' maxlength='10' value='' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\""+fxVrUnit+"\" onchange=\""+fxVrUnit+"\" />";			

	var cell1 = row.insertCell(3);
	cell1.className	= 'borderBR padding5';
	cell1.align		= 'center';
	cell1.innerHTML = objPrecioUnit;

	var objVrTotalItem	= "<input type='text' name='"+nomObjVrTotalItem+"' id='"+idObjVrTotalItem+"' value='' style='width:90px; text-align:right; border:none;' readonly='readonly' />" + 
						"<input type='hidden' name='tabla[]' value='" + tabla + "' />"; 
	var cell1 = row.insertCell(4);
	cell1.className	= 'borderBR padding5';
	cell1.align		= 'center';
	cell1.innerHTML = objVrTotalItem;
	
	
//	var rows		= table.rows;
//	var cols		= rows[2].cells;

//	table.rows[5].cols[1].innerHTML = 'www';
//	table.cols[1].innerHTML = 'www';
}
function fxInversion( objMuestra , porcentajeIVA , idObjVrUnit , nomObjVrTotalItem , idObjVrTotalItem , idDivSubTotal , idDivIVA , idDivGranTotal ){
	
	var frm		= document.formulario;
	var muestra	= document.getElementById( objMuestra 	).value;
	var vrUnit	= document.getElementById( idObjVrUnit 	).value;
    //---- quitamos caracteres
    muestra	= muestra.toString( ).replace(/\./g, '');
    muestra	= muestra.toString( ).replace(/\,/g, '');
    vrUnit	= vrUnit.toString( ).replace(/\./g, '');
    vrUnit	= vrUnit.toString( ).replace(/\,/g, '');
	var vrTotalItem	= 0;
	if(parseFloat(muestra)>0){
		vrTotalItem	= parseFloat(muestra)*parseFloat(vrUnit);
	}

	vrUnit 		= formatNumber.new( vrUnit );
	vrTotalItem = formatNumber.new(	vrTotalItem );

	document.getElementById( idObjVrUnit ).value 		= vrUnit;
	document.getElementById( idObjVrTotalItem ).value 	= vrTotalItem;

	var vrSubTotal	= 0;

	if( typeof frm[ nomObjVrTotalItem ] != 'undefined' ){

		var total = frm[ nomObjVrTotalItem ].length;
		total = ( typeof total != 'undefined' ) ? total : 1;

		for (var w = 0; w < total; w++){

			var valorObj	= ( typeof frm[ nomObjVrTotalItem ][ w ] != 'undefined' ) ? frm[ nomObjVrTotalItem ][ w ].value : frm[ nomObjVrTotalItem ].value;
			//---- quitamos caracteres
			valorObj	= valorObj.toString().replace(/\./g, '');
			valorObj	= valorObj.toString().replace(/\,/g, ''); 
			
//			var idObj_act	= frm[nomObjVrTotalItem][w].id;
			if(trimAll(valorObj).length > 0){
				if(parseFloat(valorObj)){
					vrSubTotal	+= parseFloat(valorObj);
				}
			}
		}
	} 

	
	var vrIVA	= 0;
	if(parseFloat(vrSubTotal)){
		vrIVA	= Math.round(parseFloat(porcentajeIVA) * parseFloat(vrSubTotal),0);
	}
	var vrGranTotal	= Math.round((parseFloat(vrSubTotal)+parseFloat(vrIVA)),0);
	vrSubTotal = formatNumber.new(vrSubTotal);
	document.getElementById(idDivSubTotal).innerHTML = vrSubTotal;
	vrIVA = formatNumber.new(vrIVA);
	document.getElementById(idDivIVA).innerHTML = vrIVA;
	vrGranTotal = formatNumber.new(vrGranTotal, "$ ");
	document.getElementById(idDivGranTotal).innerHTML = '<B>'+vrGranTotal+'</B>'; 
	
}

function fxDeleteMetodologia(id_row_metodologia){
	if (!confirm("Atención!!!\n\n¿Confirma que desea eliminar la metodología?\nRecuerde que no puedes deshacer esta acción")) {
		//return false;
	}
	else{
		document.getElementById('idRowMetodologiaDelete').value=id_row_metodologia;
		document.formulario.submit();
		//return true;
	}
}

function new_segmento(id_row_metodologia){
	if (!confirm("Atención!!!\n\n¿Confirma que desea crear un nuevo segmento")) {
		//return false;
	}
	else{
		document.getElementById('id_row_metodologia_new_seg').value=id_row_metodologia;
		document.formulario.submit();
		//return true;
	}
}

function new_metodologia(){
	document.getElementById('id_new_metodologia').value=1;
	document.formulario.submit();
}


function fxAvance(direccion,numPaginas){
//	alert('direccion: '+direccion);
	var pagActual	= parseInt(document.getElementById('cPagina').value);
	if(direccion == '+'){
		if(pagActual < numPaginas){
			pagActual++;
		}
	}
	else if(direccion == '-'){
		if(pagActual > 1){
			pagActual--;
		}
	}
	document.getElementById('cPagina').value=pagActual;
	//alert('pag: '+document.getElementById('cPagina').value);
}

function fxUbdicarPag( pagina ){
//	alert('pagina: '+pagina);
	document.getElementById('cPagina').value = pagina;
	document.formulario.submit();
}

function fxAprobar(idPropuesta){
//	alert('pagina: '+pagina);
	if (confirm("¿Está seguro que desea aprobar la propuesta?")) {
		document.location.href="aprobar_propuesta.php?idPropuesta="+idPropuesta;
	}
}




function fxSelEquipo(idObj,nameObjE,idObjE,idIMG,idObjRol,idPersona,nomPersona,colorBordeON,colorBordeOFF){
//	alert('direccion: '+direccion);
	var frm			= document.formulario;
	if(document.getElementById(idObj).checked==false){
		document.getElementById(idObj).checked	= true;
		document.getElementById(idObjE).value	= nomPersona;
		document.getElementById(idIMG).style.borderColor = colorBordeON;
		document.getElementById(idObjRol).value	= 0;
		document.getElementById(idObjRol).disabled	= false;
		document.getElementById(idObjRol).focus();		;
	}
	else{
		document.getElementById(idObj).checked	= false;
		document.getElementById(idObjE).value	= '';
		document.getElementById(idIMG).style.borderColor = colorBordeOFF;
		document.getElementById(idObjRol).value	= 0;
		document.getElementById(idObjRol).disabled	= true;
	}
	var	arrayEquipo		= new Array(); 
	if(typeof frm[nameObjE] != 'undefined'){
		//alert('Entro');
		var i = 0;
		for (var w = 0, total = frm[nameObjE].length; w < total; w++){
//			var valores_act	= frm[nameObjE][w].value;
//			var idObj_act	= frm[nameObjE][w].id;
			if(trimAll(frm[nameObjE][w].value).length > 0){
				arrayEquipo[i]=frm[nameObjE][w].value;
				i++;
			}
		}
	}
	var nom_equipo = arrayEquipo.length > 0 ? arrayEquipo.join(", ") : "";
	document.getElementById('divListaEquipoTrabajo').innerHTML	= "<B><u>Equipo de trabajo:</u> "+nom_equipo+"</B>";
}

function fxCalendario(id_metodologia,id_proceso,idCelda,nameObjC,idObjC,idContSem,nroSemana,vbSemana,colorBgON,colorBgOFF){
//	alert('idObjC: '+idObjC);
	var frm			= document.formulario;
	if(document.getElementById(idObjC).checked==false){
		document.getElementById(idObjC).checked	= true;
		document.getElementById(idCelda).style.backgroundColor = colorBgON;
	}
	else{
		document.getElementById(idObjC).checked	= false;
		document.getElementById(idCelda).style.backgroundColor = colorBgOFF;
	}
	if(typeof frm[nameObjC] != 'undefined'){
		//alert('Entro');
		var contSem = 0;
		for (var w = 0, total = frm[nameObjC].length; w < total; w++){
//			var valores_act	= frm[nameObjC][w].value;
			var idObj_act	= frm[nameObjC][w].id;
			//alert('valor: '+document.getElementById(idObj_act).value);
			if(document.getElementById(idObj_act).checked == true){
				contSem++;
			}
		}
		document.getElementById(idContSem).innerHTML	= contSem;
	}
}
//----
function verLugares(clic){
	if(document.getElementById('<?php echo idObjLugar?>').value.length == 0 || clic	== 1){
		var divResultado 	= document.getElementById('listLugares');
		if(divResultado.style.display == 'none'){
			showdiv('listLugares');
		}else{
			hidediv('listLugares');
		}
	}
}
//----
function selLugar(idDiv){
	//alert('idDiv: '+idDiv);
	var nomLugar 	= document.getElementById(idDiv).innerHTML;
	document.getElementById('<?php echo idObjLugar?>').value	= nomLugar;
	hidediv('listLugares');
}

</script>
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

/*a {
  text-decoration: none;
}
a:hover {
  text-decoration: underline;
}*/
</style>
<!-- Contact Form CSS files -->
<link type='text/css' href='css/contact.css?v=<?php echo $aleatorio?>' rel='stylesheet' media='screen' />

<link rel="stylesheet" href="bootstrap/css/bootstrap.css?<?php echo time();?>" />

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
								<img border='0' height="81" src="/imagenes/logo_cnc.gif" title="Centro Nacional de consultoría">
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
				
			} );
			
		});

	</script>

</BODY>
</HTML>
