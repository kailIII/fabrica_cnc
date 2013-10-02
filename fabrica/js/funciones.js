var formatNumber = {
	separador 	: "," , // separador para los miles
	sepDecimal 	: '.' , // separador para los decimales
	formatear 	: function ( num ){
		num 			+= '';
		var splitStr 	= num.split('.');
		var splitLeft 	= splitStr[0];
		var splitRight 	= ( splitStr.length > 1 ) ? this.sepDecimal + splitStr[1] : '';
		var regx = /(\d+)(\d{3})/;
		while ( regx.test( splitLeft ) ) {
			splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2' );
		}
		return this.simbol + splitLeft + splitRight;
	} ,
	vacio : null ,
	nuevo : function( num , simbol ){
		this.simbol = simbol || '';
		return this.formatear( num );
	} 
	
}


// ---- Función para mostrar y ocultar DIVISIONES
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
 * function textAreaAdjust(o) { o.style.height = "1px"; o.style.height =
 * (25+o.scrollHeight)+"px"; } window.onload = function() { var t =
 * document.getElementsByTagName('textarea')[0]; var offset= !window.opera ?
 * (t.offsetHeight - t.clientHeight) : (t.offsetHeight +
 * parseInt(window.getComputedStyle(t,
 * null).getPropertyValue('border-top-width'))) ;
 * 
 * var resize = function(t) { t.style.height = 'auto'; t.style.height =
 * (t.scrollHeight + offset ) + 'px'; }
 * 
 * t.addEventListener && t.addEventListener('input', function(event) {
 * resize(t); });
 * 
 * t['attachEvent'] && t.attachEvent('onkeyup', function() { resize(t); }); }
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
	// ----
	var table = document.getElementById(tableID);
	
	var rowCount = table.rows.length;
// var row = table.insertRow(rowCount);
	var indFila	= rowCount-3;
	var row = table.insertRow(indFila);
	
	var cell1 = row.insertCell(0);
	cell1.className	= 'borderBR padding5';
	cell1.align		= 'center';
	var nroItem		= rowCount-4;
	cell1.innerHTML = nroItem;
	// ----
	// ----
	var nameObj		= 'productos[]';
	var idObj		= 'producto'+contItems;
	var obj			= "<input type='text' name='"+nameObj+"' id='"+idObj+"' value='' class='txt' style='width:96%;' />";			

	var cell1 = row.insertCell(1);
	cell1.className	= 'borderBR padding5';
	cell1.align		= 'left';
	cell1.innerHTML = obj;

	// ----
	var nameObjVrUnit	= 'vrUnit[]';
	var idObjVrUnit		= 'vrUnit'+contItems;
	// ----
	var idObjVrTotalItem	= 'vrTotalItem'+contItems;
	// ----
	var nameObjCant	= 'cantidad[]';
	var idObjCant	= 'item'+contItems;
	var fxVrUnit	= "fxInversion('"+idObjCant+"','"+porcentajeIVA+"','"+idObjVrUnit+"','"+nomObjVrTotalItem+"','"+idObjVrTotalItem+"','"+idDivSubTotal+"','"+idDivIVA+"','"+idDivGranTotal+"')";

	var objCantidad	= "<input type='text' name='"+nameObjCant+"' id='"+idObjCant+"' maxlength='10' value='' class='txt' style='width:60px; text-align:center;' onkeypress='return esNumero(event);' onkeyup=\""+fxVrUnit+"\" onchange=\""+fxVrUnit+"\" />";			
	// ----
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
	
	
// var rows = table.rows;
// var cols = rows[2].cells;

// table.rows[5].cols[1].innerHTML = 'www';
// table.cols[1].innerHTML = 'www';
}


