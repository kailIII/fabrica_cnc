//funcion que retorna un verifica si un caractér digitado es un número
function esNumero(e) 
{
  var charCode
  if (navigator.appName == "Netscape")
    charCode = e.which // leo la tecla que ingreso
  else
    charCode = e.keyCode // leo la tecla que ingreso
  
//  status = charCode 
  if (charCode > 31 && (charCode < 48 || charCode > 57)) 
  { // Chequeamos que sea un numero comparandolo con los valores ASCII
    return false
  }
  
  return true
}

//funcion que retorna un verifica si un caractér digitado es una letra
function esLetra(e) 
{
 	var charCode
	
	if (navigator.appName == "Netscape")
    	charCode = e.which // leo la tecla que ingreso
	else
    	charCode = e.keyCode // leo la tecla que ingreso
  
//	status = charCode 
	if (charCode > 47 && charCode < 58)
	{ // Chequeamos que sea un numero comparandolo con los valores ASCII
    	return false
  	}
	
	return true
}
function leftTrim(sString) 
{
	while (sString.substring(0,1) == ' ')
	{
		sString = sString.substring(1, sString.length);
	}
	
	return sString;
}
function rightTrim(sString) 
{
	while (sString.substring(sString.length-1, sString.length) == ' ')
	{
		sString = sString.substring(0,sString.length-1);
	}
	
	return sString;
}
function trimAll(sString) 
{
	while (sString.substring(0,1) == ' ')
	{
		sString = sString.substring(1, sString.length);
	}
	
	while (sString.substring(sString.length-1, sString.length) == ' ')
	{
		sString = sString.substring(0,sString.length-1);
	}
	
	return sString;
}

//---- Función para mostrar DIVISIONES
function showdiv(divid) {
	var div = document.getElementById(divid);
	if(div != null) {
		div.style.visibility = 'visible';
		div.style.display = 'block';
	}
}
//---- Función para ocultar DIVISIONES
function hidediv(divid) {
	var div = document.getElementById(divid);
	if(div != null) {
		div.style.visibility = 'hidden';
		div.style.display = 'none';
	}
}

//---- Función para mostrar y ocultar DIVISIONES
function switchdiv(divid){
	var div = document.getElementById(divid);
	if(div != null){
		if(div.style.visibility == 'visible' || div.style.visibility == 'block'){
			div.style.visibility	= 'hidden';
			div.style.display		= 'none';
		}
		else{
			div.style.visibility	= 'visible';
			div.style.display		= 'block';
		}
	}
}

function validarRadio(idObj){
	var obj = document.formulario["pregrado"];
	alert("pregrado: "+obj.length)
	for ( k = 0; k < obj.length; k++ ){
		if (obj[k].checked==false){
			alert("si marcar")
			return true;
		}
	}
	return false;
}
function chkd(nameObj,vrObj,idDivJ){
	var obj = document.formulario[nameObj];
	//alert("items radio: "+obj.length)
	for (k = 0; k < obj.length; k++ ){
		obj[k].alt='checked';
	}
}

function estudios(vrObj,objAnios){
	if(vrObj=='1'){
		document.getElementById(objAnios).lang = 'SI';
		document.getElementById(objAnios).focus();
	}else{
		document.getElementById(objAnios).lang = 'NO';
		document.getElementById(objAnios).value = '';
	}
}

function aniosPostgrado(nameObj,objAnios){
	if(document.getElementById(nameObj).checked==true){
		document.getElementById(objAnios).lang = 'SI';
		document.getElementById(objAnios).focus();
	}else{
		document.getElementById(objAnios).lang = 'NO';
		document.getElementById(objAnios).value = '';
	}
}

function chPostgrado(nameObj){
	if(document.getElementById(nameObj).checked==true){
		document.getElementById('especializacion').alt='checked';
		document.getElementById('maestria').alt='checked';
	}else{
		if(document.getElementById('especializacion').checked==false && document.getElementById('especializacion').checked==false){
			document.getElementById('especializacion').alt='';
			document.getElementById('maestria').alt='';
		}
	}
}

function estudiosPostgrado(vrObj){
	if(vrObj=='1'){
		document.getElementById('especializacion').lang = 'SI';
		document.getElementById('maestria').lang = 'SI';
	}else{
		document.getElementById('especializacion').lang = 'NO';
		document.getElementById('maestria').lang = 'NO';
	}
}

function saltoP2(vrObj){
	if(vrObj=='1'){
		showdiv('divNroP3');
		showdiv('divVbP3');
		showdiv('divObjP3');
		showdiv('divNroP4');
		showdiv('divVbP4');
		showdiv('divObjP4');
		document.getElementById('p3').lang = 'SI';
		document.getElementById('p4').lang = 'SI';
	}else{
		document.getElementById('p3').lang = 'NO';
		document.getElementById('p4').lang = 'NO';
		document.getElementById('p3').value = '';
		document.getElementById('p4').value = '';
		hidediv('divNroP3');
		hidediv('divVbP3');
		hidediv('divObjP3');
		hidediv('divNroP4');
		hidediv('divVbP4');
		hidediv('divObjP4');
	}
}

function validaForm(){
	//---- valores de los productos
	var arrayProductos	= new Array(); 
	var elementos = document.formulario.elements.length;
	for(i=0; i<elementos; i++){
		var objeto	= document.formulario.elements[i];
//		alert("nombre: "+objeto.name+" value: "+objeto.length+" che: "+objeto.checked);
		// averigua si el objeto es un producto
		if(objeto.lang == 'SI'){
			//---- si es un texto
			if(objeto.type=='text' && trimAll(objeto.value).length < 1){
				alert(objeto.title);
				objeto.focus();
				objeto.select();
				return (false);
			}
			//---- si es mail
			if(objeto.id=='email'){
				if(validarEmail(objeto.value)==false){
					alert("Por favor ingrese una dirección de email válida");
					objeto.focus();
					objeto.select();
					return (false);
				}
			}
			//---- si es un radio
			if(objeto.type=='radio' && objeto.alt!='checked'){
				alert(objeto.title);
				objeto.focus();
				return (false);
			}
			//---- si es un checkbox
			if(objeto.type=='checkbox' && objeto.alt!='checked'){
				alert(objeto.title);
				objeto.focus();
				return (false);
			}
			//---- si es un combo
			if(objeto.type=='select-one' && (objeto.value=='0' || trimAll(objeto.value).length < 1)){
				alert(objeto.title);
				objeto.focus();
				return (false);
			}
		}// cierra si la respuesta es obligatoria
	}// cierra for que recorre los objetos del formulario
}

function validarEmail(valor){
//   re=/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/
   re=/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z ;,-]{2,3})$/
    if(!re.exec(trimAll(valor))){
        return false;
    }else{
        return true;
    }
}