$(document).ready(function(){

	$("#mainForm").submit(function(){

		if( $("#motivo_cambio").val() == '' ){
			$("#motivo_cambio").focus();
			alert( "Especifica el motivo de los cambios" );
			return false;
		}

	});

	// modal box metodologia
	$(".requi-ver-metodologia").colorbox({
		iframe		: true, width:"970px", 
		height		: "80%",
		onClosed	:function(){
			if( $("#refreshOnClose").val() == 1 ){
				document.location.reload();
			}
		}
	});

});