function fxInversion( objMuestra , porcentajeIVA , idObjVrUnit , nomObjVrTotalItem , idObjVrTotalItem , idDivSubTotal , idDivIVA , idDivGranTotal ){
	
	var frm		= document.formulario;
	var muestra	= document.getElementById( objMuestra ).value;
	var vrUnit	= document.getElementById( idObjVrUnit ).value;
    // ---- quitamos caracteres
    muestra	= muestra.toString( ).replace(/\./g, '');
    muestra	= muestra.toString( ).replace(/\,/g, '');
    vrUnit	= vrUnit.toString( ).replace(/\./g, '');
    vrUnit	= vrUnit.toString( ).replace(/\,/g, '');
	var vrTotalItem	= 0;
	if(parseFloat(muestra)>0){
		vrTotalItem	= parseFloat(muestra)*parseFloat(vrUnit);
	}

	vrUnit 		= formatNumber.nuevo( vrUnit );
	vrTotalItem = formatNumber.nuevo(	vrTotalItem );

	document.getElementById( idObjVrUnit ).value 		= vrUnit;
	document.getElementById( idObjVrTotalItem ).value 	= vrTotalItem;

	var vrSubTotal	= 0;

	if( typeof frm[ nomObjVrTotalItem ] != 'undefined' ){

		var total = frm[ nomObjVrTotalItem ].length;
		total = ( typeof total != 'undefined' ) ? total : 1;

		for (var w = 0; w < total; w++){

			var valorObj	= ( typeof frm[ nomObjVrTotalItem ][ w ] != 'undefined' ) ? frm[ nomObjVrTotalItem ][ w ].value : frm[ nomObjVrTotalItem ].value;
			// ---- quitamos caracteres
			valorObj	= valorObj.toString().replace(/\./g, '');
			valorObj	= valorObj.toString().replace(/\,/g, ''); 
			
// var idObj_act = frm[nomObjVrTotalItem][w].id;
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
	vrSubTotal = formatNumber.nuevo(vrSubTotal);
	document.getElementById(idDivSubTotal).innerHTML = vrSubTotal;
	vrIVA = formatNumber.nuevo(vrIVA);
	document.getElementById(idDivIVA).innerHTML = vrIVA;
	vrGranTotal = formatNumber.nuevo(vrGranTotal, "$ ");
	document.getElementById(idDivGranTotal).innerHTML = '<B>'+vrGranTotal+'</B>'; 
	
}

function fxDeleteMetodologia(id_row_metodologia){
	if (!confirm("Atención!!!\n\n¿Confirma que desea eliminar la metodología?\nRecuerde que no puedes deshacer esta acción")) {
		// return false;
	}
	else{
		document.getElementById('idRowMetodologiaDelete').value=id_row_metodologia;
		document.formulario.submit();
		// return true;
	}
}

function new_segmento(id_row_metodologia){
	if (!confirm("Atención!!!\n\n¿Confirma que desea crear un nuevo segmento")) {
		// return false;
	}
	else{
		document.getElementById('id_row_metodologia_new_seg').value=id_row_metodologia;
		document.formulario.submit();
		// return true;
	}
}

function new_metodologia(){
	document.getElementById('id_new_metodologia').value=1;
	document.formulario.submit();
}


function fxAvance(direccion,numPaginas){
// alert('direccion: '+direccion);
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
	// alert('pag: '+document.getElementById('cPagina').value);
}

function fxUbdicarPag( pagina ){
// alert('pagina: '+pagina);
	document.getElementById('cPagina').value = pagina;
	document.formulario.submit();
}

function fxAprobar(idPropuesta){
// alert('pagina: '+pagina);
	if (confirm("¿Está seguro que desea aprobar la propuesta?")) {
		document.location.href="aprobar_propuesta.php?idPropuesta="+idPropuesta;
	}
}




function fxSelEquipo(idObj,nameObjE,idObjE,idIMG,idObjRol,idPersona,nomPersona,colorBordeON,colorBordeOFF){
// alert('direccion: '+direccion);
	var frm			= document.formulario;
	if(document.getElementById(idObj).checked==false){
		document.getElementById(idObj).checked	= true;
		document.getElementById(idObjE).value	= nomPersona;
		document.getElementById(idIMG).style.borderColor = colorBordeON;
		document.getElementById(idObjRol).value	= 0;
		document.getElementById(idObjRol).disabled	= false;
		document.getElementById(idObjRol).focus();	
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
		// alert('Entro');
		var i = 0;
		for (var w = 0, total = frm[nameObjE].length; w < total; w++){
// var valores_act = frm[nameObjE][w].value;
// var idObj_act = frm[nameObjE][w].id;
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
// alert('idObjC: '+idObjC);
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
		// alert('Entro');
		var contSem = 0;
		for (var w = 0, total = frm[nameObjC].length; w < total; w++){
// var valores_act = frm[nameObjC][w].value;
			var idObj_act	= frm[nameObjC][w].id;
			// alert('valor: '+document.getElementById(idObj_act).value);
			if(document.getElementById(idObj_act).checked == true){
				contSem++;
			}
		}
		document.getElementById(idContSem).innerHTML	= contSem;
	}
}
// ----
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
// ----
function selLugar(idDiv){
	// alert('idDiv: '+idDiv);
	var nomLugar 	= document.getElementById(idDiv).innerHTML;
	document.getElementById('<?php echo idObjLugar?>').value	= nomLugar;
	hidediv('listLugares');
}


