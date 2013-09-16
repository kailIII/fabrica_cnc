$(document).ready(function(){

	// agrega contactos
	$("#addContact").click(function(){

		count = 1+($(".clientBlock").length);
		html = '<div class="clientBlock"> <h4>Cliente '+count+'</h4> <table> <tr> <td>Nombre:</td> <td><input type="text" name="cli_nombre[]" ></td> </tr><tr> <td>Cargo:</td> <td><input type="text" name="cli_cargo[]" ></td> </tr> <tr> <td>Email:</td> <td><input type="text" name="cli_email[]" ></td> </tr> <tr> <td>Teléfono (PBX):</td> <td><input type="text" name="cli_telefono[]" ></td> </tr> <tr> <td>Celular:</td> <td><input type="text" name="cli_celular[]" ></td> </tr> </table> </div>';

		$("#page1ClientsContainer").append(html);

	});

	// control elaborado -- revisado
	$("#elaborada_por").change(function(){

		var ev_val = $(this).val();

		$("#revisada_por option").removeAttr('disabled');

		$("#revisada_por option").each(function(){

			if( $(this).val() == ev_val ){
				$(this).attr('disabled', 'disabled');
				return false;
			}
		});

	});

	$("#revisada_por").change(function(){

		var ev_val = $(this).val();

		$("#elaborada_por option").removeAttr('disabled');

		$("#elaborada_por option").each(function(){

			if( $(this).val() == ev_val ){
				$(this).attr('disabled', 'disabled');
				return false;
			}
		});

	});
	
});