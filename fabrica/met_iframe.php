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
	
	colorBgON = "#74B64A";
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

<link rel="stylesheet" href="bootstrap/css/bootstrap.css?<?=time();?>" />

<!-- jquery library  -->
<script src="js/jquery-1.10.2.min.js" ></script>

<link rel="stylesheet" href="js/colorbox-master/example4/colorbox.css" type="text/css" media="screen" title="no title" charset="utf-8"/>
<script src="js/colorbox-master/jquery.colorbox-min.js" type="text/javascript" charset="utf-8"></script>

</HEAD>
<BODY style="margin-top:0px !important; padding-top:0px; background-color:#FFFFFF;">
<div id='container' style="margin:0px; padding:0px;">
<FORM name='formulario' action='met_iframe_save.php' method='post' id="mainForm" >

<?php if( isset( $_GET['refresh'] ) ){ ?>
	<input type="hidden" id="refreshOnClose" value="1" />
<?php } ?>

<input type='hidden' name='idPropuesta' id='idPropuesta' value='<?=$idPropuesta?>'>
<input type='hidden' name='cPagina' id='cPagina' value='<?=$paginaActual?>'>

	
<TABLE width="100%" id="iframeMets" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#FFFFFF">
 <TR></TR>
 


 <TR>
  <TD>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left" style='border:1px solid #CED7EC;'>
	 <TR>
	  <TD align="center" colspan="2" valign="top">
		
		
		<!--INNER-->
			
			<?
//----
include("data/sql_tarifario.php");

require_once dirname(__FILE__).'/classes/class.Metodologia.php';
$Metodologia = new Metodologia( $idPropuesta );

// $Metodologia->makeMigration();

$idMetodologia		= $_POST['id_metodologia'];
$idRowMetodologia	= $_POST['idRowMetodologia']; // ---- identificador del registro de cada metodologia por propuesta
//echo '<BR>idRowMetodologia: '.$idRowMetodologia;

