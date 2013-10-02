$(document).ready(function(){

	goTopage = $("#goTopage").val();


	if( typeof  goTopage != 'undefined' ){

		var pagina = 2;

		$( "#cPagina" ).val( pagina );
		$( "#mainForm" ).submit( ); 
	}

});