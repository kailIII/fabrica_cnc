
function table_jqgrid(a,ext,nom){

clear_all("tablaest");
create_element();


	if (ext=="grlogcl"){
	
	jQuery("#crud").jqGrid({
 
   	url:'../core/propuestas.php?opcion='+ext+'&select='+a,
	datatype: "json",
   	colNames:['Proceso','Semanas Activas', 'Semanas Desactivas','Usuario','Ip','Fecha'],
   	colModel:[
   		{name:'nom_proceso',index:'nom_proceso', width:250,editable:true,edittype:"text",editrules:{required:true}},	
	    {name:'semact',index:'semact', width:100,editable:true, sorttype:'text',editrules:{required:true}},		
		{name:'semdes',index:'semdes', width:120,editable:true, sorttype:'text',editrules:{required:true}},		
	    {name:'usuario',index:'usuario', width:100,editable:true,edittype:"text",editrules:{required:true}},	
   		{name:'ip',index:'ip', width:70,editable:true, sorttype:'text',editrules:{required:true}},				
		{name:'fecha',index:'fecha', width:120,editable:true, sorttype:'text',editrules:{required:true}}				
		
      	],
   	rowNum:10,
   	rowTotal: 50,
   	rowList:[10,20,30],
   	pager: '#pcrud',
   	sortname: 'titulo',
   	loadonce: true,
    viewrecords: true,
    sortorder: "desc",
    editurl: '../core/propuestas.php', // this is dummy existing url
    caption: nom,
	accion:'calendar'
});
jQuery("#crud").jqGrid('navGrid','#pcrud',{edit:false,add:false,del:false,search:true});
//jQuery('#crud').setCaption("jajaja");

}else if(ext=="grlogcp"){
clear_all("tablaest");
create_element();
		jQuery("#crud").jqGrid({
 
   	url:'../core/propuestas.php?opcion='+ext+'&select='+a,
	datatype: "json",
   	colNames:['Nombre Campo','Valor Cambiado','Usuario','Ip','Fecha'],
	colModel:[
   		{name:'label',index:'label', width:200,editable:true,edittype:"text",editrules:{required:true}},	
	    {name:'valor',index:'valor', width:150,editable:true, sorttype:'text',editrules:{required:true}},		
		{name:'usuario',index:'usuario', width:90,editable:true,edittype:"text",editrules:{required:true}},	
   		{name:'ip',index:'ip', width:150,editable:true, sorttype:'text',editrules:{required:true}},				
		{name:'fecha',index:'fecha', width:150,editable:true, sorttype:'text',editrules:{required:true}}				
		
      	],
   	rowNum:10,
   	rowTotal: 50,
   	rowList:[10,20,30],
   	pager: '#pcrud',
   	sortname: 'nombre',
   	loadonce: true,
    viewrecords: true,
    sortorder: "desc",
    editurl: '../core/propuestas.php', // this is dummy existing url
    caption:nom,
	accion:"Campos"
});
jQuery("#crud").jqGrid('navGrid','#pcrud',{edit:false,add:false,del:false,search:true});

//jQuery('#crud').setCaption("jajaja");
}//fin if

}


//Funcion que limpia un objeto "a"
function clear_all(a){
	
	if(document.getElementById(a)!=null){
	document.getElementById(a).innerHTML=" ";	
//	alert("modificando "+a);
	}
}
//funcion que crea la tabla y la div para el llenado de los datos
function create_element(){

	    data_table = document.createElement('table');
		data_table.id = "crud";
		data_table.align = "center";
		
	    data_div = document.createElement('div');
		data_div.id = "pcrud";
		
		etiqueta = document.createElement('br');		
		
		document.getElementById("tablaest").appendChild(data_table);
	    document.getElementById("tablaest").appendChild(data_div);
		document.getElementById("tablaest").appendChild(etiqueta);
}

function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}

