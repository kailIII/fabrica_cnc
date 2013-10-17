$(document).ready(function(){

	// check_submetodologia();
	init_filters();
	init_calculator();

	$(".delete-met-selected").click(function(){

		var id_met = $(this).attr('id_met');

		if( ! confirm('Desea eliminar esta metodología? (no perderas los cambios que tengas sin guardar).\nEsta acción no se puede deshacer.') ){
			return false;
		} else {

			$("#met_container_"+id_met).slideUp('slow');

			$.ajax({
				url 	: 'ajax/delete_met_selected.php',
				type 	: 'post',
				data 	: ({
					id_met 		: id_met,
					id_propuesta: $("#idPropuesta").val()
				})
			});
		}
	});

	$(".generateTable").click(function(){

		id_met = $(this).attr('id_met');

		if(  parseInt( $("#met_filas_"+id_met).val() ) <= 0 ||  parseInt( $("#met_cols_"+id_met).val() ) <= 0 ||  $("#met_cols_"+id_met).val() == '' || $("#met_filas_"+id_met).val() == '' ){
			alert('Las filas y columnas deben ser mayores a 0');
			return false;
		}
		generateTable(id_met, $(this).attr('is_presencial') , $("#met_filas_"+id_met).val() ,  $("#met_cols_"+id_met).val() );

	});

	$("#add_metodologia").val(0);

	/**
	 *configura el formulario para que se agregue la metodologia
	 * @see dml_insert.php
	*/
	$("#add_metodologia_trigger").click(function(){

		$("#add_metodologia").val(1),
		setTimeout( function(){ $("#mainForm").submit() } , 500); // slow down por explorer amotriz
	});

	// handler opcion marco muestral "otro"
	$(".met_marco").change(function(){
		id_met = $(this).attr('id_met');

		$(this).val() == 3 ? $("#met_other_marco_"+id_met).show() : $("#met_other_marco_"+id_met).hide();
	});

	// handler mostrar datos de tipos de datos probabilisticos
	$(".met_tipo").change(function(){

		id_met = $(this).attr('id_met');
		probabilistico = parseInt( $("select[name='met_tipo["+id_met+"]'] option:selected").attr( 'probabilistico' ) );
		probabilistico == 1 ? $("#probabilistic_data_"+id_met).show() : $("#probabilistic_data_"+id_met).hide();

		$(this).val() == 10 ? $("input[name='tipo_cuantitativo_custom["+id_met+"]']").show() : $("input[name='tipo_cuantitativo_custom["+id_met+"]']").hide();
	});

	$(".met_if_incidencia").change(function(){

		id_met = $(this).attr('id_met');
		parseInt( $(this).val() )  == 1 ? $("#met_incidencia_"+id_met).show() : $("#met_incidencia_"+id_met).hide();
	});

	// filtro de solo numeros
	$(".only-numbers").keydown(function(e){
		if( (e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 9 || e.keyCode == 8 )
			return true;
		else
			return false;
	});

});

function init_calculator(){

	// E = sqrt( (s^2*p*q)/n )
	// console.log(' E = sqrt( (s^2*p*q)/n )' );


	$(".met-container").on("keyup", ".varianza" , function(e){

		var id_met = $(this).attr('id_met');
		var row    = $(this).attr('row');
		var col    = $(this).attr('col');

		var n=0;
		var n_col = 0;

		if( isProbabilistico(id_met) ){
			var s = $("#met_nivel_confianza_"+id_met+" option:selected").attr('percent');
			s = parseFloat( s );
		} else {
			var s = null;
		}

		$(".varianza").each(function(){

			// calculo variable n, total en la fila
			if( $(this).attr('id_met') == id_met && $(this).attr('row') == row ){

				value = parseFloat($(this).val());
				if( ! isNaN(value) ){
					n+=value;
				}
			}

			if( $(this).attr('id_met') == id_met && $(this).attr('col') == col ){

				value = parseFloat( $(this).val() )
				if( ! isNaN(value) ){
					n_col+=value;
				}
			}

		});


		if( isProbabilistico(id_met) ){

			if( $("#met_nivel_confianza_"+id_met).val() == '' ){
				alert('No has seleccionado un nivel de confianza!\nSelecciona uno primero!');
				return false;
			}

			// E = sqrt( (s^2*p*q)/n )
			error = calcularError(s,n);
			$("#error_"+row+"_"+id_met).val(error);

		}

		$("#total_"+row+"_"+id_met).val(n);
		$("#total_col_"+col+"_"+id_met).val(n_col);

		// calculo totales de varianza
		total_var = 0;
		$(".total").each(function(){

			if( $(this).attr('id_met') == id_met  ){

				value = parseFloat( $(this).val() );
				if( !isNaN( value ) ){
					total_var+=value;
				}
			}
		});
		$("#final_var_tot_"+id_met).val( total_var );

		// calculo totales de error
		total_err = 0;
		$(".error").each(function(){
			if( $(this).attr('id_met') == id_met  ){
				value = parseFloat( $(this).val() );
				if( !isNaN( value ) ){
					total_err+=value;
				}
			}
		});

		// calculo columna error
		if( isProbabilistico(id_met) ){

			$(".total_col").each(function(){
				if( $(this).attr('id_met') == id_met  ){
					error = calcularError(s, parseFloat($(this).val()));
				}

				$("#error_col_"+$(this).attr('col')+"_"+id_met ).val( error )
			});
		}

		error_total = calcularError( s, total_var );

		$("#final_total_error_col_"+id_met).val( error_total );
		$("#final_error_tot_"+id_met).val( total_err.toFixed(2) );

	});
}

function generateTable(id_met, is_presencial, rows, cols){

	// console.log('generating...');

	/* --- fase 1 header ----- */
	html = '<table class="metTable" id="metTable_'+ id_met +'" >';
	html+='<tr>';
	html+='<td>Segmento</td>';
	for( i=1;i<=cols;i++ ){
		html+='<td><input type="text" name="varianza['+id_met+'][]" ></td>';
	}
	html+='<td>Total</td>';

	if( isProbabilistico(id_met) ){
		html+='<td>Error</td>';
	}

	if( is_presencial == 1 ){
		html+='<td class="met_zonas_wraper" >&nbsp;</td>';
	}

	html+='</tr>';

	for( i = 1; i <= rows; i++  ){
	/* -- fase 2 body --- */
		html+='<tr>';
		html+='<td><input type="text" id_met="'+ id_met +'" name="segmento['+id_met+'][]" ></td>';

		for( j = 1; j<= cols; j++ ){
			html+='<td><input type="text" row="'+ i +'" class="varianza" col="'+ j +'" id_met="'+ id_met +'" name="seg_val['+id_met+']['+(i-1)+'][]" ></td>';
		}

		html+='<td><input type="text" class="total" col="'+ j +'" row="'+ i +'" id_met="'+ id_met +'" id="total_'+ i +'_'+ id_met +'" readonly name="seg_total['+id_met+']['+(i-1)+']" /></td>';
		if( isProbabilistico(id_met) ){
			html+='<td><input type="text" class="error" col="'+ j +'" row="'+ i +'" id_met="'+ id_met +'" id="error_'+ i +'_'+ id_met +'" value="" readonly name="seg_error['+id_met+']['+(i-1)+']"></td>';
		}

		if( is_presencial == 1 ){
			html+='<td class="met_zonas_wraper" >';
			html+='<select name="seg_cobertura['+id_met+']['+(i-1)+']" >';

			$("input[name='js_coberturas["+ id_met +"]']").each(function(){

				html+='<option value="'+ $(this).val() +'">'+ $(this).attr('label') +'</option>';

			});

			html+='</select>';
			html+='</td>';
		}

		html+='</tr>';
	}

	/* -- fase 3 results --- */
	html+='<tr>';
	html+='<td>Total</td>';
	j = 1;
	for( true; j<= cols; j++ ){
		html+='<td><input type="text" class="total_col" name="total_val['+id_met+'][]" readonly id_met="'+ id_met +'" col="'+ j +'" id="total_col_'+ j +'_'+ id_met +'" /></td>';
	}

	html+='<td><input type="text" readonly id_met="'+ id_met +'"  name="final_var_tot['+id_met+']" id="final_var_tot_'+ id_met +'" /></td>';
	if( isProbabilistico(id_met) ){
		html+='<td><input type="text" readonly id_met="'+ id_met +'" id="final_error_tot_'+ id_met +'" name="final_error_tot['+id_met+']" /></td>';
	}

	if( is_presencial == 1 ){
		html+='<td class="met_zonas_wraper" >&nbsp;</td>';
	}
	html+='</tr>';

	if( isProbabilistico(id_met) ){
		html+='<tr>';
		html+='<td>Error</td>';
		for( j = 1; j<= cols; j++ ){
			html+='<td><input type="text" class="error_col" readonly="" name="error_val['+id_met+'][]" id_met="'+ id_met +'" col="'+ j +'" id="error_col_'+j+'_'+ id_met +'"></td>';
		}

		html+='<td><input type="text" id="final_total_error_col_'+ id_met +'" id_met="'+ id_met +'" readonly  name="final_total_error['+id_met+']" /></td>';

		html+='<td>&nbsp;</td>';// no hay total de errores
		if( is_presencial == 1 ){
			html+='<td class="met_zonas_wraper" >&nbsp;</td>';
		}
		html+='</tr>';
	}


	//----------//

	html+='</table>'; // end

	$("#metTableWrapper_"+id_met).html( html );
}

function isProbabilistico(id_met){
	probabilistico = parseInt( $("select[name='met_tipo["+id_met+"]'] option:selected").attr( 'probabilistico' ) );

	if( probabilistico == 1 )
		return true;

	return false;
}

function calcularError(s,n){
	// E = sqrt( (s^2*p*q)/n )
	var p = 0.5;
	var q = 1 - p;

	error = Math.sqrt( ( Math.pow(s,2) * p * q ) / n );
	error *= 100;
	return error.toFixed(2);

}

function init_filters(){

	// trae las opciones disponibles de marco muestral segun la tecnica de recoleccion seleccionada
	$(".tecnica-recoleccion").change(function(){

		var id_met = $(this).attr('id_met');
		var id_propuesta = $("#idPropuesta").val();
		var id_pob_objetivo = $(this).val();

		// -- reset
		$("select[name='met_tiempo["+id_met+"]']").html( '<option value="" >Completa los campos anteriores...</option>' );
		$("select[name='met_tiempo["+id_met+"]']").attr('disabled','disabled');

		$("select[name='nivel_aceptacion["+id_met+"]']").html( '<option value="" >Completa los campos anteriores...</option>' );
		$("select[name='nivel_aceptacion["+id_met+"]']").attr('disabled','disabled');
		// -- eoreset

		if( id_pob_objetivo == '' ){
			$("select[name='met_marco["+id_met+"]']").html( '<option value="" >Completa los campos anteriores...</option>' );
			$("select[name='met_marco["+id_met+"]']").attr('disabled','disabled');

			return false;
		} else {
			$("select[name='met_marco["+id_met+"]']").removeAttr('disabled');
		}

		$.ajax({
			url 	: 'ajax/filtros_metodologia.php',
			type 	: 'post',
			async 	: false,
			data 	:({
				id_met 			: id_met,
				id_propuesta 	: id_propuesta,
				id_pob_objetivo : id_pob_objetivo,
				opc 			: 'get_origen_db'
			}),
			success:function(data){

				$("select[name='met_marco["+id_met+"]']").html( data );
			}
		});

	});

	// trae las opciones disponibles en duracion segun el marco muestral seleccionado
	$(".met_marco").change(function(){

		var id_met = $(this).attr('id_met');
		var id_propuesta = $("#idPropuesta").val();
		var id_pob_objetivo = $( "select[name='met_poblacion["+id_met+"]']" ).val();
		var id_origen_db = $(this).val();

		$("select[name='nivel_aceptacion["+id_met+"]']").html( '<option value="" >Completa los campos anteriores...</option>' );
		$("select[name='nivel_aceptacion["+id_met+"]']").attr('disabled','disabled');

		if( id_origen_db == '' ){
			$("select[name='met_tiempo["+id_met+"]']").html( '<option value="" >Completa los campos anteriores...</option>' );
			$("select[name='met_tiempo["+id_met+"]']").attr('disabled','disabled');

			return false;
		} else {
			$("select[name='met_tiempo["+id_met+"]']").removeAttr('disabled');
		}

		$.ajax({
			url 	: 'ajax/filtros_metodologia.php',
			type 	: 'post',
			async 	: false,
			data 	:({
				id_met 			: id_met,
				id_propuesta 	: id_propuesta,
				id_pob_objetivo : id_pob_objetivo,
				id_origen_db 	: id_origen_db,
				opc 			: 'get_duracion'
			}),
			success:function(data){

				$("select[name='met_tiempo["+id_met+"]']").html( data );
			}
		});

	});

	$(".met_duracion").change(function(){

		var id_met = $(this).attr('id_met');
		var id_propuesta = $("#idPropuesta").val();
		var id_pob_objetivo = $( "select[name='met_poblacion["+id_met+"]']" ).val();
		var id_origen_db = $( "select[name='met_marco["+id_met+"]']" ).val();
		var id_duracion = $(this).val();

		if( id_duracion == '' ){
			$("select[name='nivel_aceptacion["+id_met+"]']").html( '<option value="" >Completa los campos anteriores...</option>' );
			$("select[name='nivel_aceptacion["+id_met+"]']").attr('disabled','disabled');

			return false;
		} else {
			$("select[name='nivel_aceptacion["+id_met+"]']").removeAttr('disabled');
		}

		$.ajax({
			url 	: 'ajax/filtros_metodologia.php',
			type 	: 'post',
			async 	: false,
			data 	:({
				id_met 			: id_met,
				id_propuesta 	: id_propuesta,
				id_pob_objetivo : id_pob_objetivo,
				id_origen_db 	: id_origen_db,
				id_duracion 	: id_duracion,
				opc 			: 'get_dificultad'
			}),
			success:function(data){

				$("select[name='nivel_aceptacion["+id_met+"]']").html( data );
			}
		});

	});
}

function check_submetodologia(){
	$("#id_metodologia").change(function(){

		var id_metodologia = $(this).val();

		$.ajax({
			url 	: 'ajax/cargar_submetodologia.php',
			type 	: 'post',
			async 	: false,
			data 	: ({
				id_metodologia 	: id_metodologia
			}),
			success:function(data){

				// console.log(data);

				$("#sub_metodologia").html(data);

				if( data!= '' ){
					$("#sub_metodologia").show();
					$("#sub_metodologia_label").show();
					$("#sub_metodologia").removeAttr('disabled');
				} else {
					$("#sub_metodologia").hide();
					$("#sub_metodologia_label").hide();
					$("#sub_metodologia").attr('disabled','disabled');
				}
			}
		});

	});
}