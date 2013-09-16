
$(document).ready(function() {
	$('[id*=header]').each(   //ids de input que contengan cantidad_modelo_
		function(index, value) {
			$(this).change(cantidad_cambiada)//cambio en los input y llama una funcion
		//	$('.dato_cambiable').each(cantidad_cambiada),,document.getElementById("session").innerHTML

		}
	);
});
 
 var log=new Array();
 var id_cam=new Array();
 var i=0;
function cantidad_cambiada(){
	
		
if(id_propuesta != undefined){	
	var iden=this.id;
	id_cam[i]=iden;
	
	if(i!=0){	
		var exist=false;
		for(x=0; x<id_cam.length-1;){
			if(id_cam[x]==iden){
				log[x]= id_propuesta+":"+$('#header_item2').attr('value')+":"+$('#'+iden).attr('name')+":"+iden +':'+ $('#'+iden).attr('value');
				exist=true;
			//	alert(" existe cambio"+log[x]+" "+x);
			}
		x++;
		}
	if(exist!=true){
		log[i]= id_propuesta+":"+$('#header_item2').attr('value')+":"+$('#'+iden).attr('name')+":"+iden +':'+ $('#'+iden).attr('value');
	//	alert("no existe "+log[i]+" "+i);
		i++;
	}
	}else{
		log[i]= id_propuesta+":"+$('#header_item2').attr('value')+":"+$('#'+iden).attr('name')+":"+iden +':'+ $('#'+iden).attr('value');
		//alert("primera vez"+log[i]+" "+i);
		i++;
	}		
}else{
log[i]=""; 
//alert("No ha seleccionado ninguna propuesta");
}
}
var j=0;
var log_calen=new Array();
var idproce=new Array();

function log_Calendario(selec,id_proceso,idcontsem,nroSemana){
	idproce[j]=id_proceso;	
	
	if(j!=0){	
		
		var exis=false;
		for(a=0; a<idproce.length-1; ){
	
			if(idproce[a]==id_proceso){				
				
				if(selec==true){
				
					var pos=this['arrdes'+a].indexOf(nroSemana);
					if(pos!=-1){
					pos > -1 && this['arrdes'+a].splice(pos,1);
					//alert("entro al pos act "+pos);
					pos=null;
					}else{
					this['arract'+a].push(nroSemana);	
					//alert("entro else act");
					pos=null;					
					}
				
				}else{

					var pos2=this['arract'+a].indexOf(nroSemana);
					if(pos2!=-1){
					pos2 > -1 && this['arract'+a].splice(pos2,1);
					pos2=null;
					//alert("entro al pos desa "+pos2);
					}else{
					this['arrdes'+a].push(nroSemana);	
					//alert("entro else desa");	
					pos2=null;					
					}
					
				}
				log_calen[a]=id_propuesta+":"+id_proceso+":"+this['arract'+a] +":"+this['arrdes'+a];
			//	alert(" SI existe: "+ log_calen[a]);
				
				exis=true;
			}
			a++;
		}
		if(exis!=true){
		
			if(selec==true){
				this['arract'+j]=new Array();
				this['arrdes'+j]=new Array()
				this['arract'+j].push(nroSemana);
			}else{
				this['arract'+j]=new Array();
				this['arrdes'+j]=new Array();
				this['arrdes'+j].push(nroSemana);
			}
				log_calen[j]=id_propuesta+":"+id_proceso+":"+this['arract'+j] +":"+this['arrdes'+j];
				//alert(" no existe: "+ log_calen[j]);
				j++;		
	    }
	
	}else{	
		if(selec==true){
			this['arract'+j]=new Array();
			this['arrdes'+j]=new Array();
			this['arract'+j].push(nroSemana);
		}else{
			this['arract'+j]=new Array();
			this['arrdes'+j]=new Array();
			this['arrdes'+j].push(nroSemana);
		}
		
	log_calen[j]=id_propuesta+":"+id_proceso+":"+this['arract'+j] +":"+this['arrdes'+j];
	//alert(" primeravez: "+ log_calen[j]);
	j++;
	}
	
}


function acabo(){

 $.ajax({
			type : 'GET',
			url : 'core/propuestas.php?select='+log+'&opcion=log',
			success : function () { 
					
				}
			});

	var calenJSON = JSON.stringify(log_calen);	
$.ajax({
			type : 'GET',
			url : 'core/propuestas.php?select='+log_calen+'&opcion=logcalen'+'&calen='+calenJSON,
			success : function () { 
				
				}
			});
	i=0;
	log.length = 0;
	id_cam.length = 0;
	j=0;
	log_calen.length = 0;
	idproce.length = 0;
			//camposVacios('log');
			 
}

function camposVacios(posicion){

if(posicion=='log'){

	cargaContenido("volver");
	
	}else{
		
			
			
		}
	i=0;
	log.length = 0;
	id_cam.length = 0;
	j=0;
	log_calen.length = 0;
	idproce.length = 0;
	$("#header_item2").val('');
	$("#header_item4").val('');
	$("#header_item5").val('');
	$("#header_item6").val('');
	$("#header_item7").val('');
	$("#pag1_comentario").css("display","none");
	document.getElementById("cal").innerHTML=" ";
	document.getElementById("Pag1_entregables").innerHTML=" ";
	document.getElementById("pag2").innerHTML=" ";
	document.getElementById("pag3").innerHTML=" ";
	document.getElementById("pag4").innerHTML=" ";
	document.getElementById("pag5").innerHTML=" ";
	document.getElementById("pag6").innerHTML=" ";
	document.getElementById("pag7").innerHTML=" ";
	
}

