var id_propuesta,nom_propuesta;
function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}

var listadoSelects=new Array();
listadoSelects[1]="propuesta";

function buscarEnArray(array, dato)
{
	// Retorna el indice de la posicion donde se encuentra el elemento en el array o null si no se encuentra
	var x=0;
	while(array[x])
	{
		if(array[x]==dato) return x;
		x++;
	}
	return null;
}

function cargaContenido(idSelectOrigen)
{
if(idSelectOrigen=='volver'){
	clear_all("propu");
			
		etiqueta = document.createElement('LABEL');
		etiqueta.className = "input";
		etiqueta.setAttribute("for", "propuesta");
		etiqueta.innerHTML="Seleccione una Propuesta:";
		
		opcion = document.createElement('select');
		opcion.name="propuesta";
		opcion.id="propuesta";
		opcion.className = "inputclass";
		opcion.title= "Seleccione una propuesta"; 
		
		zero_option = document.createElement('option');
		zero_option.value="";
		zero_option.innerHTML= "Selecciona opci&oacute;n...";
		
		opcion.appendChild(zero_option);
		
		br = document.createElement('br');
		
		document.getElementById("propu").appendChild(etiqueta);
		document.getElementById("propu").appendChild(br);
		document.getElementById("propu").appendChild(opcion);
		idSelectOrigen='propuesta';
		camposVacios("select");
}

	// Obtengo la posicion que ocupa el select que debe ser cargado en el array declarado mas arriba
	var posicionSelectDestino=buscarEnArray(listadoSelects, idSelectOrigen)+1;
	// Obtengo el select que el usuario modifico
	var selectOrigen=document.getElementById(idSelectOrigen);
	// Obtengo la opcion que el usuario selecciono
	var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
	// Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona opcion..."
	if(opcionSeleccionada==0)
	{
	
		var x=posicionSelectDestino, selectActual=null;
		// Busco todos los selects siguientes al que inicio el evento onChange y les cambio el estado y deshabilito
		while(listadoSelects[x])
		{
			selectActual=document.getElementById(listadoSelects[x]);
			selectActual.length=0;
			
			var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=""; nuevaOpcion.innerHTML="Selecciona opci&oacute;n...";
			selectActual.appendChild(nuevaOpcion);	selectActual.disabled=false;
			x++;
		}

	}
	// Compruebo que el select modificado no sea el ultimo de la cadena
	else if(idSelectOrigen!=listadoSelects[listadoSelects.length-1])
	
	alert('entro2');
		// Obtengo el elemento del select que debo cargar
		var idSelectDestino=listadoSelects[posicionSelectDestino];
		var selectDestino=document.getElementById(idSelectDestino);
		// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();
		ajax.open("GET", "core/propuestas.php?select="+idSelectDestino+"&opcion=opt"+opcionSeleccionada, true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
				// Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
				selectDestino.length=0;
				var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=""; nuevaOpcion.innerHTML="Cargando...";
				selectDestino.appendChild(nuevaOpcion); selectDestino.disabled=false;	
			}
			if (ajax.readyState==4)
			{
				selectDestino.parentNode.innerHTML=ajax.responseText;
				
					
			} 
		}
		ajax.send(null);
	}

function cargaDatos(iddato){
		
		$.ajaxSetup({
    		'beforeSend' : function(xhr) {
        	xhr.overrideMimeType('text/html; charset=ISO-8859-15');
   			 },
			});

		var selectOrigen=document.getElementById(iddato);
		var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
		var textoSeleccionado=selectOrigen.options[selectOrigen.selectedIndex].text;
		id_propuesta=opcionSeleccionada;
		nom_propuesta=textoSeleccionado;
		
		if(opcionSeleccionada==0){
			alert("elija algo");
			//alert(selectOrigen)
		}else{
			clear_all("propu");
			
		etiqueta = document.createElement('LABEL');
		etiqueta.className = "input required";
		etiqueta.setAttribute("for", "propuesta_select");
		etiqueta.innerHTML="Propuesta Seleccionada:&nbsp;"+textoSeleccionado;
		
		hre = document.createElement("a")
		hre.setAttribute('href', '#'); 
		hre.setAttribute('onClick', 'cargaContenido("volver")'); 
		var aTexto = document.createTextNode('volver'); 
		hre.appendChild(aTexto); 
		
		br = document.createElement('br');
		
		document.getElementById("propu").appendChild(etiqueta);
		document.getElementById("propu").appendChild(br);
		document.getElementById("propu").appendChild(hre);
		document.getElementById("Id_prop").value=opcionSeleccionada;
		
		 $.ajax({
			type : 'GET',
			url : 'core/propuestas.php?opcion=camp&select='+opcionSeleccionada,
			success : function (msg) { 
			datos = new Array();
			datos=JSON.parse(msg);
			
			$("#header_item2").val(datos[0]);
			$("#header_item4").val(datos[1]);
			$("#header_item5").val(datos[2]);
			$("#header_item6").val(datos[3]);
			$("#header_item7").val(datos[4]);
			//$('#hrefcal').attr('href','forms/grilla.php?item='+id_propuesta+'&ext=grlogcl&nom='+nom_propuesta+'&iframe=true&amp;width=3000&amp;height=1500');
			$('#hrefcal').attr('href','forms/grilla.php?item='+id_propuesta+'&ext=grlogcl&nom='+nom_propuesta);
			$('#hrefform').attr('href','forms/grilla.php?item='+id_propuesta+'&ext=grlogcp&nom='+nom_propuesta);
			$(".iframe").colorbox({iframe:true, width:"852", height:"325"});
			$(".iframe2").colorbox({iframe:true, width:"853", height:"323"});
			var fecha = datos[6];
			$("#faprob").val(fecha.substr(0,10));
			//fecha.substr(0,10)
			
			clear_all("cal");
			$("#cal").load('core/core_calendario.php?id='+opcionSeleccionada+'&faprob='+fecha.substr(0,10), '#calendario');
			$("#Pag1_entregables").load('forms/entregables.php?id='+opcionSeleccionada);
			$("#pag1_comentario").css("display","");
			
			$("#pag2").load('forms/pag2.php');
			$("#pag3").load('forms/pag3.php');
			$("#pag5").load('forms/page5.php');
						
			$("#pag7").load('forms/inversion.php?id='+opcionSeleccionada+'&vrstudio='+datos[5]);
			
			$("#Barra div").css("background","#F5F5F5");
			$("#Item1").css("background","#ccc");
			$("#stepForm").accordion("activate", 0);
			
			 $.ajax({
			type : 'GET',
			url : 'core/propuestas.php?opcion=pag&select='+opcionSeleccionada,
			success : function (msg) { 
					document.getElementById("tb_mst").innerHTML=msg;
				}
			});
			 
				}
			});
			
			
			$.ajaxSetup({
    		'beforeSend' : function(xhr) {
        	xhr.overrideMimeType('text/html; charset=ISO-8859-15');
   			 },
			});
				
		}
	}
	
