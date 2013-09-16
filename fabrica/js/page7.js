$(document).ready(function(){

	$("#addProduct").click(function(){

		html = '<tr> <td width="26" align="right" class="bb"><div class="padding5"><img src="/imagenes/yes.png" height="16" border="0"></div></td> <td  width="534" align="left" class="bb"><div class="padding5 textLabel"> <input type="text" name="new_prod_nom[]"> </div></td> <td width="356" align="center" class="bb"><div class="padding5"> <input type="checkbox" name="new_prod_act[]" value="1"> </div></td> <td align="center" class="bb">&nbsp;</td> </tr>';
		$("#prodsContainer").append(html);

	});

});