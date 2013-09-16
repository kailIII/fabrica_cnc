$(document).ready(function(){

	$("input[name=estado_prop]").change(function(){

		$("#loader_est_prop").show();

		var estado_prop 	= $(this).val();
		var id_propuesta 	= $("#id_propuesta_review").val();

		$.ajax({
			url 	: 'acciones_revision_propuesta.php',
			type 	: 'post',
			data	:({
				estado_prop 	: estado_prop,
				id_propuesta 	: id_propuesta,
				opc 			: 'cambiar_estado_prop'
			}),
			success:function(data){
				$("#loader_est_prop").hide();
				$("#ok_est_prop").css('display','block');

				setTimeout( function(){
					$("#ok_est_prop").fadeOut('slow');
				},1000 )
			}
		});
	});
});