function clear_all(a){
	if(document.getElementById(a)!=null){
	document.getElementById(a).innerHTML=" ";	
	}
}
function cargaCalendar(opc){
location.href = 'forms/calendar/index.php?iden='+id_propuesta+'&opc='+opc;
}
function fxCalendario(id_metodologia,id_proceso,idCelda,nameObjC,idObjC,idContSem,nroSemana,vbSemana,colorBgON,colorBgOFF){
//	alert('idObjC: '+idObjC);
	var frm	= document.cmaForm1;
	if(document.getElementById(idObjC).checked==false){
		document.getElementById(idObjC).checked	= true;
		document.getElementById(idCelda).style.backgroundColor = colorBgON;
		cargarTooltip(idCelda, nroSemana, idObjC);
		log_Calendario(true,id_proceso,idContSem,nroSemana);
	}

	else{
		document.getElementById(idObjC).checked	= false;
		document.getElementById(idCelda).style.backgroundColor = colorBgOFF;
		/*$("#"+idCelda+" a").mouseover(function(){
			$("#"+idCelda+" a").mousemove(function(e){*/
				//$(this).next('div').remove();
				/*}); });*/
		log_Calendario(false,id_proceso,idContSem,nroSemana);
		$("#"+idCelda+" div").remove();
		$("#"+idCelda+" a").removeClass('tooltip');
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
		//$("#cal").load('core/post_calendario.php?id='+document.getElementById("Id_prop")+'&p1p1=0');
	}
}

function tooltip(idCelda){
	$("#"+idCelda+" a").mouseover(function(){
	$("#"+idCelda+" a").mousemove(function(e){
	$("#"+idCelda+" div").css({left : e.pageX , top: e.pageY});
	});
	eleOffset = $(this).offset();
	$("#"+idCelda+" div").fadeIn("fast").css({
	left: eleOffset.left + $(this).outerWidth(),
	top: eleOffset.top
	});
	}).mouseout(function(){
	$("#"+idCelda+" div").fadeOut("fast");
	});
}

function cargarTooltip(idCelda, semana, id){
	$("#"+idCelda+" div").remove();
	$("#"+idCelda+" a").addClass('tooltip');
	//$("#"+idCelda).append('<div class="tooltip-seg">Tets</div>');
	data_text = document.createElement('div');
	data_text.className = 'tooltip-seg';
	data_text.id = "data_text"+id;
	document.getElementById(idCelda).appendChild(data_text);
	$('#'+data_text.id).load('core/core_calendario.php?semana='+semana+'&fechaprop='+$('#faprob').attr('value'), '#label');
	tooltip(idCelda);
	}

function rotarImages(id){
	if($("#"+id).attr('src') === 'images/yes.png'){
	$("#"+id).attr("src","images/no.png");
	
	AttentionBox.showMessage("Por favor ingrese su Argumento: <br /><textarea id='argumento' style='width: 388px; height: 49px;' onkeyup='loadArg()'></textarea>",
	{
	modal  : true,
	buttons : 
    [
        { caption : "Enviar" },
    ],
	callback: function(action)
    {
        var message = "";

        if (action != "CANCELLED")
        {
			if($('#Arg_prop').attr('value')==0){
				message = "No se ha enviado nada";
				$("#"+id).attr("src","images/yes.png");
				}else{
			
			message = "Entrada de Usuario: ";							
            message += $('#Arg_prop').attr('value');
			$.ajax({
			type : 'GET',
			url : 'core/core_calendario.php?flag=yes&image='+id+'&args='+message+'&idprop='+$('#Id_prop').attr('value'),
			});	
			}
			AttentionBox.showMessage(
				message,
				{
					buttons : 
    				[{ caption : "Aceptar" },],
					}
					); 
		}
        else
        {
           // message = "Cancelado Por el Usuario";
			$("#"+id).attr("src","images/yes.png");	
			$('#Arg_prop').val(0);					
        }

        
     
	 }
	 });

	}else{
		$.ajax({
			type : 'GET',
			url : 'core/core_calendario.php?flag=no&image='+id+'&idprop='+$('#Id_prop').attr('value'),
			});	
		$("#"+id).attr("src","images/yes.png");
		$('#Arg_prop').val(0);
		}
	}

function loadArg(){
	document.getElementById('Arg_prop').setAttribute('value',$('#argumento').attr('value'));
	//alert($('#Arg_prop').attr('value'));
}