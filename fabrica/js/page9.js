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
					fxUbicarPag(9);
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
					fxUbicarPag(9);
				}
			});
		}
	});

});