//----
$sqlM = "SELECT * FROM ".tablaTipoMetodologia." where id_tipo_metodologia <4 ORDER BY 1";
//echo '<BR>'.$sqlM;
$optionMetodologia			= NULL;
$contMetodologias			= 0;
$conM						= mysql_query($sqlM);
while($camposM				= mysql_fetch_array($conM)){
	$id_tipo_metodologia	= $camposM["id_tipo_metodologia"];
	$nom_tipo_metodologia	= $camposM["nom_tipo_metodologia"];

	$optionMetodologia		.= "<OPTGROUP label='$nom_tipo_metodologia'>";
	
	$sql = "SELECT * FROM ".tablaMetodologia." WHERE id_tipo_metodologia=$id_tipo_metodologia ORDER BY 1";
	//echo '<BR>'.$sql;
	$con					= mysql_query($sql);
	while($campos			= mysql_fetch_array($con)){
		$id_metodologia		= $campos["id_metodologia"];
		$nom_metodologia	= $campos["nom_metodologia"];

		$selected_e		= NULL;
		if($id_metodologia==$idMetodologia){
//			$selected_e	= "selected";
		}
		$optionMetodologia	.= "<OPTION value='$id_metodologia' $selected_e>$nom_metodologia</OPTION>";
	}
	$optionMetodologia	.= "</OPTGROUP>";
}
if(!empty($idMetodologia)){
	//---- consulta el tipo de metodología seleccionada
	$sql = "SELECT * FROM ".tablaMetodologia." WHERE id_metodologia=$idMetodologia";
	//echo '<BR>'.$sql;
	$nom_metodologia		= NULL;
	$con					= mysql_query($sql);
	while($campos			= mysql_fetch_array($con)){
		$idTipoMetodologia	= $campos["id_tipo_metodologia"];
		$nomMetodologia		= $campos["nom_metodologia"];
	}

	$sql = "INSERT INTO ".tablaMetodologiaRTA." (id_propuesta,id_metodologia)
	 VALUES (".$idPropuesta.",'$idMetodologia')";
	//echo '<BR>'.$sql;
//	$result	= eSQL($sql);
	if(mysql_query($sql)){
		$idRowMetodologia	= mysql_insert_id();
		//---- adiciona el primer segmento
		$sqlSeg = "INSERT INTO ".tablaSegmentoMetodologiaRTA." (id_propuesta,
		id_row_metodologia,
		id_tipo_metodologia,
		id_metodologia)
		 VALUES (".$idPropuesta.",
		 '$idRowMetodologia',
		 '$idTipoMetodologia',
		 '$idMetodologia')";
		//echo '<BR>'.$sqlSeg;
		if(mysql_query($sqlSeg)){}
	}
	else{
		echo "<div style='color:#990000'>Atención!!! Error al guardar la información, por favor intente nuevamente</div>".mysql_error();
	}
}
// ---- nuevo segmento
$id_row_metodologia_new_seg		= $_POST['id_row_metodologia_new_seg'];
if(!empty($id_row_metodologia_new_seg)){
	//---- consulta el tipo de metodología seleccionada
	$sql = "SELECT A.id_metodologia,A.id_tipo_metodologia,B.id_row_metodologia
	 FROM ".tablaMetodologia." A INNER JOIN ".tablaMetodologiaRTA." B USING(id_metodologia)
	 WHERE id_propuesta = ".$idPropuesta." AND id_row_metodologia=$id_row_metodologia_new_seg";
	//echo '<BR>'.$sql;
	$con					= mysql_query($sql);
	while($campos			= mysql_fetch_array($con)){
		$idTipoMetodologia	= $campos["id_tipo_metodologia"];
		$idRowMetodologia	= $campos["id_row_metodologia"];
		$idMetodologia		= $campos["id_metodologia"];

		//---- adiciona el primer segmento
		$sqlSeg = "INSERT INTO ".tablaSegmentoMetodologiaRTA." (id_propuesta,
		id_row_metodologia,
		id_tipo_metodologia,
		id_metodologia)
		 VALUES (".$idPropuesta.",
		 '$idRowMetodologia',
		 '$idTipoMetodologia',
		 '$idMetodologia')";
		//echo '<BR>'.$sqlSeg;
		if(mysql_query($sqlSeg)){}
		else{
			echo "<div style='color:#990000'>Atención!!! Error al guardar el segmento</div>".mysql_error();
		}
	}
}
?>
<INPUT type='hidden' name='idRowMetodologiaDelete' id='idRowMetodologiaDelete' value=''>
<INPUT type='hidden' name='id_row_metodologia_new_seg' id='id_row_metodologia_new_seg' value=''>
<INPUT type='hidden' name='id_new_metodologia' id='id_new_metodologia' value=''>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	 

	 <TR>
	  <TD align='left'>
        <TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>

         <tr>
         	<TD align='left' width="5%" class="bb" nowrap="nowrap"><div class='padding5 textLabel'><B id="sub_metodologia_label" >Herramienta:</B></div></TD>
         	<TD align='left' width="15%" class="bb"><div class='padding5'>
         		<select name="sub_metodologia"  id="sub_metodologia" disabled >
         		</select>
         	</TD>
         	<TD align='left' width="85%" class="bb"><div style="padding:2px 5px;">&nbsp;</TD>
         </tr>

        </TABLE>
        <TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>
        <?php $met = $Metodologia->getPropMetodologia( $_GET['id_row_metodologia'] ); ?>
        <?php  $id_r_met = $met['id_row_metodologia'];  ?>
	        <tr>
				<td>
					<div class="met-container" >
						<div class="met-title"><?=$met['nom_metodologia']?>  </div>
						<div class="met-fields">
							<table cellSpacing='0' cellPadding='0' width='100%' align='center' border='0' >
									
								<?php if( $met['id_sub_metodologia'] != ''){ ?>
								<tr>
									<td>Herramienta:</td>
									<td>
										<select name="met_submetodologia[<?=$id_r_met?>]" >
											<?php foreach( $Contenidos->getSubMetodologia( $met['id_metodologia'] ) as $submet ){ ?>
											<option value="<?=$submet['id_sub_met']?>" <?php if( $met['id_sub_metodologia'] == $submet['id_sub_met'] ){ ?> selected <?php } ?> ><?=$submet['nom_sub_met']?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<?php } ?>

								<tr>
									<td>Titulo:</td>
									<td>
										<input  class="w90" type="text" value="<?=$met['titulo']?>" name="met_titulo[<?=$id_r_met?>]" >
										<input type="hidden" name="met_ids[]" value="<?=$id_r_met?>" >
									</td>
								</tr>
								<tr>
									<td>Temas a tratar o objetivos temáticos a cubrir:</td>
									<td><textarea class="met-field-temas"  name="met_temas[<?=$id_r_met?>]" ><?=$met['temas']?></textarea></td>
								</tr>

								
								<tr>
									<td><?=$met['titulo_universo']?>:</td>
									<td><input type="text" name="met_universo[<?=$id_r_met?>]" value="<?=$met['universo']?>" ></td>
								</tr>
								<?php if( $met['a_tam_poblacion'] == 1 ){ ?>
								<tr>
									<td><?=$met['titulo_tam_poblacion']?>:</td>
									<td><input type="text" name="met_tamanio[<?=$id_r_met?>]"  class="only-numbers" value="<?=$met['tamano_poblacion']?>" ></td>
								</tr>
								<?php } ?>
								<?php if( $met['a_tecnica_recoleccion'] == 1 ){ ?>
								<tr>
									<td><?=$met['titulo_tecnica_recoleccion']?>:</td>
									<td>
										<select name="met_poblacion[<?=$id_r_met?>]" class="tecnica-recoleccion" id_met="<?=$id_r_met?>" >
											<option value="">Selecione...</option>
											<?php foreach( $Contenidos->getTecnicasRecoleccion( $met['ids_pob_objetivo'] ) as $pob ){ ?>
											<option value="<?=$pob['id_pob_objetivo']?>" <?php if( $met['id_pob_objetivo'] == $pob['id_pob_objetivo'] ){ ?> selected <?php } ?> ><?=$pob['des_pob_objetivo']?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<?php } ?>
								
								<?php if( $met['a_marco_muestral'] == 1 ){ ?>
								<tr>
									<!-- En realidad origen DB -->
									<td><?=$met['titulo_marco_muestral']?></td>
									<td>
										<?php if( $met['id_pob_objetivo'] != '' ){ ?>
										<select name="met_marco[<?=$id_r_met?>]" class="met_marco" id_met="<?=$id_r_met?>" >
											<option value="">Seleccione...</option>
											<?php foreach( $Metodologia->getAvailableOrigenDb( $id_r_met, $met['id_pob_objetivo'] ) as $origen_db ){ ?>
											<option <?php if( $met['id_origen_db'] == $origen_db['id_origen_db'] ){ ?> selected <?php } ?> value="<?=$origen_db['id_origen_db']?>"><?=$origen_db['nom_origen_db'] ?></option>
											<?php } ?>
										</select>
										<?php } else { ?>
										<select name="met_marco[<?=$id_r_met?>]" class="met_marco" id_met="<?=$id_r_met?>" disabled >
											<option value="" >Completa los campos anteriores...</option>
										</select>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>
								
								<!-- <tr>
									<td>Marco estadistico:</td>
									<td><input type="text" value="<?=$met['marco_custom']?>" name="met_other_marco[<?=$id_r_met?>]" ></td>
								</tr> -->

								<?php if( $met['id_tipo_metodologia'] == 3 ){ ?>
								<tr>
									<td>Metodo de selección de la muestra:</td>
									<td>
										<select name="met_tipo[<?=$id_r_met?>]" class="met_tipo" id_met="<?=$id_r_met?>" >
											<option value="">Selecione...</option>
											<?php foreach( $Contenidos->getTiposMetCuant( $met['exclude_tipo_cuant'] ) as $met_tipo ){ ?>
											<option <?php if( $met['id_tipo_cuantitativo'] == $met_tipo['id_tipo_cuantitativo'] ){ ?> selected <?php } ?> probabilistico="<?=$met_tipo['probabilistico']?>" value="<?=$met_tipo['id_tipo_cuantitativo']?>"><?=$met_tipo['descripcion']?></option>
											<?php } ?>
										</select>

										
											<input type="text" name="tipo_cuantitativo_custom[<?php echo $id_r_met ?>]" value="<?php echo $met['tipo_cuantitativo_custom'] ?>" placeholder="Especifique:"  <?php if( $met['id_tipo_cuantitativo'] != 10 ){ //otro ?> style="display:none;" <?php } ?>  >
										
									</td>
								</tr>
								<?php } ?>

								<tr class="probabilistic_data" id="probabilistic_data_<?=$id_r_met?>" <?php if( $Metodologia->isProbabilistico($id_r_met) ){ ?> style="display: table-row;" <?php } ?>  >
									<td>Nivel de confianza:</td>
									<td>
										<select name="met_nivel_confianza[<?=$id_r_met?>]" id="met_nivel_confianza_<?=$id_r_met?>">
											<?php foreach( $Contenidos->getNivelConfianza() as $niv_confianza ){ ?>
											<option <?php if( $met['id_nivel_confianza'] == $niv_confianza['id_nivel_confianza'] ){ ?> selected <?php } ?> percent="<?=$niv_confianza['valor']?>" value="<?=$niv_confianza['id_nivel_confianza']?>"><?=$niv_confianza['label']?></option>
											<?php } ?>
										</select>
									</td>
								</tr>

								<tr>
									<td>Especificación de la muestra:</td>
									<td>
										<input class="only-numbers" min="0" type="number" name="met_filas[<?=$id_r_met?>]" id="met_filas_<?=$id_r_met?>" placeholder="segmentos (filas)" value="<?=$met['rows']?>" >
										<input class="only-numbers" min="0" type="number" name="met_cols[<?=$id_r_met?>]" id="met_cols_<?=$id_r_met?>" placeholder="cantidad (columnas)" value="<?=$met['cols']?>" >
										<a href="javascript:void(0);" class="generateTable" id_met="<?=$id_r_met?>" is_presencial="<?=$met['is_presencial']?>" >Generar Tabla</a>
									</td>
								</tr>
								
								<?php if( $met['a_duracion'] == 1 ){ ?>
								<tr>
									<td><?=$met['titulo_duracion']?>:</td>
									<td>
										<?php if( $met['id_pob_objetivo'] != '' && $met['id_origen_db'] != '' ){ ?>
										<select  class="met_duracion" name="met_tiempo[<?=$id_r_met?>]" id="met_timpo_<?=$id_r_met?>" id_met="<?=$id_r_met?>" >
											<option value="">Selecione...</option>
											<?php foreach( $Metodologia->getAvailableDuracion( $id_r_met, $met['id_pob_objetivo'], $met['id_origen_db'] ) as $dur_met ){ ?>
											<option <?php if( $met['id_duracion'] == $dur_met['id_duracion'] ){ ?> selected <?php } ?> value="<?=$dur_met['id_duracion']?>"><?=$dur_met['duracion']?></option>
											<?php } ?>
										</select>
										<?php } else { ?>
										<select  class="met_duracion" name="met_tiempo[<?=$id_r_met?>]" id="met_timpo_<?=$id_r_met?>" disabled id_met="<?=$id_r_met?>" >
											<option value="" >Completa los campos anteriores...</option>
										</select>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>

								<?php if( $met['a_incidencia'] == 1 ){ ?>
								<tr>
									<td>¿Se conoce incidencia o hay que aplicar filtros?	</td>
									<td>
										<select class="met_if_incidencia" name="met_if_incidencia[<?=$id_r_met?>]" id="met_if_incidencia_<?=$id_r_met?>" id_met="<?=$id_r_met?>" >
											<option <?php if( $met['if_incidencia'] == 1 ){ ?> selected <?php } ?> value="1">Si</option>
											<option <?php if( $met['if_incidencia'] == 0 ){ ?> selected <?php } ?> value="0">No</option>
										</select>

										<input value="<?=$met['incidencia']?>" class="met_incidencia" type="text" name="met_incidencia[<?=$id_r_met?>]" id="met_incidencia_<?=$id_r_met?>" placeholder="Especifique:" <?php if( $met['if_incidencia'] == 1 ){ ?> style="display:block;" <?php } ?> >
									</td>
								</tr>
								<?php } ?>
								
								<?php if( $met['a_dificultad'] == 1 ){ ?>
								<tr>
									<td><?=$met['titulo_dificultad']?>:</td>
									<td>
										<?php if( $met['id_pob_objetivo'] != '' && $met['id_origen_db'] != '' && $met['id_duracion'] != '' ){ ?>
										<select name="nivel_aceptacion[<?=$id_r_met?>]" >
											<option value="">Selecione...</option>
											<?php foreach( $Metodologia->getAvailableDificultad( $id_r_met, $met['id_pob_objetivo'], $met['id_origen_db'], $met['id_duracion'] ) as $contenido ){ ?>
											<option <?php if( $met['id_nivel_aceptacion'] == $contenido['id_nivel_aceptacion'] ){ ?> selected <?php } ?> value="<?=$contenido['id_nivel_aceptacion']?>"><?=$contenido['des_nivel_aceptacion']?></option>
											<?php } ?>
										</select>
										<?php } else { ?>
										<select name="nivel_aceptacion[<?=$id_r_met?>]" disabled >
											<option value="" >Completa los campos anteriores...</option>
										</select>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>


							</table>
						</div><!-- fin met fields -->

						<!-- cobertura -->
						<?php foreach( $Contenidos->getCoberturaConstrained( $met['ids_cobertura'] ) as $cobertura ){ ?>
						<input type="hidden" name="js_coberturas[<?=$id_r_met?>]" value="<?=$cobertura['id_cobertura']?>" label="<?=$cobertura['nom_cobertura']?>"  >
						<?php } ?>

						<div class="metTableWrapper" id="metTableWrapper_<?=$id_r_met?>" >
							
							<?php if( $met['cols'] > 0 && $met['rows'] > 0  ){ echo @$Metodologia->makeTable($id_r_met); } ?>
							
						</div> <!-- Fin met tabla -->
					</div><!-- Fin met container -->
					<div style="text-align:center;" >
						<button type="submit" class="btn btn-primary" >Guardar</button>
					</div>
				</td>
			</tr>
		</table>
      </TD>
	 </TR>
	</TABLE>

<input type="hidden" name="set_default_inv" id="set_default_inv" value="0" >
<!-- jquery library  -->
<script src="js/jquery-1.10.2.min.js" ></script>
<script src="js/metodologia.js?<?php echo time(); ?>" ></script>

<!-- registra algun cambio en alguna metodologia para establecer valores por defecto en inversion -->
<script>
	$(document).ready(function(){

		// $("select").change(function(){ set_default_inv($(this)); });
		// $("input[type=text]").keydown(function(){ set_default_inv($(this)); });

		$("#btn_siguiente").click(function(){

			if( $("#set_default_inv").val() == 1 ){

				if( !confirm('Ud modificó las metodologías propuestas, los precios volverán a sus valores originales.\n¿Desea continuar?') ){
					return false;
				}
			}

		});

		// si se guardan cambios, se refresca al cerrar el popup
		refresh = $("#refreshOnClose").val();
		if( typeof  refresh != 'undefined' ){
			parent.$("#refreshOnClose").val(1);
		}

	});

	function set_default_inv( jQueryObject ){

		/**
		 * Ignora cambio si:
		 * se agrega nueva metodologia
		 * se cambia el titulo de metodlogia
		 * el campo Temas a tratar o objetivos es ignorado
		 */
		if( jQueryObject.attr('id') == 'id_metodologia' || jQueryObject.hasClass('met-title') ){
			return false;
		}

		$("#set_default_inv").val(1);
	}
</script>


 	

<!--<INPUT type='hidden' name='sendPage5' id='sendPage5' value='1'>
-->

		<!--INNER -->



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