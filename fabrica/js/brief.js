$(window).load(function(){

	// carga de brief -- para mostrar la pag cuando los tabs esten listos

	$("#brief2pageLoader").hide();
	$("#brief2Container").show();

});


$(document).ready(function(){

	$(".tabs-analisis").click(function(){

		window.location.href = "brief_2.php#tabs-analisis";
		window.location.reload();

	});

	// calcula produccion
	$(".produccion-calcular").click(function(){

		id_row_segmento 	= $(this).attr('id_row_segmento');
		num_encuestadores 	= parseInt( $("#produccion-num-encu-"+id_row_segmento).val() );
		efectividad 		= parseInt( $("#produccion-efectividad-"+id_row_segmento).val() );
		goal 				= parseInt( $("#produccion-goal-"+id_row_segmento).val() );
		dias_semana 		= parseInt( $("#produccion-diashab-"+id_row_segmento).val() ); // dias habiles semana

		efectividad *= dias_semana // efectividad en la semana

		// si en una semana se hace X encuestas
		encuestas_por_semana = goal / efectividad;

		// se dilata el resultado segun el num de encuestadores
		semanas_de_demora = Math.ceil(encuestas_por_semana / num_encuestadores);

		msg = num_encuestadores + ' encuestador/es demorarían ' + semanas_de_demora + ' semana/s';


		$("#produccion-resultado-"+id_row_segmento).html( msg );

	});

	// cambia porcentaje proyecto
	$(".toggle-porcentaje-proyecto").change(function(){

		porcentaje 		= $(this).find('option:selected').attr('porcentaje');
		id_propuesta 	= $(this).attr('id_propuesta');

		$("#porcentaje-proyecto-"+id_propuesta).html( porcentaje+'%' );
	});

	// cambia porcentaje proceso (AREA)
	$(".toggle-porcentaje-proceso").change(function(){

		porcentaje 		= $(this).find('option:selected').attr('porcentaje');
		id_propuesta 	= $(this).attr('id_propuesta');

		$("#porcentaje-proceso-"+id_propuesta).html( porcentaje+'%' );

	});

	// global listener de interacciones ajax
	var ajax_requests = 0;
	$(document).ajaxSend(function(){
		ajax_requests++;
		$("#brief2AjaxLoader").show();
	});


	$(document).ajaxComplete(function(){
		ajax_requests--;

		if( ajax_requests == 0 ){
			$("#brief2AjaxLoader").hide();
		}
	});




	// entregado productos custom (inversion en BD)
	$(".entregado-producto-c").click(function(){

		data = new Object;

		$(this).is(':checked') ? data.val = 1 : data.val = 0;
		data.id_producto = $(this).attr( 'id_producto' );

		setEntragadoProductoCustom( data );

	})

	// entregado productos
	$(".entregado-producto").click(function(){

		data = new Object;

		$(this).is(':checked') ? data.val = 1 : data.val = 0;
		data.id_row_segmento = $(this).attr( 'id_row_segmento' );

		setEntragadoProducto( data );

	});


	$(".completado").keydown(function(e){

		min = parseInt( $(this).attr('min') );
		max = parseInt( $(this).attr('max') );

		number 			= getKeyCodeNumber( e.keyCode );
		expected_value 	= $(this).val().toString()+number;
		expected_value 	= parseInt( expected_value );
		digitos_max 	= ( $(this).attr('max').length );

		// evita que el valor sea mayor al permitido
		if( number != null && ( expected_value > max ) ){
			return false;
		}

		// evita que el valor sea menor al actual (solo para numeros de 1 digito)
		if( number != null && digitos_max < 2 && expected_value < min ){
			return false;
		}


	});

	// tabulados
	$(".entrega-tabulados").change(function(){

		data = new Object;

		data.id_propuesta 	= $(this).attr('id_propuesta');
		data.val 			= $(this).val();

		setEntregaTabulados( data );

	});

	// digitacion
	$(".digitacion").click(function(){

		data = new Object;

		data.id_propuesta 	= $(this).attr('id_propuesta');
		data.val 			= $(this).val();

		setDigitacion( data );
	});

	// critica y codificacion
	$(".cyc").click(function(){

		data = new Object;

		data.id_propuesta 	= $(this).attr('id_propuesta');
		data.val 			= $(this).val();

		setCriticaYCod( data );
	});

	// tipo captura
	$(".tipo-captura").change(function(){

		data = new Object;

		data.id_propuesta 	= $(this).attr('id_propuesta');
		data.val 			= $(this).val();

		setTipoCaptura( data );

	});

	// completado de productos personalizados (tabla inversion en BD)
	$(".set-completado-productos-c").click(function(){

		id_producto = $(this).attr('id_producto');

		max 	= parseInt( $("#producto_completado_c_"+id_producto).attr('max') );
		min 	= parseInt( $("#producto_completado_c_"+id_producto).attr('min') );
		value 	= parseInt( $("#producto_completado_c_"+id_producto).val() );

		if( value > max ){
			alert( 'El valor no puede ser mayor a '+max );
			return false;
		}

		if( value < min ){
			alert( 'El valor no puede ser menor a '+min );
			return false;
		}

		data = new Object;

		data.id_producto 	= id_producto;
		data.val 			= value;

		setCompletadoProductosC( data );
	});

	// completado de productos
	$(".set-completado-productos").click(function(){

		id_row_segmento = $(this).attr('id_row_segmento');

		max 	= parseInt( $("#producto_completado_"+id_row_segmento).attr('max') );
		min 	= parseInt( $("#producto_completado_"+id_row_segmento).attr('min') );
		value 	= parseInt( $("#producto_completado_"+id_row_segmento).val() );

		if( value > max ){
			alert( 'El valor no puede ser mayor a '+max );
			return false;
		}

		if( value < min ){
			alert( 'El valor no puede ser menor a '+min );
			return false;
		}

		data = new Object;

		data.id_row_segmento 	= id_row_segmento;
		data.val 				= $("#producto_completado_"+data.id_row_segmento).val();

		setCompletadoProductos( data );
	});

	// cambio razon incumplimiento
	$(".razon-incu-proceso").change(function(){

		data = new Object;

		data.val 			= $(this).val()
		data.id_propuesta 	= $(this).attr('id_propuesta');
		data.id_proceso 	= $(this).attr('id_proceso');

		cambiarRazonIncuProceso( data );

	});

	// cambio de tarea completada
	$(".completado-proceso").change(function(){

		data = new Object;

		$(this).is(':checked') ? data.val = 1 : data.val = 0;

		data.id_propuesta 	= $(this).attr('id_propuesta');
		data.id_proceso 	= $(this).attr('id_proceso');

		cambiarProcesoCompletado( data );

	});

	$(window).scroll(function(){

		if( typeof  $("#tabs").val() != 'undefined' ){

			bodyTop = $(document).scrollTop();
			limit 	= $("#tabs").offset().top;

			if( bodyTop > limit ){
				$("#brief2Container #tabs .ui-tabs-nav").addClass('fixed-top');
			} else {
				$("#brief2Container #tabs .ui-tabs-nav").removeClass('fixed-top');
			}
		}
	});


    $( "#tabs" ).tabs();

	$(document).click(function(event){

		if( !$(event.target).hasClass('proceso-item') && !$(event.target).hasClass('le-datepciker') ){

			$("#toolTipProceso").removeClass('show');
			$("#toolTipProceso").addClass('hide');

			$(".proceso-item").removeClass('active');

		}
	});

	$(".proceso-item").click(function(){

		posX = $(this).offset().left;
		posY = $(this).offset().top;

		altura_caja = $("#toolTipProceso").height();
		posY		= ( posY - altura_caja ) - 10;

		// centra la caja
		ancho_link = $(this).width();
		if( ancho_link <= 150 ){
			posX -= ancho_link;
		}


		$("#toolTipProceso").css('top', posY+'px' );
		$("#toolTipProceso").css('left', posX+'px' );

		$("#toolTipProceso").removeClass('hide');
		$("#toolTipProceso").addClass('show');

		$(".proceso-item").removeClass('active');
		$(this).addClass('active');

		$("#procesoFechaIni").val( $(this).attr('fecha-inicio') );
		$("#procesoFechaFin").val( $(this).attr('fecha-final') );

	});

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

	$( ".le-datepciker" ).datepicker({
		dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
		dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
		dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
		monthNamesShort: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
		dateFormat : "yy-mm-dd"
	});

	// filtro de solo numeros
	$(".only-numbers").keydown(function(e){
		if( (e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 9 || e.keyCode == 8 )
			return true;
		else
			return false;
	});


});

function setEntragadoProductoCustom( data ){

	$.ajax({
		url 	: 'ajax/brief_ajax.php',
		type 	: 'post',
		data 	: ({
			opc 	: 'set-entregado-producto-custom',
			data 	: data
		})
	});
}

function getKeyCodeNumber( keycode ){

	number = null;

	switch( keycode ){

		case 49:
		case 97:
			number = 1;
			break;

		case 50:
		case 98:
			number = 2;
			break;

		case 51:
		case 99:
			number = 3;
			break;

		case 52:
		case 100:
			number = 4;
			break;

		case 53:
		case 101:
			number = 5;
			break;

		case 54:
		case 102:
			number = 6;
			break;

		case 55:
		case 103:
			number = 7;
			break;

		case 56:
		case 104:
			number = 8;
			break;

		case 57:
		case 105:
			number = 9;
			break;

		case 48:
		case 96:
			number = 0;
			break;
	}

	if( number != null ){
		return number.toString();
	}

	return number;

}

function setEntragadoProducto( data ){

	$.ajax({
		url 	: 'ajax/brief_ajax.php',
		type 	: 'post',
		data 	: ({
			opc 	: 'set-entregado-productos',
			data 	: data
		})
	});
}

function setEntregaTabulados( data ){

	$.ajax({
		url 	: 'ajax/brief_ajax.php',
		type 	: 'post',
		data 	: ({
			opc 	: 'set-entrega-tabulados',
			data 	: data
		})
	});
}

function setDigitacion( data ){

	$.ajax({
		url 	: 'ajax/brief_ajax.php',
		type 	: 'post',
		data 	: ({
			opc 	: 'set-digitacion',
			data 	: data
		})
	});
}

function setCriticaYCod( data ){

	$.ajax({
		url 	: 'ajax/brief_ajax.php',
		type 	: 'post',
		data 	: ({
			opc 	: 'set-critica-y-cod',
			data 	: data
		})
	});
}

function setTipoCaptura( data ){

	$.ajax({
		url 	: 'ajax/brief_ajax.php',
		type 	: 'post',
		data 	: ({
			opc 	: 'set-tipo-captura',
			data 	: data
		})
	});
}

function setCompletadoProductosC( data ){
	$.ajax({
		url 	: 'ajax/brief_ajax.php',
		type 	: 'post',
		data 	: ({
			opc 	: 'set-completado-productos-c',
			data 	: data
		})
	});
}

function setCompletadoProductos( data ){

	$.ajax({
		url 	: 'ajax/brief_ajax.php',
		type 	: 'post',
		data 	: ({
			opc 	: 'set-completado-productos',
			data 	: data
		})
	});
}

function cambiarProcesoCompletado( data ){

	$.ajax({
		url 	: 'ajax/brief_ajax.php',
		type 	: 'post',
		data 	: ({
			opc 	: 'cambiar-proceso-completado',
			data 	: data
		}),
		success:function(result){
			// console.log(result);
		}
	});
}

function cambiarRazonIncuProceso( data ){

	$.ajax({
		url 	: 'ajax/brief_ajax.php',
		type 	: 'post',
		data 	: ({
			opc 	: 'cambiar-razon-incu-proceso',
			data 	: data
		}),
		success:function(result){
			// console.log(result);
		}
	});
}