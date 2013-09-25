$(document).ready(function(){

	// Estado propuesta
	$( "#propEstFinal").change(function(){

		$(this).val() == '' ? estado_final = 'NULL' : estado_final = $(this).val();
		setEstadoFinal(estado_final, $( "#id_propuesta" ).val() );
	});

	// envio revision x mail
	$( "#downloadProp").click(function(){

		if( $( "#send_docx_mail").is(':checked') ){
			enviar_revision();
		}
	});

	/*$( "input[name=send_docx_mail]").change(function(){

		$( "#send_docx_mail").is(':checked') ? $( "#docxRecipentWraper").show() :  $( "#docxRecipentWraper").hide();

	});*/

});

function enviar_revision( ){

	$.ajax({
		url 	:'ajax/send_mail_revision.php',
		type 	: 'post',
		async 	: false,
		data 	:( {
				path_propuesta 		: $( "#path_propuesta" ).val( ),
				recipent 			: $( "#docxRecipent" ).val( ),
				id_propuesta 		: $( "#id_propuesta" ).val( ),
				titulo_propuesta 	: $( "#titulo_prop" ).val( ),
				crypt_archivo 		: $( "#crypt_archivo" ).val( ) ,
				codigo_validacion 	: $( "#codigo_validacion" ).val( ) ,
				
		})
	});

}

function setEstadoFinal( estado_final, id_propuesta ){

	$( "#estadoLoader").show();

	$.ajax({
		url : 'ajax/set_estado_final.php',
		type : 'post',
		data:({
			estado_final : estado_final,
			id_propuesta : id_propuesta
		}),
		success:function(data){
			$( "#estadoLoader").hide();
			alert('Estado cambiado!');
		}
	});
}