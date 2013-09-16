<?
//----
$sql = "SELECT * FROM ".tablaTipoEstudio." ORDER BY nom_tipo_estudio";
//echo '<BR>'.$sql;
$optionTipoEstudio		= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_tipo_estudio	= $campos["id_tipo_estudio"];
	$nom_tipo_estudio	= $campos["nom_tipo_estudio"];

	$selected_e		= NULL;
	if($id_tipo_estudio==$tipo_estudio){
		$selected_e	= "selected";
	}

	$optionTipoEstudio.= "<OPTION value='$id_tipo_estudio' $selected_e>$nom_tipo_estudio</OPTION>";
}

$objetosObjEsp			= NULL;
if(empty($objetivos_especificos)){
		$objetosObjEsp = "<TEXTAREA name='objetivos_especificos[]' class='borderBlue' style='width:99%; height:40px; padding:5px; margin-top:5px;'>$vbObjetivo</TEXTAREA>";
}
else{
	$objetivos_especificos	= explode('||',$objetivos_especificos);
	foreach($objetivos_especificos as $ind => $vbObjetivo){
		//echo '<BR>ind: '.$ind.' vbObjetivo: '.$vbObjetivo;
	
		$objetosObjEsp .= "<TEXTAREA name='objetivos_especificos[]' class='borderBlue' style='width:99%; height:40px; padding:5px; margin-top:5px;'>$vbObjetivo</TEXTAREA>";
	}
}
?>
	<TABLE width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
	 <?php /*<TR>
	  <TD width="5%" align='left' class="bb" nowrap="nowrap"><div class='padding5 textLabel'><B>Tipo de estudio:</B></div></TD>
	  <TD width="95%" align='left' class="bb" colspan="2"><div class='padding5'>
			<!-- <SELECT name='tipo_estudio' id='tipo_estudio' lang='1' title='' style="padding:5px;" onchange="con_objetivos();"> -->

			<!-- Problema obj especifico solucinado implementando jQuery Ajax y jsonencode -->
			<SELECT name='tipo_estudio' id='tipo_estudio' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionTipoEstudio?>
		</SELECT>
	  </div></TD>
	 </TR> */ ?>
	 <TR>
	  <TD align='left' colspan="2">
        <div id="divObjetivos">
        <B>Objetivo General:</B><br />
        <TEXTAREA name='objetivo_general' id='objetivo_general' lang='1' title='' class='borderBlue' style='width:99%; height:60px; padding:5px;'><?=$objetivo_general?></TEXTAREA>
        </div>
		<br />
        <B id="obEspTag" >Objetivos espec&iacute;ficos: (Para agregar subniveles, realize un salto de linea (tecla enter) y añada un asterisco): </B>
        <div id="divObjetivosEsp">
        <?=$objetosObjEsp?>
        </div>
        <div style="padding:5px;"><a href="javascript:add_objetivo_esp();"><img src='/imagenes/ico-feedback.png' height='32' border='0' alt='Adicionar objetivo' title='Adicionar objetivo' /></a></div>
      </TD>
	 </TR>
	</TABLE>

<!-- jquery library  -->
<script src="js/jquery-1.10.2.min.js" ></script>

<script>
	$(document).ready(function(){

		var imagen_loader = "<br> <div align='center'><img src='/imagenes/loader_new.gif' ></div>";
		var texto_loader = imagen_loader+"<BR><div align='center'>Cargando, por favor espere...</div><BR>";

		$("#tipo_estudio").change(function(){

			$("#divObjetivosEsp").html('');
			$("#divObjetivos").html( texto_loader );
			$("#obEspTag").hide();

			$.ajax({
				type:'post',
				url:'ajax/con_objetivos.php',
				data:({
					tipo_estudio : $(this).val()
				}),
				dataType:'json',
				success:function(data){

					$("#obEspTag").show();
					$("#divObjetivos").html( data.objetivo_general );
					$("#divObjetivosEsp").html( data.objetivo_especifico );
				}
			})

		});
	});
</script>