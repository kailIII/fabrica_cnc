<?
include("../ctl_login_admin.php");
$aleatorio	= rand(1,1000);

$paginaActual	= $_POST['cPagina'];
$idPropuesta	= $_REQUEST['idPropuesta'];

require_once dirname(__FILE__).'/classes/class.Propuesta.php';
require_once dirname(__FILE__).'/krumo/class.krumo.php';

require_once dirname(__FILE__).'/classes/class.Contenidos.php';
if( $idPropuesta != '' ): $Propuesta = new Propuesta( $idPropuesta ); endif;

$Propuesta->hasIdoneidad(2);

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
function add_item_factura(porcentajeIVA,nomObjVrTotalItem,idDivSubTotal,idDivIVA,idDivGranTotal){
	var tableID = 'tabla_inversion';
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
	var obj			= "<INPUT type='text' name='"+nameObj+"' id='"+idObj+"' value='' class='txt' style='width:96%;' />";			

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

	var objCantidad	= "<INPUT type='text' name='"+nameObjCant+"' id='"+idObjCant+"' maxlength='10' value='' class='txt' style='width:60px; text-align:center;' onkeypress='return esNumero(event);' onkeyup=\""+fxVrUnit+"\" onchange=\""+fxVrUnit+"\" />";			
	//----
	var cell1 = row.insertCell(2);
	cell1.className	= 'borderBR padding5';
	cell1.align		= 'center';
	cell1.innerHTML = objCantidad;

	var objPrecioUnit	= "<INPUT type='text' name='"+nameObjVrUnit+"' id='"+idObjVrUnit+"' maxlength='10' value='' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\""+fxVrUnit+"\" onchange=\""+fxVrUnit+"\" />";			

	var cell1 = row.insertCell(3);
	cell1.className	= 'borderBR padding5';
	cell1.align		= 'center';
	cell1.innerHTML = objPrecioUnit;

	var objVrTotalItem	= "<INPUT type='text' name='"+nomObjVrTotalItem+"' id='"+idObjVrTotalItem+"' value='' style='width:90px; text-align:right; border:none;' readonly='readonly' />";			
	var cell1 = row.insertCell(4);
	cell1.className	= 'borderBR padding5';
	cell1.align		= 'center';
	cell1.innerHTML = objVrTotalItem;
	
//	var rows		= table.rows;
//	var cols		= rows[2].cells;

//	table.rows[5].cols[1].innerHTML = 'www';
//	table.cols[1].innerHTML = 'www';
}
function fxInversion(objMuestra,porcentajeIVA,idObjVrUnit,nomObjVrTotalItem,idObjVrTotalItem,idDivSubTotal,idDivIVA,idDivGranTotal){
	var frm		= document.formulario;
	var muestra	= document.getElementById(objMuestra).value;
	var vrUnit	= document.getElementById(idObjVrUnit).value;
    //---- quitamos caracteres
    muestra	= muestra.toString().replace(/\./g, '');
    muestra	= muestra.toString().replace(/\,/g, '');
    vrUnit	= vrUnit.toString().replace(/\./g, '');
    vrUnit	= vrUnit.toString().replace(/\,/g, '');
	var vrTotalItem	= 0;
	if(parseFloat(muestra)>0){
		vrTotalItem	= parseFloat(muestra)*parseFloat(vrUnit);
	}
	vrUnit = formatNumber.new(vrUnit);
	document.getElementById(idObjVrUnit).value=vrUnit;
	vrTotalItem = formatNumber.new(vrTotalItem);
	document.getElementById(idObjVrTotalItem).value=vrTotalItem;

	var vrSubTotal	= 0;
	if(typeof frm[nomObjVrTotalItem] != 'undefined'){
		//alert('Entro');
		for (var w = 0, total = frm[nomObjVrTotalItem].length; w < total; w++){
			var valorObj	= frm[nomObjVrTotalItem][w].value;
			//---- quitamos caracteres
			valorObj	= valorObj.toString().replace(/\./g, '');
			valorObj	= valorObj.toString().replace(/\,/g, '');
//			alert('valorObj: '+valorObj);
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
	//alert('vrSubTotal: '+vrSubTotal);
// http://www.verteweb.com/2012/11/funcion-para-dar-formato-numeros-en.html
// http://www.antisacsor.com/articulo/10_98_dar-formato-a-numeros-en-javascript
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

function fxUbicarPag(pagina){
//	alert('pagina: '+pagina);
	document.getElementById('cPagina').value=pagina;
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
	if(document.getElementById('<?=idObjLugar?>').value.length == 0 || clic	== 1){
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
	document.getElementById('<?=idObjLugar?>').value	= nomLugar;
	hidediv('listLugares');
}

</script>
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

</HEAD>
<BODY style="margin-top:0px !important; padding-top:0px; background-color:#FFFFFF;">
<div id='container' style="margin:0px; padding:0px;">
<FORM name='formulario' action='' method='post' id="mainForm" >
<INPUT type='hidden' name='idPropuesta' id='idPropuesta' value='<?=$idPropuesta?>'>
<INPUT type='hidden' name='cPagina' id='cPagina' value='<?=$paginaActual?>'>
<? include("../menu_admin.php"); ?>
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
  <TD style="background-color:#F5F5F5" height="20">
	<TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>
	  <TR>
	   <TD width="9%" nowrap="nowrap" class="<?=$bgT[1]?>"><div class="padding5 menuF"><a href="javascript:fxUbicarPag(1)"><B>Página 1</B></a></div></TD>
	   <TD width="9%" nowrap="nowrap" class="<?=$bgT[2]?>"><div class="padding5 menuF"><a href="javascript:fxUbicarPag(2)"><B>Página 2</B></a></div></TD>
	   <TD width="9%" nowrap="nowrap" class="<?=$bgT[3]?>"><div class="padding5 menuF"><a href="javascript:fxUbicarPag(3)"><B>Contexto</B></a></div></TD>
	   <TD width="9%" nowrap="nowrap" class="<?=$bgT[4]?>"><div class="padding5 menuF"><a href="javascript:fxUbicarPag(4)"><B>Objetivos</B></a></div></TD>
	   <TD width="9%" nowrap="nowrap" class="<?=$bgT[5]?>"><div class="padding5 menuF"><a href="javascript:fxUbicarPag(5)"><B>Metodologías</B></a></div></TD>
	   <TD width="9%" nowrap="nowrap" class="<?=$bgT[6]?>"><div class="padding5 menuF"><a href="javascript:fxUbicarPag(6)"><B>Inversión</B></a></div></TD>
	   <TD width="9%" nowrap="nowrap" class="<?=$bgT[7]?>"><div class="padding5 menuF"><a href="javascript:fxUbicarPag(7)"><B>Productos</B></a></div></TD>
	   <TD width="9%" nowrap="nowrap" class="<?=$bgT[8]?>"><div class="padding5 menuF"><a href="javascript:fxUbicarPag(8)"><B>Equipo</B></a></div></TD>
	   <TD width="9%" nowrap="nowrap" class="<?=$bgT[9]?>"><div class="padding5 menuF"><a href="javascript:fxUbicarPag(9)"><B>Calendario</B></a></div></TD>
	   <TD width="9%" nowrap="nowrap" class="<?=$bgT[10]?>"><div class="padding5 menuF"><a href="javascript:fxUbicarPag(10)"><B>Notas de calidad</B></a></div></TD>
	   <TD width="9%" nowrap="nowrap" class="<?=$bgT[11]?>"><div class="padding5 menuF"><a href="javascript:fxUbicarPag(11)"><B><u>Descargar</u></B></a></div></TD>
	   <TD width="9%" nowrap="nowrap" class="<?=$bgT[12]?>"><div class="padding5 menuF"><a href="javascript:fxAprobar(<?=$idPropuesta?>);"><B><u>Aprobar</u></B></a></div></TD>
	  </TR>
	</TABLE>
  </TD>
 </TR>


 <TR>
  <TD>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left" style='border:1px solid #CED7EC;'>
	 <TR>
	  <TD align="center" colspan="2" valign="top">
	  <?
	  if($paginaActual=='1'){
	 	 include("pagina1.php");
	  }
	  elseif($paginaActual=='2'){
	 	 include("pagina2.php");
	  }
	  elseif($paginaActual=='3'){
	 	 include("pagina3.php");
	  }
	  elseif($paginaActual=='4'){
	 	 include("pagina4.php");
	  }
	  elseif($paginaActual=='5'){
	 	 include("pagina5.php");
	  }
	  elseif($paginaActual=='6'){
	 	 include("pagina6.php");
	  }
	  elseif($paginaActual=='7'){
	 	 include("pagina7.php");
	  }
	  elseif($paginaActual=='8'){
	 	 include("pagina8.php");
	  }
	  elseif($paginaActual=='9'){
	 	 include("pagina9.php");
	  }
	  elseif($paginaActual=='10'){
	 	 include("pagina10.php");
	  }
	  ?>
	  </TD>
	 </TR>
	 <TR>
	  <TD align="center" colspan="2">
		<TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
<!--		 <TR>
		  <TD width="50%" align='right'><div class='padding5'><INPUT type='submit' name='btn_anterior' id='btn_anterior' class='Button' style="padding:5px 8px;" value='Anterior' onclick="fxAvance('-',<?=numPaginas?>);" /></div></TD>
		  <TD width="50%" align='left'><div class='padding5'><INPUT type='submit' name='btn_siguiente' id='btn_siguiente' class='Button' style="padding:5px 8px;" value='Siguiente' onclick="fxAvance('+',<?=numPaginas?>);" /></div></TD>
		 </TR>
-->
		 <TR>
		  <TD width="50%" align='right'><div class='padding5'><INPUT type='submit' name='btn_anterior' id='btn_anterior' class='Button' style="padding:5px 8px;" value='Anterior' /></div></TD>
		  <TD width="50%" align='left'><div class='padding5'><INPUT type='submit' name='btn_siguiente' id='btn_siguiente' class='Button' style="padding:5px 8px;" value='Siguiente' /></div></TD>
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
</BODY>
</HTML>
