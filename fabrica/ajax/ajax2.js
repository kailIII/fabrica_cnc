function objetoAjax()
{
	var xmlhttp=false;
	try
	{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} 
	catch (e)
	{
		try
		{
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (E)
		{
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined')
	{
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

var loader2 = "<div align='center'><img src='/imagenes/loader2.gif' width='220' height='18'><br>Guardando...</div>";
var imagen_loader = "<br> <div align='center'><img src='/imagenes/loader_new.gif' ></div>";
var loader1 = "<img src='/imagenes/loader_new.gif' alt='Cargando...'>&nbsp;";

//---- consulta los objetivos del tipo de estudio
function con_objetivos(){
	//// si seleccionó una empresa
	divResultado = document.getElementById('divObjetivos');
	ajax=objetoAjax();
	var texto_loader = imagen_loader+"<BR><div align='center'>Cargando, por favor espere...</div><BR>";
	divResultado.innerHTML = texto_loader;
	var tipo_estudio		= document.getElementById('tipo_estudio').value;

	ajax.open("POST", "ajax/con_objetivos.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			divResultado.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send('tipo_estudio='+tipo_estudio);
}

//---- consulta los objetivos del tipo de estudio
var num	= 0;
function add_objetivo_esp(){
	num++;
	//// si seleccionó una empresa
	divResultado = document.getElementById('divObjetivosEsp');

	contenedor = document.createElement('div');
	contenedor.id = 'divObjEsp'+num;
	divResultado.appendChild(contenedor);
	divResultado = document.getElementById(contenedor.id);

	ajax=objetoAjax();
	var texto_loader = loader1+" Cargando, por favor espere...";
	divResultado.innerHTML = texto_loader;
	var tipo_estudio		= document.getElementById('tipo_estudio').value;

	ajax.open("POST", "ajax/add_objetivo_esp.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			divResultado.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send('tipo_estudio='+tipo_estudio);
}

////---- guarda datos de metodologías
//function save_diagnostico(id_row,nameObjEstado,idObjCodR,idObjD,idDivS){
//	frm				= document.formulario;
//	divResultado	= document.getElementById(idDivS);
//	ajax=objetoAjax();
////	var texto_loader = imagen_loader+"<BR><div align='center'>Cargando, por favor espere...</div><BR>";
//	var texto_loader = "<img src='/imagenes/loader_new.gif' height='16' border='0' /> Guardando...";
//	divResultado.innerHTML = texto_loader;
//	var id_estado_orden	= 0;
//	var cod_resultado	= document.getElementById(idObjCodR).value;
//	var diagnostico		= document.getElementById(idObjD).value;
//
//	for (var ob = 0, total_ob = frm[nameObjEstado].length; ob < total_ob; ob++){
//		//alert('checked '+frm[idObjeto][ob].checked);
//		if(frm[nameObjEstado][ob].checked==true){
//			id_estado_orden	= frm[nameObjEstado][ob].value;
//		}
//	}
//	ajax.open("POST", "ajax/save_diagnostico.php",true);
//	ajax.onreadystatechange=function(){
//		if (ajax.readyState==4){
//			divResultado.innerHTML = ajax.responseText;
//		}
//	}
//	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
//	ajax.send('id_row='+id_row+'&id_estado_orden='+id_estado_orden+'&cod_resultado='+cod_resultado+'&diagnostico='+diagnostico);
//}

//---- guarda
function save_tipo_metodologia3(idRowMetodologia,idPropuesta,idObjTitulo,idObjTemas,idObjUniverso,idObjMarco,idDivS){
	frm				= document.formulario;
	divResultado	= document.getElementById(idDivS);
	ajax=objetoAjax();
//	var texto_loader = imagen_loader+"<BR><div align='center'>Cargando, por favor espere...</div><BR>";
	var texto_loader = "<img src='/imagenes/loader_new.gif'  border='0' /> Guardando...";
	divResultado.innerHTML = texto_loader;
	var id_estado_orden	= 0;
	var vr_titulo		= document.getElementById(idObjTitulo).value;
	var vr_temas		= document.getElementById(idObjTemas).value;
	var vr_universo		= document.getElementById(idObjUniverso).value;
	var vr_marco		= document.getElementById(idObjMarco).value;

	ajax.open("POST", "data/save_tipo_metodologia3.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			divResultado.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send('idRowMetodologia='+idRowMetodologia+'&idPropuesta='+idPropuesta+'&vr_titulo='+vr_titulo+'&vr_temas='+vr_temas+'&vr_universo='+vr_universo+'&vr_marco='+vr_marco);
}

//---- guarda
function save_tipo_metodologia1(idRowMetodologia,idPropuesta,idObjTitulo,idObjTemas,idObjUniverso,idObjMarco,idDivS){
	frm				= document.formulario;
	divResultado	= document.getElementById(idDivS);
	ajax=objetoAjax();
//	var texto_loader = imagen_loader+"<BR><div align='center'>Cargando, por favor espere...</div><BR>";
	var texto_loader = "<img src='/imagenes/loader_new.gif' height='16' border='0' /> Guardando...";
	divResultado.innerHTML = texto_loader;
	var id_estado_orden	= 0;
	var vr_titulo		= document.getElementById(idObjTitulo).value;
	var vr_temas		= document.getElementById(idObjTemas).value;

	ajax.open("POST", "data/save_tipo_metodologia3.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			divResultado.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send('idRowMetodologia='+idRowMetodologia+'&idPropuesta='+idPropuesta+'&vr_titulo='+vr_titulo+'&vr_temas='+vr_temas);
}

//---- add los campos de la metodología
function add_metodologia(){
	//// si seleccionó una empresa
	divMet = document.getElementById('divMetodologia');
	ajax=objetoAjax();
	var texto_loader = imagen_loader+"<BR><div align='center'>Cargando, por favor espere...</div><BR>";

	var contMetodologias = parseInt(document.getElementById('contMetodologias').value);
	contMetodologias++;

	contenedor		= document.createElement('div');
	var idDivM		= 'divMetodologia'+contMetodologias;
	contenedor.id	= idDivM
	divMet.appendChild(contenedor);
	document.getElementById('contMetodologias').value	= contMetodologias;

	divResultado = document.getElementById(idDivM);
	divResultado.innerHTML	= texto_loader;
	var idMetodologia		= document.getElementById('id_metodologia').value;

	ajax.open("POST", "ajax/add_metodologia.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			divResultado.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send('idMetodologia='+idMetodologia+'&idDivM='+idDivM+'&contMetodologias='+contMetodologias);
}

function delete_metodologia(idDiv){
	divResultado = document.getElementById(idDiv);
	divResultado.innerHTML = '';

	fi = document.getElementById('fiel'); // 1 
	fi.removeChild(document.getElementById(idDiv)); // 10
}

//---- crea un nuevo directivo
function add_Fields(nameObj,idDiv,idPreg,idObjNroObjetos,idObjContObjetos,URL){
	//alert('URL: '+URL);
	divResultado = document.getElementById(idDiv);
	ajax=objetoAjax();
	var texto_loader = loader1;
	//divResultado.innerHTML = texto_loader;

	var objNroObjetos	= document.getElementById(idObjNroObjetos);
	var nroObjetos		= parseInt(objNroObjetos.value)+1;

	var objContObjetos	= document.getElementById(idObjContObjetos);
	var contObjetos		= parseInt(objContObjetos.value)+1;
	//alert('nroObjetos: '+nroObjetos);
	var divNewDiv		= document.createElement("div");
	var idNewDiv		= 'idNewDiv'+idPreg+'_'+nroObjetos;
	divNewDiv.id		= idNewDiv;
	divResultado.appendChild(divNewDiv);

	divResultado = document.getElementById(idNewDiv);

	ajax.open("POST", "ajax/"+URL,true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
//			divResultado.innerHTML += ajax.responseText;
			divResultado.innerHTML	= ajax.responseText;
			objNroObjetos.value		= nroObjetos;
			objContObjetos.value	= contObjetos;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send('nameObj='+nameObj+'&idObjContObjetos='+idObjContObjetos+'&idPreg='+idPreg+'&nroObjetos='+nroObjetos+'&contObjetos='+contObjetos+'&idDivNewObj='+divNewDiv.id+'&newObj='+1);
}

//---- eliminar directivo
function del_Fields(idDiv,idObj,idObjNroObjetos){
	var nomPersona	= document.getElementById(idObj).value;
	if (!nomPersona){
		mensaje	= "Confirma que lo desea eliminar?";
	}
	else{
		mensaje	= "Confirma que desea eliminar a: "+nomPersona+'?';
	}
	
	var can = confirm(mensaje);
	if (!can){
		//return false;
	}
	else{
		divResultado = document.getElementById(idDiv);
		divResultado.innerHTML = "";
		hidediv(idDiv);
		var objNroObjetos	= document.getElementById(idObjNroObjetos);
		var nroObjetos		= parseInt(objNroObjetos.value)-1;
		objNroObjetos.value	= nroObjetos;
	}
}

//---- consulta los objetivos del tipo de estudio
function add_table_segmentos(){
	divResultado = document.getElementById('divTrabla');
	ajax=objetoAjax();
	var texto_loader = imagen_loader+"<BR><div align='center'>Cargando, por favor espere...</div><BR>";
	divResultado.innerHTML = texto_loader;
	var nroRows		= document.getElementById('nro_rows').value;
	var nroCols		= document.getElementById('nro_cols').value;

	ajax.open("POST", "ajax/add_table_segmentos.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			divResultado.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send('nroRows='+nroRows+'&nroCols='+nroCols);
}

//---- eliminar directivo
function cal_error_muestral(p,costante,idObjMuestra,idObjErrorMuestral){
	var eMuestral	= '';
	if(parseFloat(document.getElementById(idObjMuestra).value)){
		muestra	= parseFloat(document.getElementById(idObjMuestra).value);
//	=RCUAD((1,96*1,96*$B$12*(1-$B$12))/(G14))
		var ope1	= costante*costante*p*(1-p);
		var ope2	= ope1/muestra;
		var raiz 	= Math.sqrt(ope2);
		var eMuestral	= Math.round(raiz*100);
	}
	document.getElementById(idObjErrorMuestral).value=eMuestral;
}

// descarga la base con todo el trabajo de campo realizado a cada registro
function xls_reporte_campo(estado){
//	var fecha_inicio	= document.getElementById('fecha_inicio').value;
//	var fecha_final		= document.getElementById('fecha_final').value;
//	var cEstado			= document.getElementById('cEstado').value;
//	if(fecha_inicio == ''){
//		alert('Por favor seleccione la fecha de inicio');
//		document.getElementById('fecha_inicio').focus();
//	}
//	else if(fecha_final == ''){
//		alert('Por favor seleccione la fecha final');
//		document.getElementById('fecha_final').focus();
//	}
//	else{
//		location.href='xls_reporte.php?fecha_inicio='+fecha_inicio+'&fecha_final='+fecha_final+'&cEstado='+cEstado;
//	}
	location.href='xls_reporte_campo.php?estado='+estado;
}
