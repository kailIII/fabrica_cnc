$(document).ready(function(){

	$(".remove-proceso").click(function(){
		if( confirm('¿Deseas eliminar este proceso?') ){

			id_proceso = $(this).attr('id_proceso'),
			
			$.ajax({

				url 	: 'ajax/add_proceso.php',
				type 	: 'post',
				data	:({
					opc 		: 'delete_proceso',
					id_proceso  : id_proceso
				}),
				success:function(data){
					var pagina = 9;

					$( "#cPagina" ).val( pagina );
					$( "#mainForm" ).submit(); 
				}

			});
		}

	});

	$("#page9AddProcess").click(function(){

		if( confirm('¿Deseas agregar un proceso?') ){
			var id_propuesta = $("#idPropuesta").val();

			$.ajax({

				url		: 'ajax/add_proceso.php',
				type 	: 'post',
				data:({
					id_propuesta : id_propuesta,
					opc 		 : 'add_proceso'
				}),
				success:function(data){
					var pagina = 9;

					$( "#cPagina" ).val( pagina );
					$( "#mainForm" ).submit(); 
				}
			});
		}
	});

	$( "#fecha_inicio" ).datepicker({
	    dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
	    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
	    dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
	    monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
	    monthNamesShort: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
	    dateFormat : "yy-mm-dd"
	});

});